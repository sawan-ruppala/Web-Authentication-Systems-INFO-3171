

<?php
//a callback function to help redirect the user to the dashboard.php
//the reason why this code cannot be done in the auth0_login.php
//is that it creates an internet traffic loop
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

$configuration = new SdkConfiguration(
     domain: '',
    clientId: '',
    clientSecret: '',
    cookieSecret: '',
    redirectUri: 'http://localhost/project/callback.php'
);

//creates a new connection
$auth0 = new Auth0($configuration);

//auth flow is completed, and user is directed to dashboard
$auth0->exchange(); 


header('Location: dashboard.php');
exit;
