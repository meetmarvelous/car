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

        // Get booking ID from Paystack metadata
        $bookingId = $transaction->data->metadata->booking_id;

        // Update the booking status and transaction_id in tblbooking
        $sql = "UPDATE tblbooking SET payment_status='$status', Status=1, transaction_id='$reference' WHERE id='$bookingId'";
        if (mysqli_query($con, $sql)) {
            // Update the transaction status in the database
            $sql2 = "UPDATE transactions SET payment_status='$status' WHERE transaction_id='$reference' AND userEmail='$userEmail'";
            mysqli_query($con, $sql2);

            // Clear session variables
            unset($_SESSION['bookingno']);
            unset($_SESSION['useremail']);
            unset($_SESSION['vhid']);
            unset($_SESSION['fromdate']);
            unset($_SESSION['todate']);
            unset($_SESSION['message']);
            unset($_SESSION['status']);

            // Display success message
            echo "<script>alert('$message');</script>";
            echo "<script>window.location.href = 'my-booking.php';</script>";
        } else {
            die("Database error: " . mysqli_error($con));
        }
    } else {
        $status = 'failed';
        $message = "Payment Failed. Please try again.";
        echo "<script>alert('$message');</script>";
        echo "<script>window.location.href = 'my-booking.php';</script>";
    }
} catch (Exception $e) {
    die('Error verifying payment: ' . $e->getMessage());
}

// Include the footer
include('includes/footer.php');
?>