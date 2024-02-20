<?php
session_start();
include "include/dbconnect.php";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
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
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
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
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <form action="cart_process.php" method="post">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $subtotal = 0;
                                $grandtotal = 0;
                                $fetch_cart = mysqli_query($con, "SELECT cart.*,product_master.* FROM product_master INNER JOIN cart ON product_master.pro_id = cart.pro_id WHERE cart.user_id = '" . $_SESSION['user']['user_id'] . "'");
                                while ($row = mysqli_fetch_array($fetch_cart)) {
                                    $subtotal = $row['pro_price'] * $row['pro_cart_qty'];
                                    $grandtotal += $subtotal;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="images/products/<?= $row['pro_image'] ?>" alt="" width="200px">
                                                </div>
                                                <div class="media-body">
                                                    <p><?= $row['pro_title'] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>₹<?= $row['pro_price'] ?></h5>
                                        </td>
                                        <td>
                                            <div class="product_count">

                                                <input type="number" name="pro_cart_qty[<?= $row['pro_id'] ?>]" id="sst" maxlength="12" value="<?= $row['pro_cart_qty'] ?>" title="Quantity:" class="input-text qty">

                                                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                                <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>₹<?= $subtotal ?></h5>
                                        </td>
                                        <td>
                                           <h2><a href="cart_process.php?delete_pro_cart=<?=$row['cart_id']?>"><i class="fa fa-trash text-danger"></i></a></h2>
                                        </td>
                                        

                                    </tr>
                                <?php
                                }
                                ?>

                                <tr class="bottom_button">
                                    <td>
                                        <button type="submit" name="update_cart"  class="gray_btn">Update Cart</button>
                                        
                                    </td>
                                    <td>
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td></td>
                                    <td>

                                    </td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <h5>₹<?= $grandtotal ?></h5>
                                    </td>
                                </tr>
                                <tr class="out_button_area">
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner d-flex align-items-center">
                                            <a class="gray_btn" href="shop.php">Continue Shopping</a>
                                            <?php
                                            if(mysqli_num_rows($fetch_cart)>0)
                                            {?>
                                             <a class="primary-btn" href="checkout.php">Proceed to checkout</a>
                                             <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>

    </section>
    <!--================End Cart Area =================-->

    <?php include "components/footer.php"; ?>

</body>

</html>