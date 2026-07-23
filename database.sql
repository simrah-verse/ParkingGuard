CREATE DATABASE IF NOT EXISTS parkingguard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE parkingguard;

DROP TABLE IF EXISTS parking_records;
DROP TABLE IF EXISTS vehicles;
DROP TABLE IF EXISTS visitors;
DROP TABLE IF EXISTS parking_slots;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','operator') NOT NULL DEFAULT 'operator',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    email VARCHAR(150) NULL,
    purpose VARCHAR(255) NOT NULL,
    host_name VARCHAR(120) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visitor_id INT NOT NULL,
    plate_number VARCHAR(30) NOT NULL UNIQUE,
    vehicle_type ENUM('Car','Motorcycle','Van','Truck','Other') NOT NULL DEFAULT 'Car',
    color VARCHAR(50) NOT NULL,
    model VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_vehicle_visitor FOREIGN KEY (visitor_id) REFERENCES visitors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE parking_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slot_code VARCHAR(20) NOT NULL UNIQUE,
    slot_type ENUM('Car','Motorcycle','Van','Truck','Other') NOT NULL DEFAULT 'Car',
    status ENUM('Available','Occupied','Maintenance') NOT NULL DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE parking_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visitor_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    slot_id INT NOT NULL,
    check_in DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    check_out DATETIME NULL,
    status ENUM('Active','Completed') NOT NULL DEFAULT 'Active',
    fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_record_visitor FOREIGN KEY (visitor_id) REFERENCES visitors(id) ON DELETE CASCADE,
    CONSTRAINT fk_record_vehicle FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE,
    CONSTRAINT fk_record_slot FOREIGN KEY (slot_id) REFERENCES parking_slots(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO users (name, email, password, role) VALUES
('System Administrator', 'admin@parkingguard.local', '$2y$10$S9Q.LgvPBIygCsIJU6xSvOiAkzNEypoQfNfzKvq3YHUrC.iAdRVHe', 'admin');

INSERT INTO parking_slots (slot_code, slot_type, status) VALUES
('C-001','Car','Available'),('C-002','Car','Available'),('C-003','Car','Available'),('C-004','Car','Available'),
('M-001','Motorcycle','Available'),('M-002','Motorcycle','Available'),('V-001','Van','Available'),('T-001','Truck','Available');
