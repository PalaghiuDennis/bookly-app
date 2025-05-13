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

		<!-- Start Header/Navigation -->
		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

			<div class="container">
				<a class="navbar-brand" href="index.php">Bookly.<span>.</span></a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
						<li class="nav-item ">
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

<?php

include("conn.php");

$name = "";
$email = "";

if (isset($_SESSION['email'])) {
    $session_email = $_SESSION['email'];
    
    $stmt = $connection->prepare("SELECT name, email FROM users WHERE email = ?");
    $stmt->bind_param("s", $session_email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $name = $user['name'];
        $email = $user['email'];
    }
    
    $stmt->close();
}

$cart_items = [];
$cart_total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $ids = implode(",", array_keys($cart));

    $query = "SELECT * FROM books WHERE id IN ($ids)";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $qty = intval($cart[$id]);
        $price = floatval($row['price']);
        $subtotal = $price * $qty;
        $cart_total += $subtotal;

        $cart_items[] = [
            'name' => $row['title'],
            'quantity' => $qty,
            'total' => $subtotal
        ];
    }
}


?>

<div class="untree_co-section">
  <div class="container">
    <div class="row mt-5">
<div class="col-md-6 mb-5">
  <h2 class="h3 mb-3 text-black">Billing Details</h2>
  <div class="p-3 p-lg-5 border bg-white">
    <div class="form-group row">
      <div class="col-md-12">
        <label for="c_companyname" class="text-black"> Name </label>
        <input type="text" class="form-control" id="c_companyname" name="c_companyname"
               value="<?= htmlspecialchars($name) ?>">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-12">
        <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address">
      </div>
    </div>
    <div class="form-group row mb-5">
      <div class="col-md-12">
        <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="c_email_address" name="c_email_address"
               value="<?= htmlspecialchars($email) ?>">
      </div>
    </div>
  </div>
</div>
<div class="col-md-6 mb-5">
  <h2 class="h3 mb-3 text-black">Your Order</h2>
  <div class="p-3 p-lg-5 border bg-white">
    <table class="table site-block-order-table mb-5">
      <thead>
        <tr>
          <th>Product</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($cart_items)): ?>
          <?php foreach ($cart_items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?> <strong class="mx-2">x</strong> <?= $item['quantity'] ?></td>
              <td>$<?= number_format($item['total'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="2">Your cart is empty.</td>
          </tr>
        <?php endif; ?>
        <tr>
          <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
          <td class="text-black">$<?= number_format($cart_total, 2) ?></td>
        </tr>
        <tr>
          <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
          <td class="text-black font-weight-bold"><strong>$<?= number_format($cart_total, 2) ?></strong></td>
        </tr>
      </tbody>
    </table>
    <div class="form-group">
	<form action="place_order.php" method="post">
  <input type="hidden" name="address" value="<?= isset($_POST['c_address']) ? htmlspecialchars($_POST['c_address']) : '' ?>">
  <button type="submit" class="btn btn-black btn-lg py-3 btn-block">Place Order</button>
</form>
    </div>
  </div>
</div>

 

    </div> <!-- .row -->
  </div> <!-- .container -->
</div> <!-- .untree_co-section -->


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