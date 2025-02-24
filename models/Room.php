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
}
?>
