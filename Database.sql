CREATE DATABASE IF NOT EXISTS gearlog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gearlog;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    serial_number VARCHAR(100) NOT NULL UNIQUE,
    device_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    status ENUM('Deployed', 'Under Repair', 'In Storage') NOT NULL DEFAULT 'In Storage',
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO categories (name) VALUES 
('Laptops'), 
('Monitors'), 
('Servers'), 
('Networking Gear'), 
('Peripherals')
ON DUPLICATE KEY UPDATE name=name;
