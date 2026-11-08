<?php
require "../includes/auth.php";
require_role("delivery");
$page_title = "Assigned Deliveries";
include "../includes/header.php";
?>
<h2>Assigned Delivery Orders</h2>
<div id="deliveryBox"></div>
<script src="<?= BASE_URL ?>/js/delivery.js"></script>
<?php include "../includes/footer.php"; ?>