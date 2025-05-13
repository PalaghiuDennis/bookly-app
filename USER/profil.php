<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link href="css/tiny-slider.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<title>Bookly.</title>
	</head>
	<body>

	<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

<div class="container">
	<a class="navbar-brand" href="index.php">Bookly.<span>.</span></a>

	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarsFurni">
		<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
			<li class="nav-item">
				<a class="nav-link" href="index.php">Home</a>
			</li>
			<li><a class="nav-link" href="shop.php">Shop</a></li>
			<li><a class="nav-link" href="about.php">About us</a></li>
			<li><a class="nav-link" href="contact.php">Contact us</a></li>
		</ul>

		<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
<li>
<?php
session_start();

if (isset($_SESSION['email']) && filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)) {
    echo '<a class="nav-link" href="profil.php"><img src="images/user.svg"></a>';
} else {
    echo '<a class="nav-link" href="login.php"><img src="images/user.svg"></a>';
}
?>
</li>

			<li><a class="nav-link" href="cart.php"><img src="images/cart.svg"></a></li>
		</ul>
	</div>
</div>
	
</nav>
<!-- End Header/Navigation -->




<!-- Start Contact Form -->
<div class="untree_co-section mt-5" style="padding-bottom: 100px;">
<div class="container">


<?php
include("conn.php");

if (!isset($_SESSION['email'])) {
    echo "User not logged in.";
    exit;
}
$email = $_SESSION['email'];

$userQuery = $connection->prepare("SELECT * FROM users WHERE email = ?");
$userQuery->bind_param("s", $email);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows === 0) {
    echo "User not found.";
    exit;
}
$user = $userResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['disconnect'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    } else {
        $new_name = $_POST['name'] ?? $user['name'];
        $new_password = $_POST['password'] ?? $user['password'];

        if (empty($new_password)) {
            $new_password = $user['password'];
        }

        $updateQuery = $connection->prepare("UPDATE users SET name = ?, password = ? WHERE email = ?");
        $updateQuery->bind_param("sss", $new_name, $new_password, $email);
        $updateQuery->execute();

        header("Location: profil.php");
        exit;
    }
}

$ordersQuery = $connection->prepare("SELECT * FROM orders WHERE user_id = ?");
$ordersQuery->bind_param("i", $user['id']);
$ordersQuery->execute();
$ordersResult = $ordersQuery->get_result();
$orders = [];

