<?php
include_once __DIR__ . '/header.php';
?>
<section id="login-page">
    <h2 id="title">Login</h2>
    <form id="login-form" method="post">
        <input type="text" id="login-username" class="login-input" name="username" placeholder="Username..." required>
        <input type="password" id="login-password" class="login-input" name="password" placeholder="Password..."
            required>
        <input type="submit" id="login-submit" name="submit" onclick="login()">
    </form>
    <p id="message">I cant get the header to refresh itself to make the correct buttons appear after logging in, so just
        refresh
        yourself please. -- Login will be updated soon</p>
</section>

<script type="text/javascript" src="http://localhost/views/JS/login.js"></script>


<?php
include_once __DIR__ . '/footer.php';
?>