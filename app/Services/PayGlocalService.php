<?php

namespace App\Services;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A128CBCHS256;
use Jose\Component\Encryption\Algorithm\KeyEncryption\RSAOAEP256;
use Jose\Component\Encryption\JWEBuilder;
use Jose\Component\Encryption\Serializer\CompactSerializer as EncryptionCompactSerializer;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\JWSLoader;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Signature\Serializer\CompactSerializer as SignatureCompactSerializer;
use Jose\Component\Signature\Serializer\JWSSerializerManager;

class PayGlocalService
{
    private const CHECKOUT_PATH = '/gl/v1/payments/initiate/paycollect';

    private $merchantId;
    private $publicKeyId;      // PayGlocal's public key ID
    private $privateKeyId;     // Your private key ID
    private $publicKeyPath;    // Path to PayGlocal's public key
    private $privateKeyPath;   // Path to your private key
    private $baseUrl;
    private $mode;
    private $checkoutAuthMode = 'x-gl-token-external';
    private const UAT_BASE_URL = 'https://api.uat.payglocal.in';
    private const PROD_BASE_URL = 'https://api.prod.payglocal.in';

    public function __construct()
    {
        // Read credentials from database (via Setting model) to match admin panel configuration
        $this->merchantId = Setting::getValue('payment_payglocal_merchant_id', '');
        $this->publicKeyId = Setting::getValue('payment_payglocal_public_key_id', '');
        $this->privateKeyId = Setting::getValue('payment_payglocal_private_key_id', '');
        $this->publicKeyPath = Setting::getValue('payment_payglocal_public_key_path', 'payments/payglocal/public.pem');
        $this->privateKeyPath = Setting::getValue('payment_payglocal_private_key_path', 'payments/payglocal/private.pem');
        $this->mode = Setting::getValue('payment_payglocal_mode', 'sandbox');
        $this->baseUrl = $this->normalizeBaseUrl(
            Setting::getValue('payment_payglocal_base_url', self::UAT_BASE_URL)
        );

        // Validate required credentials
        if (!$this->merchantId || !$this->publicKeyId || !$this->privateKeyId) {
            throw new Exception('PayGlocal credentials are not properly configured. Please check Admin Panel → Payment Gateways → PayGlocal Configuration.');
        }
    }

    /**
     * Map legacy or empty PayGlocal base URLs to the current official API hosts.
     */
    private function normalizeBaseUrl(?string $baseUrl): string
    {
        $baseUrl = rtrim(trim((string) $baseUrl), '/');

        if ($baseUrl === '') {
            return $this->mode === 'live' ? self::PROD_BASE_URL : self::UAT_BASE_URL;
        }

        return match ($baseUrl) {
            'https://sandbox.payglocal.in' => self::UAT_BASE_URL,
            'https://api.prod.payglocal.in' => self::PROD_BASE_URL,
            default => $baseUrl,
        };
    }

    /**
     * Build the SDK-style PayGlocal request tokens.
     */
    public function createAuthToken(array $payload): array
    {
        $this->ensureJoseDependenciesAvailable();

        $encryptedPayload = $this->encryptPayload($payload);
        $signatureToken = $this->signPayload($encryptedPayload);

        return [
            'token' => $signatureToken,
            'encrypted_payload' => $encryptedPayload,
            'headers' => [
                'x-gl-token-external' => $signatureToken,
                'Content-Type' => 'text/plain',
            ],
        ];
    }

    /**
     * Fail with a useful message when the PayGlocal JOSE dependencies are missing on the deployed server.
     */
    private function ensureJoseDependenciesAvailable(): void
    {
        $requiredClasses = [
            JWEBuilder::class,
            JWSBuilder::class,
            JWKFactory::class,
            AlgorithmManager::class,
            RSAOAEP256::class,
            A128CBCHS256::class,
            RS256::class,
        ];

        foreach ($requiredClasses as $className) {
            if (!class_exists($className)) {
                throw new Exception(
                    'PayGlocal SDK dependency is missing on this server (' . $className . '). ' .
                    'Run composer install/update on the deployed project so the web-token/jwt-library package is available.'
                );
            }
        }
    }

