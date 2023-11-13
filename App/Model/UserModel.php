<?php
require_once (__DIR__."/../../Config/Model.php");

class UserModel extends Model{

    public function getUsers(){

        $con = $this->conect->conection();//Conexão com o banco
        $query = $query = "SELECT * FROM tb_usuarios";
        $result = mysqli_query($con, $query);
        $con->close();
        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            //Processar o resultado, se necessário
            $rows = array();
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[$i] = $row;
                $i++;
            }
            return $rows;
        }
    }

    public function insertUsers($nome, $email, $senha){
        $con = $this->conect->conection();//Conexão com o banco
        $query = "INSERT INTO tb_usuarios (usu_nome, usu_email, usu_senha) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("sss", $nome, $email, $senha);
            $stmt->execute();
        
        } else {
            throw new Exception("Erro: " . $con->error);
        }
        $con->close();
    }
}