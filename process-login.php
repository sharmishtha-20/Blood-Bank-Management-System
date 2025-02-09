<?php
require_once 'user-auth.php';

$auth = new UserAuthentication();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        // Redirect to dashboard or home page
        header('Location: dashboard.php');
        exit();
    } else {
        // Set error message in session
        session_start();
        $_SESSION['error'] = 'Invalid email or password';
        header('Location: index.php');
        exit();
    }
}
?>
