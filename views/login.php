<?php
include_once __DIR__ . '/header.php';
?>
<section id="login-page">
    <h2 id="title">Login</h2>
    <form id="login-form" action="?" method="post">
        <input type="text" id="login-username" class="login-input" name="username" placeholder="Username..." required>
        <input type="password" id="login-password" class="login-input" name="password" placeholder="Password..."
            required>
        <div id="g-recaptcha"></div>
        <input type="submit" id="login-submit" name="submit">
    </form>
</section>

<script type="text/javascript" src="http://localhost/views/JS/login.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
</script>

<?php
include_once __DIR__ . '/footer.php';
?>