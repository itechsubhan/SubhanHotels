<?php  
require_once "../controllers/UserController.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Instantiate the UserController and call the login method
    $controller = new UserController();
    $controller->login(); // Assuming login method handles POST data internally
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url("../assets/images/adminBG.jpeg"); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-group label {
            font-weight: bold;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ccc;
        }

        .divider span {
            padding: 0 15px;
            color: #555;
        }
    </style>
</head>

<body>
    <?php include "layouts/header.php"; ?>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-white p-4 rounded">
            <h3 class="text-center mb-4">Welcome Back Admin!</h3>

            <!-- Display error message if set -->
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['login_error']; ?></div>
                <?php unset($_SESSION['login_error']); ?> <!-- Clear error after displaying -->
            <?php endif; ?>

            <form method="POST" action="login.php"> <!-- Submit to this page itself -->
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group d-flex justify-content-between align-items-center mb-3">
                    <label class="mb-0">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="index.php?action=forgotpassword" class="text-decoration-none">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <?php include "layouts/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
