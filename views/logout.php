<?php

session_start();

session_unset();

$_SESSION['logout'] = "'true'";

header('Location: /');
exit;