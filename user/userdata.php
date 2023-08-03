<?php 
    require_once('../config/dbconfig.php');
    $db = new Database();

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $tables = ['users', 'book','user_image'];
        $joinConditions = [
            'users.user_id = book.user_id',
            'users.user_id = user_image.user_id'
        ];
        echo json_encode($db->joinTables($tables,$joinConditions));
    }else{
        http_response_code(405);
    }
?>