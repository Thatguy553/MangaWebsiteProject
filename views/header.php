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
    <title>Home</title>
</head>

<body>
    <header>
        <nav id="pub-nav">
            <h1>Magic Mushrooms</h1>
            <ul>
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
            </ul>
        </nav>
        <h3 id="vers">Version: 1.0.0</h3>
    </header>