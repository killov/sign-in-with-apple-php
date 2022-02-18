<?php
require('../vendor/autoload.php');

use Killov\AppleSignIn\AppleSignInBuilder;

$signIn = AppleSignInBuilder::create()
    ->setClientId("worldeecomAppleSignInFrontend")
    ->setTeamId("BDT54D54G5")
    ->setKeyPath("DG755G24FK", "C:\sources\sign-in-with-apple-example\asd.p8")
    ->setRedirectUrl("https://www.worldee.com/sign/apple-return")
    ->build();

echo $signIn->createAuthUrl("asd");
