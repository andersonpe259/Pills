<?php
require_once (__DIR__."/Conexao.php");
require_once (__DIR__."/../Database/SqlCommands.php");
class Model{
    public $conect, $query;
    public function __construct(){
        $this->conect = new Conexao();
        $this->query = new SqlCommands();
    }
}