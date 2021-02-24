<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../css/style.css">
    <meta name="description" content="Work-In-Progress Manga Website Template by Thatguy553.">
    <script src="https://kit.fontawesome.com/3926abc82e.js" crossorigin="anonymous"></script>
    <title>Home</title>
</head>

<body>
    <header>
        <nav class="pub-nav" id="pub-nav">
            <h1>Magic Mushrooms</h1>
            <a href="javascript:void(0);" class="icon" onclick="dropdown()"><i class="fas fa-bars"></i></a>
            <a href="/" class="nav-item">Home</a>
            <a href="/pubSeries" class="nav-item">Series</a>
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
            if (($_SESSION['role'] ?? "") == "Admin") {
            ?>
            <a href="/adminSeries" class="nav-item">Series</a>
            <a href="/adminChapters" class="nav-item">Chapters</a>
            <?php
            }
            ?>

        </nav>
        <h3 id="vers">Version: 1.0.1</h3>
    </header>

    <script>
    function dropdown() {
        var x = document.getElementById("pub-nav");
        if (x.className === "pub-nav") {
            x.className += " responsive";
        } else {
            x.className = "pub-nav";
        }
    }
    </script>

    <main id="app">