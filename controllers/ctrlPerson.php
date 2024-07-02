<?php

//Declare Headers
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../services/Personas.php';
include_once '../repository/connectDB.php';

if(isset($_SERVER['REQUEST_METHOD'])){
    $database = new connectDB();
    $db = $database->connect();
    $person = new Personas($db);

    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $person->readPerson();
            break;
        
        case 'POST':
            $json = json_decode(file_get_contents('php://input'), true);
            $person->nombres = $json['nombre'];
            $person->apellido = $json['apellido']; 
            $person->direccion = $json['direccion'];
            $person->telefono = $json['telefono'];
            $person->foto = $json['foto'];
            $person->createPerson();
            break;
        case 'PUT':
            $json = json_decode(file_get_contents('php://input'), true);
            $person->id = $json['id'];
            $person->nombres = $json['nombre'];
            $person->apellido = $json['apellido']; 
            $person->direccion = $json['direccion'];
            $person->telefono = $json['telefono'];
            $person->foto = $json['foto'];
            $person->putPerson();
            break;
        case 'DELETE':
            $json = json_decode(file_get_contents('php://input'), true);
            $person->id = $json['id'];
            $person->deletePerson();
            break;
    }
}


?>