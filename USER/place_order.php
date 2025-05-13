<?php
session_start();
include("conn.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$session_email = $_SESSION['email'];
$address = $_POST['address'] ?? 'Unknown address';

$stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $session_email);
$stmt->execute();
$result = $stmt->get_result();

if (!$user = $result->fetch_assoc()) {
    die("User not found.");
}
$user_id = $user['id'];
$stmt->close();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty.");
}

$cart = $_SESSION['cart'];
$ids = implode(",", array_keys($cart));
$cart_items = [];
$cart_total = 0;

$query = "SELECT * FROM books WHERE id IN ($ids)";
$result = $connection->query($query);

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $qty = intval($cart[$id]);
    $price = floatval($row['price']);
    $subtotal = $price * $qty;
    $cart_total += $subtotal;

    $cart_items[] = [
        'book_id' => $id,
        'quantity' => $qty,
        'price' => $price
    ];
}

$stmt = $connection->prepare("INSERT INTO orders (user_id, total, address) VALUES (?, ?, ?)");
$stmt->bind_param("ids", $user_id, $cart_total, $address);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

$stmt = $connection->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");

foreach ($cart_items as $item) {
    $stmt->bind_param("iiid", $order_id, $item['book_id'], $item['quantity'], $item['price']);
    $stmt->execute();
}
$stmt->close();

unset($_SESSION['cart']);

header("Location: thankyou.php");
exit;
?>
