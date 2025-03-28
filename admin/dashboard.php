<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:index.php');
}
else{
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    
    <title>Titiabiks Ventures | Admin Dashboard</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include('includes/header.php');?>

    <div class="ts-main-content">
<?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Dashboard</h2>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
<?php 
$sql = "SELECT id from tblusers";
$query = mysqli_query($con, $sql);
$regusers = mysqli_num_rows($query);
?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($regusers);?></div>
                                                    <div class="stat-panel-title text-uppercase">Reg Users</div>
                                                </div>
                                            </div>
                                            <a href="reg-users.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-success text-light">
                                                <div class="stat-panel text-center">
                                                <?php 
$sql1 = "SELECT id from tblvehicles";
$query1 = mysqli_query($con, $sql1);
$totalvehicle = mysqli_num_rows($query1);
?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($totalvehicle);?></div>
                                                    <div class="stat-panel-title text-uppercase">Listed Vehicles</div>
                                                </div>
                                            </div>
                                            <a href="manage-vehicles.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-info text-light">
                                                <div class="stat-panel text-center">
<?php 
$sql2 = "SELECT id from tblbooking";
$query2 = mysqli_query($con, $sql2);
$bookings = mysqli_num_rows($query2);
?>

                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bookings);?></div>
                                                    <div class="stat-panel-title text-uppercase">Total Bookings</div>
                                                </div>
                                            </div>
                                            <a href="manage-bookings.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-warning text-light">
                                                <div class="stat-panel text-center">
<?php 
$sql3 = "SELECT id from tblbrands";
$query3 = mysqli_query($con, $sql3);
$brands = mysqli_num_rows($query3);
?>                                                
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($brands);?></div>
                                                    <div class="stat-panel-title text-uppercase">Listed Brands</div>
                                                </div>
                                            </div>
                                            <a href="manage-brands.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
<?php 
$sql4 = "SELECT id from tblsubscribers";
$query4 = mysqli_query($con, $sql4);
$subscribers = mysqli_num_rows($query4);
?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($subscribers);?></div>
                                                    <div class="stat-panel-title text-uppercase">Subscribers</div>
                                                </div>
                                            </div>
                                            <a href="manage-subscribers.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-success text-light">
                                                <div class="stat-panel text-center">
                                                <?php 
$sql6 = "SELECT id from tblcontactusquery";
$query6 = mysqli_query($con, $sql6);
$query = mysqli_num_rows($query6);
?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                    <div class="stat-panel-title text-uppercase">Queries</div>
                                                </div>
                                            </div>
                                            <a href="manage-conactusquery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-info text-light">
                                                <div class="stat-panel text-center">
<?php 
$sql5 = "SELECT id from tbltestimonial";
$query5 = mysqli_query($con, $sql5);
$testimonials = mysqli_num_rows($query5);
?>

                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($testimonials);?></div>
                                                    <div class="stat-panel-title text-uppercase">Testimonials</div>
                                                </div>
                                            </div>
                                            <a href="testimonials.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    
    <script>
    window.onload = function(){
    
        // Line chart from swirlData for dashReport
        var ctx = document.getElementById("dashReport").getContext("2d");
        window.myLine = new Chart(ctx).Line(swirlData, {
            responsive: true,
            scaleShowVerticalLines: false,
            scaleBeginAtZero : true,
            multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
        }); 
        
        // Pie Chart from doughutData
        var doctx = document.getElementById("chart-area3").getContext("2d");
        window.myDoughnut = new Chart(doctx).Pie(doughnutData, {responsive : true});

        // Dougnut Chart from doughnutData
        var doctx = document.getElementById("chart-area4").getContext("2d");
        window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive : true});

    }
    </script>
</body>
</html>
<?php } ?>