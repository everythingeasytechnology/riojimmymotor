# Quick Reference: PayGlocal JWT Authentication

## Before vs After

### ❌ Before (INCORRECT)

```php
// Using simple Bearer token (WRONG!)
$ch = curl_init($baseUrl . '/api/checkout/create');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $secretKey,  // ❌ Not how PayGlocal works!
]);
```

**Problems:**

- Doesn't follow PayGlocal's JWT spec
- Only uses 2 credentials
- No encryption/signing
- Won't work with PayGlocal's API

---

### ✅ After (CORRECT)

```php
// Using proper JWT (JWE + JWS)
$payGlocalService = new PayGlocalService();
$auth = $payGlocalService->createAuthToken($payload);

$response = Http::withHeaders([
    'x-gl-token-external' => $auth['token'],  // ✅ JWS in header
    'Content-Type' => 'application/json',
])->post($baseUrl . '/api/v1/checkout', $payload);  // ✅ JWE in body
```

**Benefits:**

- Follows PayGlocal's official JWT specification
- Secure encryption (RSA-OAEP + AES-256-GCM)
- Proper signature verification (RS256)
- Uses 5 required credentials
- Production-ready security

---

## Credentials Required

### Old Setup (WRONG)

```
- Merchant ID
- Secret Key
❌ Missing: Public Key, Private Key, Key IDs
```

### New Setup (CORRECT)

```
1. Merchant ID (MID)           ← From: My Account → TID Details
2. Public Key ID               ← Extract from public key filename
3. Private Key ID              ← Extract from private key filename
4. PayGlocal Public Key (file) ← Download: Key Management System
5. Your Private Key (file)     ← Download: Generate RSA Key
✅ All required credentials
```

---

## JWT Token Structure

```
┌─────────────────────────────────────────────────┐
│ Step 1: Create JWE (Encrypt with Public Key)   │
├─────────────────────────────────────────────────┤
│ Header.EncryptedKey.IV.Ciphertext.Tag          │
│                                                 │
│ - Encrypts payload with PayGlocal's public key │
│ - Uses AES-256-GCM for symmetric encryption    │
│ - Only PayGlocal can decrypt                   │
└─────────────────────────────────────────────────┘
              ↓
┌─────────────────────────────────────────────────┐
│ Step 2: Create JWS (Sign with Private Key)     │
├─────────────────────────────────────────────────┤
│ Header.JWE.Signature                           │
│                                                 │
│ - Signs the JWE with your private key          │
│ - Uses RS256 (RSA with SHA256)                 │
│ - Proves request came from you                 │
└─────────────────────────────────────────────────┘
              ↓
┌─────────────────────────────────────────────────┐
│ Step 3: Send Request                           │
├─────────────────────────────────────────────────┤
│ Header: x-gl-token-external: [JWS Token]      │
│ Body:   {...original payload...}               │
│                                                 │
│ PayGlocal verifies signature + decrypts        │
└─────────────────────────────────────────────────┘
```

---

## Key Files

| File          | Purpose                              | Location                    |
| ------------- | ------------------------------------ | --------------------------- |
| `public.pem`  | PayGlocal's certificate (public key) | storage/payments/payglocal/ |
| `private.pem` | Your RSA private key (SECRET!)       | storage/payments/payglocal/ |
| (not stored)  | Public Key ID                        | From filename               |
| (not stored)  | Private Key ID                       | From filename or dashboard  |

---

## Setup Steps Summary

1. **Get Keys from PayGlocal Dashboard**

    ```
    GCC → Configure → Key Management System
    ├── Download or Copy: PayGlocal Common Certificate (.pem)
    └── Generate RSA Key → Download (.pem file) OR Copy (paste into .pem file)
    ```

2. **Identify Key IDs**

    ```
    From Filenames:
    Public:  834hinrh-8r0n-4657-34nn-fnjhjre33uur_glocal.pem
             ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
             This is the Public Key ID

    Private: 884hiurh-8e0b-4907-38nn-fuerikejr89_paygmerchant.pem
             ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
             This is the Private Key ID

    OR from Key Management Table:
    - Public Key ID is in the filename when you download PayGlocal's cert
    - Private Key ID is shown in the Key Management table for your RSA key
    ```

3. **Upload Keys to Application**

    ```
    storage/payments/payglocal/
    ├── public.pem    (PayGlocal's certificate)
    └── private.pem   (Your RSA key - ⚠️ SECRET!)
    ```

4. **Configure in Admin Panel**

    ```
    Admin → Payment Gateways → PayGlocal
    ├── Enable: Toggle ON
    ├── Mode: Sandbox (test) or Live (production)
    ├── Merchant ID: [from dashboard]
    ├── Public Key ID: [from filename]
    ├── Private Key ID: [from filename]
    ├── Public Key Path: payments/payglocal/public.pem
    ├── Private Key Path: payments/payglocal/private.pem
    └── Save
    ```

5. **Test in Sandbox**
    ```
    Place order → Select PayGlocal → Complete payment
    ```

---

## Encryption Details

### RSA-OAEP (for symmetric key)

- Asymmetric encryption for initial key exchange
- PayGlocal's public key encrypts symmetric key
- Only PayGlocal's private key can decrypt

### AES-256-GCM (for payload)

- Symmetric encryption for actual payload
- Much faster than RSA
- GCM mode provides authentication + encryption
- Uses: encrypted symmetric key, IV, authentication tag

### RS256 (for signature)

- RSA signature with SHA256
- Your private key signs the JWE
- PayGlocal verifies with your public key
- Proves authenticity and non-repudiation

---

## Security Reminders

⚠️ **CRITICAL**

- Private key downloaded only once from PayGlocal
- Never commit to git (already in .gitignore)
- Never send via email or chat
- Store securely in production
- If lost, regenerate from dashboard

✅ **SAFE**

- Public key (PayGlocal's certificate)
- Key IDs (just identifiers)
- Merchant ID
- Environment settings

---

## References

- **Official Docs**: https://docs.payglocal.in
- **Key Management**: https://docs.payglocal.in/getting-started/dashboard-and-key-management
- **Local Setup Guide**: [PAYGLOCAL_SETUP.md](PAYGLOCAL_SETUP.md)
- **Service Code**: [PayGlocalService.php](app/Services/PayGlocalService.php)
