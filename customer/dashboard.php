<?php
require "../includes/auth.php";
require_role("customer");
$page_title = "Customer Dashboard";
include "../includes/header.php";
?>
<div class="card">
    <h2>Customer Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>.</p>
    <a class="btn" href="menu.php">Browse Menu</a>
</div>
<?php include "../includes/footer.php";
?>