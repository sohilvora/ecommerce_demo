<?php
include "include/dbconnect.php";
if ($_POST) {
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_detail = $_POST['p_detail'];
    $q = mysqli_query($con, "INSERT INTO product(p_name, p_price, p_detail) VALUES ('$p_name','$p_price','$p_detail')");

    if ($q) {
        echo "<script type='text/javascript'>alert('Record Added');window.location='view_product.php';</script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    
    <!--  Sidebar Start -->
    <?php include "include/sidebar.php"; ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php include "include/header.php"; ?>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Add Product</h5>
              <div class="card">
                <div class="card-body">
                  <form action="" method="POST">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Product Name</label>
                      <input type="text" class="form-control" name="p_name" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Product Price</label>
                      <input type="text" class="form-control" name="p_price" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Product Detail</label>
                      <input type="text" class="form-control" name="p_detail" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <a href="view_product.php" class="btn btn-info">View Product</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>