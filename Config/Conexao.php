<?php
class Conexao{
    public $host = '127.0.0.1:3307'; // ou o endereço IP do servidor MySQL, se não for local
    public $username = 'root'; // Nome de usuário do MySQL
    public $password = 'usbw'; // Senha do MySQL
    public $database = 'db_pills'; // Nome do banco de dados que você criou
    
    // Estabelecer conexão com o banco de dados
    public function conection(){
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$connection) {
            die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
        }

        return $connection;
    }
    
}



