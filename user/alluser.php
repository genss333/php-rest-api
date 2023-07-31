<?php 
    require_once('../config/dbconfig.php');
    $db = new Database();

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        echo json_encode($db->query('SELECT * FROM users'));
    }else{
        http_response_code(405);
    }
?>