<?php
// models/Room.php
require_once '../config/Database.php';

class Room
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAvailableRooms($checkin, $checkout, $guests)
    {
        $query = "SELECT r.room_id, r.type, r.price, r.capacity, r.image
                  FROM rooms r
                  WHERE r.capacity >= :guests
                  AND r.room_id NOT IN (
                      SELECT room_id
                      FROM reservations
                      WHERE (checkin_date BETWEEN :checkin AND :checkout)
                         OR (checkout_date BETWEEN :checkin AND :checkout)
                         OR (:checkin BETWEEN checkin_date AND checkout_date)
                         OR (:checkout BETWEEN checkin_date AND checkout_date)
                  )
                  ORDER BY r.type";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':guests', $guests, PDO::PARAM_INT);
        $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
        $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRooms()
    {
        $query = "SELECT r.room_id, r.type, r.price, r.capacity, r.image
                  FROM rooms r";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertRoom($type, $price, $capacity, $image)
    {
        // SQL query to insert a new room
        $query = "INSERT INTO rooms (type, price, capacity, image) 
              VALUES (:type, :price, :capacity, :image)";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind the parameters to the SQL query
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        // Execute the statement and return the result
        if ($stmt->execute()) {
            return true;  // Room inserted successfully
        } else {
            return false;  // Failed to insert room
        }
    }
    
    public function deleteRoom($room_id)
    {
        // SQL query to delete a room
        $query = "DELETE FROM rooms WHERE room_id = :room_id";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind the parameters to the SQL query
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);

        // Execute the statement and return the result
        if ($stmt->execute()) {
            return true;  // Room deleted successfully
        } else {
            return false;  // Failed to delete room
        }
    }

}
?>