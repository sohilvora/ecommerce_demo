<?php
session_start();
include "include/dbconnect.php";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if ($_POST) {
    $shipping_name = mysqli_real_escape_string($con, $_POST['shipping_name']);
    $shipping_mobile = mysqli_real_escape_string($con, $_POST['shipping_mobile']);
    $shipping_email = mysqli_real_escape_string($con, $_POST['shipping_email']);
    $shipping_country = mysqli_real_escape_string($con, $_POST['shipping_country']);
    $shipping_address1 = mysqli_real_escape_string($con, $_POST['shipping_address1']);
    $shipping_address2 = mysqli_real_escape_string($con, $_POST['shipping_address2']);
    $shipping_city = mysqli_real_escape_string($con, $_POST['shipping_city']);
    $shipping_district = mysqli_real_escape_string($con, $_POST['shipping_district']);
    $shipping_zipcode = mysqli_real_escape_string($con, $_POST['shipping_zipcode']);
    $user_id = $_SESSION['user']['user_id'];
    $ordermasterq = mysqli_query($con, "INSERT INTO order_master(order_date, user_id, order_status, shipping_name, shipping_mobile,shipping_address1,shipping_address2,shipping_email,shipping_country,shipping_city,shipping_district,shipping_zipcode) 
    VALUES (CURRENT_TIMESTAMP(),'{$user_id}','pending','{$shipping_name}','{$shipping_mobile}','{$shipping_address1}','{$shipping_address2}','{$shipping_email}','{$shipping_country}','{$shipping_city}','{$shipping_district}','{$shipping_zipcode}')") or die(mysqli_error($con));
    $order_id = mysqli_insert_id($con);
    $cart_q = mysqli_query($con, "SELECT product_master.pro_price,cart.* FROM product_master INNER JOIN cart ON product_master.pro_id = cart.pro_id WHERE user_id = '$user_id'");    
    while ($cartd = mysqli_fetch_array($cart_q)) {
        $pro_id = $cartd['pro_id'];
        $pro_cart_qty = $cartd['pro_cart_qty'];
        $pro_price = $cartd['pro_price'];
        $orderdetailq = mysqli_query($con, "insert into order_details(order_id,product_id,product_qty,product_price)values('{$order_id}','{$pro_id}','{$pro_cart_qty}','{$pro_price}')") or die(mysqli_error($con));
        
        $deletecart = mysqli_query($con, "DELETE FROM cart WHERE user_id = '$user_id' AND cart_id = '" . $cartd['cart_id'] . "'");
    }
    if ($deletecart) {
        echo "<script>alert('Thanks for shopping...');window.location='index.php'</script>";
    }
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

    <!--CSS============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

    <?php include "components/header.php"; ?>

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="single-product.html">Checkout</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">

            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8 my-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#">Product <span>Total</span></a></li>
                                <?php
                                $subtotal = 0;
                                $shipping_charge = 50;
                                $fetch_cart = mysqli_query($con, "SELECT cart.*,product_master.* FROM product_master INNER JOIN cart ON product_master.pro_id = cart.pro_id WHERE cart.user_id = '" . $_SESSION['user']['user_id'] . "'");
                                while ($row = mysqli_fetch_array($fetch_cart)) {
                                    $total = $row['pro_price'] * $row['pro_cart_qty'];
                                    $subtotal += $total;
                                ?>
                                    <li><a href="#"><?= $row['pro_title']; ?><span class="middle">₹<?= $row['pro_price']; ?></span><span class="middle">x <?= $row['pro_cart_qty']; ?></span> <span class="last">₹<?= $total; ?></span></a></li>

                                <?php
                                }
                                ?>
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>₹<?= $subtotal; ?></span></a></li>
                                <li><a href="#">Shipping <span>Flat rate: ₹<?= $shipping_charge; ?></span></a></li>
                                <hr>
                                <li><a href="#">Total <span>₹<?= $subtotal + $shipping_charge; ?></span></a></li>
                            </ul>



                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h3>Billing Details</h3>
                        <form class="row contact_form" action="" method="post" novalidate="novalidate">
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" name="shipping_name" required>
                                <span class="placeholder" data-placeholder="Name"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="number" name="shipping_mobile" required>
                                <span class="placeholder" data-placeholder="Mobile number"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="email" name="shipping_email" required>
                                <span class="placeholder" data-placeholder="Email Address"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="country" name="shipping_country" required>
                                <span class="placeholder" data-placeholder="Country"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="add1" name="shipping_address1" required>
                                <span class="placeholder" data-placeholder="Address line 01"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="add2" name="shipping_address2" required>
                                <span class="placeholder" data-placeholder="Address line 02"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="city" name="shipping_city" required>
                                <span class="placeholder" data-placeholder="Town/City"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="district" name="shipping_district" required>
                                <span class="placeholder" data-placeholder="District"></span>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="zip" name="shipping_zipcode" placeholder="Postcode/ZIP" required>
                            </div>
                            <button type="submit" class="primary-btn"name="proceed">Proceed</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->

    <!-- start footer Area -->
    <?php include "components/footer.php"; ?>
    <!-- End footer Area -->



</body>

</html>