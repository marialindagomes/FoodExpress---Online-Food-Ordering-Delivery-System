<?php
require "../includes/auth.php";
require_role("customer");
$page_title = "Orders";
include "../includes/header.php";
?>
<h2>My Orders</h2>
<div id="ordersBox"></div>
<script src="<?= BASE_URL ?>/js/customer.js"></script>
<?php include "../includes/footer.php"; ?>