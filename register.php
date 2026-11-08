<?php
require "config/database.php";
$page_title = "Register";
include "includes/header.php";
?>
<div class="form-card">
    <h2>Create Customer Account</h2>
    <form id="registerForm">
        <input name="name" placeholder="Full name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input name="phone" placeholder="Phone">
        <input name="address" placeholder="Delivery address">
        <input type="password" name="password" placeholder="Password" minlength="6" required>
        <input type="password" name="confirm_password" placeholder="Confirm password" minlength="6" required>
        <button class="btn" type="submit">Register</button>
        <p id="registerMsg" class="msg"></p>
    </form>
    <p>Already registered? <a href="login.php">Login</a></p>
</div>
<script src="<?= BASE_URL ?>/js/auth.js"></script>
<?php include "includes/footer.php"; ?>