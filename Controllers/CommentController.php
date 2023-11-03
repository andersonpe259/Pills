<?php
require_once ("foundation/Controller.php");

class CommentController extends Controller{
    public function commentPost($idPost, $text){
        $sqlCom = $this->commands->getCommand("commentPost");
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
            $con = $this->conect->conection();
            $stmt = $con->prepare($sqlCom[0]);

            if ($stmt) {
                // Vincula os parâmetros e executa a consulta
                $stmt->bind_param("sss", $_SESSION['user_id'], $idPost, $text);
                if ($stmt->execute()) 
                {
                    $stmt->close();
                    $con->close();
                    header("Refresh: 0");
                    return true;
                } 
                else 
                {
                    throw new Exception("Erro: " . $con->error);
                }
            } else {
                throw new Exception("Erro: " . $con->error);
            }
        }else{
            throw new Exception("Erro: User_id não definido");
        }
    }
    public function viewComment($idPost){
        $sqlCom = $this->commands->getCommand("viewComment");
        $html = $this->commands->getHtml("viewComment");
        $keywords = $this->commands->getHtml("keyWords-vc");
        
        $con = $this->conect->conection();
        $result = $con->prepare($sqlCom[0]);
        $result->bind_param('i', $idPost);
        $result->execute();
        $result = $result->get_result();
        $con->close();
        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            $showHtml = "";
            // Processar o resultado, se necessário
            while ($row = mysqli_fetch_assoc($result)) {
                $rows = [$row['usu_nome'], $row['com_data_comentario'],$row['com_texto']];
                $showHtml = $showHtml . $this->substituteValues($html[0], $keywords, $rows);
            }
            return $showHtml;
        }
        
    }
}