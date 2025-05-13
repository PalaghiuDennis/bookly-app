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




<?php
include("conn.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid product ID.";
    exit;
}
$product_id = (int)$_GET['id'];
$query = $connection->prepare("
    SELECT books.*, categories.name AS category_name, authors.name AS author_name 
    FROM books 
    LEFT JOIN categories ON books.category_id = categories.id 
    LEFT JOIN authors ON books.author_id = authors.id 
    WHERE books.id = ?
");
$query->bind_param("i", $product_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit;
}

$product = $result->fetch_assoc();
if (isset($_GET['add_to_cart']) && $_GET['add_to_cart'] == 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    header("Location: cart.php");
    exit();
}
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-5">
            <img src="products/<?= htmlspecialchars($product['image_url']) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['title']) ?>">
        </div>
        <div class="col-md-7">
            <h2><?= htmlspecialchars($product['title']) ?></h2>
            <p><strong>Author:</strong> <?= htmlspecialchars($product['author_name'] ?? 'Unknown') ?></p>
            <p><strong>Genre:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Unknown') ?></p>
            <p><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></p>
            <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            <div class="mt-3 d-flex gap-2">
                <a href="shop.php" class="btn btn-secondary">Back to Catalog</a>
                <a href="product.php?id=<?= $product_id ?>&add_to_cart=1" class="btn btn-primary">Buy</a>
            </div>
        </div>
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
