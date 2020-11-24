<?php
include __DIR__ . '/class/router.php';

$router = new Router();

// Respond to a home page request
$router->respond("GET", "/", function() {
    require __DIR__ . '/views/home.php';
});

// Strange "Wildcard" method.
$router->respond("GET", "/login", function() {
    require __DIR__ . '/views/login.php';
});

$router->respond("GET", "/signup", function() {
    require __DIR__ . '/views/signup.php';
});

$router->respond("GET", "/logout", function() {
    require __DIR__ . '/views/logout.php';
});

$router->respond("GET", "/serie", function() {
    require __DIR__ . '/views/series.php';
});