while ($order = $ordersResult->fetch_assoc()) {
    $order_id = $order['id'];
    $itemsQuery = $connection->prepare("
        SELECT order_items.*, books.title AS book_title 
        FROM order_items 
        JOIN books ON order_items.book_id = books.id 
        WHERE order_id = ?
    ");
    $itemsQuery->bind_param("i", $order_id);
    $itemsQuery->execute();
    $itemsResult = $itemsQuery->get_result();

    $items = [];
    while ($item = $itemsResult->fetch_assoc()) {
        $items[] = $item;
    }

    $orders[] = [
        'order_id' => $order_id,
        'total' => $order['total'],
        'status' => $order['status'],
        'address' => $order['address'],
        'created_at' => $order['created_at'],
        'items' => $items
    ];
}
?>


<div class="untree_co-section mt-5" style="padding-bottom: 100px;">
    <div class="container">
        <div class="profile-container">
            <div class="profile-box mt-5">
                <h2>User Profile</h2>
                <div class="profile-details">
                    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Password:</strong> <?= htmlspecialchars($user['password']) ?></p> 
                    <p><strong>Created At:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
                </div>

                <form method="POST" action="profil.php">
                    <div class="form-group">
                        <label for="name">New Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Leave empty to keep current">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Update Profile</button>
                </form>
                <form method="POST" action="profil.php" style="display: inline;">
                    <input type="hidden" name="disconnect" value="1">
                    <button type="submit" class="btn btn-danger mt-2">Disconnect</button>
                </form>
            </div>
            <div class="orders-box mt-5">
                <h2>Your Orders</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)) {
                            foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['order_id']) ?></td>
                                <td><?= htmlspecialchars(number_format($order['total'], 2)) ?></td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td><?= htmlspecialchars($order['address']) ?></td>
                                <td><?= htmlspecialchars($order['created_at']) ?></td>
                                <td>
                                    <button class="btn btn-success btn-sm" onclick="toggleDetails(<?= $order['order_id'] ?>)">View Details</button>
                                </td>
                            </tr>
                            <tr id="order-details-<?= $order['order_id'] ?>" style="display: none;">
                                <td colspan="6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Book Title</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order['items'] as $item): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['book_title']) ?></td>
                                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                                <td><?= htmlspecialchars(number_format($item['price'], 2)) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach;
                        } else { ?>
                            <tr><td colspan="6">No orders found.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDetails(orderId) {
    var row = document.getElementById("order-details-" + orderId);
    row.style.display = row.style.display === "none" ? "table-row" : "none";
}
</script>




</div>
</div>
  

  <script>
	const urlParams = new URLSearchParams(window.location.search);
	const status = urlParams.get('status');
  
	if (status === 'success') {
	  alert("✅ Message sent successfully!");
	} else if (status === 'error') {
	  alert("❌ Message failed to send. Please try again.");
	}
  </script>
  

		<!-- Start Footer Section -->
		<footer class="footer-section">
			<div class="container relative">
			<?php if (isset($_GET['status'])): ?>
        <div class="container mt-4">
        <?php if ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                ✅ You have successfully subscribed to the newsletter!
            </div>
        <?php elseif ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger" role="alert">
                ❌ Error: Please enter a valid name and email.
            </div>
        <?php endif; ?>
        </div>
        <?php endif; ?>
				<div class="row">
					<div class="col-lg-8">
					<div class="subscription-form" id="newsletter">
							<h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

							<form action="newsletter.php" method="POST" class="row g-3">
								<div class="col-auto">
								<input type="text" name="name" class="form-control" placeholder="Enter your name">
								</div>
								<div class="col-auto">
								<input type="email" name="email" class="form-control" placeholder="Enter your email">
								</div>
								<div class="col-auto">
									<button class="btn btn-primary">
										<span class="fa fa-paper-plane"></span>
									</button>
								</div>
							</form>

						</div>
					</div>
				</div>

				<div class="row g-5 mb-5">
					<div class="col-lg-4">
						<div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Bookly<span>.</span></a></div>
						<p class="mb-4">Welcome to Bookly — your go-to online bookstore. From timeless classics to the latest bestsellers, we bring stories to your fingertips. Discover, read, and get inspired every day.</p>

						<ul class="list-unstyled custom-social">
							<li><a href="https://www.instagram.com/dennis.palaghiu/" target="_blank" rel="noopener noreferrer"><span class="fa fa-brands fa-facebook-f"></span></a></li>
							<li><a href="https://www.instagram.com/dennis.palaghiu/" target="_blank" rel="noopener noreferrer"><span class="fa fa-brands fa-twitter"></span></a></li>
							<li><a href="https://www.instagram.com/dennis.palaghiu/" target="_blank" rel="noopener noreferrer"><span class="fa fa-brands fa-instagram"></span></a></li>
							<li><a href="https://www.linkedin.com/in/dennis-palaghiu-b7a5a8219/" target="_blank" rel="noopener noreferrer"><span class="fa fa-brands fa-linkedin"></span></a></li>
						</ul>
					</div>



				</div>

				<div class="border-top copyright">
					<div class="row pt-4">
						<div class="col-lg-6">
							<p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed by <a href="https://www.linkedin.com/in/dennis-palaghiu-b7a5a8219/" target="_blank" rel="noopener noreferrer">Palaghiu Dennis</a>
            </p>
						</div>

						<div class="col-lg-6 text-center text-lg-end">
							<ul class="list-unstyled d-inline-flex ms-auto">
								<li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
								<li><a href="#">Privacy Policy</a></li>
							</ul>
						</div>

					</div>
				</div>

			</div>
		</footer>
		<!-- End Footer Section -->	


		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/tiny-slider.js"></script>
		<script src="js/custom.js"></script>
	</body>

</html>
