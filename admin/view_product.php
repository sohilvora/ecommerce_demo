<?php
include "include/dbconnect.php";
if (isset($_GET['p_id'])) {
  $p_id = $_GET['p_id'];
  $query = mysqli_query($con, "DELETE FROM product WHERE p_id='$p_id'");
  if ($query) {
    echo "<script type='text/javascript'>alert('Record deleted');window.location='view_product.php';</script>";
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
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

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
          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Products</h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Id</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Name</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Price</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Detail</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Acion</h6>
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $q = mysqli_query($con, "SELECT * FROM product");
                      $i = 1;
                      if (mysqli_num_rows($q) != 0) {
                        while ($r = mysqli_fetch_array($q)) {
                      ?>

                          <tr>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-0"><?= $i ?></h6>
                            </td>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-1"><?= $r['p_name'] ?></h6>

                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal"><?= $r['p_price'] ?></p>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal"><?= $r['p_detail'] ?></p>
                            </td>
                            <td class="border-bottom-0">
                              <a href="view_product.php?p_id=<?= $r['p_id'] ?>">Delete</a>&nbsp;&nbsp;<a href="edit_product.php?p_id=<?= $r['p_id'] ?>">Edit</a>
                            </td>
                          </tr>
                        <?php
                          $i++;
                        }
                      } else {
                        ?>
                        <tr>
                          <td colspan="5">No Records Found</td>
                        </tr>
                      <?php
                      }
                      ?>

                    </tbody>
                  </table>
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