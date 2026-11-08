<?php
require "../includes/auth.php";
require_role("delivery");
$page_title = "Delivery Dashboard";
include "../includes/header.php";
?>
<h2>Delivery Person Dashboard</h2>
<div class="grid three">
    <div class="card">
        <h3>Assigned Deliveries</h3>
        <p>View orders assigned to you.</p>
        <a class="btn" href="deliveries.php">Deliveries</a>
    </div>
    <div class="card">
        <h3>Delivery History</h3>
        <p>View completed deliveries.</p>
        <a class="btn" href="history.php">History</a>
    </div>
    <div class="card">
        <h3>Profile</h3>
        <a class="btn" href="../profile.php">Profile</a>
    </div>
</div>
<?php include "../includes/footer.php"; ?>