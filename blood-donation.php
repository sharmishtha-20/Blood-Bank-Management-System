<?php
require_once 'db-connection.php';

class BloodDonation {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function recordDonation($user_id, $donation_date, $blood_quantity, $donation_center, $health_status = 'Healthy', $notes = '') {
        $query = "INSERT INTO donations (user_id, donation_date, blood_quantity, donation_center, health_status, notes) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("isdsss", $user_id, $donation_date, $blood_quantity, $donation_center, $health_status, $notes);
        
        if ($stmt->execute()) {
            // Update last donation date in users table
            $update_query = "UPDATE users SET last_donation_date = ?, is_donor = 1 WHERE user_id = ?";
            $update_stmt = $this->db->conn->prepare($update_query);
            $update_stmt->bind_param("si", $donation_date, $user_id);
            $update_stmt->execute();

            return true;
        }
        return false;
    }

    public function createBloodRequest($patient_name, $blood_group, $required_quantity, $hospital_name, $contact_number) {
        $query = "INSERT INTO blood_requests (patient_name, blood_group, required_quantity, hospital_name, contact_number, request_date) 
                  VALUES (?, ?, ?, ?, ?, CURDATE())";
        
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("ssdss", $patient_name, $blood_group, $required_quantity, $hospital_name, $contact_number);
        
        return $stmt->execute();
    }

    public function getAvailableDonors($blood_group) {
        $query = "SELECT * FROM users 
                  WHERE blood_group = ? AND is_donor = 1 
                  AND (last_donation_date IS NULL OR DATEDIFF(CURDATE(), last_donation_date) >= 90)";
        
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $blood_group);
        $stmt->execute();
        
        return $stmt->get_result();
    }
}
?>
