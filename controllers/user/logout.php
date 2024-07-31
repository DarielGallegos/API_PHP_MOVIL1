<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: X-Requested-With");
if(isset($_SERVER['REQUEST_METHOD'])){
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            session_start();
            session_destroy();
            echo json_encode(array('status' => true, 'message' => 'Ha destruido el token', 'token' => ''));
            break;
    }
}
?>