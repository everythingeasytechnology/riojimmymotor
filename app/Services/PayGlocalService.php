<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Exception;

class PayGlocalService
{
    private $merchantId;
    private $publicKeyId;      // PayGlocal's public key ID
    private $privateKeyId;     // Your private key ID
    private $publicKeyPath;    // Path to PayGlocal's public key
    private $privateKeyPath;   // Path to your private key
    private $baseUrl;
    private $mode;

    public function __construct()
    {
        // Read credentials from database (via Setting model) to match admin panel configuration
        $this->merchantId = Setting::getValue('payment_payglocal_merchant_id', '');
        $this->publicKeyId = Setting::getValue('payment_payglocal_public_key_id', '');
        $this->privateKeyId = Setting::getValue('payment_payglocal_private_key_id', '');
        $this->publicKeyPath = Setting::getValue('payment_payglocal_public_key_path', 'payments/payglocal/public.pem');
        $this->privateKeyPath = Setting::getValue('payment_payglocal_private_key_path', 'payments/payglocal/private.pem');
        $this->baseUrl = Setting::getValue('payment_payglocal_base_url', 'https://sandbox.payglocal.in');
        $this->mode = Setting::getValue('payment_payglocal_mode', 'sandbox');

        // Validate required credentials
        if (!$this->merchantId || !$this->publicKeyId || !$this->privateKeyId) {
            throw new Exception('PayGlocal credentials are not properly configured. Please check Admin Panel → Payment Gateways → PayGlocal Configuration.');
        }
    }

    /**
     * Create JWT tokens for PayGlocal API authentication.
     * 
     * PayGlocal requires JWE (encrypted payload) + JWS (signed encryption).
     * This follows the flow:
     * 1. Encrypt payload with PayGlocal's public key → JWE
     * 2. Sign the JWE with your private key → JWS
     * 3. Send JWS in header, encrypted payload in body
     */
    public function createAuthToken(array $payload): array
    {
        // Add metadata to payload
        $payload['mid'] = $this->merchantId;
        $payload['timestamp'] = now()->toIso8601String();

        // Create JWE (encrypted payload)
        $jwe = $this->encryptPayload($payload);

        // Create JWS (sign the JWE)
        $jws = $this->signPayload($jwe);

        return [
            'token' => $jws,
            'encrypted_payload' => $jwe,
            'headers' => [
                'x-gl-token-external' => $jws,
                'Content-Type' => 'application/json',
            ]
        ];
    }

    /**
     * Encrypt payload using PayGlocal's public key (JWE).
     * 
     * JWE format: header.encrypted_key.iv.ciphertext.tag
     */
    private function encryptPayload(array $payload): string
    {
        $json = json_encode($payload);

        // Generate random symmetric key for AES-256-GCM
        $symmetricKey = openssl_random_pseudo_bytes(32);
        $iv = openssl_random_pseudo_bytes(16);

        // Encrypt the JSON payload with AES-256-GCM
        $tag = '';
        $encrypted = openssl_encrypt(
            $json,
            'aes-256-gcm',
            $symmetricKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        // Load PayGlocal's public key and encrypt the symmetric key
        $publicKey = $this->loadPublicKey();
        $encryptedKey = '';
        openssl_public_encrypt($symmetricKey, $encryptedKey, $publicKey, OPENSSL_PKCS1_OAEP_PADDING);

        // Build JWE: header.encrypted_key.iv.ciphertext.tag
        $header = $this->base64UrlEncode(json_encode([
            'alg' => 'RSA-OAEP',
            'enc' => 'A256GCM',
            'kid' => $this->publicKeyId
        ]));

        return implode('.', [
            $header,
            $this->base64UrlEncode($encryptedKey),
            $this->base64UrlEncode($iv),
            $this->base64UrlEncode($encrypted),
            $this->base64UrlEncode($tag),
        ]);
    }

    /**
     * Sign the JWE using your private key (JWS).
     * 
     * JWS format: header.payload.signature
     * Here, payload is the entire JWE from previous step.
     */
    private function signPayload(string $jwe): string
    {
        $header = $this->base64UrlEncode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
            'kid' => $this->privateKeyId
        ]));

        // Data to sign: header.jwe
        $signatureData = "{$header}.{$jwe}";

        // Sign with your private key
        $privateKey = $this->loadPrivateKey();
        $signature = '';
        openssl_sign($signatureData, $signature, $privateKey, 'sha256WithRSAEncryption');

        return $signatureData . '.' . $this->base64UrlEncode($signature);
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
            $hint = $this->looksLikeKeyBodyWithoutPemEnvelope($keyContent)
                ? ' The configured private key appears to be missing PEM BEGIN/END lines.'
                : '';

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
     * Base64 URL encode a string (RFC 4648).
     */
    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Create a PayGlocal checkout session.
     */
    public function createCheckout(array $data): array
    {
        $payload = [
            'order_id' => $data['order_id'],
            'amount' => (float) $data['amount'],
            'currency' => $data['currency'] ?? 'USD',
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'return_url' => $data['return_url'],
            'cancel_url' => $data['cancel_url'],
            'metadata' => $data['metadata'] ?? [],
        ];

        // Generate auth token
        $auth = $this->createAuthToken($payload);

        // Make API request
        $response = Http::withHeaders([
            'x-gl-token-external' => $auth['token'],
            'Content-Type' => 'application/json',
        ])->post(rtrim($this->baseUrl, '/') . '/api/v1/checkout', $payload);

        if (!$response->successful()) {
            throw new Exception('PayGlocal API error: ' . $response->body());
        }

        $data = $response->json();
        return $data;
    }

    /**
     * Verify a PayGlocal webhook signature.
     */
    public function verifyWebhook(string $token, array $payload): bool
    {
        try {
            $parts = explode('.', $token);
            if (count($parts) !== 5) {
                return false;
            }

            // Extract components
            $header = $parts[0];
            $payload_part = implode('.', array_slice($parts, 1, 3));
            $signature = base64_decode(strtr($parts[4], '-_', '+/'));

            // Verify signature using your private key
            $privateKey = $this->loadPrivateKey();
            $signatureData = "{$header}.{$payload_part}";

            return openssl_verify($signatureData, $signature, $privateKey, 'sha256WithRSAEncryption') === 1;
        } catch (Exception $e) {
            return false;
        }
    }
}
