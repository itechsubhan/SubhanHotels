<?php
require_once "../config/Database.php";

class Room {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAvailableRooms($checkin, $checkout, $guests) {
        $sql = "SELECT * FROM rooms WHERE room_id NOT IN (
                    SELECT room_id FROM reservations 
                    WHERE (:checkin BETWEEN checkin_date AND checkout_date) 
                       OR (:checkout BETWEEN checkin_date AND checkout_date)
                       OR (checkin_date BETWEEN :checkin AND :checkout)
                       OR (checkout_date BETWEEN :checkin AND :checkout)
                ) AND capacity >= :guests";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['checkin' => $checkin, 'checkout' => $checkout, 'guests' => $guests]);
        return $stmt->fetchAll();
    }
}
?>
