<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../repository/connectDB.php';
include_once '../../controllers/Autentication.php';


session_start();
if(isset($_SERVER['REQUEST_METHOD'])){
    $database = new connectDB();
    $db = $database->connect();
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            $json = json_decode(file_get_contents('php://input'), true);
                    $autentication = new Autentication();
                    $openID = $autentication->authenticationUser($json['usuario'], $json['passwd']);
                    $openID = json_decode($openID);
                    $arr = (array)$openID;    
                    if($arr['access_token'] != ""){
                        $_SESSION['token'] = $arr['access_token'];
                        echo json_encode(array('statusCode' => 200,'status' => true, 'data' => $arr,  'token' => $arr['access_token']));
                    }else{
                        echo json_encode(array('statusCode' => 500, 'status' => false, 'token' => ''));
                    }
                break;
    }
}

?>