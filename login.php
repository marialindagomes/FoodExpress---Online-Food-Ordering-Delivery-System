<?php
$page_title = "Login";
include "includes/header.php";
?>
<div class="form-card">
    <h2>Login</h2>
    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="btn" type="submit">Login</button>
        <p id="loginMsg" class="msg"></p>
    </form>
</div>
<script src="<?= BASE_URL ?>/js/auth.js"></script>
<?php include "includes/footer.php"; ?>