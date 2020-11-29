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
                <a href="/" class="nav-item right">Home</a>
                <a href="/pubSeries" class="nav-item right">Series</a>
                <a href="/about" class="nav-item right">About</a>
                <?php 
                if (!$_SESSION) {
                ?>
                <a href="/login" class="nav-item left">Login</a>
                <a href="/signup" class="nav-item left">Signup</a>
                <?php
                } else {
                ?>
                <a href="/logout" class="nav-item left">Logout</a>
                <?php 
                }
                if (($_SESSION['role'] ?? "") == "Admin") {
                ?>
                <a href="/adminSeries" class="nav-item left">Series</a>
                <a href="/adminChapters" class="nav-item left">Chapters</a>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>