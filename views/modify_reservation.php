<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM reservations WHERE reservation_id = ?");
$stmt->execute([$id]);
$reservation = $stmt->fetch();

if (!$reservation) {
    die("Reservation not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];

    $update_stmt = $pdo->prepare("UPDATE reservations SET checkin_date = ?, checkout_date = ? WHERE reservation_id = ?");
    $update_stmt->execute([$checkin_date, $checkout_date, $id]);

    echo "Reservation updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Modify Reservation</title>
</head>
<body>
    <h2>Modify Your Reservation</h2>
    <form method="POST">
        <label>Check-in Date:</label>
        <input type="date" name="checkin_date" value="<?= htmlspecialchars($reservation['checkin_date']) ?>" required>
        <label>Check-out Date:</label>
        <input type="date" name="checkout_date" value="<?= htmlspecialchars($reservation['checkout_date']) ?>" required>
        <button type="submit">Update Reservation</button>
    </form>
</body>
</html>
