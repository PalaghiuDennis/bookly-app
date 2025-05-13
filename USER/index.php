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
						<li class="nav-item active">
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

<!-- Start Hero Section -->
<div class="hero" style="max-height: 650px;">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Discover Your Next <span class="d-block">Great Read</span></h1>
                    <p class="mb-4">From bestsellers to hidden gems, Bookly brings you stories that inspire, inform, and entertain — all in one place.</p>
                    <p>
                        <a href="shop.php" class="btn btn-secondary me-2">Shop Now</a>
                        <a href="about.php" class="btn btn-white-outline">Explore</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="images/couch.png" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<?php
include("conn.php");

// Interogare: cele mai vândute 3 cărți
$query = "
    SELECT books.*, authors.name AS author_name, SUM(order_items.quantity) AS total_sold
    FROM order_items
    JOIN books ON order_items.book_id = books.id
    LEFT JOIN authors ON books.author_id = authors.id
    GROUP BY books.id
    ORDER BY total_sold DESC
    LIMIT 3
";
$result = $connection->query($query);
?>

<!-- Start Product Section -->
<div class="product-section">
    <div class="container">
        <div class="row">

            <!-- Start Column 1: Text -->
            <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                <h2 class="mb-4 section-title">Books Selected with Passion and Quality</h2>
				<p class="mb-4">At Bookly, we carefully select every book in our collection — from timeless classics to modern bestsellers — to ensure you enjoy both quality and inspiration with every page.</p>
                <p class="mb-1">Discover our top 3 best-sellers chosen by readers like you. Enjoy quality content that made an impact!</p>
                <p><a href="about.php" class="btn">Explore</a></p>
            </div>
            <!-- End Column 1 -->

            <!-- Start Column 2-4: Produse -->
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                        <a class="product-item" href="product.php?id=<?= $row['id'] ?>">
                            <img src="products/<?= htmlspecialchars($row['image_url']) ?>" class="img-fluid product-thumbnail" alt="<?= htmlspecialchars($row['title']) ?>">
                            <h3 class="product-title"><?= htmlspecialchars($row['title']) ?></h3>
                            <strong class="product-price">$<?= number_format($row['price'], 2) ?></strong>
                            <span class="text-muted small d-block"><?= htmlspecialchars($row['author_name']) ?></span>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-muted">No best-sellers found.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- End Product Section -->




<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-6">
				<h2 class="section-title">Why Choose Bookly</h2>
				<p>At Bookly, we go beyond just selling books — we create an experience tailored to every reader. Here's why thousands of book lovers choose us every day:</p>

				<div class="row my-5">
					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="images/truck.svg" alt="Fast Delivery" class="img-fluid">
							</div>
							<h3>Fast &amp; Free Shipping</h3>
							<p>Get your favorite books delivered quickly and without extra cost, no matter where you are.</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="images/bag.svg" alt="Easy Shopping" class="img-fluid">
							</div>
							<h3>Easy to Shop</h3>
							<p>Our platform is designed for simplicity — find, browse, and buy books with just a few clicks.</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="images/support.svg" alt="Support" class="img-fluid">
							</div>
							<h3>24/7 Support</h3>
							<p>Have questions or issues? Our support team is always here to help, anytime you need it.</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="images/return.svg" alt="Returns" class="img-fluid">
							</div>
							<h3>Hassle-Free Returns</h3>
							<p>If you're not satisfied, returning a book is simple and straightforward — no stress, no delays.</p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-5">
				<div class="img-wrap">
					<img src="images/why-choose-us-img.jpg" alt="Why Choose Bookly" class="img-fluid">
				</div>
			</div>

		</div>
	</div>
</div>
<!-- End Why Choose Us Section -->


<!-- Start We Help Section -->
<div class="we-help-section">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-7 mb-5 mb-lg-0">
				<div class="imgs-grid">
					<div class="grid grid-1"><img src="images/img-grid-1.jpg" alt="Books"></div>
					<div class="grid grid-2"><img src="images/img-grid-2.jpg" alt="Reading"></div>
					<div class="grid grid-3"><img src="images/img-grid-3.jpg" alt="Library"></div>
				</div>
			</div>
			<div class="col-lg-5 ps-lg-5">
				<h2 class="section-title mb-4">We Help You Discover the Books You Love</h2>
				<p>At Bookly, we believe in the power of stories to inspire, educate, and entertain. Whether you're searching for the latest bestsellers, timeless classics, or niche genres, we've curated a collection for every reader. Explore our shelves and let your next adventure begin.</p>

				<ul class="list-unstyled custom-list my-4">
					<li>Curated selections across all genres</li>
					<li>Affordable prices and exclusive deals</li>
					<li>Personalized recommendations</li>
					<li>Fast and reliable delivery</li>
				</ul>
				<p><a href="about.php" class="btn">Explore</a></p>
			</div>
		</div>
	</div>
</div>
<!-- End We Help Section -->

        

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
