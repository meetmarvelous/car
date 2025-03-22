<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
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
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
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
    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <!-- Page Header -->
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
                <!-- Sidebar -->
                <?php include('includes/sidebar.php'); ?>
              </div>

              <div class="col-md-9 col-sm-9">
                <div class="profile_wrap">

                  <h5 class="uppercase underline">My Bookings</h5>
                  <div class="my_vehicles_list">

                    <ul class="vehicle_listing">
                      <?php
                      // Query to fetch booking details
                      $sql = "SELECT tblbooking.*, tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.Vimage1, tblvehicles.PricePerDay 
                              FROM tblbooking 
                              JOIN tblvehicles ON tblbooking.VehicleId = tblvehicles.id 
                              JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                              WHERE tblbooking.userEmail = '$useremail' 
                              ORDER BY tblbooking.id DESC";
                      $query = mysqli_query($con, $sql);

                      if (mysqli_num_rows($query) > 0) {
                        while ($result = mysqli_fetch_assoc($query)) {
                          $bookingNo = $result['BookingNumber'];
                          $transactionId = $result['transaction_id'];
                          $paymentStatus = $result['payment_status'] === 'success' ? 'Confirmed' : 'Not Confirmed';
                          $vehicleTitle = $result['VehiclesTitle'];
                          $brandName = $result['BrandName'];
                          $fromDate = $result['FromDate'];
                          $toDate = $result['ToDate'];
                          $message = $result['message'];
                          $totalDays = (strtotime($toDate) - strtotime($fromDate)) / (60 * 60 * 24);
                          $pricePerDay = $result['PricePerDay'];
                          $totalAmount = $totalDays * $pricePerDay;
                      ?>
                          <li>
                            <h4 style="color:red">Booking No #<?php echo htmlentities($result['BookingNumber']); ?></h4>
                            <div class="vehicle_img">
                              <a href="vehical-details.php?vhid=<?= htmlentities($result['VehicleId']) ?>">
                                <img src="admin/img/vehicleimages/<?= htmlentities($result['Vimage1']) ?>" alt="image">
                              </a>
                            </div>
                            <div class="vehicle_title">
                              <h6>
                                <a href="vehical-details.php?vhid=<?= htmlentities($result['VehicleId']) ?>">
                                  <?= htmlentities($brandName) ?>, <?= htmlentities($vehicleTitle) ?>
                                </a>
                              </h6>
                              <p><b>From:</b> <?= htmlentities($fromDate) ?> <b>To:</b> <?= htmlentities($toDate) ?></p>
                              <div style="float: left">
                                <p><b>Message:</b> <?= htmlentities($message) ?></p>
                                <p><b>Transaction ID:</b> <?= htmlentities($transactionId) ?></p>
                                <p><b>Payment Status:</b> <?= htmlentities($paymentStatus) ?></p>
                              </div>
                            </div>

                            <!-- Status Section -->
                            <div class="vehicle_status">
                              <?php if ($paymentStatus === 'Confirmed') { ?>
                                <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
                                <div class="clearfix"></div>
                              <?php } else { ?>
                                <a href="#" class="btn outline btn-xs">Not Confirmed Yet</a>
                                <div class="clearfix"></div>
                              <?php } ?>
                            </div>
                            <!-- Status Section -->

                          </li>
                          <h5 style="color:blue">Invoice</h5>
                          <table class="table table-bordered">
                            <tr>
                              <th>Car Name</th>
                              <th>From Date</th>
                              <th>To Date</th>
                              <th>Total Days</th>
                              <th>Rent / Day</th>
                            </tr>
                            <tr>
                              <td><?= htmlentities($vehicleTitle) ?>, <?= htmlentities($brandName) ?></td>
                              <td><?= htmlentities($fromDate) ?></td>
                              <td><?= htmlentities($toDate) ?></td>
                              <td><?= htmlentities($totalDays) ?></td>
                              <td>₦<?= htmlentities($pricePerDay) ?></td>
                            </tr>
                            <tr>
                              <th colspan="4" style="text-align:center;">Grand Total</th>
                              <th>₦<?= htmlentities($totalAmount) ?></th>
                            </tr>
                          </table>
                          <hr />
                      <?php
                        }
                      } else {
                        echo "<h5 align='center' style='color:red'>No bookings found.</h5>";
                      }
                      ?>
                    </ul>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- /User Profile Section -->

        <!-- Footer -->
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
<?php
      }
    }
  }
?>