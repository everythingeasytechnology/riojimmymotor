# PayGlocal Private Key: Copy vs Download Options

## Updated Information

PayGlocal's Key Management System provides **two options** for getting your private key:

### Option 1: Download (Traditional)

- Click the **Download** icon in the Key Management table
- This downloads the `.pem` file directly to your computer
- The filename contains your Private Key ID

### Option 2: Copy (Newer UI)

- Click the **Copy** button to copy the key content to clipboard
- You'll need to manually create a `.pem` file with the content
- The Private Key ID is shown in the Key Management table

## How to Use the Copy Option

If you see the **Copy** button instead of Download:

1. **Copy the Key Content**

    ```
    Key Management System → RSA Section
    └── Your generated key
        └── Click "Copy" button
    ```

2. **Find Your Private Key ID**

    ```
    In the same table, look at the "Key ID" column
    This is your PRIVATE_KEY_ID
    Note this value (e.g., 884hiurh-8e0b-4907-38nn-fuerikejr89)
    ```

3. **Create the .pem File**

    ```
    On your computer:
    1. Open a text editor (Notepad, VS Code, etc.)
    2. Paste the copied content
    3. Save as: private.pem
    4. Make sure it starts with "-----BEGIN RSA PRIVATE KEY-----"
        and ends with "-----END RSA PRIVATE KEY-----"
    ```

4. **Upload to Application**
    ```bash
    Copy private.pem to: storage/payments/payglocal/private.pem
    ```

## Important Notes

⚠️ **Critical Points:**

- The content you copy is the complete private key - treat it as sensitive!
- Don't share the key content or email it
- Keep it only in the designated `storage/payments/payglocal/` folder
- Delete it from temporary locations after uploading
- This is available only once - save it before closing the browser

✅ **File Format Check:**
Your `private.pem` file should look like:

```
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA1234567890...
... (many lines of base64 content) ...
... (private key content) ...
-----END RSA PRIVATE KEY-----
```

## Extracting Key ID from Copied Content

If you used the **Copy option**, the private key content typically follows this format in the filename (if you can see it):

```
[PRIVATE_KEY_ID]_[MERCHANT_ID].pem
```

But since you're copying, look at the **Key ID column in the Key Management table** - that's your Private Key ID.

## Updated Setup Guide

All setup documentation has been updated to include both options:

- [PAYGLOCAL_SETUP.md](PAYGLOCAL_SETUP.md) - Step 3 explains both download and copy options
- [PAYGLOCAL_CHECKLIST.md](PAYGLOCAL_CHECKLIST.md) - Section "Step 2: Get Keys from PayGlocal"
- [PAYGLOCAL_JWT_REFERENCE.md](PAYGLOCAL_JWT_REFERENCE.md) - "Setup Steps Summary"

## Troubleshooting

| Issue                           | Solution                                                              |
| ------------------------------- | --------------------------------------------------------------------- |
| Can't find Copy button          | Make sure you're in RSA section and key is generated                  |
| Private key content looks wrong | Verify it starts with `-----BEGIN RSA PRIVATE KEY-----`               |
| Key ID not visible in table     | Scroll right in Key Management table or check dashboard notifications |
| File won't upload               | Ensure file is named exactly `private.pem` with correct content       |

## Support

If you need help:

1. Double-check the key ID from the Key Management table
2. Verify the `.pem` file starts/ends with the proper markers
3. Check file permissions on `storage/payments/payglocal/` directory
4. Contact PayGlocal support: merchant.support@payglocal.in
