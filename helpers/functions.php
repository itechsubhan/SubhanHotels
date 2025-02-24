<?php

// Function to validate dates
function validate_checkin_checkout($checkin, $checkout) {
    // Convert the date strings to DateTime objects
    $checkinDate = DateTime::createFromFormat('Y-m-d', $checkin);
    $checkoutDate = DateTime::createFromFormat('Y-m-d', $checkout);

    // Check if the checkin date is valid
    if (!$checkinDate) {
        return "Invalid check-in date format.";
    }

    // Check if the checkout date is valid
    if (!$checkoutDate) {
        return "Invalid check-out date format.";
    }

    // Check if check-out date is after check-in date
    if ($checkoutDate <= $checkinDate) {
        return "Check-out date must be after the Check-in date.";
    }

    return true; // No errors
}
?>