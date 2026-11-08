<?php
require "../includes/auth.php";
require_role("delivery");
require "../config/database.php";
header("Content-Type: application/json");
$a = $_REQUEST['action'] ?? '';
$uid = $_SESSION['user']['id'];
if ($a === 'list') {
   $s = $pdo->prepare("SELECT d.*,o.total_amount,o.delivery_address,o.customer_id,u.name customer FROM delivery_assignments d JOIN orders o ON o.id=d.order_id JOIN users u ON u.id=o.customer_id WHERE d.delivery_person_id=? AND d.status<>'Delivered' ORDER BY d.id DESC");
   $s->execute([$uid]);
   echo json_encode(["ok" => true, "items" => $s->fetchAll()]);
   exit;
}
if ($a === 'history') {
   $s = $pdo->prepare("SELECT d.*,o.total_amount,o.delivery_address,u.name customer FROM delivery_assignments d JOIN orders o ON o.id=d.order_id JOIN users u ON u.id=o.customer_id WHERE d.delivery_person_id=? AND d.status='Delivered' ORDER BY d.id DESC");
   $s->execute([$uid]);
   echo json_encode(["ok" => true, "items" => $s->fetchAll()]);
   exit;
}
if ($a === 'status') {
   $id = (int)$_POST['id'];
   $status = $_POST['status'];
   $allowed = ['Picked Up', 'On the Way', 'Delivered'];
   if (!in_array($status, $allowed, true)) {
      echo json_encode(["ok" => false, "message" => "Invalid status"]);
      exit;
   }
   $s = $pdo->prepare("UPDATE delivery_assignments SET status=? WHERE id=? AND delivery_person_id=?");
   $s->execute([$status, $id, $uid]);
   $orderStatus = $status;
   $o = $pdo->prepare("UPDATE orders SET status=? WHERE id=(SELECT order_id FROM delivery_assignments WHERE id=?)");
   $o->execute([$orderStatus, $id]);
   echo json_encode(["ok" => true]);
   exit;
}
