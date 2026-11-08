<?php
require "config/database.php";

$users = [
    ["Demo Customer", "customer@foodexpress.com", "customer", "01700000001", "Dhaka"],
    ["Restaurant Admin", "admin@foodexpress.com", "admin", "01700000002", "FoodExpress Restaurant"],
    ["Delivery Person", "delivery@foodexpress.com", "delivery", "01700000003", "Dhaka"]
];

$stmt = $pdo->prepare("INSERT INTO users(name,email,password,phone,address,role) VALUES(?,?,?,?,?,?) ON DUPLICATE KEY UPDATE name=VALUES(name), role=VALUES(role)");
foreach ($users as $u) {
    $stmt->execute([$u[0], $u[1], password_hash("123456", PASSWORD_DEFAULT), $u[3], $u[4], $u[2]]);
}

$items = [
    ["Burgers", "Classic Chicken Burger", "Chicken patty, lettuce and sauce", 180],
    ["Burgers", "Cheese Burger", "Beef patty with cheese", 220],
    ["Pizza", "Chicken Pizza", "Chicken, capsicum and cheese", 450],
    ["Biryani", "Chicken Biryani", "Aromatic rice with chicken", 250],
    ["Drinks", "Cold Coffee", "Chilled creamy coffee", 140],
    ["Desserts", "Chocolate Cake", "Soft chocolate cake", 160]
];

$cat = $pdo->prepare("SELECT id FROM categories WHERE name=?");
$ins = $pdo->prepare("INSERT INTO menu_items(category_id,name,description,price,image) VALUES(?,?,?,?,?)");
foreach ($items as $x) {
    $cat->execute([$x[0]]);
    $cid = $cat->fetchColumn();
    $exists = $pdo->prepare("SELECT id FROM menu_items WHERE name=?");
    $exists->execute([$x[1]]);
    if (!$exists->fetchColumn()) $ins->execute([$cid, $x[1], $x[2], $x[3], ""]);
}
echo "<h2>FoodExpress setup completed.</h2><p>Demo password for all accounts: <b>123456</b></p><p><a href='login.php'>Go to Login</a></p>";
