<?php
require_once "../models/Room.php";

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
        <h2 class="mb-4">Book a Room</h2>

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
                                    <a href="booking_confirmation.php?room_id=<?= $room['room_id']; ?>&checkin=<?= $_GET['checkin']; ?>&checkout=<?= $_GET['checkout']; ?>" class="btn btn-success">Book Now</a>
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

    <?php include "layouts/footer.php"; ?>
</body>
</html>
