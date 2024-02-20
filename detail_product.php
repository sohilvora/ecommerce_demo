<?php
session_start();
include "include/dbconnect.php";
if (isset($_GET['pro_id'])) {
	$pid = $_GET['pro_id'];
	$detailq = mysqli_query($con, "SELECT sub_category.*,product_master.* FROM product_master INNER JOIN sub_category ON product_master.sub_cat_id = sub_category.sub_cat_id where pro_id = {$pid}") or die(mysqli_error($con));
	$r = mysqli_fetch_array($detailq);
} else {
	header("location:shop.php");
}
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
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/ion.rangeSlider.css" />
	<link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<?php include "components/header.php" ?>

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Product Details Page</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
						<a href="single-product.html">product-details</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Single Product Area =================-->
	<div class="product_image_area p-5">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<img class="img-fluid" src="images/products/<?= $r['pro_image'] ?>" alt="">
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?= $r['pro_title'] ?></h3>
						<h2>₹<?= $r['pro_price'] ?></h2>
						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> : <?= $r['sub_cat_name'] ?></a></li>
							<li><a href="#"><span>Availibility</span> : In Stock</a></li>
						</ul>
						<p><?= $r['pro_detail'] ?></p>
						<form action="cart_process.php" method="post">
							<div class="product_count">
								<select name="pro_cart_qty" id="" class="input-text qty">
									<?php
									for ($i = 1; $i <= 10; $i++) {
										echo "<option value='$i'>$i</option>";
									}
									?>
								</select>
								<input type="hidden" name="pro_id" value="<?= $r['pro_id'] ?>">
							</div>
							<div class="card_area d-flex align-items-center">
								<button type="submit" class="primary-btn" name="addtocart">Add to Cart</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->

	<?php include "components/footer.php" ?>
</body>

</html>