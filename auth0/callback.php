

<?php
//a callback function to help redirect the user to the dashboard.php
//the reason why this code cannot be done in the auth0_login.php
//is that it creates an internet traffic loop
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

$configuration = new SdkConfiguration(
     domain: 'dev-1d6an1dziu0b7mok.ca.auth0.com',
    clientId: '2pxfQBdNmSMFbs9mgPWdbTeLrKOkJj7Q',
    clientSecret: '663B9U3f-jteA-CvNkRQLz0ZkwmBtMZl8hj5u9m2qJGTgjhm-3bwMxyygblx7ByQ',
    cookieSecret: 'qsdgreyujnw12315431237532qvg',
    redirectUri: 'http://localhost/project/callback.php'
);

//creates a new connection
$auth0 = new Auth0($configuration);

//Complete the authentication flow and obtain the tokens by calling exchange()
$auth0->exchange(); 


header('Location: dashboard.php');
exit;
