<?php
session_start();
require_once 'database.php';
require_once 'user-auth.php';

// Check if user is logged in
$auth = new UserAuthentication();
if (!$auth->isLoggedIn()) {
    header('Location: index.php');
    exit();
}

// Fetch donor details
class DonorManager {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getDonorDetails($user_id) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getDonationHistory($user_id) {
        $query = "SELECT * FROM donations WHERE user_id = ? ORDER BY donation_date DESC";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function calculateNextEligibilityDate($last_donation_date) {
        // Assuming 90 days between donations
        $next_eligibility = date('Y-m-d', strtotime($last_donation_date . ' + 90 days'));
        return $next_eligibility;
    }
}

// Get donor details
$donorManager = new DonorManager();
$user_id = $_SESSION['user_id'];
$donor = $donorManager->getDonorDetails($user_id);
$donations = $donorManager->getDonationHistory($user_id);

// Calculate donation statistics
$total_donations = count($donations);
$last_donation = $donations ? $donations[0] : null;
$next_eligibility = $last_donation 
    ? $donorManager->calculateNextEligibilityDate($last_donation['donation_date'])
    : null;
?>


