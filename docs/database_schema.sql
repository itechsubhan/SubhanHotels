-- Create the hotel_reservation database
CREATE DATABASE IF NOT EXISTS subhanHotelDB;
USE subhanHotelDB;

-- Create rooms table
CREATE TABLE IF NOT EXISTS rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    capacity INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create reservations table
CREATE TABLE IF NOT EXISTS reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    guest_name VARCHAR(255) NOT NULL,
    checkin_date DATE NOT NULL,
    checkout_date DATE NOT NULL,
    num_guests INT NOT NULL,
    total_cost DECIMAL(10, 2) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE
);

-- Create users table (for admin purposes)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample rooms data
INSERT INTO rooms (type, price, capacity, image) VALUES
('Single Room', 100.00, 1, 'single_room.jpg'),
('Double Room', 150.00, 2, 'double_room.jpg'),
('Suite', 250.00, 4, 'suite.jpg'),
('Presidential Suite', 500.00, 6, 'presidential_suite.jpg');

-- Insert sample reservations data
INSERT INTO reservations (room_id, guest_name, checkin_date, checkout_date, num_guests, total_cost, email, phone) VALUES
(1, 'John Doe', '2025-02-28', '2025-03-05', 2, 500.00, 'john.doe@example.com', '123-456-7890'),
(2, 'Jane Smith', '2025-03-01', '2025-03-07', 3, 900.00, 'jane.smith@example.com', '987-654-3210'),
(3, 'Mark Johnson', '2025-03-10', '2025-03-15', 4, 1000.00, 'mark.johnson@example.com', '555-555-5555');

-- Insert sample users data (admin for login functionality)
INSERT INTO users (username, password, role) VALUES
('admin', MD5('adminpassword'), 'admin'), -- MD5 for hashing (You can use better hashing algorithms like bcrypt)
('user1', MD5('userpassword1'), 'user'),
('user2', MD5('userpassword2'), 'user');
