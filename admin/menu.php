<?php
require "../includes/auth.php";
require_role("admin");
require "../config/database.php";
$page_title = "Admin Menu";
include "../includes/header.php";
$cats = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>
<h2>Menu Management</h2>
<div class="form-card">
    <form id="foodForm">
        <input type="hidden" name="id" id="foodId">
        <select name="category_id" id="foodCategory" required>
            <option value="">Category</option>
            <?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option><?php endforeach; ?>
        </select>
        <input name="name" id="foodName" placeholder="Food name" required>
        <input name="description" id="foodDescription" placeholder="Description">
        <input type="number" step="0.01" name="price" id="foodPrice" placeholder="Price" required>
        <button class="btn">Save Item</button>
        <button type="button" onclick="clearFood()">Clear</button>
    </form>
    <p id="foodMsg" class="msg"></p>
</div>
<div id="adminMenu"></div>
<script src="<?= BASE_URL ?>/js/admin.js"></script>
<?php include "../includes/footer.php"; ?>