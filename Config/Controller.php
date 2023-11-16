<?php
require_once (__DIR__."/Conexao.php");
require_once (__DIR__."/../Database/SqlCommands.php");
require_once (__DIR__."/../App/Procedures/Analyze.php");
require_once (__DIR__."/../App/Procedures/Drawing.php");

class Controller {
    public $conect, $commands, $analyze, $drawing;

    
    public function __construct() {
        $this->conect = new Conexao();
        $this->commands = new SqlCommands();
        $this->analyze = new Analyze();
        $this->drawing = new Drawing();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    
    
    public function initValues($name_function){
        /**
         * Os htmls que serão feitos estão no arquivo SqlCommands e são pegos com variável $html
         * já Keywords pega as palavras chaves desse html, que serão substituidas
         */
        $n = $name_function;//Simplificar a chamada da Variável
        $values = [
            "h" => $this->commands->getHtml($n), //Html
            "k" => $this->commands->getKeywords($n), //Keywords
            "s" => $this->commands->getCommand($n) //Comandos MYSQL
        ];

        return $values;
    }
}
    
    

