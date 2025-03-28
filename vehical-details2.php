<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['submit'])) {
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $message = $_POST['message'];
    $useremail = $_SESSION['login'];
    $status = 0; // Payment pending
    $vhid = $_GET['vhid'];
    $bookingno = mt_rand(100000000, 999999999);

    // Validate From Date and To Date
    if (strtotime($fromdate) >= strtotime($todate)) {
        echo "<script>alert('Please ensure the start date comes before the end date.');</script>";
        echo "<script>window.location.href = window.location.href;</script>"; // Refresh the page
        exit();
    }

    // Check for overlapping bookings
    $ret = "SELECT * FROM tblbooking WHERE 
            ('$fromdate' BETWEEN date(FromDate) AND date(ToDate) OR 
             '$todate' BETWEEN date(FromDate) AND date(ToDate) OR 
             date(FromDate) BETWEEN '$fromdate' AND '$todate') AND 
            VehicleId = '$vhid'";
    $result1 = mysqli_query($con, $ret);

    if (mysqli_num_rows($result1) == 0) {
        // Store booking details in session
        $_SESSION['bookingno'] = $bookingno;
        $_SESSION['useremail'] = $useremail;
        $_SESSION['vhid'] = $vhid;
        $_SESSION['fromdate'] = $fromdate;
        $_SESSION['todate'] = $todate;
        $_SESSION['message'] = $message;
        $_SESSION['status'] = $status;

        // Redirect to payment form
        header("Location: payment_form.php");
        exit();
    } else {
        echo "<script>alert('Car already booked for these days.');</script>";
        echo "<script>window.location.href = window.location.href;</script>"; // Refresh the page
    }
}
?>


