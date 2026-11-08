<?php
require "../includes/auth.php";
require_role("admin");
$page_title = "Admin Orders";
include "../includes/header.php";
?>
<h2>Incoming Orders</h2>
<div id="adminOrders"></div>
<script src="<?= BASE_URL ?>/js/admin.js"></script>
<?php include "../includes/footer.php"; ?>