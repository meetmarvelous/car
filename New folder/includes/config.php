<?php
// DB credentials.
define('DB_HOST', 'localhost');
define('DB_USER', 'ichwyqtl_marvelbyte');
define('DB_PASS', 'Mahvellous1698.');
define('DB_NAME', 'ichwyqtl_ayocar');

// Establish database connection.
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    exit("Error: Failed to connect to MySQL: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($con, "utf8");
?>