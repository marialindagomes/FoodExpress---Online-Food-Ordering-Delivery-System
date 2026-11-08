<?php
require "../includes/auth.php";
require_role("customer");
require "../config/database.php";
$page_title = "Menu";
include "../includes/header.php";
$cats = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>
<h2>Food Menu</h2>
<div class="filters">
    <button class="chip active" data-cat="0">All</button>
    <?php
    foreach ($cats as $c): ?>
        <button class="chip" data-cat="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></button>
    <?php endforeach; ?>
</div>
<div id="menuGrid" class="grid three"></div>
<p id="menuMsg" class="msg"></p>
<script src="<?= BASE_URL ?>/js/customer.js"></script>
<?php include "../includes/footer.php"; ?>