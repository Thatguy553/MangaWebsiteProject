<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-M6ST47K');
    </script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../css/style.css">
    <meta name="description" content="Work-In-Progress Manga Website Template by Thatguy553.">
    <script src="https://kit.fontawesome.com/3926abc82e.js" crossorigin="anonymous"></script>
    <script src="../vue.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>Home</title>
</head>

<script>
let logout = <?php echo  $_SESSION['logout']  ?? "'false'"; ?>;
</script>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M6ST47K" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header id="header">
        <nav class="pub-nav" id="pub-nav">
            <h1>Magic Mushrooms</h1>
            <a href="javascript:void(0);" class="icon" onclick="dropdown()"><i class="fas fa-bars"></i></a>
            <a href="/" class="nav-item">Home</a>
            <a href="/pubSeries" class="nav-item">Series</a>
            <a href="/about" class="nav-item">About</a>
            <a v-if="loggedin" href="/logout" class="nav-item">Logout</a>
            <span v-else>
                <a href="/login" class="nav-item">Login</a>
                <a href="/signup" class="nav-item">Signup</a>
            </span>

            <div v-if="admin">
                <a href="/adminSeries" class="nav-item">Series</a>
                <a href="/adminChapters" class="nav-item">Chapters</a>
            </div>
        </nav>
        <h3 id="vers">Version: 1.0.4</h3>
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