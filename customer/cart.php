<?php
require "../includes/auth.php";
require_role("customer");
$page_title = "Cart";
include "../includes/header.php";
?>
<h2>Your Cart</h2>
<div id="cartBox"></div>
<script src="<?= BASE_URL ?>/js/customer.js"></script>
<?php include "../includes/footer.php"; ?>