<?php
require_once "config.php";
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($page_title ?? 'FoodExpress') ?></title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
  <script>
    const BASE_URL = "<?= BASE_URL ?>";
  </script>
</head>

<body>
  <header class="navbar">
    <a class="brand" href="<?= BASE_URL ?>/index.php">🍔 FOOD EXPRESS</a>
    <nav>
      <a href="<?= BASE_URL ?>/index.php">Home</a>
      <?php if ($user): ?>
        <?php if ($user['role'] === 'customer'): ?>
          <a href="<?= BASE_URL ?>/customer/menu.php">Menu</a>
          <a href="<?= BASE_URL ?>/customer/cart.php">Cart</a>
          <a href="<?= BASE_URL ?>/customer/orders.php">Orders</a>
        <?php elseif ($user['role'] === 'admin'): ?>
          <a href="<?= BASE_URL ?>/admin/dashboard.php">Admin Dashboard</a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/delivery/dashboard.php">Delivery Dashboard</a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/profile.php">Profile</a>
        <a href="<?= BASE_URL ?>/logout.php">Logout</a>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/login.php">Login</a>
        <a class="btn small" href="<?= BASE_URL ?>/register.php">Register</a>
      <?php endif;
      ?>
    </nav>
  </header>
  <main class="container">