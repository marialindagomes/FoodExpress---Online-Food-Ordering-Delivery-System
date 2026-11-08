<?php
require "../includes/auth.php";
require_role("customer");
require "../config/database.php";
header("Content-Type: application/json");
$a = $_REQUEST['action'] ?? '';

if ($a === 'menu') {
   $cat = (int)($_GET['category_id'] ?? 0);
   if ($cat) {
      $s = $pdo->prepare("SELECT m.*,c.name category FROM menu_items m JOIN categories c ON c.id=m.category_id WHERE m.available=1 AND m.category_id=? ORDER BY m.id DESC");
      $s->execute([$cat]);
   } else $s = $pdo->query("SELECT m.*,c.name category FROM menu_items m JOIN categories c ON c.id=m.category_id WHERE m.available=1 ORDER BY m.id DESC");
   echo json_encode(["ok" => true, "items" => $s->fetchAll()]);
   exit;
}
if ($a === 'cart') {
   $cart = $_SESSION['cart'] ?? [];
   $ids = array_keys($cart);
   $items = [];
   if ($ids) {
      $in = implode(',', array_fill(0, count($ids), '?'));
      $s = $pdo->prepare("SELECT * FROM menu_items WHERE id IN($in)");
      $s->execute($ids);
      $rows = $s->fetchAll();
      foreach ($rows as $r) {
         $q = (int)$cart[$r['id']];
         $r['quantity'] = $q;
         $r['subtotal'] = $q * $r['price'];
         $items[] = $r;
      }
   }
   echo json_encode(["ok" => true, "items" => $items]);
   exit;
}
if ($a === 'add') {
   $id = (int)$_POST['id'];
   $q = max(1, (int)($_POST['quantity'] ?? 1));
   $s = $pdo->prepare("SELECT id FROM menu_items WHERE id=? AND available=1");
   $s->execute([$id]);
   if (!$s->fetchColumn()) {
      echo json_encode(["ok" => false, "message" => "Item unavailable."]);
      exit;
   }
   if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
   $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $q;
   echo json_encode(["ok" => true, "message" => "Added to cart."]);
   exit;
}
if ($a === 'remove') {
   $id = (int)$_POST['id'];
   unset($_SESSION['cart'][$id]);
   echo json_encode(["ok" => true]);
   exit;
}
if ($a === 'qty') {
   $id = (int)$_POST['id'];
   $q = (int)$_POST['quantity'];
   if ($q <= 0) unset($_SESSION['cart'][$id]);
   else $_SESSION['cart'][$id] = $q;
   echo json_encode(["ok" => true]);
   exit;
}
if ($a === 'place') {
   $address = trim($_POST['address'] ?? '');
   $cart = $_SESSION['cart'] ?? [];
   if (!$cart || !$address) {
      echo json_encode(["ok" => false, "message" => "Cart or delivery address is empty."]);
      exit;
   }
   $pdo->beginTransaction();
   try {
      $ids = array_keys($cart);
      $in = implode(',', array_fill(0, count($ids), '?'));
      $s = $pdo->prepare("SELECT * FROM menu_items WHERE id IN($in) AND available=1");
      $s->execute($ids);
      $rows = $s->fetchAll();
      $total = 0;
      foreach ($rows as $r) $total += $r['price'] * $cart[$r['id']];
      $o = $pdo->prepare("INSERT INTO orders(customer_id,total_amount,delivery_address) VALUES(?,?,?)");
      $o->execute([$_SESSION['user']['id'], $total, $address]);
      $oid = $pdo->lastInsertId();
      $oi = $pdo->prepare("INSERT INTO order_items(order_id,menu_item_id,quantity,unit_price) VALUES(?,?,?,?)");
      foreach ($rows as $r) $oi->execute([$oid, $r['id'], $cart[$r['id']], $r['price']]);
      unset($_SESSION['cart']);
      $pdo->commit();
      echo json_encode(["ok" => true, "order_id" => $oid]);
   } catch (Exception $e) {
      $pdo->rollBack();
      echo json_encode(["ok" => false, "message" => "Could not place order."]);
   }
   exit;
}
if ($a === 'orders') {
   $s = $pdo->prepare("SELECT * FROM orders WHERE customer_id=? ORDER BY id DESC");
   $s->execute([$_SESSION['user']['id']]);
   $orders = $s->fetchAll();
   foreach ($orders as &$o) {
      $q = $pdo->prepare("SELECT oi.*,m.name FROM order_items oi JOIN menu_items m ON m.id=oi.menu_item_id WHERE order_id=?");
      $q->execute([$o['id']]);
      $o['items'] = $q->fetchAll();
   }
   echo json_encode(["ok" => true, "orders" => $orders]);
   exit;
}
