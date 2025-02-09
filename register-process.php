<?php
header('Content-Type: application/json');
// changed user_auth to user-auth (typo)
require_once 'user-auth.php';

$data = json_decode(file_get_contents('php://input'), true);

$auth = new UserAuthentication();

$response = [
    'success' => false,
    'message' => 'Registration failed'
];

if (!empty($data['fullName']) && !empty($data['email']) && !empty($data['password'])) {
    $result = $auth->register(
        $data['fullName'], 
        $data['email'], 
        $data['password'], 
        $data['bloodGroup'], 
        $data['dateOfBirth'], 
        $data['gender'], 
        $data['contactNumber'], 
        $data['address']
    );

    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Registration successful';
    }
}

echo json_encode($response);
?>