    /**
     * Encrypt payload using the same JOSE structure shown in PayGlocal's PHP SDK.
     */
    private function encryptPayload(array $payload): string
    {
        $jweBuilder = new JWEBuilder(new AlgorithmManager([
            new RSAOAEP256(),
            new A128CBCHS256(),
        ]));

        $payloadJson = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        $jwe = $jweBuilder
            ->create()
            ->withPayload($payloadJson)
            ->withSharedProtectedHeader([
                'issued-by' => $this->merchantId,
                'enc' => 'A128CBC-HS256',
                'exp' => 30000,
                'iat' => $this->currentTimestampMillis(),
                'alg' => 'RSA-OAEP-256',
                'kid' => $this->publicKeyId,
            ])
            ->addRecipient($this->createEncryptionPublicJwk())
            ->build();

        return (new EncryptionCompactSerializer())->serialize($jwe, 0);
    }

    /**
     * Sign the encrypted payload digest using the merchant private key.
     */
    private function signPayload(string $encryptedPayload): string
    {
        $jwsBuilder = new JWSBuilder(new AlgorithmManager([
            new RS256(),
        ]));

        $digestPayload = json_encode([
            'digest' => base64_encode(hash('sha256', $encryptedPayload, true)),
            'digestAlgorithm' => 'SHA-256',
            'exp' => 300000,
            'iat' => $this->currentTimestampMillis(),
        ], JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        $jws = $jwsBuilder
            ->create()
            ->withPayload($digestPayload)
            ->addSignature($this->createSigningPrivateJwk(), [
                'issued-by' => $this->merchantId,
                'is-digested' => 'true',
                'alg' => 'RS256',
                'x-gl-enc' => 'true',
                'x-gl-merchantId' => $this->merchantId,
                'kid' => $this->privateKeyId,
            ])
            ->build();

        return (new SignatureCompactSerializer())->serialize($jws, 0);
    }

    /**
     * Load a public JWK suitable for request encryption.
     */
    private function createEncryptionPublicJwk()
    {
        $keyContent = $this->getKeyContent($this->publicKeyPath);
        if (!$keyContent) {
            throw new Exception('PayGlocal public key could not be loaded from: ' . $this->describeKeySource($this->publicKeyPath));
        }

        try {
            return $this->isCertificatePem($keyContent)
                ? JWKFactory::createFromCertificate($keyContent, [
                    'kid' => $this->publicKeyId,
                    'use' => 'enc',
                    'alg' => 'RSA-OAEP-256',
                ])
                : JWKFactory::createFromKey($keyContent, null, [
                    'kid' => $this->publicKeyId,
                    'use' => 'enc',
                    'alg' => 'RSA-OAEP-256',
                ]);
        } catch (\Throwable $e) {
            throw new Exception(
                'Failed to parse PayGlocal public key for encryption. Ensure it is a valid PEM certificate or public key. ' .
                $e->getMessage()
            );
        }
    }

    /**
     * Load a private JWK suitable for request signing.
     */
    private function createSigningPrivateJwk()
    {
        $keyContent = $this->getKeyContent($this->privateKeyPath);
        if (!$keyContent) {
            throw new Exception('Your private key could not be loaded from: ' . $this->describeKeySource($this->privateKeyPath));
        }

        try {
            return JWKFactory::createFromKey($keyContent, null, [
                'kid' => $this->privateKeyId,
                'use' => 'sig',
            ]);
        } catch (\Throwable $e) {
            throw new Exception(
                'Failed to parse your private key for signing. Ensure it is a valid PEM format RSA key. ' .
                $e->getMessage()
            );
        }
    }

    /**
     * Build a public JWK for verifying PayGlocal callback tokens.
     */
    private function createVerificationPublicJwk()
    {
        $keyContent = $this->getKeyContent($this->publicKeyPath);
        if (!$keyContent) {
            throw new Exception('PayGlocal public key could not be loaded from: ' . $this->describeKeySource($this->publicKeyPath));
        }

        try {
            return $this->isCertificatePem($keyContent)
                ? JWKFactory::createFromCertificate($keyContent, [
                    'kid' => $this->publicKeyId,
                    'use' => 'sig',
                ])
                : JWKFactory::createFromKey($keyContent, null, [
                    'kid' => $this->publicKeyId,
                    'use' => 'sig',
                ]);
        } catch (\Throwable $e) {
            throw new Exception(
                'Failed to parse PayGlocal public key for response verification. Ensure it is a valid PEM certificate or public key. ' .
                $e->getMessage()
            );
        }
    }

    /**
     * Detect certificate PEM material so JWKFactory uses the correct parser.
     */
    private function isCertificatePem(string $content): bool
    {
        return str_contains($content, '-----BEGIN CERTIFICATE-----');
    }

    /**
     * Create the millisecond timestamp string used by the SDK sample.
     */
    private function currentTimestampMillis(): string
    {
        return (string) round(microtime(true) * 1000);
    }

    /**
     * Generate the 16-character merchant unique ID used in the SDK sample payload.
     */
    private function generateMerchantUniqueId(): string
    {
        return Str::random(16);
    }

    /**
     * Split a full customer name into first and last names for billingData.
     *
     * @return array{0: string, 1: string}
     */
    private function splitCustomerName(string $customerName): array
    {
        $customerName = trim($customerName);
        if ($customerName === '') {
            return ['Customer', ''];
        }

        $parts = preg_split('/\s+/', $customerName) ?: [];
        $firstName = array_shift($parts) ?: 'Customer';
        $lastName = implode(' ', $parts);

        return [$firstName, $lastName];
    }

    /**
     * Build the checkout request body in the same envelope shown in the SDK sample.
     */
    private function buildCheckoutPayload(array $data): array
    {
        [$firstName, $lastName] = $this->splitCustomerName((string) ($data['customer_name'] ?? ''));

        return [
            'merchantTxnId' => (string) $data['order_id'],
            'merchantUniqueId' => $this->generateMerchantUniqueId(),
            'paymentData' => [
                'totalAmount' => number_format((float) $data['amount'], 2, '.', ''),
                'txnCurrency' => (string) ($data['currency'] ?? 'USD'),
                'billingData' => [
                    'firstName' => (string) ($data['billing_first_name'] ?? $firstName),
                    'lastName' => (string) ($data['billing_last_name'] ?? $lastName),
                    'addressStreet1' => (string) ($data['billing_address_1'] ?? ''),
                    'addressStreet2' => (string) ($data['billing_address_2'] ?? ''),
                    'addressCity' => (string) ($data['billing_city'] ?? ''),
                    'addressState' => (string) ($data['billing_state'] ?? ''),
                    'addressPostalCode' => (string) ($data['billing_postal_code'] ?? ''),
                    'addressCountry' => (string) ($data['billing_country'] ?? 'US'),
                    'emailId' => (string) ($data['customer_email'] ?? ''),
                ],
            ],
            'merchantCallbackURL' => (string) $data['return_url'],
        ];
    }

    /**
     * Load PayGlocal's public key certificate.
     */
    private function loadPublicKey()
    {
        $keyContent = $this->getKeyContent($this->publicKeyPath);
        if (!$keyContent) {
            throw new Exception('PayGlocal public key could not be loaded from: ' . $this->describeKeySource($this->publicKeyPath));
        }

        $key = $this->parsePublicKey($keyContent);
        if (!$key) {
            throw new Exception(
                'Failed to parse PayGlocal public key. Ensure it is a valid PEM certificate or public key.' .
                $this->formatOpenSslErrors()
            );
        }

        return $key;
    }

    /**
     * Load your private key for signing.
     */
    private function loadPrivateKey()
    {
        $keyContent = $this->getKeyContent($this->privateKeyPath);
        if (!$keyContent) {
            throw new Exception('Your private key could not be loaded from: ' . $this->describeKeySource($this->privateKeyPath));
        }

        $key = $this->parsePrivateKey($keyContent);
        if (!$key) {
            $hint = '';

            if ($this->looksLikeKeyIdentifier($keyContent)) {
                $hint = ' The configured private key file appears to contain only a key ID or token, not the actual RSA private key contents.';
            } elseif ($this->looksLikeKeyBodyWithoutPemEnvelope($keyContent)) {
                $hint = ' The configured private key appears to be missing PEM BEGIN/END lines.';
            }

            throw new Exception(
                'Failed to parse your private key. Ensure it is a valid PEM format RSA key.' .
                $hint .
                $this->formatOpenSslErrors()
            );
        }

        return $key;
    }

    /**
     * Get key file content from disk.
     */
    private function getKeyContent(string $path): ?string
    {
        $path = trim($path);
        if ($path === '') {
            return null;
        }

        $inlinePem = $this->normalizePemContent($path);
        if ($inlinePem !== null) {
            return $inlinePem;
        }

        // Check if it's an absolute path
        foreach ($this->possibleKeyPaths($path) as $candidate) {
            if (is_file($candidate) && is_readable($candidate)) {
                $content = file_get_contents($candidate);

                return $content === false ? null : ($this->normalizePemContent($content) ?? $content);
            }
        }

        $diskPath = $this->localDiskPath($path);
        if ($diskPath !== null && Storage::disk('local')->exists($diskPath)) {
            $content = Storage::disk('local')->get($diskPath);

            return $this->normalizePemContent($content) ?? $content;
        }

        return null;
    }

    /**
     * Generate the possible filesystem paths for a configured key source.
     *
     * @return array<int, string>
     */
    private function possibleKeyPaths(string $path): array
    {
        $paths = [$path];

        if (str_starts_with($path, 'file://')) {
            $paths[] = substr($path, 7);
        }

        $trimmedPath = ltrim($path, '/');

        $paths[] = base_path($trimmedPath);
        $paths[] = storage_path($trimmedPath);
        $paths[] = storage_path('app/' . $trimmedPath);

        return array_values(array_unique(array_filter($paths)));
    }

    /**
     * Map a configured path to the default local storage disk when possible.
     */
    private function localDiskPath(string $path): ?string
    {
        $path = ltrim($path, '/');
        if ($path === '') {
            return null;
        }

        foreach (['storage/app/', 'storage/', 'app/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $path = substr($path, strlen($prefix));
                break;
            }
        }

        return $path === '' ? null : $path;
    }

    /**
     * Normalize PEM content from either file contents or copied key material.
     */
    private function normalizePemContent(string $content): ?string
    {
        $content = preg_replace('/^\xEF\xBB\xBF/', '', trim($content));
        if (!is_string($content) || $content === '') {
            return null;
        }

        if (($normalizedPem = $this->extractAndFormatPem($content)) !== null) {
            return $normalizedPem;
        }

        $decoded = base64_decode($content, true);
        if ($decoded !== false) {
            $decoded = trim($decoded);

            if (($normalizedPem = $this->extractAndFormatPem($decoded)) !== null) {
                return $normalizedPem;
            }
        }

        return null;
    }

    /**
     * Detect PEM blocks, including keys stored on a single line with escaped newlines.
     */
    private function looksLikePem(string $content): bool
    {
        $normalized = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $content);

        return str_contains($normalized, '-----BEGIN ') && str_contains($normalized, '-----END ');
    }

