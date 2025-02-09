-- Create database
CREATE DATABASE blood_bank_management;
USE blood_bank_management;

-- Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    contact_number VARCHAR(15) NOT NULL,
    address TEXT,
    last_donation_date DATE,
    is_donor BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blood Donation Records Table
CREATE TABLE donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    donation_date DATE NOT NULL,
    blood_quantity DECIMAL(5,2) NOT NULL,
    donation_center VARCHAR(100) NOT NULL,
    health_status ENUM('Healthy', 'Deferred', 'Rejected') DEFAULT 'Healthy',
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Blood Request Table
CREATE TABLE blood_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(100) NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    required_quantity DECIMAL(5,2) NOT NULL,
    hospital_name VARCHAR(100) NOT NULL,
    contact_number VARCHAR(15) NOT NULL,
    request_date DATE NOT NULL,
    status ENUM('Pending', 'Fulfilled', 'Cancelled') DEFAULT 'Pending'
);
