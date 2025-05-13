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
						<li class="active"><a class="nav-link" href="about.php">About us</a></li>
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



	<div class="why-choose-section">
			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-6">
        <h2 class="section-title">Why Choose Us</h2>
        <p>We offer a seamless shopping experience, fast delivery, and dedicated support to make sure you enjoy every step of your journey with us.</p>

						<div class="row my-5">
							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="images/truck.svg" alt="Image" class="imf-fluid">
									</div>
          <h3>Easy Shopping</h3>
          <p>Intuitive and user-friendly platform – find and order your desired book in just a few clicks.</p>
								</div>
							</div>

							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="images/bag.svg" alt="Image" class="imf-fluid">
									</div>
              <h3>Easy Shopping</h3>
              <p>Intuitive and user-friendly platform – find and order your desired book in just a few clicks.</p>
								</div>
							</div>

							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="images/support.svg" alt="Image" class="imf-fluid">
									</div>
              <h3>24/7 Support</h3>
              <p>We're here for you anytime you have questions or need help during the purchasing process.</p>
								</div>
							</div>

							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="images/return.svg" alt="Image" class="imf-fluid">
									</div>
          <h3>Hassle-Free Returns</h3>
          <p>Not satisfied? You can return the book within 14 days, quickly and easily.</p>
								</div>
							</div>

						</div>
					</div>

					<div class="col-lg-5">
						<div class="img-wrap">
							<img src="images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- End Why Choose Us Section -->

<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
  <div class="container">
    <div class="row my-5">
      <div class="col-6 col-md-6 col-lg-3 mb-4">
        <div class="feature">
          <div class="icon">
            <img src="images/truck.svg" alt="Image" class="imf-fluid">
          </div>
          <h3>Fast & Free Delivery</h3>
          <p>Get your favorite books delivered straight to your door, with no extra costs and without long waits.</p>
        </div>
      </div>

      <div class="col-6 col-md-6 col-lg-3 mb-4">
        <div class="feature">
          <div class="icon">
            <img src="images/bag.svg" alt="Image" class="imf-fluid">
          </div>
          <h3>Easy Shopping</h3>
          <p>Intuitive and user-friendly platform – find and order your desired book in just a few clicks.</p>
        </div>
      </div>

      <div class="col-6 col-md-6 col-lg-3 mb-4">
        <div class="feature">
          <div class="icon">
            <img src="images/support.svg" alt="Image" class="imf-fluid">
          </div>
          <h3>24/7 Support</h3>
          <p>We're here for you anytime you have questions or need help during the purchasing process.</p>
        </div>
      </div>

      <div class="col-6 col-md-6 col-lg-3 mb-4">
        <div class="feature">
          <div class="icon">
            <img src="images/return.svg" alt="Image" class="imf-fluid">
          </div>
          <h3>Hassle-Free Returns</h3>
          <p>Not satisfied? You can return the book within 14 days, quickly and easily.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Why Choose Us Section -->	



		

		<!-- Start Testimonial Slider -->
        <!-- Elfsight Google Reviews | Untitled Google Reviews -->
<script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-69b534f5-e256-47f2-bc2c-a42b9ec2f144" data-elfsight-app-lazy></div>
		<!-- End Testimonial Slider -->


		

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