<?php
// controllers/RoomsController.php
require_once '../models/Room.php';

class RoomsController
{

    public function index()
    {
        $checkin = $_GET['checkin'] ?? null;
        $checkout = $_GET['checkout'] ?? null;
        $guests = $_GET['guests'] ?? null;

        $roomModel = new Room();
        $availableRooms = $roomModel->getAvailableRooms($checkin, $checkout, $guests);

        // Include the view
        include 'views/rooms_view.php';
    }
}
?>
