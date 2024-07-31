<?php

class Personas{
    private $con;
    private $table = "personas";
    
    //Declare attrs
    public $id;
    public $nombres;
    public $apellido;
    public $direccion;
    public $telefono;
    public $foto;

    //Constructor de la clase personas
    public function __construct($db){
        $this->con = $db;
    }


    //Operations CRUD

    //CREATE
    public function createPerson(){
        $query  = "INSERT INTO "
                .$this->table.
                " SET nombres = ?, 
                apellido = ?, 
                direccion = ?, 
                telefono = ?, 
                foto = ?";
        $this->sanitize();
        $statement = $this->con->prepare($query);
        $statement->bindParam(1, $this->nombres);
        $statement->bindParam(2, $this->apellido);
        $statement->bindParam(3, $this->direccion);
        $statement->bindParam(4, $this->telefono);
        $statement->bindParam(5, $this->foto);
        try{
            if($statement->execute()){
                http_response_code(201);
                echo json_encode(array(
                    "status" => 200,
                    "data" => "",
                    "message" => "Se ha insertado con exito"
                ));
            }
        }catch(Exception $ex){
            echo json_encode(array("msg" => $ex->getMessage()));
        }
    }
    public function getPersonaById(){
        $query = "SELECT * FROM ".$this->table." WHERE id = ?";
        $statement = $this->con->prepare($query);
        $statement->bindParam(1, $this->id);
        try{
            $statement->execute();
            http_response_code(200);
            echo json_encode(
                array(
                    "status" => 200,
                    "data" => $statement->fetch(PDO::FETCH_ASSOC),
                    "message" => "Registro Encontrado"                
                ));
        }catch(Exception $ex){
            http_response_code(400);
            echo json_encode(array("msg" => $ex->getMessage()));
        }
    }

    //READ
    public function readPerson(){
        $query = "SELECT * FROM ".$this->table;
        $statement = $this->con->prepare($query);
       try{
        $statement->execute();
        http_response_code(200);
        echo json_encode(
            array(
                "status" => 200,
                "data" => $statement->fetchAll(PDO::FETCH_ASSOC),
                "message" => "Registros Encontrados"
            ));
        }catch(Exception $ex){
            http_response_code(400);
           echo json_encode(array("msg" => $ex->getMessage()));
       }
    }

    //PUT
    public function putPerson(){
        $query = "UPDATE "
                .$this->table.
                " SET nombres = ?, 
                apellido = ?, 
                direccion = ?, 
                telefono = ?, 
                foto = ? 
                WHERE id = ?";
        $this->sanitize();
        $statement = $this->con->prepare($query);
        $statement->bindParam(1, $this->nombres);
        $statement->bindParam(2, $this->apellido);
        $statement->bindParam(3, $this->direccion);
        $statement->bindParam(4, $this->telefono);
        $statement->bindParam(5, $this->foto);
        $statement->bindParam(6, $this->id);
        try{
            if($statement->execute()){
                http_response_code(200);
                echo json_encode(array(
                    "status" => 200,
                    "data" => "",
                    "message" => "Se ha actualizado con exito"
                ));
            }else{
                http_response_code(400);
                echo json_encode(array("message" => "No se ha podido actualizar"));
            }
        }catch(Exception $ex){
            http_response_code(400);
            echo json_encode(array("msg" => $ex->getMessage()));
        }
    }

    //DELETE
    public function deletePerson(){
        if($this->id != 0 || $this->id != null){
            $query = "DELETE FROM ".$this->table." WHERE id = ?";
            $statement = $this->con->prepare($query);
            $statement->bindParam(1, $this->id);
            try{
                if($statement->execute()){
                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 200,
                        "data" => "",
                        "message" => "Se ha eliminado con exito"
                    ));
                }else{
                    http_response_code(400);
                    echo json_encode(array("message" => "No se ha podido eliminar"));
                }
            }catch(Exception $ex){
                http_response_code(400);
                echo json_encode(array("msg" => $ex->getMessage()));
            }
        }
    }


    //Sanitize data function
    private function sanitize(){
        $this->nombres = htmlspecialchars(strip_tags($this->nombres));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->foto = htmlspecialchars(strip_tags($this->foto));
    }
}

?>