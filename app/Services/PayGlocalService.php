<?php

namespace App\Services;

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
        $this->merchantId = config('payment.payglocal.merchant_id');
        $this->publicKeyId = config('payment.payglocal.public_key_id');
        $this->privateKeyId = config('payment.payglocal.private_key_id');
        $this->publicKeyPath = config('payment.payglocal.public_key_path');
        $this->privateKeyPath = config('payment.payglocal.private_key_path');
        $this->baseUrl = config('payment.payglocal.base_url');
        $this->mode = config('payment.payglocal.mode', 'sandbox');

        // Validate required credentials
        if (!$this->merchantId || !$this->publicKeyId || !$this->privateKeyId) {
            throw new Exception('PayGlocal credentials are not properly configured.');
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
            throw new Exception('PayGlocal public key could not be loaded from: ' . $this->publicKeyPath);
        }

        $key = openssl_pkey_get_public($keyContent);
        if (!$key) {
            throw new Exception('Failed to parse PayGlocal public key. Ensure it is a valid PEM certificate.');
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
            throw new Exception('Your private key could not be loaded from: ' . $this->privateKeyPath);
        }

        $key = openssl_pkey_get_private($keyContent);
        if (!$key) {
            throw new Exception('Failed to parse your private key. Ensure it is a valid PEM format RSA key.');
        }

        return $key;
    }

    /**
     * Get key file content from disk.
     */
    private function getKeyContent(string $path): ?string
    {
        // Check if it's an absolute path
        if (file_exists($path)) {
            return file_get_contents($path);
        }

        // Check in storage
        $storagePath = 'app/' . ltrim($path, '/');
        if (Storage::exists($storagePath)) {
            return Storage::get($storagePath);
        }

        // Check in storage root
        if (file_exists(storage_path($path))) {
            return file_get_contents(storage_path($path));
        }

        return null;
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
