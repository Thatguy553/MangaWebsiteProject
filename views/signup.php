<?php
include_once __DIR__ . '/header.php';
?>
<section id="signup-page">
    <h2>Signup</h2>
    <form id="signup-form" action="#" method="post">
        <input type="text" class="signup-input" id="signup-username" name="username" placeholder="Username..." required>
        <input type="password" class="signup-input" id="signup-password" name="password" placeholder="Password..."
            required>
        <input type="password" class="signup-input" name="password" placeholder="Re-Input Password..."
            oninput="checkPass(this)" required>
        <input type="submit" id="signup-submit" name="submit" onclick="signup()">
    </form>
</section>
<script type="text/javascript" src="http://localhost/views/JS/signup.js"></script>

<?php
include_once __DIR__ . '/footer.php';
?>