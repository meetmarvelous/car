
-- Add payment status and transaction ID columns to tblbooking
ALTER TABLE `tblbooking`
ADD COLUMN `payment_status` ENUM('pending', 'success', 'failed') DEFAULT 'pending',
ADD COLUMN `transaction_id` VARCHAR(255) DEFAULT NULL;

-- Create transactions table to track Paystack payments
CREATE TABLE `transactions` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `userEmail` VARCHAR(100) NOT NULL, -- User email from tblusers
    `booking_id` INT NOT NULL, -- Foreign key to tblbooking
    `transaction_id` VARCHAR(255) NOT NULL, -- Unique transaction ID from Paystack
    `amount` DECIMAL(10, 2) NOT NULL, -- Amount in kobo (Paystack uses kobo)
    `payment_status` ENUM('pending', 'success', 'failed') DEFAULT 'pending', -- Payment status
    `payment_method` VARCHAR(50), -- Payment method (e.g., card, bank transfer)
    `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of the transaction
    FOREIGN KEY (`booking_id`) REFERENCES `tblbooking`(`id`) ON DELETE CASCADE -- Cascade delete if booking is deleted
);