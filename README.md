# sign-in-with-apple-php

Library for web sign in over Apple ID.

## Installation

For install please use composer.

`composer require killov/apple-sign-in`

## Basic usage

Common code
```php
$signIn = AppleSignInBuilder::create()
    ->setClientId("client")
    ->setTeamId("BDT54D54G5")
    ->setKeyPath("DG755G24FK", __DIR__ . "\keys\key.p8")
    ->setRedirectUrl($publicPath . "sign/apple-return")
    ->build();
```

Generate link for link button
```php
$state = "random_code";
$_SESSION["state"] = $state; // store to session for for distraction CSRF
$link = $signIn->createAuthUrl($state); // https://appleid.apple.com/auth/authorize?response_type=code...

```

Prepare a return endpoint (redirectUrl)
```php

$state = $_POST["state"]; 
// validate state from session
if ($_SESSION["state"] !== $state) {
    return;
}
$code = $_POST["code"];

// fetch JWT token
$jwt = $signIn->fetchAccessTokenWithAuthCode($code)->getIdTokenString()
```

Decode JWT token or use [Sign-in with Apple SDK](https://github.com/AzimoLabs/apple-sign-in-php-sdk).
