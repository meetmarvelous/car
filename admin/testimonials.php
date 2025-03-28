<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_REQUEST['eid'])) {
        $eid = intval($_GET['eid']);
        $status = "0";
        $sql = "UPDATE tbltestimonial SET status='$status' WHERE id='$eid'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $msg = "Testimonial Successfully Inactive";
        } else {
            $error = "Error updating testimonial: " . mysqli_error($con);
        }
    }

    if (isset($_REQUEST['aeid'])) {
        $aeid = intval($_GET['aeid']);
        $status = 1;
        $sql = "UPDATE tbltestimonial SET status='$status' WHERE id='$aeid'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $msg = "Testimonial Successfully Active";
        } else {
            $error = "Error updating testimonial: " . mysqli_error($con);
        }
    }
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

        <title>Titiabiks Ventures | Admin Manage Testimonials</title>

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
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php include('includes/leftbar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <h2 class="page-title">Manage Testimonials</h2>

                            <!-- Zero Configuration Table -->
                            <div class="panel panel-default">
                                <div class="panel-heading">User Testimonials</div>
                                <div class="panel-body">
                                    <?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                    <div class="table-responsive">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Testimonials</th>
                                                    <th>Posting Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Testimonials</th>
                                                    <th>Posting Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>

                                                <?php
                                                $sql = "SELECT tblusers.FullName, tbltestimonial.UserEmail, tbltestimonial.Testimonial, tbltestimonial.PostingDate, tbltestimonial.status, tbltestimonial.id FROM tbltestimonial JOIN tblusers ON tblusers.Emailid = tbltestimonial.UserEmail";
                                                $result = mysqli_query($con, $sql);
                                                $cnt = 1;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row['FullName']); ?></td>
                                                            <td><?php echo htmlentities($row['UserEmail']); ?></td>
                                                            <td><?php echo htmlentities($row['Testimonial']); ?></td>
                                                            <td><?php echo htmlentities($row['PostingDate']); ?></td>
                                                            <td>
                                                                <?php if ($row['status'] == "" || $row['status'] == 0) {
                                                                ?>
                                                                    <a href="testimonials.php?aeid=<?php echo htmlentities($row['id']); ?>" onclick="return confirm('Do you really want to Active')"> Inactive</a>
                                                                <?php } else { ?>
                                                                    <a href="testimonials.php?eid=<?php echo htmlentities($row['id']); ?>" onclick="return confirm('Do you really want to Inactive')"> Active</a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                <?php $cnt = $cnt + 1;
                                                    }
                                                } ?>

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
    </body>

    </html>
<?php } ?>