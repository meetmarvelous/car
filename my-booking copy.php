<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    $useremail = $_SESSION['login']; // Get the logged-in user's email
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Titiabiks Ventures | My Booking</title>
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
                    <h1>My Booking</h1>
                </div>
                <ul class="coustom-breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li>My Booking</li>
                </ul>
            </div>
        </div>
        <!-- Dark Overlay -->
        <div class="dark-overlay"></div>
    </section>
    <!-- /Page Header -->

    <!-- User Profile Section -->
    <section class="user_profile inner_pages">
        <div class="container">
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
                                $sql = "SELECT tblbooking.*, tblvehicles.VehiclesTitle, tblbrands.BrandName 
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
                                <li class="gray-bg">
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
                                        <p><b>Message:</b> <?= htmlentities($message) ?></p>
                                        <p><b>Transaction ID:</b> <?= htmlentities($transactionId) ?></p>
                                        <p><b>Payment Status:</b> <?= htmlentities($paymentStatus) ?></p>
                                    </div>
                                    <div class="vehicle_status">
                                        <?php if ($paymentStatus === 'Confirmed') { ?>
                                            <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
                                        <?php } else { ?>
                                            <a href="#" class="btn outline btn-xs">Not Confirmed</a>
                                        <?php } ?>
                                    </div>
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
                                </li>
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
</body>

</html>
<?php
}
?>