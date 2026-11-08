<?php
require "includes/auth.php";
require_login();
require "config/database.php";
$page_title = "Profile";
include "includes/header.php";
$u = $_SESSION['user'];
$s = $pdo->prepare("SELECT * FROM users WHERE id=?");
$s->execute([$u['id']]);
$u = $s->fetch();
?>
<div class="form-card">
    <h2>Manage Profile</h2>
    <form id="profileForm">
        <input name="name" value="<?= htmlspecialchars($u['name']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($u['email']) ?>" readonly>
        <input name="phone" value="<?= htmlspecialchars($u['phone'] ?? '') ?>" placeholder="Phone">
        <input name="address" value="<?= htmlspecialchars($u['address'] ?? '') ?>" placeholder="Address">
        <button class="btn">Save Profile</button>
    </form>
    <hr>
    <h3>Change Password</h3>
    <form id="passwordForm">
        <input type="password" name="old_password" placeholder="Current password" required>
        <input type="password" name="new_password" placeholder="New password" minlength="6" required>
        <button class="btn secondary">Change Password</button>
    </form>
    <p id="profileMsg" class="msg"></p>
</div>
<script>
    async function sendProfile(form, action) {
        const fd = new FormData(form);
        fd.append('action', action);
        const r = await fetch(BASE_URL + '/ajax/profile.php', {
            method: 'POST',
            body: fd
        });
        const d = await r.json();
        document.getElementById('profileMsg').textContent = d.message;
        if (d.ok) setTimeout(() => location.reload(), 600);
    }
    document.getElementById('profileForm').onsubmit = e => {
        e.preventDefault();
        sendProfile(e.target, 'profile')
    };
    document.getElementById('passwordForm').onsubmit = e => {
        e.preventDefault();
        sendProfile(e.target, 'password')
    };
</script>
<?php include "includes/footer.php"; ?>