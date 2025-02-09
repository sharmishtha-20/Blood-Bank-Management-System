<?php
session_start();
require_once 'db-connection.php';

class UserAuthentication {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($full_name, $email, $password, $blood_group, $date_of_birth, $gender, $contact_number, $address) {
        $email = $this->db->sanitize($email);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (full_name, email, password, blood_group, date_of_birth, gender, contact_number, address) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("ssssssss", $full_name, $email, $hashed_password, $blood_group, $date_of_birth, $gender, $contact_number, $address);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($email, $password) {
        $email = $this->db->sanitize($email);

        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                return true;
            }
        }
        return false;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>
