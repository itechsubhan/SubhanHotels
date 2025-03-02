<?php
// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Fetch user data by email
            $user = $this->userModel->getUserByEmail($email);
            if ($user) {
                // Debugging: Check if user password from database is correct
                var_dump($user['password']); // This should show the hashed password in the database
        
                // Verify password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = $user['name']; // Store user session
                    header("Location: manage_rooms.php"); // Redirect to welcome page
                    exit;
                } else {
                    $_SESSION['login_error'] = "Incorrect password."; // Store error
                }
            } else {
                $_SESSION['login_error'] = "Incorrect email or password."; // Store error
            }
        }
    
        require_once __DIR__ . '/../views/login.php'; // Load login page
    }

    public function validateCode() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $entered_code = $_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4'];
    
            if ($entered_code == $_SESSION['verification_code']) {
                header("Location: index.php?action=reset_password");
                exit();
            } else {
                echo "Invalid code! Try again.";
            }
        }
    }
}
