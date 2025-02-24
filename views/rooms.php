<?php
require_once "../models/Room.php";
$roomModel = new Room();
$availableRooms = $roomModel->getAvailableRooms($_GET['checkin'] ?? null, $_GET['checkout'] ?? null, $_GET['guests'] ?? null); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rooms</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include "layouts/header.php"; ?>
    <div class="container m-4">
        <?php if (!empty($availableRooms)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Room ID</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Capacity</th>
                        <th>Selection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($availableRooms as $room): ?>
                        <tr>
                            <td><?= htmlspecialchars($room['room_id']); ?></td>
                            <td><?= htmlspecialchars($room['type']); ?></td>
                            <td>$<?= htmlspecialchars($room['price']); ?></td>
                            <td><?= htmlspecialchars($room['capacity']); ?></td>
                            <td>
                                <form action="booking.php" method="GET">
                                    <input type="hidden" name="room_id" value="<?= $room['room_id']; ?>">
                                    <input type="hidden" name="checkin" value="<?= $_GET['checkin']; ?>">
                                    <input type="hidden" name="checkout" value="<?= $_GET['checkout']; ?>">
                                    <input type="hidden" name="guests" value="<?= $_GET['guests']; ?>">
                                    <button type="submit" class="btn btn-primary">Select</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No available rooms found.</p>
        <?php endif; ?>
    </div>

    <?php include "layouts/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
