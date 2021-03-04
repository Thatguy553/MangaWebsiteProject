<?php
// Requires the PHP captcha files
require('../../recaptcha-master/src/autoload.php');

// The client side site key sent from login.js
$siteKey = $_POST['site-key'];

// Your server side site key 
$secret = 'YOUR_SERVER_SIDE_KEY';

// Idk some class or namespace from recaptcha php files
$recaptcha = new \ReCaptcha\ReCaptcha($secret);

$gRecaptchaResponse = $_POST['g-recaptcha-response']; //google captcha post data
$remoteIp = $_SERVER['REMOTE_ADDR']; //to get user's ip

$recaptchaErrors = ''; // blank varible to store error

$resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp); //method to verify captcha
if ($resp->isSuccess()) {
    echo json_encode(['Error' => 'false']);
} else {
    $recaptchaErrors = $resp->getErrorCodes(); // set the error in varible
    echo json_encode(['Error' => $recaptchaErrors]);
}