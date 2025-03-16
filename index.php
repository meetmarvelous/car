<?php
session_start();
include('includes/config.php');
error_reporting(0);

?>

<!DOCTYPE HTML>
<html lang="en">

<head>

  <title>Titiabiks Ventures</title>
  <!--Bootstrap -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
  <link href="assets/css/slick.css" rel="stylesheet">
  <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
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
  <link rel="stylesheet" href="assets/css/marvel.css" type="text/css">

</head>

<body>

  <!-- Start Switcher -->
  <?php // include('includes/colorswitcher.php'); 
  ?>
  <!-- /Switcher -->

  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->

  <!-- Banners -->
  <section id="banner" class="banner-section">
    <div class="container">
      <div class="div_zindex">
        <div class="row">
          <div class="col-md-5 col-md-push-7">
            <div class="banner_content">
              <h1>&nbsp;</h1>
              <p>&nbsp; </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Banners -->

  <!-- Services Section -->
  <section class="custom-container">

    <!-- About Section -->
    <div class="about-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-sm-6 logo-column">
            <div class="logo-container-about">
              <img src="assets/images/logo500.svg" alt="TITIABIKS VENTURES Logo" class="about-logo">
            </div>
          </div>
          <div class="col-sm-6 text-column">
            <h2 class="section-title">About Us</h2>
            <p class="section-text">
              At TITIABIKS VENTURES, we provide top-quality car rental and chauffeur services tailored to meet your transportation needs. Whether you need a luxury ride for a special event, a reliable vehicle for business travel, or a comfortable car for your daily commute, we have the perfect solution for you.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Services Section -->
    <div class="services-section">
      <div class="container">
        <h2 class="section-title text-center">Our Services</h2>
        <div class="row service-cards">
          <div class="col-md-4 service-card">
            <i class="fa fa-car service-icon"></i>
            <h4 class="service-title">Car Rental</h4>
            <p class="service-desc">Choose from our fleet of well-maintained vehicles, ranging from economy cars to luxury SUVs. Available for short-term and long-term rentals.</p>
          </div>
          <div class="col-md-4 service-card">
            <i class="fa fa-user service-icon"></i>
            <h4 class="service-title">Chauffeur Services</h4>
            <p class="service-desc">Enjoy a stress-free ride with our professional drivers, ensuring safety, punctuality, and comfort. Ideal for corporate executives, weddings, VIPs, and airport transfers.</p>
          </div>
          <div class="col-md-4 service-card">
            <i class="fa fa-plane service-icon"></i>
            <h4 class="service-title">Airport Transfers</h4>
            <p class="service-desc">Get picked up and dropped off on time with our reliable airport transfer services.</p>
          </div>
          <div class="col-md-4 service-card">
            <i class="fa fa-building service-icon"></i>
            <h4 class="service-title">Corporate & Event Transportation</h4>
            <p class="service-desc">Impress your clients and guests with premium transportation for conferences, business meetings, and special occasions.</p>
          </div>
          <div class="col-md-4 service-card">
            <i class="fa fa-road service-icon"></i>
            <h4 class="service-title">Interstate Travel</h4>
            <p class="service-desc">Travel in comfort and style across different cities with our experienced drivers.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="why-us-section">
      <div class="container">
        <h2 class="section-title text-center">Why Choose Us?</h2>
        <div class="row feature-list">
          <div class="col-md-6 feature-item">
            <i class="fa fa-car feature-icon"></i>
            <div class="feature-content">
              <h4 class="feature-title">Variety of Vehicles</h4>
              <p class="feature-desc">From budget-friendly cars to luxury models, we have options to suit all needs.</p>
            </div>
          </div>
          <div class="col-md-6 feature-item">
            <i class="fa fa-shield feature-icon"></i>
            <div class="feature-content">
              <h4 class="feature-title">Safety & Reliability</h4>
              <p class="feature-desc">All our vehicles are regularly serviced and well-maintained for your safety.</p>
            </div>
          </div>
          <div class="col-md-6 feature-item">
            <i class="fa fa-clock-o feature-icon"></i>
            <div class="feature-content">
              <h4 class="feature-title">24/7 Availability</h4>
              <p class="feature-desc">We are always ready to serve you, anytime and anywhere.</p>
            </div>
          </div>
          <div class="col-md-6 feature-item">
            <i class="fa fa-user-circle feature-icon"></i>
            <div class="feature-content">
              <h4 class="feature-title">Professional Chauffeurs</h4>
              <p class="feature-desc">Courteous, well-trained, and experienced drivers at your service.</p>
            </div>
          </div>
          <div class="col-md-6 feature-item">
            <i class="fa fa-money feature-icon"></i>
            <div class="feature-content">
              <h4 class="feature-title">Affordable Pricing</h4>
              <p class="feature-desc">Competitive rates with no hidden charges.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action Section -->
    <div class="cta-section">
      <div class="container">
        <h2 class="cta-title">Book a Ride Today!</h2>
        <p class="cta-text">Experience seamless transportation with TITIABIKS VENTURES. Contact us today to book your ride.</p>
        <div class="contact-info">
          <div class="contact-item">
            <i class="fa fa-phone"></i>
            <span>📞 Call/WhatsApp: 08056008908</span>
          </div>
          <div class="contact-item">
            <i class="fa fa-map-marker"></i>
            <span>📍 Location: Ibadan, Oyo State. </span>
          </div>
          <div class="contact-item">
            <i class="fa fa-envelope"></i>
            <span>📧 Email: info@titiabiks.com</span>
          </div>
          <div class="contact-item">
            <i class="fa fa-globe"></i>
            <span>🌍 Website: [Your Website URL]</span>
          </div>
        </div>
      </div>
    </div>



  </section>


  <!-- Resent Cat-->
  <section class="section-padding gray-bg">
    <div class="container">
      <div class="section-header text-center">
        <h2>Find the Best <span>Car For Rental</span></h2>
        <p>Need a car for a short trip or long-term use? Choose from our range of economy, luxury, and SUV models at competitive rates.</p>
      </div>
      <div class="row">

        <!-- Nav tabs -->
        <div class="recent-tab">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#resentnewcar" role="tab" data-toggle="tab">New Car</a></li>
          </ul>
        </div>
        <!-- Recently Listed New Cars -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="resentnewcar">

            <?php
            $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType, tblvehicles.ModelYear, tblvehicles.id, tblvehicles.SeatingCapacity, tblvehicles.VehiclesOverview, tblvehicles.Vimage1 FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand LIMIT 9";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query) > 0) {
              while ($result = mysqli_fetch_assoc($query)) {
            ?>

                <div class="col-list-3">
                  <div class="recent-car-list">
                    <div class="car-info-box"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result['id']); ?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result['Vimage1']); ?>" class="img-responsive" alt="image"></a>
                      <ul>
                        <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result['FuelType']); ?></li>
                        <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result['ModelYear']); ?> Model</li>
                        <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result['SeatingCapacity']); ?> seats</li>
                      </ul>
                    </div>
                    <div class="car-title-m">
                      <h6><a href="vehical-details.php?vhid=<?php echo htmlentities($result['id']); ?>"> <?php echo htmlentities($result['VehiclesTitle']); ?></a></h6>
                      <span class="price">₦<?php echo htmlentities($result['PricePerDay']); ?> /Day</span>
                    </div>
                    <div class="inventory_info_m">
                      <p><?php echo substr($result['VehiclesOverview'], 0, 70); ?></p>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>

          </div>
        </div>
      </div>
  </section>
  <!-- /Resent Cat -->

  <!-- Fun Facts-->
  <section class="fun-facts-section">
    <div class="container div_zindex">
      <div class="row">
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-calendar" aria-hidden="true"></i>99%</h2>
              <p>Customer Satisfaction Rate</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-car" aria-hidden="true"></i>24/7</h2>
              <p>Availability & Support</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-car" aria-hidden="true"></i>20+</h2>
              <p>Professional Chauffeurs</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>200+</h2>
              <p>Monthly Bookings</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Fun Facts-->


  <!--Testimonial -->
  <section class="section-padding testimonial-section parallex-bg">
    <div class="container div_zindex">
      <div class="section-header white-text text-center">
        <h2>Our Satisfied <span>Customers</span></h2>
      </div>
      <div class="row">
        <div id="testimonial-slider">
          <?php
          $tid = 1;
          $sql = "SELECT tbltestimonial.Testimonial, tblusers.FullName FROM tbltestimonial JOIN tblusers ON tbltestimonial.UserEmail = tblusers.EmailId WHERE tbltestimonial.status = '$tid' LIMIT 4";
          $query = mysqli_query($con, $sql);
          if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_assoc($query)) {
          ?>

              <div class="testimonial-m">
                <div class="testimonial-content">
                  <div class="testimonial-heading">
                    <h5><?php echo htmlentities($result['FullName']); ?></h5>
                    <p><?php echo htmlentities($result['Testimonial']); ?></p>
                  </div>
                </div>
              </div>
          <?php }
          } ?>
        </div>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Testimonial-->


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
  <!--/Forgot-password-Form -->

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

<!-- Mirrored from themes.webmasterdriver.net/carforyou/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Jun 2017 07:22:11 GMT -->

</html>