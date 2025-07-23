<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

$config = new SdkConfiguration(
  
);

$auth0 = new Auth0($config);

//destroys the session
session_unset();
session_destroy();

//$auth0 -> logout is the verified path back to logout
// the logout path is configured in the auth0 dashboard
// uses header for the logout, to make things simpler to read
header('Location: ' . $auth0->logout('http://localhost/Web-Authentication-Systems-INFO-3171/security_selector.php'));
exit;
