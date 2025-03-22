<?php
session_start();
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['fullname'];
  $mobileno = $_POST['mobilenumber'];
  $dob = $_POST['dob'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $country = $_POST['country'];
  $email = $_POST['email']; // Ensure email is retrieved from the form

  // Update user profile in the database
  $sql = "UPDATE tblusers SET FullName = '$name', ContactNo = '$mobileno', dob = '$dob', Address = '$address', City = '$city', Country = '$country' WHERE EmailId = '$email'";
  $result = mysqli_query($con, $sql);

  if ($result) {
    echo 'success';
  } else {
    echo 'error';
  }
}
?>