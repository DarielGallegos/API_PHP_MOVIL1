<?php

//Declare Headers
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../services/Personas.php';
include_once '../../repository/connectDB.php';


if (isset($_SERVER['REQUEST_METHOD'])) {
    $database = new connectDB();
    $db = $database->connect();
    $person = new Personas($db);

    $request = $_SERVER['REQUEST_URI'];
    $request = explode('/', trim($request, '/'));

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $headers = apache_request_headers();
            $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
            if (!empty($authorizationHeader)) { 
                if (isset($request[4])) {
                    $person->id = $request[4];
                    $person->getPersonaById();
                }else{
                    $person->readPerson();
                }
            } else {
                echo json_encode(array('status' => 400, 'data' => "", 'message' => 'No tienen acceso'));
            }
            break;

        case 'POST':
            $headers = apache_request_headers();
            $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
            if (!empty($authorizationHeader)) {
                $json = json_decode(file_get_contents('php://input'), true);
                $person->nombres = $json['nombres'];
                $person->apellido = $json['apellido'];
                $person->direccion = $json['direccion'];
                $person->telefono = $json['telefono'];
                $person->foto = $json['foto'];
                $person->createPerson();    
            }else{
                echo json_encode(array('status' => 400, 'data' => "", 'message' => 'No tienen acceso'));
            }
            break;
        case 'PUT':
            $headers = apache_request_headers();
            $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
            if (!empty($authorizationHeader)) {
                $json = json_decode(file_get_contents('php://input'), true);
                $person->id = $request[4];
                $person->nombres = $json['nombres'];
                $person->apellido = $json['apellido'];
                $person->direccion = $json['direccion'];
                $person->telefono = $json['telefono'];
                $person->foto = $json['foto'];
                $person->putPerson();    
            }else{
                echo json_encode(array('status' => 400, 'data' => "", 'message' => 'No tienen acceso'));
            }
            break;
        case 'DELETE':
            $headers = apache_request_headers();
            $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
            if (!empty($authorizationHeader)) { 
                $person->id = $request[4];
                $person->deletePerson();
            } else {
                echo json_encode(array('status' => 400, 'data' => "", 'message' => 'No tienen acceso'));
            }
            break;
    }
}
