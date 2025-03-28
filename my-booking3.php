<?php
session_start();
error_reporting(0);
include('includes/config.php');
require 'vendor/autoload.php'; // Paystack library

// Redirect if not logged in
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
  exit();
}

$userEmail = $_SESSION['login'];

// ====================== 1. HANDLE NEW BOOKING SUBMISSION ======================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Validate required fields
  if (!isset($_POST['fromdate']) || !isset($_POST['todate']) || !isset($_POST['vehicle_id'])) {
    die("Invalid booking data.");
  }

  // Calculate booking amount
  $vehicleId = $_POST['vehicle_id'];
  $fromDate = $_POST['fromdate'];
  $toDate = $_POST['todate'];
  $message = $_POST['message'] ?? '';
  $pickup = $_POST['pickup'] ?? '';

  // Get vehicle price
  $sql = "SELECT PricePerDay FROM tblvehicles WHERE id = '$vehicleId'";
  $result = mysqli_query($con, $sql);
  $vehicle = mysqli_fetch_assoc($result);

  if (!$vehicle) {
    die("Vehicle not found.");
  }

  $days = (strtotime($toDate) - strtotime($fromDate)) / (60 * 60 * 24);
  $totalAmount = $days * $vehicle['PricePerDay'];
  $amountInKobo = $totalAmount * 100;

  // Generate booking number
  $bookingNo = mt_rand(100000000, 999999999);

  // Create booking (status = 0 → pending payment)
  $sql = "INSERT INTO tblbooking (BookingNumber, userEmail, VehicleId, FromDate, ToDate, message, pickup, Status, payment_status)
            VALUES ('$bookingNo', '$userEmail', '$vehicleId', '$fromDate', '$toDate', '$message', '$pickup', 0, 'pending')";

  if (mysqli_query($con, $sql)) {
    $bookingId = mysqli_insert_id($con);

    // Store payment details in session
    $_SESSION['pending_payment'] = [
      'booking_id' => $bookingId,
      'booking_no' => $bookingNo,
      'amount' => $amountInKobo,
      'email' => $userEmail,
      'vehicle_id' => $vehicleId
    ];

    // Redirect to avoid form resubmission
    header("Location: my-booking.php?new_booking=1");
    exit();
  } else {
    die("Error creating booking: " . mysqli_error($con));
  }
}

// ====================== 2. HANDLE PAYMENT INITIATION ======================
if (isset($_GET['new_booking']) && isset($_SESSION['pending_payment'])) {
  $paymentData = $_SESSION['pending_payment'];
  $paystack = new Yabacon\Paystack('sk_test_73ef2c03b79c54431a14e36f8582f59a7f332780');
  $reference = uniqid('txn_');

  try {
    // Initialize Paystack payment
    $transaction = $paystack->transaction->initialize([
      'email' => $paymentData['email'],
      'amount' => $paymentData['amount'],
      'reference' => $reference,
      'callback_url' => 'http://localhost/Recent/carrental/payment_confirmation.php',
      'metadata' => [
        'booking_id' => $paymentData['booking_id'],
        'booking_no' => $paymentData['booking_no']
      ]
    ]);

    // Update booking with transaction ID
    $sql = "UPDATE tblbooking SET transaction_id = '$reference' WHERE id = '{$paymentData['booking_id']}'";
    mysqli_query($con, $sql);

    // Record transaction
    $amountInNaira = $paymentData['amount'] / 100;
    $sql = "INSERT INTO transactions (userEmail, booking_id, transaction_id, amount, payment_status)
                VALUES ('$userEmail', '{$paymentData['booking_id']}', '$reference', '$amountInNaira', 'pending')";
    mysqli_query($con, $sql);

    // Clear session to prevent reprocessing
    unset($_SESSION['pending_payment']);

    // Redirect to Paystack
    header("Location: " . $transaction->data->authorization_url);
    exit();
  } catch (Exception $e) {
    $error = "Payment failed: " . $e->getMessage();
  }
}

// ====================== 3. DISPLAY USER'S BOOKINGS ======================
?>
<!DOCTYPE HTML>
<html lang="en">

