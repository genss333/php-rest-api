<?php
require_once('../config/dbconfig.php');
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];

        $condition = array(
            'user_id' => $user_id
        );

        if ($db->delete('users', $condition)) {
            http_response_code(200); // OK
            echo json_encode(array('message' => 'User deleted successfully'));
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to delete user'));
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('message' => 'User ID is required'));
    }
} else {
    http_response_code(405); // Method Not Allowed
}
?>
