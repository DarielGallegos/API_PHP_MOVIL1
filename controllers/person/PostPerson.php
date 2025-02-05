<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../services/Personas.php';
include_once '../../repository/connectDB.php';

$database = new connectDB();
$db = $database->connect();

$pinst = new Personas($db);

$data = json_decode(file_get_contents("php://input"), true);
$pinst->nombres = $data['nombre'];
$pinst->apellido = $data['apellido'];
$pinst->direccion = $data['direccion'];
$pinst->telefono = $data['telefono'];
$pinst->foto = $data['foto'];
$pinst->createPerson();

?>