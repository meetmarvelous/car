<?php
session_start();
include('includes/config.php');
include('includes/header.php');
require 'vendor/autoload.php'; // Include Paystack library

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    die("You must be logged in to view this page. <a href='login.php'>Login here</a>.");
}

$userEmail = $_SESSION['login']; // Get the user email from the session

// Verify the transaction with Paystack
$paystack = new Yabacon\Paystack('sk_test_73ef2c03b79c54431a14e36f8582f59a7f332780'); // Replace with your Paystack secret key
$reference = $_GET['reference'];

try {
    $transaction = $paystack->transaction->verify([
        'reference' => $reference
    ]);

    if ($transaction->data->status === 'success') {
        $status = 'success';
        $message = "Payment Successful! Thank you for your purchase.";
    } else {
        $status = 'failed';
        $message = "Payment Failed. Please try again.";
    }

    // Get booking ID and transaction ID from Paystack metadata
    $bookingId = $transaction->data->metadata->booking_id;
    $transactionId = $transaction->data->reference;

    // Update the transaction status in the database
    $sql = "UPDATE transactions SET payment_status='$status' WHERE transaction_id='$reference' AND userEmail='$userEmail'";
    if (mysqli_query($con, $sql)) {
        // Update the booking status in tblbooking
        $sql2 = "UPDATE tblbooking SET payment_status='$status', transaction_id='$transactionId' WHERE id='$bookingId'";
        mysqli_query($con, $sql2);

        // Display success or failure message
        echo "<script>alert('$message');</script>";
        echo "<script>window.location.href = 'my-booking.php';</script>";
    } else {
        die("Database error: " . mysqli_error($con));
    }
} catch (Exception $e) {
    die('Error verifying payment: ' . $e->getMessage());
}

// Include the footer
include('includes/footer.php');
?>