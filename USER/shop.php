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
						<li class="active"><a class="nav-link" href="shop.php">Shop</a></li>
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
</li>				<li><a class="nav-link" href="cart.php"><img src="images/cart.svg"></a></li>
					</ul>
				</div>
			</div>
				
		</nav>
		<!-- End Header/Navigation -->


<?php
include("conn.php");

// Inițializează filtrarea
$where = "WHERE 1";

// Preia parametrii cu fallback (evită warninguri)
$search = $_GET['search'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$author = $_GET['author'] ?? '';
$category_id = $_GET['category_id'] ?? '';

// Filtrare titlu
if (!empty($search)) {
    $search = $connection->real_escape_string($search);
    $where .= " AND title LIKE '%$search%'";
}

// Filtrare preț minim
if (!empty($min_price)) {
    $min = (float)$min_price;
    $where .= " AND price >= $min";
}

// Filtrare preț maxim
if (!empty($max_price)) {
    $max = (float)$max_price;
    $where .= " AND price <= $max";
}

// Filtrare autor
if (!empty($author)) {
    $author = $connection->real_escape_string($author);
    $where .= " AND authors.name LIKE '%$author%'";

}

// Filtrare categorie
if (!empty($category_id)) {
    $category_id = (int)$category_id;
    $where .= " AND category_id = $category_id";
}


// Query for books
$query = "SELECT books.*, authors.name AS author_name FROM books 
          LEFT JOIN authors ON books.author_id = authors.id
          $where";
$result = $connection->query($query);
?>

<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <div class="container mt-0">
                <h2 class="mb-4">Book Catalog</h2>

                <!-- Filter -->
                <form method="get" class="row mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by title..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="min_price" class="form-control" placeholder="Min price" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="max_price" class="form-control" placeholder="Max price" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <!-- Text search for author -->
                        <input type="text" name="author" class="form-control" placeholder="Search by author" value="<?= htmlspecialchars($_GET['author'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <!-- Dropdown for genre -->
                        <select name="category_id" class="form-control">
                            <option value="">Select genre</option>
                            <?php
                            // Get categories from the database
                            $categoriesQuery = "SELECT * FROM categories";
                            $categoriesResult = $connection->query($categoriesQuery);
                            while ($category = $categoriesResult->fetch_assoc()) {
                                $selected = (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'selected' : '';
                                echo "<option value=\"{$category['id']}\" $selected>{$category['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mt-3"> <!-- Added margin-top for spacing -->
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </form>

                <!-- Products -->
                <div class="row">
                    <?php if ($result && $result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()): ?>
    <div class="col-12 col-md-6 col-lg-3 mb-4">
        <a href="product.php?id=<?= $row['id'] ?>" style="text-decoration: none; color: inherit;">
            <div class="product-item">
                <img src="products/<?= htmlspecialchars($row['image_url']) ?>" class="img-fluid product-thumbnail" alt="<?= htmlspecialchars($row['title']) ?>">
                <h3 class="product-title"><?= htmlspecialchars($row['title']) ?></h3>
                <strong class="product-price">$<?= number_format($row['price'], 2) ?></strong>
            </div>
        </a>
    </div>
<?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">No products found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



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