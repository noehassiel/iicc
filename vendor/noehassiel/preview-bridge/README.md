# noehassiel/preview-bridge

Lets a Laravel site be reviewed inside the noehassiel client portal. Install it in the client project; turn it on only on the preview server.

When enabled it:

- lets only the portal show the site in an iframe (`Content-Security-Policy: frame-ancestors`, drops `X-Frame-Options`);
- adds a small script that tells the portal which page the client is on, so change requests arrive with the exact page.

When disabled (the default) it does nothing: no script, no headers.

## Install

```bash
composer require noehassiel/preview-bridge
```

## Configure

```dotenv
# Preview server only. Like APP_DEBUG: keep it false everywhere else.
PREVIEW_BRIDGE=true
PREVIEW_BRIDGE_PORTAL=https://noehassiel.com
```

Optional: `php artisan vendor:publish --tag=preview-bridge-config`.

## Test

```bash
composer install
vendor/bin/pest
```
