<?php
// models/Reservation.php
require_once '../config/Database.php';

class Reservation
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createReservation($room_id, $guest_name, $email, $phone, $checkin, $checkout, $guests)
    {
        $query = "INSERT INTO reservations (room_id, guest_name, checkin_date, checkout_date, num_guests, total_cost, email, phone)
                  VALUES (:room_id, :guest_name, :checkin, :checkout, :guests, :total_cost, :email, :phone)";

        // Calculate total cost
        $stmt = $this->conn->prepare("SELECT price FROM rooms WHERE room_id = :room_id");
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        $price_per_night = $room['price'];
        $total_cost = $price_per_night * (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);

        // Insert reservation into database
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->bindParam(':guest_name', $guest_name, PDO::PARAM_STR);
        $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
        $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
        $stmt->bindParam(':guests', $guests, PDO::PARAM_INT);
        $stmt->bindParam(':total_cost', $total_cost, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
?>
