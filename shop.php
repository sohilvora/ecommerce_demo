<?php
session_start();
include "include/dbconnect.php";
if (isset($_GET['subcatid'])) {
	$subcatid1 = $_GET['subcatid'];
	$q = mysqli_query($con, "SELECT * FROM product_master where sub_cat_id ='{$subcatid1}'") or die(mysqli_error($con,));
	$count = mysqli_num_rows($q);
	if ($count < 1) {
		echo  "No Records Found";
	}
} else if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$q = mysqli_query($con, "SELECT * FROM product_master where pro_title like '%$search%'") or die(mysqli_error($con,));
} else if (isset($_GET['starting']) && isset($_GET['ending'])) {

	$starting = $_GET['starting'];
	$ending = $_GET['ending'];
	$q = mysqli_query($con, "SELECT * FROM product_master where pro_price between $starting and $ending") or die(mysqli_error($con,));
} else {
	$q = mysqli_query($con, "SELECT * FROM product_master") or die(mysqli_error($con,));
}
$sub_category = mysqli_query($con, "SELECT * FROM sub_category");
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Karma Shop</title>

	<!--
            CSS
            ============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body id="category">

	<?php include "components/header.php" ?>

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Shop Category page</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Fashon Category</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
						<li class="main-nav-list"><a href="shop.php"><span class="lnr lnr-arrow-right"></span>All</a></li>
						<?php
						while ($row = mysqli_fetch_array($sub_category)) {
						?>
							<li class="main-nav-list"><a href="shop.php?subcatid=<?= $row['sub_cat_id'] ?>"><span class="lnr lnr-arrow-right"></span><?= $row['sub_cat_name'] ?></a></li>
						<?php
						}
						?>
					</ul>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">

						<?php
						if (mysqli_num_rows($q)) {
							while ($r = mysqli_fetch_array($q)) {
						?>
								<!-- single product -->
								<div class="col-lg-4 col-md-6">
									<div class="single-product">
										<img class="img-fluid" src="images/products/<?= $r['pro_image'] ?>" alt="">
										<div class="product-details">
											<h6><?= $r['pro_title'] ?></h6>
											<div class="price">
												<h6>₹<?= $r['pro_price'] ?></h6>
												<h6 class="l-through">₹<?= round(($r['pro_price'] * 5 / 100) + $r['pro_price']) ?></h6>
											</div>
											<div class="prd-bottom">
												<a class="social-info">
														<form action="cart_process.php" method="post">
														<input type="hidden" name="pro_id" value="<?=$r['pro_id']?>">
														<input type="hidden" name="pro_cart_qty" value="1">
														<button class="border-0" type="submit" name="addtocart">
															<span class="ti-bag"></span>
															<p class="hover-text">add to bag</p>
														</button>
													</form>
													</a>
												<a href="detail_product.php?pro_id=<?= $r['pro_id'] ?>" class="social-info">
													<span class="lnr lnr-move"></span>
													<p class="hover-text">view more</p>
												</a>
											</div>
										</div>
									</div>
								</div>
							<?php
							}
						} else {
							?>
							<h1>Product not available</h1>
						<?php
						}
						?>
					</div>
				</section>
				<!-- End Best Seller -->
			</div>
		</div>
	</div>

	<?php include "components/footer.php" ?>
</body>

</html>