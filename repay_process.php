<?php
session_start();
include 'includes/config.php';
require 'vendor/autoload.php'; // Include Paystack library

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    die("You must be logged in to make a payment. <a href='login.php'>Login here</a>.");
}

$userEmail = $_SESSION['login']; // Get the user email from the session
$bookingNo = $_GET['bookingno'];

// Get booking details
$sql = "SELECT b.*, v.PricePerDay, v.VehiclesTitle, DATEDIFF(b.ToDate, b.FromDate) as days 
        FROM tblbooking b 
        JOIN tblvehicles v ON b.VehicleId = v.id 
        WHERE b.BookingNumber = '$bookingNo' AND b.userEmail = '$userEmail'";
$result = mysqli_query($con, $sql);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Booking not found or you don't have permission to access it.");
}

// Calculate amount in kobo
$amountInNaira = $booking['PricePerDay'] * $booking['days'];
$amountInKobo = $amountInNaira * 100;

// Initialize Paystack payment
$paystack = new Yabacon\Paystack('sk_test_73ef2c03b79c54431a14e36f8582f59a7f332780'); // Replace with your Paystack secret key
$reference = uniqid('txn_'); // Generate a unique transaction ID

try {
    // Initialize the transaction with Paystack
    $transaction = $paystack->transaction->initialize([
        'email' => $userEmail,
        'amount' => $amountInKobo,
        'reference' => $reference,
        'callback_url' => 'http://localhost/Recent/carrental/payment_confirmation.php', // Different confirmation page for repayments
        'metadata' => [
            'booking_id' => $booking['id'],
            'booking_no' => $bookingNo,
            'vehicle_title' => $booking['VehiclesTitle'],
            'from_date' => $booking['FromDate'],
            'to_date' => $booking['ToDate'],
            'days' => $booking['days'],
            'amount' => $amountInNaira
        ]
    ]);

    // Update the booking with new transaction ID
    $sql = "UPDATE tblbooking SET transaction_id = '$reference', payment_status = 'pending' WHERE BookingNumber = '$bookingNo'";
    mysqli_query($con, $sql);

    // Save transaction to the database
    $sql2 = "INSERT INTO transactions (userEmail, booking_id, transaction_id, amount, payment_status)
             VALUES ('$userEmail', '{$booking['id']}', '$reference', '$amountInNaira', 'pending')";
    mysqli_query($con, $sql2);

    // Store booking details in session for confirmation page
    $_SESSION['repay_booking'] = [
        'booking_no' => $bookingNo,
        'vehicle_title' => $booking['VehiclesTitle'],
        'from_date' => $booking['FromDate'],
        'to_date' => $booking['ToDate'],
        'days' => $booking['days'],
        'amount' => $amountInNaira,
        'transaction_id' => $reference
    ];

    // Redirect to Paystack's payment page
    header("Location: " . $transaction->data->authorization_url);
    exit();
} catch (Exception $e) {
    die('Paystack Error: ' . $e->getMessage());
}
?>