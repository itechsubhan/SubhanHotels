<?php
// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/Database.php';

class UserModel {
    private $conn;

    public function __construct() {
        // Initialize the database connection
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Login method to check user credentials
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false; // Return false if login fails
    }    

    // Register a new user
    public function register($name, $email, $hashedPassword) {
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        return $stmt->execute(); // Execute the query to insert the user
    }

    // Get user by email (used for login)
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email"; // Use named placeholder
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR); // Bind email using PDO
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch result as an associative array
        return $user ? $user : null; // Return user if found, otherwise return null
    }
}
?>
