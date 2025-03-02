<?php
require_once '../config/Database.php';

class UserSeeder {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Function to add users
    public function addUser($name, $email, $password) {
        // Hash the password before saving to database
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare SQL statement
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        // Execute the query
        if ($stmt->execute()) {
            echo "User added successfully!<br>";
        } else {
            echo "Error adding user.<br>";
        }
    }
}

// Create UserSeeder object and insert sample users
$userSeeder = new UserSeeder();
$userSeeder->addUser('John Doe', 'john.doe@example.com', 'password123');
$userSeeder->addUser('Jane Smith', 'jane.smith@example.com', 'mypassword');
$userSeeder->addUser('Admin User', 'admin@example.com', 'adminpassword');
?>
