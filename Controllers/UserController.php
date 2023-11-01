<?php
require 'foundation/Controller.php';

class UserController extends Controller{

    public function userLogin($email, $senha) {
        //se ainda não começou a session.
        $query = "SELECT * FROM tb_usuarios";
        $result = mysqli_query($this->conect->conection(), $query);

        // Processar o resultado, se necessário
        while ($row = mysqli_fetch_assoc($result)) {
            if ($email == $row['usu_email'] && $senha == $row['usu_senha']) {
                $_SESSION['user_id'] = $row['usu_id'];
                $_SESSION['user_name'] = $row['usu_nome'];
                header('Location: Principal.php');
                return; // Termina o script para evitar execução adicional.
            }
        }
        // Fechar conexão após o loop.
        $this->conect->conection()->close();
    }

    public function userRegister($nome, $email, $senha){
        // prepared statements para evitar SQL injection
        $query = "INSERT INTO tb_usuarios (usu_nome, usu_email, usu_senha) VALUES (?, ?, ?)";
        $con = $this->conect->conection();
        $stmt = $con->prepare($query);

        // Verifica se a preparação da consulta foi bem-sucedida
        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("sss", $nome, $email, $senha);
            if ($stmt->execute()) 
            {
                echo "Registro criado com sucesso!";
                $stmt->close();
                $con->close();
                header("Location: Index.php");
                return;
            } 
            else 
            {
                throw new Exception("Erro: " . $con->error);
            }
        } else {
            throw new Exception("Erro: " . $con->error);
        }
    }

    public function editarAvatar($id, $avatar) {
        $query = "UPDATE tb_usuarios SET usu_avatar = ? WHERE usu_id = ?";
        $con = $this->conect->conection();
        $stmt = $con->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("si", $avatar, $id);
            if ($stmt->execute()) {
                echo "Registro editado com sucesso!";
                $stmt->close();
                $con->close();
            } else {
                throw new Exception("Erro: " . $con->error);
            }
        } else {
            throw new Exception("Erro: " . $con->error);
        }
    }
    

}