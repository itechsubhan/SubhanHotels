<?php
require_once '../config/Database.php';

// Fetch user search inputs
$checkin = $_GET['checkin'] ?? null;
$checkout = $_GET['checkout'] ?? null;
$guests = $_GET['guests'] ?? null;
$availableRooms = [];
$database = new Database();
$conn = $database->getConnection();
$sql = "SELECT room_id,type,price,capacity FROM rooms";

// Prepare the SQL query
$query = "SELECT r.room_id, r.type, r.price, r.capacity, r.image
FROM rooms r
WHERE r.capacity >= :guests
AND r.room_id NOT IN (
    SELECT room_id
    FROM reservati`ons
    WHERE (checkin_date BETWEEN :checkin AND :checkout)
       OR (checkout_date BETWEEN :checkin AND :checkout)
       OR (:checkin BETWEEN checkin_date AND checkout_date)
       OR (:checkout BETWEEN checkin_date AND checkout_date)
)
ORDER BY r.type";

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bindParam(':guests', $guests, PDO::PARAM_INT);
$stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
$stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);

$stmt->execute();

// $stmt = $conn->prepare($sql);
// $stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rooms as $room) {
    $room_id = $room['room_id'];
    $type = $room['type'];
    $price = $room['price'];
    $capacity = $room['capacity'];
    $availableRooms[] = [
        'room_id' => $room_id,
        'type' => $type,
        'price' => $price,
        'capacity' => $capacity,
    ];
}

?>

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
        <?php $availableRooms ?>
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
                                    <input type="hidden" name="checkin" value="<?= $checkin; ?>">
                                    <input type="hidden" name="checkout" value="<?= $checkout; ?>">
                                    <input type="hidden" name="guests" value="<?= $guests; ?>">
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