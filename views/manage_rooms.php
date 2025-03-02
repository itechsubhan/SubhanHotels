<?php
require_once "../models/Room.php"; // Include the Room model
$roomModel = new Room(); // Instantiate the Room class

// Get all rooms for display
$availableRooms = $roomModel->getAllRooms();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'insert_room':
            // Retrieve form data for inserting room
            $type = $_POST['type'];
            $price = $_POST['price'];
            $capacity = $_POST['capacity'];
            $image = $_FILES['image']['name'];
            $target = "../assets/images/" . basename($image);

            // Handle file upload
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // Insert room into the database using Room model method
                if ($roomModel->insertRoom($type, $price, $capacity, $image)) {
                    header("Location: manage_rooms.php");
                    exit;
                } else {
                    $_SESSION['error_message'] = "Failed to insert room.";
                }
            } else {
                $_SESSION['error_message'] = "Image upload failed.";
            }
            break;
        
        case 'delete_room':
            // Get room ID and delete it
            $room_id = $_POST['room_id'];
            if ($roomModel->deleteRoom($room_id)) {
                header("Location: manage_rooms.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Failed to delete room.";
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include "layouts/header.php"; ?>

    <div class="container m-4">
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($availableRooms)): ?>
            <center><h2>Admin - Room Management</h2></center>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Room ID</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Capacity</th>
                        <th>Actions</th>
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
                                <form action="manage_rooms.php" method="POST">
                                    <input type="hidden" name="room_id" value="<?= $room['room_id']; ?>">
                                    <button type="submit" name="action" value="delete_room" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <center><h2>Add a New Room</h2></center>
            <form action="manage_rooms.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="insert_room">
                <div class="mb-3">
                    <label for="type" class="form-label">Room Type</label>
                    <input type="text" class="form-control" id="type" name="type" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-success">Add Room</button>
            </form>

        <?php else: ?>
            <p>No rooms available.</p>
        <?php endif; ?>
    </div>

    <?php include "layouts/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
