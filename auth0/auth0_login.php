<?php

//https://community.auth0.com/t/uncaught-error-class-auth0-sdk-not-found/85962/2
//sets up the vendorload once
require_once __DIR__ . '/vendor/autoload.php';

//auth0 libraries
//more information regarding Auth0 libraries
//https://github.com/auth0/auth0-PHP
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

//API keys, safe to keep as PHP is server scripting
$configuration = new SdkConfiguration(
    domain: 'dev-1d6an1dziu0b7mok.ca.auth0.com',
    clientId: '2pxfQBdNmSMFbs9mgPWdbTeLrKOkJj7Q',
    clientSecret: '663B9U3f-jteA-CvNkRQLz0ZkwmBtMZl8hj5u9m2qJGTgjhm-3bwMxyygblx7ByQ',
    cookieSecret: 'qsdgreyujnw12315431237532qvg',
    redirectUri: 'http://localhost/project/callback.php' 
);

//creates the login website point
$auth0 = new Auth0($configuration);

//directs users to login site
header('Location: ' . $auth0->login());
exit;
