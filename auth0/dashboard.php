<?php
session_start();

//https://community.auth0.com/t/uncaught-error-class-auth0-sdk-not-found/85962/2
//sets up the vendorload once
require_once __DIR__ . '/vendor/autoload.php';

//more information regarding Auth0 libraries
//https://github.com/auth0/auth0-PHP
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

//api keys
//safe to keep it here, as php is a server-scripting language
$configuration = new SdkConfiguration(
  
);

//establish connection
$auth0 = new Auth0($configuration);

//checks if user is authenticated already
$session = $auth0->getCredentials();

//if auth0 session doesn't exist or token expired
if (null === $session || $session->accessTokenExpired) {
    header('Location: auth0_login.php'); 
    exit;
}

//gets information regarding the user using auth0 lib
$user = $auth0->getUser();

echo "<h1>Welcome, " . htmlspecialchars($user['name']) . "!</h1>";
echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
echo "<p>You have reached the Auth0 Dashboard Page</p>";
echo '<a href="auth0_logout.php">Logout</a>';
