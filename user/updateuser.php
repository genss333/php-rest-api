<?php
require_once('../config/dbconfig.php');
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['user_id']) && isset($data['email'])) {
        $user_id = $data['user_id'];
        $email = $data['email'];

        $userData = array(
            'user_email' => $email
        );

        $condition = array(
            'user_id' => $user_id
        );

        if ($db->update('users', $userData, $condition)) {
            http_response_code(200); // OK
            echo json_encode(array('message' => 'User email updated successfully'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to update user email'));
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('message' => 'User ID and email are required'));
    }
} else {
    http_response_code(405); // Method Not Allowed
}
?>
