<?php
// test.php

require_once '../config/Database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Prepare the SQL query to select user details
    $sql = 'SELECT user_id, username, password, role FROM users';
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch all user details
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any users
    if ($users) {
        echo '<table border="1">';
        echo '<tr><th>User ID</th><th>Username</th><th>Role</th></tr>';
        foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($user['user_id']) . '</td>';
            echo '<td>' . htmlspecialchars($user['username']) . '</td>';
            echo '<td>' . htmlspecialchars($user['role']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No users found.';
    }
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