    /**
     * Convert mixed or escaped line endings into a PEM string OpenSSL can parse.
     */
    private function normalizePemLineEndings(string $content): string
    {
        $content = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $content);
        $content = str_replace(["\r\n", "\r"], "\n", $content);

        return rtrim($content) . "\n";
    }

    /**
     * Normalize an existing PEM block into a well-formed multi-line string.
     */
    private function extractAndFormatPem(string $content): ?string
    {
        $content = $this->normalizePemLineEndings($content);

        if (!preg_match('/-----BEGIN ([A-Z0-9 ]+)-----(.*?)-----END \1-----/s', $content, $matches)) {
            return null;
        }

        $body = preg_replace('/\s+/', '', $matches[2]);
        if (!is_string($body) || $body === '') {
            return null;
        }

        return $this->buildPemFromBase64Body($matches[1], $body);
    }

    /**
     * Attempt to parse the configured public key using PEM and headerless fallbacks.
     */
    private function parsePublicKey(string $keyContent)
    {
        foreach ($this->publicKeyCandidates($keyContent) as $candidate) {
            $this->clearOpenSslErrors();
            $key = openssl_pkey_get_public($candidate);

            if ($key !== false) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Attempt to parse the configured private key using PEM and headerless fallbacks.
     */
    private function parsePrivateKey(string $keyContent)
    {
        foreach ($this->privateKeyCandidates($keyContent) as $candidate) {
            $this->clearOpenSslErrors();
            $key = openssl_pkey_get_private($candidate);

            if ($key !== false) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Build possible public-key representations from inline/file content.
     *
     * @return array<int, string>
     */
    private function publicKeyCandidates(string $content): array
    {
        return $this->keyCandidatesForLabels($content, ['PUBLIC KEY', 'CERTIFICATE']);
    }

    /**
     * Build possible private-key representations from inline/file content.
     *
     * @return array<int, string>
     */
    private function privateKeyCandidates(string $content): array
    {
        return $this->keyCandidatesForLabels($content, ['PRIVATE KEY', 'RSA PRIVATE KEY']);
    }

    /**
     * Build candidate PEM strings from several common key storage formats.
     *
     * @param  array<int, string>  $labels
     * @return array<int, string>
     */
    private function keyCandidatesForLabels(string $content, array $labels): array
    {
        $candidates = [$content];
        $normalizedPem = $this->normalizePemContent($content);
        if ($normalizedPem !== null) {
            $candidates[] = $normalizedPem;
        }

        $base64Body = $this->extractBase64KeyBody($content);
        if ($base64Body !== null) {
            foreach ($labels as $label) {
                $candidates[] = $this->buildPemFromBase64Body($label, $base64Body);
            }
        }

        $derBody = $this->extractBinaryDerBody($content);
        if ($derBody !== null) {
            foreach ($labels as $label) {
                $candidates[] = $this->buildPemFromBase64Body($label, $derBody);
            }
        }

        return array_values(array_unique($candidates));
    }

    /**
     * Detect headerless base64 key material copied without PEM markers.
     */
    private function extractBase64KeyBody(string $content): ?string
    {
        $content = preg_replace('/^\xEF\xBB\xBF/', '', trim($content));
        if (!is_string($content) || $content === '') {
            return null;
        }

        if ($this->looksLikePem($content)) {
            return null;
        }

        $body = preg_replace('/\s+/', '', $content);
        if (!is_string($body) || $body === '') {
            return null;
        }

        if (strlen($body) < 128 || !preg_match('/^[A-Za-z0-9+\/=]+$/', $body)) {
            return null;
        }

        return $body;
    }

    /**
     * Detect raw DER key bytes that were stored without PEM/base64 wrapping.
     */
    private function extractBinaryDerBody(string $content): ?string
    {
        if ($this->looksLikePem($content)) {
            return null;
        }

        if (!preg_match('/[^\x09\x0A\x0D\x20-\x7E]/', $content)) {
            return null;
        }

        return base64_encode($content);
    }

    /**
     * Determine whether content resembles a base64 key body without PEM headers.
     */
    private function looksLikeKeyBodyWithoutPemEnvelope(string $content): bool
    {
        return $this->extractBase64KeyBody($content) !== null || $this->extractBinaryDerBody($content) !== null;
    }

    /**
     * Detect short identifier-like values that are not actual key material.
     */
    private function looksLikeKeyIdentifier(string $content): bool
    {
        $content = trim($content);

        if (
            $content === '' ||
            $this->looksLikePem($content) ||
            str_contains($content, "\n") ||
            strlen($content) < 8 ||
            strlen($content) > 128
        ) {
            return false;
        }

        return preg_match('/^[A-Za-z0-9._-]+$/', $content) === 1;
    }

    /**
     * Build a PEM block from base64 body content.
     */
    private function buildPemFromBase64Body(string $label, string $body): string
    {
        return sprintf(
            "-----BEGIN %s-----\n%s-----END %s-----\n",
            $label,
            chunk_split($body, 64, "\n"),
            $label
        );
    }

    /**
     * Avoid echoing inline secret material back in exception messages.
     */
    private function describeKeySource(string $source): string
    {
        $source = trim($source);

        if (
            $source === '' ||
            str_contains($source, "\n") ||
            str_contains($source, '-----BEGIN ') ||
            strlen($source) > 120 ||
            $this->looksLikeKeyBodyWithoutPemEnvelope($source)
        ) {
            return '[configured inline key value]';
        }

        return $source;
    }

    /**
     * Clear any buffered OpenSSL errors before a parse attempt.
     */
    private function clearOpenSslErrors(): void
    {
        while (openssl_error_string() !== false) {
            // Drain the OpenSSL error buffer.
        }
    }

    /**
     * Format buffered OpenSSL errors for troubleshooting.
     */
    private function formatOpenSslErrors(): string
    {
        $errors = [];

        while (($error = openssl_error_string()) !== false) {
            $errors[] = $error;
        }

        return empty($errors) ? '' : ' OpenSSL: ' . implode(' | ', $errors);
    }

    /**
     * Create a PayGlocal checkout session.
     */
    public function createCheckout(array $data): array
    {
        $payload = $this->buildCheckoutPayload($data);
        $auth = $this->createAuthToken($payload);

        $response = Http::withHeaders($auth['headers'])
            ->withoutRedirecting()
            ->withBody($auth['encrypted_payload'], 'text/plain')
            ->send('POST', rtrim($this->baseUrl, '/') . self::CHECKOUT_PATH);

        if ($this->isRedirectResponse($response)) {
            $redirectUrl = $response->header('Location');

            if (is_string($redirectUrl) && trim($redirectUrl) !== '') {
                return [
                    'redirect_url' => $redirectUrl,
                    'message' => $this->extractResponseMessage($response),
                    'status_code' => $response->status(),
                ];
            }
        }

        if ($response->successful()) {
            $data = $response->json();

            if (is_array($data)) {
                return $data;
            }

            $redirectUrl = $this->findFirstUrlInBody($response->body());
            if ($redirectUrl !== null) {
                return [
                    'redirect_url' => $redirectUrl,
                    'message' => $this->extractResponseMessage($response),
                    'status_code' => $response->status(),
                ];
            }

            return [
                'raw_body' => $response->body(),
                'message' => $this->extractResponseMessage($response),
                'status_code' => $response->status(),
            ];
        }

        $message = $this->extractResponseMessage($response);
        $location = $response->header('Location');
        $status = $response->status();

        $details = " HTTP {$status}";
        if (is_string($location) && trim($location) !== '') {
            $details .= " Location: {$location}";
        }
        if ($message !== null) {
            $details .= " Message: {$message}";
        } elseif (trim($response->body()) !== '') {
            $details .= ' Body: ' . $response->body();
        }
        $details .= " Auth: {$this->checkoutAuthMode}";

        throw new Exception('PayGlocal API error.' . $details);
    }

    /**
     * Check whether the gateway returned a redirect-style response.
     */
    private function isRedirectResponse($response): bool
    {
        return $response->status() >= 300 && $response->status() < 400;
    }

    /**
     * Extract a human-readable message from a PayGlocal HTTP response.
     */
    private function extractResponseMessage($response): ?string
    {
        $json = $response->json();
        if (is_array($json)) {
            foreach (['message', 'status', 'reasonCode'] as $key) {
                $value = $json[$key] ?? null;
                if (is_string($value) && trim($value) !== '') {
                    return $value;
                }
            }
        }

        $body = trim($response->body());
        return $body === '' ? null : $body;
    }

    /**
     * Extract the first absolute URL found in a plain-text or HTML response body.
     */
    private function findFirstUrlInBody(string $body): ?string
    {
        if (preg_match('/https?:\/\/[^\s"\']+/i', $body, $matches) === 1) {
            return $matches[0];
        }

        return null;
    }

    /**
     * Decode and verify the PayGlocal callback token sent to the merchant callback URL.
     *
     * @return array<string, mixed>
     */
    public function decodeCallbackToken(string $token): array
    {
        $serializerManager = new JWSSerializerManager([
            new SignatureCompactSerializer(),
        ]);

        $verifier = new JWSVerifier(new AlgorithmManager([
            new RS256(),
        ]));

        $loader = new JWSLoader($serializerManager, $verifier, null);
        $signatureIndex = null;
        $payload = null;

        $jws = $loader->loadAndVerifyWithKey($token, $this->createVerificationPublicJwk(), $signatureIndex, $payload);
        if ($signatureIndex === null) {
            throw new Exception('PayGlocal callback signature could not be verified.');
        }

        $decodedPayload = json_decode($payload ?? $jws->getPayload() ?? '', true);
        if (!is_array($decodedPayload)) {
            throw new Exception('PayGlocal callback payload is invalid.');
        }

        return $decodedPayload;
    }

    /**
     * Verify a PayGlocal webhook signature.
     */
    public function verifyWebhook(string $token, array $payload): bool
    {
        try {
            return $this->decodeCallbackToken($token) !== [];
        } catch (Exception $e) {
            return false;
        }
    }
}
