<?php
require_once (__DIR__."/Conexao.php");
require_once (__DIR__."/../Database/SqlCommands.php");
require_once (__DIR__."/../App/Procedures/Analyze.php");
// require_once (__DIR__."/../App/Procedures/Drawing.php");
require_once (__DIR__."/../App/Procedures/UploadImg.php");

class Controller {
    public $conect, $commands, $analyze, $drawing, $upImg;

    
    public function __construct() {
        $this->conect = new Conexao();
        $this->commands = new SqlCommands();
        $this->analyze = new Analyze();
        $this->upImg = new UploadImg();
        session_start();
    }
}
    
    

