<?php 
session_start();                
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <header>

        <h1>Magic Mushrooms</h1>

        <nav id="pub-nav">
            <ul>
                <a href="/" class="nav-item">Home</a>
                <a href="/serie" class="nav-item">Series</a>
                <a href="/about" class="nav-item">About</a>
                <?php 
                if (!$_SESSION) {
                ?>
                <a href="/login" class="nav-item">Login</a>
                <a href="/signup" class="nav-item">Signup</a>
                <?php
                } else {
                ?>
                <a href="/logout" class="nav-item">Logout</a>
                <?php 
                }
                ?>
            </ul>
        </nav>
    </header>