<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Titiabiks Ventures | Vehicle Details</title>
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
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>
  <!-- Start Switcher -->
  <?php // include('includes/colorswitcher.php'); 
  ?>
  <!-- /Switcher -->

  <!-- Header -->
  <?php include('includes/header.php'); ?>

  <!-- Listing-Image-Slider -->
  <?php
  $vhid = intval($_GET['vhid']);
  $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id AS bid FROM tblvehicles 
            JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
            WHERE tblvehicles.id = '$vhid'";
  $result = mysqli_query($con, $sql);
  $cnt = 1;
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $_SESSION['brndid'] = $row['bid'];
  ?>
      <section id="listing_img_slider">
        <div><img src="admin/img/vehicleimages/<?= htmlentities($row['Vimage1']) ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <div><img src="admin/img/vehicleimages/<?= htmlentities($row['Vimage2']) ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <div><img src="admin/img/vehicleimages/<?= htmlentities($row['Vimage3']) ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <div><img src="admin/img/vehicleimages/<?= htmlentities($row['Vimage4']) ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <?php if ($row['Vimage5'] != "") { ?>
          <div><img src="admin/img/vehicleimages/<?= htmlentities($row['Vimage5']) ?>" class="img-responsive" alt="image" width="900" height="560"></div>
        <?php } ?>
      </section>
      <!-- /Listing-Image-Slider -->

      <!-- Listing-detail -->
      <section class="listing-detail">
        <div class="container">
          <div class="listing_detail_head row">
            <div class="col-md-9">
              <h2><?= htmlentities($row['BrandName']) ?>, <?= htmlentities($row['VehiclesTitle']) ?></h2>
            </div>
            <div class="col-md-3">
              <div class="price_info">
                <p>₦<?= htmlentities($row['PricePerDay']) ?></p>Per Day
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-9">
              <div class="main_features">
                <ul>
                  <li> <i class="fa fa-calendar" aria-hidden="true"></i>
                    <h5><?= htmlentities($row['ModelYear']) ?></h5>
                    <p>Reg.Year</p>
                  </li>
                  <li> <i class="fa fa-cogs" aria-hidden="true"></i>
                    <h5><?= htmlentities($row['FuelType']) ?></h5>
                    <p>Fuel Type</p>
                  </li>
                  <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <h5><?= htmlentities($row['SeatingCapacity']) ?></h5>
                    <p>Seats</p>
                  </li>
                </ul>
              </div>
              <div class="listing_more_info">
                <div class="listing_detail_wrap">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs gray-bg" role="tablist">
                    <li role="presentation" class="active"><a href="#vehicle-overview" aria-controls="vehicle-overview" role="tab" data-toggle="tab">Vehicle Overview</a></li>
                    <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accessories</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!-- Vehicle Overview -->
                    <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                      <p><?= htmlentities($row['VehiclesOverview']) ?></p>
                    </div>

                    <!-- Accessories -->
                    <div role="tabpanel" class="tab-pane" id="accessories">
                      <table>
                        <thead>
                          <tr>
                            <th colspan="2">Accessories</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Air Conditioner</td>
                            <td><?= $row['AirConditioner'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>AntiLock Braking System</td>
                            <td><?= $row['AntiLockBrakingSystem'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Power Steering</td>
                            <td><?= $row['PowerSteering'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Power Windows</td>
                            <td><?= $row['PowerWindows'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>CD Player</td>
                            <td><?= $row['CDPlayer'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Leather Seats</td>
                            <td><?= $row['LeatherSeats'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Central Locking</td>
                            <td><?= $row['CentralLocking'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Power Door Locks</td>
                            <td><?= $row['PowerDoorLocks'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Brake Assist</td>
                            <td><?= $row['BrakeAssist'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Driver Airbag</td>
                            <td><?= $row['DriverAirbag'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Passenger Airbag</td>
                            <td><?= $row['PassengerAirbag'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                          <tr>
                            <td>Crash Sensor</td>
                            <td><?= $row['CrashSensor'] ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-close" aria-hidden="true"></i>' ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <?php
      }
    }
        ?>
        <!-- Side-Bar -->
        <aside class="col-md-3">
          <div class="share_vehicle">
            <p>Share:
              <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
              <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
              <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
              <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
            </p>
          </div>
          <div class="sidebar_widget">
            <div class="widget_heading">
              <h5><i class="fa fa-envelope" aria-hidden="true"></i>Book Now</h5>
            </div>
            <form method="post">

              <?php if ($_SESSION['login']) { ?>
              <div class="form-group">
                <label>From Date:</label>
                <input type="date" class="form-control" name="fromdate" required>
              </div>
              <div class="form-group">
                <label>To Date:</label>
                <input type="date" class="form-control" name="todate" required>
              </div>
              <div class="form-group">
                <textarea rows="4" class="form-control" name="message" placeholder="Message" required></textarea>
              </div>                
                <div class="form-group">
                  <input type="submit" class="btn" name="submit" value="Book Now">
                </div>
              <?php } else { ?>
                <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>
              <?php } ?>
            </form>
          </div>
        </aside>
        <!-- /Side-Bar -->
          </div>

          <div class="space-20"></div>
          <div class="divider"></div>

          <!--Similar-Cars-->
          <div class="similar_cars">
            <h3>Similar Cars</h3>
            <div class="row">
              <?php
              $bid = $_SESSION['brndid'];
              $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType, tblvehicles.ModelYear, tblvehicles.id, tblvehicles.SeatingCapacity, tblvehicles.VehiclesOverview, tblvehicles.Vimage1 FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand WHERE tblvehicles.VehiclesBrand = '$bid'";
              $result = mysqli_query($con, $sql);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <div class="col-md-3 grid_listing">
                    <div class="product-listing-m gray-bg">
                      <div class="product-listing-img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($row['id']); ?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($row['Vimage1']); ?>" class="img-responsive" alt="image" /> </a>
                      </div>
                      <div class="product-listing-content">
                        <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['BrandName']); ?>, <?php echo htmlentities($row['VehiclesTitle']); ?></a></h5>
                        <p class="list-price">₦<?php echo htmlentities($row['PricePerDay']); ?></p>
                        <ul class="features_list">
                          <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($row['SeatingCapacity']); ?> seats</li>
                          <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($row['ModelYear']); ?> model</li>
                          <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($row['FuelType']); ?></li>
                        </ul>
                      </div>
                    </div>
                  </div>
              <?php }
              } ?>
            </div>
          </div>
          <!--/Similar-Cars-->
        </div>
      </section>
      <!--/Listing-detail-->

      <!--Footer -->
      <?php include('includes/footer.php'); ?>
      <!-- /Footer-->

      <!--Back to top-->
      <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
      <!--/Back to top-->

      <!--Login-Form -->
      <?php include('includes/login.php'); ?>
      <!--/Login-Form -->

      <!--Register-Form -->
      <?php include('includes/registration.php'); ?>
      <!--/Register-Form -->

      <!--Forgot-password-Form -->
      <?php include('includes/forgotpassword.php'); ?>
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/interface.js"></script>
      <script src="assets/switcher/js/switcher.js"></script>
      <script src="assets/js/bootstrap-slider.min.js"></script>
      <script src="assets/js/slick.min.js"></script>
      <script src="assets/js/owl.carousel.min.js"></script>
</body>

</html>