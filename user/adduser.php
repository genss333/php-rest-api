<?php
require_once('../config/dbconfig.php');
require_once('../service/fileservice.php');
$db = new Database();
$fileService = new ImageUploader();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    if ($username && $email && isset($_FILES['image'])) {
        $userData = array(
            'username' => $username,
            'user_email' => $email
        );

        if ($db->insert('users', $userData)) {
            $dataUser = $db->queryCustom('SELECT * FROM users ORDER BY user_id DESC LIMIT 1');
            $user_id = $dataUser[0]['user_id'];

            $address = $_POST['address'];
            $tel = $_POST['tel'];
            $pid = $_POST['pid'];
            $bookData = array(
                'user_id' => $user_id,
                'address' => $address,
                'tel' => $tel,
                'pid' => $pid
            );

            if ($db->insert('book', $bookData)) {
                $imagePath = $fileService->uploadImage($_FILES['image']);
                $imageData = array(
                    'user_id' => $user_id,
                    'image' => $imagePath
                );

                if ($db->insert('user_image', $imageData)) {
                    http_response_code(201); // Created
                    echo json_encode(array('message' => 'User, book, and image data added successfully'));
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(array('message' => 'Failed to insert image data'));
                }
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(array('message' => 'Failed to insert book data'));
            }
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Failed to add new user'));
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('message' => 'Username, email, and image are required'));
    }
} else {
    http_response_code(405); // Method Not Allowed
}
?>
