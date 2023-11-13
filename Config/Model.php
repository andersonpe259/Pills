<?php
require_once (__DIR__."/Conexao.php");
require_once (__DIR__."/../Database/SqlCommands.php");
class Model{
    //Base para Fazer o CRUD
    public $conect, $query;
    public function __construct(){
        $this->conect = new Conexao();
        $this->query = new SqlCommands();
    }

    public function genericInsert($con, $query, $types, ...$params){

        $stmt = $con->prepare($query);
        if ($stmt) {
            $bindParams = array_merge([$types], $params);
            $stmt->bind_param(...$bindParams);
            $stmt->execute();   
        } else {
            throw new Exception("Erro: " . $con->error);
        }
        $con->close();
    }
}