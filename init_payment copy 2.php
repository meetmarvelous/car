<?php
session_start();
include 'includes/config.php';
require 'vendor/autoload.php';

if (!isset($_SESSION['login'])) {
  die("You must be logged in to make a payment. <a href='login.php'>Login here</a>.");
}

$userEmail = $_SESSION['login'];
$email = $_POST['email'];
$amountInNaira = $_POST['amount'];
$amountInKobo = $amountInNaira * 100;
$fromDate = $_POST['fromdate'];
$toDate = $_POST['todate'];
$message = $_POST['message'];
$pickup = $_POST['pickup'];
$vehicleId = $_POST['vehicle_id'];
$bookingNo = $_SESSION['bookingno'];

// Check if booking already exists
$checkSql = "SELECT id FROM tblbooking WHERE BookingNumber = '$bookingNo' AND userEmail = '$userEmail'";
$checkResult = mysqli_query($con, $checkSql);

if (mysqli_num_rows($checkResult) > 0) {
  // Booking exists - update it
  $bookingRow = mysqli_fetch_assoc($checkResult);
  $bookingId = $bookingRow['id'];

  $updateSql = "UPDATE tblbooking SET 
        VehicleId = '$vehicleId',
        FromDate = '$fromDate',
        ToDate = '$toDate',
        message = '$message',
        pickup = '$pickup',
        Status = 0,
        payment_status = 'pending'
        WHERE id = '$bookingId'";

  if (!mysqli_query($con, $updateSql)) {
    die("Failed to update booking: " . mysqli_error($con));
  }
} else {
  // Create new booking
  $insertSql = "INSERT INTO tblbooking (BookingNumber, userEmail, VehicleId, FromDate, ToDate, message, pickup, Status, payment_status)
            VALUES ('$bookingNo', '$userEmail', '$vehicleId', '$fromDate', '$toDate', '$message', '$pickup', 0, 'pending')";

  if (!mysqli_query($con, $insertSql)) {
    die("Failed to create booking: " . mysqli_error($con));
  }

  $bookingId = mysqli_insert_id($con);
}

// Initialize Paystack payment
$paystack = new Yabacon\Paystack('sk_test_73ef2c03b79c54431a14e36f8582f59a7f332780');
$reference = uniqid('txn_');

try {
  $transaction = $paystack->transaction->initialize([
    'email' => $email,
    'amount' => $amountInKobo,
    'reference' => $reference,
    'callback_url' => 'http://localhost/Recent/carrental/payment_confirmation.php',
    'metadata' => [
      'booking_id' => $bookingId,
      'booking_no' => $bookingNo
    ]
  ]);

  // Save/update transaction
  $transactionSql = "INSERT INTO transactions (userEmail, booking_id, transaction_id, amount, payment_status)
             VALUES ('$userEmail', '$bookingId', '$reference', '$amountInNaira', 'pending')
             ON DUPLICATE KEY UPDATE 
                transaction_id = VALUES(transaction_id),
                amount = VALUES(amount),
                payment_status = VALUES(payment_status)";

  if (!mysqli_query($con, $transactionSql)) {
    die("Failed to save transaction: " . mysqli_error($con));
  }

  header("Location: " . $transaction->data->authorization_url);
  exit();
} catch (Exception $e) {
  die('Paystack Error: ' . $e->getMessage());
}
