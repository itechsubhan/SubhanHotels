<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <?php include "views/layouts/header.php"; ?> <!-- Navigation Bar -->

    <!-- Hero Section -->
    <section class="position-relative text-center text-white d-flex align-items-center justify-content-center vh-100" style="background: url('assets/images/hotel-bg.jpg') center/cover no-repeat;">
        <div class="container">
            <h1 class="display-1 fw-bold">Luxury Awaits You</h1>
            <p class="lead">Book your perfect stay today!</p>
        </div>
    </section>

    <!-- Booking Form -->
    <section class="container my-5">
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

    <!-- Hotel Overview -->
    <section class="container my-5 text-center">
        <h2>About Our Hotel</h2>
        <p>Experience world-class service, luxurious rooms, and breathtaking views.</p>
        <div class="row g-3">
            <div class="col-md-4"><img src="assets/images/hotel1.jpg" class="img-fluid rounded"></div>
            <div class="col-md-4"><img src="assets/images/hotel2.jpg" class="img-fluid rounded"></div>
            <div class="col-md-4"><img src="assets/images/hotel3.jpg" class="img-fluid rounded"></div>
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
                        <a href="views/rooms.php" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/room2.jpg" class="card-img-top" alt="Standard Room">
                    <div class="card-body text-center">
                        <h5 class="card-title">Standard Room</h5>
                        <p class="card-text">$80/night</p>
                        <a href="views/rooms.php" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/room3.jpg" class="card-img-top" alt="Suite">
                    <div class="card-body text-center">
                        <h5 class="card-title">Executive Suite</h5>
                        <p class="card-text">$250/night</p>
                        <a href="views/rooms.php" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "views/layouts/footer.php"; ?> <!-- Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
