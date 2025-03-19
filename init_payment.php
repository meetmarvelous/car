<?php
session_start();
include 'includes/config.php';
require 'vendor/autoload.php'; // Include Paystack library

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    die("You must be logged in to make a payment. <a href='login.php'>Login here</a>.");
}

$userEmail = $_SESSION['login']; // Get the user email from the session

// Get form data
$email = $_POST['email'];
$amount = $_POST['amount'] * 100; // Convert to kobo
$fromDate = $_POST['fromdate'];
$toDate = $_POST['todate'];
$message = $_POST['message'];
$vehicleId = $_POST['vehicle_id'];

// Generate a unique Booking No #
$bookingNo = mt_rand(100000000, 999999999);

// Save booking details to tblbooking
$sql = "INSERT INTO tblbooking (BookingNumber, userEmail, VehicleId, FromDate, ToDate, message, Status, payment_status)
        VALUES ('$bookingNo', '$userEmail', '$vehicleId', '$fromDate', '$toDate', '$message', 0, 'pending')";
if (mysqli_query($con, $sql)) {
    $bookingId = mysqli_insert_id($con); // Get the last inserted booking ID

    // Initialize Paystack payment
    $paystack = new Yabacon\Paystack('sk_test_73ef2c03b79c54431a14e36f8582f59a7f332780'); // Replace with your Paystack secret key
    $reference = uniqid('txn_'); // Generate a unique transaction ID

    try {
        // Initialize the transaction with Paystack
        $transaction = $paystack->transaction->initialize([
            'email' => $email,
            'amount' => $amount,
            'reference' => $reference,
            'callback_url' => 'http://localhost/Recent/carrental/payment_confirmation.php', // Replace with your domain
            'metadata' => [
                'booking_id' => $bookingId, // Pass booking ID to Paystack
                'booking_no' => $bookingNo // Pass booking number to Paystack
            ]
        ]);

        // Save transaction to the database
        $sql2 = "INSERT INTO transactions (userEmail, booking_id, transaction_id, amount, payment_status)
                 VALUES ('$userEmail', '$bookingId', '$reference', '$amount', 'pending')";
        if (mysqli_query($con, $sql2)) {
            // Redirect to Paystack's payment page
            header("Location: " . $transaction->data->authorization_url);
            exit();
        } else {
            die("Database error: " . mysqli_error($con));
        }
    } catch (Exception $e) {
        die('Paystack Error: ' . $e->getMessage());
    }
} else {
    die("Database error: " . mysqli_error($con));
}
?>