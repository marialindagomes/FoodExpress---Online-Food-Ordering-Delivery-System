<?php
require "../includes/auth.php";
require_role("delivery");
$page_title = "Delivery History";
include "../includes/header.php";
?>
<h2>Delivery History</h2>
<div id="historyBox"></div>
<script src="<?= BASE_URL ?>/js/delivery.js"></script>
<?php include "../includes/footer.php"; ?>