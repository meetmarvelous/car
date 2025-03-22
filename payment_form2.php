<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit();
}

// Check if booking details are set in the session
if (!isset($_SESSION['fromdate']) || !isset($_SESSION['todate']) || !isset($_SESSION['vhid'])) {
  echo "<script>alert('Invalid booking details. Please try again.');</script>";
  echo "<script>window.location.href = 'car-listing.php';</script>";
  exit();
}

// Get vehicle details
$vhid = $_SESSION['vhid'];
$sql = "SELECT * FROM tblvehicles WHERE id='$vhid'";
$result = mysqli_query($con, $sql);
$vehicle = mysqli_fetch_assoc($result);

if (!$vehicle) {
  echo "<script>alert('Vehicle not found.');</script>";
  echo "<script>window.location.href = 'car-listing.php';</script>";
  exit();
}

// Calculate total amount
$fromDate = $_SESSION['fromdate'];
$toDate = $_SESSION['todate'];
$days = (strtotime($toDate) - strtotime($fromDate)) / (60 * 60 * 24);
$days = intval($days); // Ensure days is a whole number
$totalAmount = $days * $vehicle['PricePerDay'];

// Ensure the total amount is an integer (Paystack requires amount in kobo)
$totalAmountKobo = intval($totalAmount); // Convert to kobo
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Titiabiks Ventures | Payment Form</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <!-- Custom Style -->
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <!-- FontAwesome -->
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>
  <!-- Header -->
  <?php include('includes/header.php'); ?>

  <!-- Page Header -->
  <section class="page-header profile_page">
    <div class="container">
      <div class="page-header_wrap">
        <div class="page-heading">
          <h1>Payment Form</h1>
        </div>
        <ul class="coustom-breadcrumb">
          <li><a href="#">Home</a></li>
          <li>Payment Form</li>
        </ul>
      </div>
    </div>
    <!-- Dark Overlay -->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Page Header -->

  <!-- Payment Form Section -->
  <section class="user_profile inner_pages">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3">
          <!-- Sidebar -->
          <?php include('includes/sidebar.php'); ?>
        </div>
        <div class="col-md-9 col-sm-9">
          <div class="profile_wrap">
            <h5 class="uppercase underline">Complete Your Payment</h5>
            <div class="my_vehicles_list">
              <div class="row">
                <div class="col-md-6">
                  <h4><?= htmlentities($vehicle['VehiclesTitle']) ?></h4>
                  <p>Price Per Day: ₦<?= htmlentities($vehicle['PricePerDay']) ?></p>
                  <p>Total Amount: ₦<?= $totalAmount ?></p>
                </div>
                <div class="col-md-6">
                  <form action="init_payment.php" method="POST">
                    <input type="hidden" name="amount" value="<?= $totalAmountKobo ?>">
                    <input type="hidden" name="vehicle_id" value="<?= $vhid ?>">
                    <input type="hidden" name="fromdate" value="<?= $fromDate ?>">
                    <input type="hidden" name="todate" value="<?= $toDate ?>">
                    <input type="hidden" name="message" value="<?= $_SESSION['message'] ?>">
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control" required placeholder="Email" value="<?= $_SESSION['login'] ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Proceed to Payment</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Payment Form Section -->

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/interface.js"></script>
</body>

</html>