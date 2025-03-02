<?php
// Start session if needed
session_start();
// Check if booking was successful
if (isset($_SESSION['booking_success']) && $_SESSION['booking_success'] === true) {
    $success_message = "Your reservation was successfully made!";
    unset($_SESSION['booking_success']); // Clear session flag after showing message
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hotel Reservation System</title>

    <!--- custom css link-->
    <link rel="stylesheet" href="assets/css/styles.css">

</head>

<body>
    <!-- Nav  bar -->
    <?php include "views/layouts/header.php"; ?>

    <!-- Display Success Message if Reservation was Successful -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success_message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="hero slider-bg text-white text-center herosection">
        <div class="container hero-text">
            <h1 class="display-4 ">Welcome to Majestic Peaks Hotel</h1>
            <p class="lead">Book your perfect stay at our luxurious rooms.</p>
            <p class="hero-subtitle">Comfort, luxury, and unforgettable experiences await.</p>
            <a href="#find-room" class="btn btn-light btn-lg">Book Now</a>
        </div>
    </section>

    <!-- Find a Room -->
    <section id="find-room" class="container my-5">
        <div class="card p-4 shadow">
            <h3 class="text-center">Find a Room</h3>
            <form action="views/rooms.php" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="checkin" class="form-label">Check-in</label>
                    <input type="date" id="checkin" name="checkin" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="checkout" class="form-label">Check-out</label>
                    <input type="date" id="checkout" name="checkout" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label for="guests" class="form-label">Guests</label>
                    <input type="number" id="guests" name="guests" class="form-control" min="1" required>
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary w-100">Search Rooms</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Room Categories -->
    <section class="container my-5">
        <h2 class="text-center">Our Rooms</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/room1.jpg" class="card-img-top" alt="Deluxe Room">
                    <div class="card-body text-center">
                        <h5 class="card-title">Deluxe Room</h5>
                        <p class="card-text">$150/night</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/room2.jpg" class="card-img-top" alt="Standard Room">
                    <div class="card-body text-center">
                        <h5 class="card-title">Standard Room</h5>
                        <p class="card-text">$80/night</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/room3.jpg" class="card-img-top" alt="Suite">
                    <div class="card-body text-center">
                        <h5 class="card-title">Executive Suite</h5>
                        <p class="card-text">$250/night</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "views/layouts/footer.php"; ?> <!-- Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
