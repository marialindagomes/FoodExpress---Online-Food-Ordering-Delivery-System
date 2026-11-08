<?php
$page_title = "FoodExpress";
include "includes/header.php";
?>
<section class="hero">
  <div>
    <h1>FoodExpress</h1>
    <p>Order food online, manage restaurant orders, and track deliveries from one connected platform.</p>
    <div class="actions">
      <a class="btn" href="<?= BASE_URL ?>/customer/menu.php">Browse Menu</a>
      <?php if (!$user): ?><a class="btn secondary" href="register.php">Create Account</a>
      <?php endif;
      ?>
    </div>
  </div>
</section>
<section class="grid three">
  <div class="card">
    <h3>Customer</h3>
    <p>Browse menus, add food to cart, place orders and track order history.</p>
  </div>
  <div class="card">
    <h3>Restaurant Admin</h3>
    <p>Manage menu items and accept/reject and process incoming orders.</p>
  </div>
  <div class="card">
    <h3>Delivery Person</h3>
    <p>View assigned deliveries and update delivery status and history.</p>
  </div>
</section>
<?php include "includes/footer.php"; ?>