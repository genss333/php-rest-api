<?php
require_once('../config/dbconfig.php');
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo json_encode($db->query("SELECT * FROM users WHERE user_id = $id"));
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "Missing 'id' parameter"));
    }
} else {
    http_response_code(405);
}
?>
