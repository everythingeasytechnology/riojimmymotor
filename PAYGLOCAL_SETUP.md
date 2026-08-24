# PayGlocal Payment Gateway Setup Guide

## Overview

PayGlocal is a cross-border payment gateway that uses **JWT token-based authentication** (JWE + JWS). This guide explains how to properly set up PayGlocal integration in your Laravel application.

## How PayGlocal Authentication Works

PayGlocal uses a two-step JWT token creation process:

### Step 1: Create JWE (JSON Web Encryption)

- Encrypt your payment payload using **PayGlocal's public key**
- Creates a 5-part encrypted token: `header.encryptedKey.iv.ciphertext.tag`
- Only PayGlocal can decrypt this with their private key

### Step 2: Create JWS (JSON Web Signature)

- Sign the JWE using **your private key**
- Creates a 3-part signed token: `header.payload.signature`
- PayGlocal verifies your signature using your public key

### Step 3: Send the Request

- JWS goes into the `x-gl-token-external` header
- Original payload goes in the request body
- PayGlocal verifies signature, decrypts payload, and processes payment

## Required Credentials

You need **5 credentials** from PayGlocal dashboard:

| Credential                 | Where to Get                                                                           | Description                              |
| -------------------------- | -------------------------------------------------------------------------------------- | ---------------------------------------- |
| **Merchant ID (MID)**      | GCC → Profile → My Account → TID Details → Payment Gateway                             | Your merchant account identifier         |
| **PayGlocal's Public Key** | GCC → Configure → Key Management → PayGlocal Common Certificate (Download)             | Certificate to encrypt your payloads     |
| **Your Private Key**       | GCC → Configure → Key Management → Generate RSA Key (Download)                         | Your signing key - downloaded only once! |
| **Public Key ID (KID)**    | Extract from public key filename (text before first `_`)                               | Identifies PayGlocal's key to use        |
| **Private Key ID (KID)**   | Extract from private key filename (text before first `_`) OR from Key Management table | Identifies your key to use               |

## Setup Steps

### 1. Get Your Merchant ID

1. Log in to [GCC UAT](https://gcc.uat.payglocal.in) or [GCC Production](https://gcc.prod.payglocal.in)
2. Click your profile icon (top-right) → **My Account**
3. Go to **TID Details**
4. Under **Payment Gateway** section, copy your **Merchant ID (MID)**

### 2. Download PayGlocal's Public Key

1. From GCC Dashboard, go to **Configure** (left sidebar)
2. Click **Key Management System**
3. Find **PayGlocal Common Certificate**
4. Click **Download** and save the `.pem` file
5. Extract the **Public Key ID** from the filename:
    - Filename format: `[PUBLIC_KEY_ID]_[rest].pem`
    - Example: `834hinrh-8r0n-4657-34nn-fnjhjre33uur_glocal.pem`
    - Public Key ID: `834hinrh-8r0n-4657-34nn-fnjhjre33uur`

### 3. Generate and Download Your Private Key

1. From **Key Management System**, click the **Key Type** dropdown filter
2. Select **RSA** and click **Apply**
3. Click **Generate RSA Key** button (top-right)
4. Once generated, click the **Download** icon for your new RSA key
5. **⚠️ This is your only chance to download!** Save it securely
6. Extract the **Private Key ID** from the filename:
    - Filename format: `[PRIVATE_KEY_ID]_[MERCHANT_ID].pem`
    - Example: `884hiurh-8e0b-4907-38nn-fuerikejr89_paygmerchant.pem`
    - Private Key ID: `884hiurh-8e0b-4907-38nn-fuerikejr89`

### 4. Upload Keys to Your Application

Create the storage directory and upload your keys:

```bash
mkdir -p storage/payments/payglocal
# Upload public.pem (PayGlocal's certificate)
# Upload private.pem (Your RSA private key)
```

Make sure these files are **NOT** in version control (.gitignore them):

```
storage/payments/payglocal/private.pem
storage/payments/payglocal/public.pem
```

### 5. Configure in Admin Panel

1. Go to **Admin → Payment Gateways**
2. Find **PayGlocal Configs** section
3. Enable PayGlocal checkbox
4. Fill in the fields:
    - **Mode**: Select Sandbox or Live (must match your credentials)
    - **Merchant ID (MID)**: Paste your merchant ID
    - **Public Key ID**: Paste the ID extracted from public key filename
    - **Private Key ID**: Paste the ID extracted from private key filename
    - **Public Key File Path**: `payments/payglocal/public.pem`
    - **Private Key File Path**: `payments/payglocal/private.pem`
    - **Base URL**:
        - Sandbox: `https://sandbox.payglocal.in`
        - Live: `https://api.payglocal.in`
5. Click **Save Payment Configs**

### 6. Set Environment Variables (Optional)

You can also configure via `.env`:

```env
PAYGLOCAL_ENABLED=true
PAYGLOCAL_MODE=sandbox
PAYGLOCAL_MERCHANT_ID=your_merchant_id_here
PAYGLOCAL_PUBLIC_KEY_ID=834hinrh-8r0n-4657-34nn-fnjhjre33uur
PAYGLOCAL_PRIVATE_KEY_ID=884hiurh-8e0b-4907-38nn-fuerikejr89
PAYGLOCAL_PUBLIC_KEY_PATH=payments/payglocal/public.pem
PAYGLOCAL_PRIVATE_KEY_PATH=payments/payglocal/private.pem
PAYGLOCAL_BASE_URL=https://sandbox.payglocal.in
```

## Key Security Notes

⚠️ **Critical Security Reminders:**

1. **Private Key is Sensitive**
    - Downloaded once only from PayGlocal dashboard
    - Never commit to version control
    - Never share via email or chat
    - Store securely in environment-specific configuration
    - If lost, regenerate a new key pair from dashboard

2. **Environment-Specific Credentials**
    - UAT/Sandbox credentials ≠ Production credentials
    - Generate separate key pairs for each environment
    - Different Merchant IDs for each environment
    - Always use matching credentials for your environment

3. **Public Key Management**
    - PayGlocal Common Certificate is public
    - Safe to share/backup
    - May change periodically - check PayGlocal docs for rotation

## File Structure

```
storage/
├── payments/
│   └── payglocal/
│       ├── public.pem        # PayGlocal's public certificate
│       └── private.pem       # Your RSA private key (⚠️ Secret!)
```

## Testing Your Setup

1. Enable PayGlocal in sandbox mode
2. Create a test order with PayGlocal payment method
3. Verify the JWT token is created correctly (should see token in request headers)
4. Complete payment in PayGlocal sandbox checkout
5. Verify callback is processed correctly

## Troubleshooting

| Issue                                  | Solution                                                     |
| -------------------------------------- | ------------------------------------------------------------ |
| "PayGlocal credentials not configured" | Check all 5 credentials are filled in admin panel            |
| Token generation errors                | Verify public/private key files exist in storage path        |
| Signature verification failed          | Ensure private key file is correct and not corrupted         |
| "Checkout URL not returned"            | Check Base URL setting, verify credentials match environment |
| Different payment amounts              | Verify currency conversion if using non-INR currencies       |

## API Implementation Details

See [PayGlocalService.php](app/Services/PayGlocalService.php) for:

- JWT token creation (JWE + JWS)
- Checkout session creation
- Webhook signature verification

## References

- [PayGlocal Documentation](https://docs.payglocal.in)
- [Key Management Guide](https://docs.payglocal.in/getting-started/dashboard-and-key-management)
- [API Integration Overview](https://docs.payglocal.in/integration/api-overview)

## Support

For PayGlocal support: merchant.support@payglocal.in