<head>

  <title>Titiabiks Ventures - My Booking</title>
  <!--Bootstrap -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <!--Custome Style -->
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <!--OWL Carousel slider-->
  <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
  <!--slick-slider -->
  <link href="assets/css/slick.css" rel="stylesheet">
  <!--bootstrap-slider -->
  <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
  <!--FontAwesome Font Style -->
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <!-- SWITCHER -->
  <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all"
    data-default-color="true" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144"
    href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114"
    href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
  <link rel="apple-touch-icon-precomposed" sizes="72x72"
    href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
  <!-- Google-Font-->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!--Page Header-->
  <!-- /Header -->

  <!--Page Header-->
  <section class="page-header profile_page">
    <div class="container">
      <div class="page-header_wrap">
        <div class="page-heading">
          <h1>My Booking</h1>
        </div>
        <ul class="coustom-breadcrumb">
          <li><a href="#">Home</a></li>
          <li>My Booking</li>
        </ul>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Page Header-->

  <?php
  $useremail = $_SESSION['login'];
  $sql = "SELECT * FROM tblusers WHERE EmailId = '$useremail'";
  $query = mysqli_query($con, $sql);
  if (mysqli_num_rows($query) > 0) {
    while ($result = mysqli_fetch_assoc($query)) { ?>
      <section class="user_profile inner_pages">
        <div class="container">
          <div class="user_profile_info gray-bg padding_4x4_40">
            <div class="upload_user_logo"> <img src="assets/images/dealer-logo.jpg" alt="image">
            </div>

            <div class="dealer_info">
              <h5><?php echo htmlentities($result['FullName']); ?></h5>
              <p><?php echo htmlentities($result['Address']); ?><br>
                <?php echo htmlentities($result['City']); ?>&nbsp;<?php echo htmlentities($result['Country']); ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-sm-3">
              <?php include('includes/sidebar2.php'); ?>

              <div class="col-md-8 col-sm-8">
                <div class="profile_wrap">
                  <h5 class="uppercase underline">My Bookings </h5>
                  <div class="my_vehicles_list">
                    <ul class="vehicle_listing">
                      <?php
                      // Query to fetch booking details

                      $sql = "SELECT tblvehicles.Vimage1 AS Vimage1, tblvehicles.VehiclesTitle, tblvehicles.id AS vid, tblbrands.BrandName, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.Status, tblvehicles.PricePerDay, DATEDIFF(tblbooking.ToDate, tblbooking.FromDate) AS totaldays, tblbooking.BookingNumber, tblbooking.transaction_id, tblbooking.payment_status, tblbooking.pickup FROM tblbooking JOIN tblvehicles ON tblbooking.VehicleId = tblvehicles.id JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand WHERE tblbooking.userEmail = '$useremail' ORDER BY tblbooking.id DESC";
                      $query = mysqli_query($con, $sql);

                      if (mysqli_num_rows($query) > 0) {
                        while ($result = mysqli_fetch_assoc($query)) {
                          $bookingNo = $result['BookingNumber'];
                          $transactionId = $result['transaction_id'];
                          $paymentStatus = $result['payment_status'] === 'success' ? 'Confirmed' : 'Not Confirmed Yet';
                          $vehicleTitle = $result['VehiclesTitle'];
                          $brandName = $result['BrandName'];
                          $fromDate = $result['FromDate'];
                          $toDate = $result['ToDate'];
                          $message = $result['message'];
                          $totalDays = $result['totaldays'];
                          $pricePerDay = $result['PricePerDay'];
                          $totalAmount = $totalDays * $pricePerDay; ?>

                          <li>
                            <h4 style="color:red">Booking No #<?php echo htmlentities($result['BookingNumber']); ?></h4>
                            <div class="vehicle_img"> <a
                                href="vehical-details.php?vhid=<?php echo htmlentities($result['vid']); ?>"><img
                                  src="admin/img/vehicleimages/<?php echo htmlentities($result['Vimage1']); ?>" alt="image"></a>
                            </div>
                            <div class="vehicle_title">

                              <h6><a href="vehical-details.php?vhid=<?php echo htmlentities($result['vid']); ?>">
                                  <?php echo htmlentities($result['BrandName']); ?>,
                                  <?php echo htmlentities($result['VehiclesTitle']); ?></a></h6>
                              <p><b>From </b> <?php echo htmlentities($result['FromDate']); ?> <b>To </b>
                                <?php echo htmlentities($result['ToDate']); ?></p>
                              <div style="float: left">
                                <p><b>Message:</b> <?php echo htmlentities($result['message']); ?> </p>
                                <p><b>Transaction ID:</b> <?php echo htmlentities($result['transaction_id']); ?></p>
                                <p><b>Payment Status:</b> <?php echo htmlentities($paymentStatus); ?></p>
                                <p><b>Pickup Location:</b> <?php echo htmlentities($result['pickup']); ?></p>
                              </div>
                            </div>

                            <!-- Status Section -->

                            <div class="vehicle_status">
                              <?php if ($paymentStatus === 'Confirmed') { ?>
                                <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
                                <div class="clearfix"></div>
                              <?php } else { ?>
                                <a href="repay_process.php?bookingno=<?php echo htmlentities($result['BookingNumber']); ?>" class="btn outline btn-xs">Pay To Confirm</a>
                                <div class="clearfix"></div>
                              <?php } ?>
                            </div>

                            <!-- Status Section -->

                          </li>

                          <h5 style="color:blue">Invoice</h5>
                          <table>
                            <tr>
                              <th>Car Name</th>
                              <th>From Date</th>
                              <th>To Date</th>
                              <th>Total Days</th>
                              <th>Rent / Day</th>
                            </tr>
                            <tr>
                              <td><?php echo htmlentities($result['VehiclesTitle']); ?>,
                                <?php echo htmlentities($result['BrandName']); ?>
                              </td>
                              <td><?php echo htmlentities($result['FromDate']); ?></td>
                              <td> <?php echo htmlentities($result['ToDate']); ?></td>
                              <td><?php echo htmlentities($tds = $result['totaldays']); ?></td>
                              <td> <?php echo htmlentities($ppd = $result['PricePerDay']); ?></td>
                            </tr>
                            <tr>
                              <th colspan="4" style="text-align:center;"> Grand Total</th>
                              <th>₦<?php echo htmlentities($tds * $ppd); ?></th>
                            </tr>
                          </table>
                          <hr />
                        <?php }
                      } else { ?>
                        <h5 align="center" style="color:red">No booking yet</h5>
                      <?php } ?>

                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--/my-vehicles-->
      <?php include('includes/footer.php'); ?>

      <!-- Scripts -->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/interface.js"></script>
      <!--Switcher-->
      <script src="assets/switcher/js/switcher.js"></script>
      <!--bootstrap-slider-JS-->
      <script src="assets/js/bootstrap-slider.min.js"></script>
      <!--Slider-JS-->
      <script src="assets/js/slick.min.js"></script>
      <script src="assets/js/owl.carousel.min.js"></script>
</body>

</html>
<?php }
  }
?>