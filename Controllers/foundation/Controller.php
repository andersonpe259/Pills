<?php
require 'Conexao.php';

class Controller {
    public $conect;
    
    public function __construct() {
        $this->conect = new Conexao();
        session_start();
    }

    
    }
    

