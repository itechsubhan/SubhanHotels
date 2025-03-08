<?php
require_once "../models/Room.php";
require_once "../models/Reservation.php"; // Include the Reservation model

// Handle the form submission if POST is made
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $room_id = $_POST['room_id'];
    $guest_name = $_POST['guest_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = $_POST['guests'];

    // Create reservation using Reservation model
    $reservationModel = new Reservation();

    // Create reservation and check if successful
    if ($reservationModel->createReservation($room_id, $guest_name, $email, $phone, $checkin, $checkout, $guests)) {
        session_start();
        $_SESSION['booking_success'] = true; // Set session flag for confirmation message
        $_SESSION['reservation_id'] = $reservationModel->getLastReservationId();
        header("Location: ../index.php"); 
        exit;
    } else {
        $error_message = "Failed to create reservation.";
    }
}

$roomModel = new Room();
$rooms = $roomModel->getAvailableRooms($_GET['checkin'] ?? null, $_GET['checkout'] ?? null, $_GET['guests'] ?? null);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include "layouts/header.php"; ?>

    <div class="container mt-5">
        <h2 class="mb-4">You are one step away from enjoying your stay</h2>
        <h3 class="mb-4">Please confirm your dates and information</h3>

        <!-- Display Confirmation Message if Booking is Successful -->
        <?php if (isset($_SESSION['booking_success']) && $_SESSION['booking_success'] === true): ?>
            <div class="alert alert-success">
                Booking Confirmed! You will be redirected to the homepage shortly.
            </div>
            <?php unset($_SESSION['booking_success']); ?>
        <?php endif; ?>

        <!-- Display Error Message if Reservation Fails -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <!-- Booking Form -->
        <form method="GET" action="booking.php" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="checkin" class="form-label">Check-in Date:</label>
                    <input type="date" class="form-control" id="checkin" name="checkin" required>
                </div>
                <div class="col-md-3">
                    <label for="checkout" class="form-label">Check-out Date:</label>
                    <input type="date" class="form-control" id="checkout" name="checkout" required>
                </div>
                <div class="col-md-2">
                    <label for="guests" class="form-label">Guests:</label>
                    <input type="number" class="form-control" id="guests" name="guests" min="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Search Rooms</button>
                </div>
            </div>
        </form>

        <!-- Available Rooms -->
        <?php if (!empty($_GET['checkin']) && !empty($_GET['checkout']) && !empty($_GET['guests'])): ?>
            <h3>Please select a room to book</h3>
            <h3>Available Rooms</h3>
            <div class="row">
                <?php if ($rooms): ?>
                    <?php foreach ($rooms as $room): ?>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <img src="../assets/images/<?= htmlspecialchars($room['image']); ?>" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($room['type']); ?></h5>
                                    <p><strong>Price:</strong> $<?= htmlspecialchars($room['price']); ?>/night</p>
                                    <p><strong>Capacity:</strong> <?= htmlspecialchars($room['capacity']); ?> guests</p>

                                    <!-- Book Now Button -->
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reservationModal" data-room_id="<?= $room['room_id']; ?>" data-room_type="<?= $room['type']; ?>" data-price="<?= $room['price']; ?>">Book Now</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="alert alert-warning">No rooms available for the selected dates.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Reservation Modal -->
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservationModalLabel">Reservation Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="booking.php">
                        <input type="hidden" name="room_id" id="room_id">
                        <input type="hidden" name="checkin" value="<?= $_GET['checkin']; ?>">
                        <input type="hidden" name="checkout" value="<?= $_GET['checkout']; ?>">
                        <input type="hidden" name="guests" value="<?= $_GET['guests']; ?>">

                        <div class="mb-3">
                            <label for="guest_name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="guest_name" name="guest_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "layouts/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Populate modal form with room details when "Book Now" is clicked
        var reservationModal = document.getElementById('reservationModal');
        reservationModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var roomId = button.getAttribute('data-room_id');
            var roomType = button.getAttribute('data-room_type');
            var price = button.getAttribute('data-price');

            var modalRoomId = reservationModal.querySelector('#room_id');
            var modalRoomType = reservationModal.querySelector('#room_type');
            var modalPrice = reservationModal.querySelector('#price');

            modalRoomId.value = roomId;
        });
    </script>
</body>

</html>
