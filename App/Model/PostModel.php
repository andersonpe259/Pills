<?php
require_once (__DIR__."/../../Config/Model.php");

class PostModel extends Model{

    public function getPost($base, $indice = 0){

        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand($base);
        $result = mysqli_query($con, $query[$indice]);

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

    public function getPostSave($id){

        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("viewSave");
        $result = $con->prepare($query[0]);
        $result->bind_param('i', $id);
        $result->execute();

        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            $result = $result->get_result();
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

    public function getPostCompartilhado($id){

        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("viewNotification");
        $result = $con->prepare($query[0]);
        $result->bind_param('i', $id);
        $result->execute();

        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            $result = $result->get_result();
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

    public function getPostByID($base, $indice, $id){

        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand($base);
        $result = $con->prepare($query[$indice]);
        $result->bind_param("i", $id);
        $result->execute();

        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            //Processar o resultado, se necessário
            $result = $result->get_result();
            $rows = array();
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[$i] = $row;
                $i++;
            }
            return $rows;
        }
    }


    public function insertPost($texto, $id){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("userPost");
        $stmt = $con->prepare($query[0]);
        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("ss", $id, $texto);
            $stmt->execute();
        
        } else {
            throw new Exception("Erro: " . $con->error);
        }
        $id = mysqli_insert_id($con);
        $con->close();

        return $id;
    }

    public function insertSave($idUser, $idPost){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("savePost");
        $stmt = $con->prepare($query[0]);
        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("ii", $idUser, $idPost);
            $stmt->execute();
        
        } else {
            throw new Exception("Erro: " . $con->error);
        }
        
        $con->close();

    }

    public function insertHashtag($hashtag){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("userPost");
        $stmt = $con->prepare($query[1]);
        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("s", $hashtag);
            $stmt->execute();
        
        } else {
            throw new Exception("Erro: " . $con->error);
        }
        $id = mysqli_insert_id($con);
        $con->close();

        return $id;
    }

    public function insertHashDosPost($idPost, $idHash){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("userPost");
        $stmt = $con->prepare($query[3]);
        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("ii", $idHash, $idPost);
            $stmt->execute();
        
        } else {
            throw new Exception("Erro: " . $con->error);
        }
        $con->close();
    }

    public function getHashtag(){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("userPost");
        $result = mysqli_query($con, $query[2]);


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
    public function insertComment($texto, $idUser, $idPost){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("commentPost");
        $stmt = $con->prepare($query[0]);
        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("iis", $idUser, $idPost, $texto);
            $stmt->execute();
        
        } else {
            throw new Exception("Erro: " . $con->error);
        }
        $con->close();

    }
    public function getComment($idPost){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("viewComment");
        $result = $con->prepare($query[0]);
        $result->bind_param('i', $idPost);
        $result->execute();

        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            $result = $result->get_result();
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

    public function getTags(){
        $con = $this->conect->conection();//Conexão com o banco
        $query = $this->query->getCommand("tagPost");
        $result = mysqli_query($con, $query[0]);
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
}
