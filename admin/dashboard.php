<?php
require "../includes/auth.php";
require_role("admin");
$page_title = "Admin Dashboard";
include "../includes/header.php";
?>
<h2>Restaurant Admin Dashboard</h2>
<div class="grid three">
    <div class="card">
        <h3>Menu Management</h3>
        <p>Add, edit and remove menu items.</p>
        <a class="btn" href="menu.php">Manage Menu</a>
    </div>
    <div class="card">
        <h3>Incoming Orders</h3>
        <p>Accept, reject and update customer orders.</p>
        <a class="btn" href="orders.php">Manage Orders</a>
    </div>
    <div class="card">
        <h3>Profile</h3>
        <p>Manage your account information.</p>
        <a class="btn" href="../profile.php">Profile</a>
    </div>
</div>
<?php include "../includes/footer.php"; ?>