<?php
require_once 'user-auth.php';

$auth = new UserAuthentication();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // You might want to add more validation here
    // For this example, we'll keep it simple
    $blood_group = ''; // Optional
    $date_of_birth = ''; // Optional
    $gender = ''; // Optional
    $contact_number = ''; // Optional
    $address = ''; // Optional

    if ($auth->register($full_name, $email, $password, $blood_group, $date_of_birth, $gender, $contact_number, $address)) {
        // Redirect to login page with success message
        session_start();
        $_SESSION['success'] = 'Registration successful. Please log in.';
        header('Location: index.php');
        exit();
    } else {
        // Set error message in session
        session_start();
        $_SESSION['error'] = 'Registration failed. Please try again.';
        header('Location: index.php');
        exit();
    }
}
?>
