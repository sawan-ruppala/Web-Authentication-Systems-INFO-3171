<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

$config = new SdkConfiguration(
    domain: 'dev-1d6an1dziu0b7mok.ca.auth0.com',
    clientId: '2pxfQBdNmSMFbs9mgPWdbTeLrKOkJj7Q',
    clientSecret: '663B9U3f-jteA-CvNkRQLz0ZkwmBtMZl8hj5u9m2qJGTgjhm-3bwMxyygblx7ByQ',
    cookieSecret: 'qsdgreyujnw12315431237532qvg',
    redirectUri: 'http://localhost/project/callback.php'
);

$auth0 = new Auth0($config);

//destroys the session
session_unset();
session_destroy();

//$auth0 -> logout is the verified path back to logout
// the logout path is configured in the auth0 dashboard
// uses header for the logout, to make things simpler to read
header('Location: ' . $auth0->logout('http://localhost/project/security_selector.php'));
exit;
