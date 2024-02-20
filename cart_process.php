<?php
session_start();
include "include/dbconnect.php";
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if (isset($_POST['addtocart'])) {
    $pro_id = mysqli_real_escape_string($con, $_POST['pro_id']);
    $pro_cart_qty = mysqli_real_escape_string($con, $_POST['pro_cart_qty']);
    $user_id = $_SESSION['user']['user_id'];
    $select_cart = mysqli_query($con, "SELECT * FROM cart WHERE user_id = '$user_id' AND pro_id = '$pro_id'");
    $cart_fetch = mysqli_fetch_array($select_cart);
    if (mysqli_num_rows($select_cart) > 0) {
        $new_pro_qty = $cart_fetch['pro_cart_qty'] + $pro_cart_qty;
        $update_query = mysqli_query($con, "UPDATE cart SET pro_cart_qty = $new_pro_qty WHERE user_id = '$user_id' AND cart_id = '" . $cart_fetch['cart_id'] . "'");
        header("location:cart.php");
    } else {
        $q = mysqli_query($con, "INSERT INTO cart(pro_id,pro_cart_qty,user_id) VALUES('$pro_id','$pro_cart_qty','$user_id')");
        header("location:cart.php");
    }
}
if (isset($_POST['update_cart'])) {
    $cart_items = $_POST['pro_cart_qty'];
    foreach ($cart_items as $pro_id => $quantity) {
        if ($quantity == 0 || $quantity < 0) {
            $sql = mysqli_query($con, "DELETE FROM  cart WHERE pro_id = '$pro_id' AND user_id = '" . $_SESSION['user']['user_id'] . "'");
        } else {
            $sql = mysqli_query($con, "UPDATE cart SET pro_cart_qty = '$quantity' WHERE pro_id = '$pro_id' AND user_id = '" . $_SESSION['user']['user_id'] . "'");
        }
    }
    if ($sql) {
        header("Location: cart.php");
    }
}
if (isset($_GET['delete_pro_cart'])) {
    $cart_id = $_GET['delete_pro_cart'];
    $q = mysqli_query($con, "DELETE FROM cart WHERE cart_id = '$cart_id' AND user_id = '" . $_SESSION['user']['user_id'] . "'");
    header("location:cart.php");
}
