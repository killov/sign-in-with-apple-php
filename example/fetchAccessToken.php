<?php
require('../vendor/autoload.php');

use Killov\AppleSignIn\AppleSignInBuilder;


$signIn = AppleSignInBuilder::create()
    ->setClientId("worldeecomAppleSignInFrontend")
    ->setTeamId("BDT54D54G5")
    ->setKeyPath("DG755G24FK", "C:\sources\sign-in-with-apple-example\asd.p8")
    ->setRedirectUrl("https://www.worldee.com/sign/apple-return")
    ->build();

$code = "cc8f11705b4b0404b8ef51762607b9623.0.rrqvu.4WpjvQzzUICYaMQ5cNw1CQ";

$token = $signIn->fetchAccessTokenWithAuthCode($code)->getIdTokenString();

print_r(json_decode(base64_decode($token)));

$claims = explode('.', $token)[1];
$claims = json_decode(base64_decode($claims));

print_r($claims);