<?php
require_once '../models/Reservation.php';
session_start();

$reservationModel = new Reservation();
$reservation = null;
$success_message = $error_message = "";

// Handle search request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $reservation_id = $_POST['reservation_id'];
    $_SESSION['email'] = $_POST['email']; // Store email for session-based search

    $reservation = $reservationModel->searchReservation($reservation_id);

    if (!$reservation) {
        $error_message = "Reservation not found.";
    }
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $reservation_id = $_POST['reservation_id'];
    $guest_name = $_POST['guest_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $checkin = $_POST['checkin_date'];
    $checkout = $_POST['checkout_date'];
    $guests = $_POST['num_guests'];

    if ($reservationModel->updateReservation($reservation_id, $guest_name, $email, $phone, $checkin, $checkout, $guests)) {
        $success_message = "Reservation updated successfully!";
        $reservation = $reservationModel->searchReservation($reservation_id);
    } else {
        $error_message = "Failed to update reservation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search & Update Reservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<?php include "layouts/header.php"; ?>
    <div class="container mt-4">
        <h2>Search Reservation</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="reservation_id" class="form-label">Reservation ID</label>
                <input type="text" class="form-control" id="reservation_id" name="reservation_id" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>

        <?php if ($error_message): ?>
            <div class="alert alert-danger mt-3"><?= htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <?php if ($reservation): ?>
            <h2 class="mt-4">Update Reservation</h2>
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservation_id']); ?>">
                <div class="mb-3">
                    <label for="guest_name" class="form-label">Guest Name</label>
                    <input type="text" class="form-control" id="guest_name" name="guest_name"
                        value="<?= htmlspecialchars($reservation['guest_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?= htmlspecialchars($reservation['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="<?= htmlspecialchars($reservation['phone']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="checkin_date" class="form-label">Check-in Date</label>
                    <input type="date" class="form-control" id="checkin_date" name="checkin_date"
                        value="<?= htmlspecialchars($reservation['checkin_date']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="checkout_date" class="form-label">Check-out Date</label>
                    <input type="date" class="form-control" id="checkout_date" name="checkout_date"
                        value="<?= htmlspecialchars($reservation['checkout_date']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="num_guests" class="form-label">Number of Guests</label>
                    <input type="number" class="form-control" id="num_guests" name="num_guests"
                        value="<?= htmlspecialchars($reservation['num_guests']); ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-success">Update Reservation</button>
            </form>
        <?php endif; ?>
    </div>
    <br>``
    <?php include "layouts/footer.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript to set minimum check-in and check-out dates
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            var checkinInput = document.getElementById('checkin_date');
            var checkoutInput = document.getElementById('checkout_date');

            checkinInput.setAttribute('min', today);
            checkoutInput.setAttribute('min', today);

            checkinInput.addEventListener('change', function() {
                if (checkoutInput.value < checkinInput.value) {
                    checkoutInput.value = checkinInput.value;
                }
                checkoutInput.setAttribute('min', checkinInput.value);
            });
        });
    </script>
</body>

</html>