<?php
require_once (__DIR__.'/../../Config/Controller.php');

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
        $values = $this->initValues(__FUNCTION__);
        
        $con = $this->conect->conection();
        $html = array();
        $result = $con->prepare($values['s'][0]);
        $result->bind_param('i', $idPost);
        $result->execute();
        $result = $result->get_result();
        $con->close();
        // $this->drawing->drawing_post($result, $values['h'], $values['k'], __FUNCTION__);
        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{

            // Processar o resultado, se necessário
            while ($row = mysqli_fetch_assoc($result)) {
                $rows = [$row['usu_avatar'], $row['usu_nome'], $row['com_data_comentario'],$row['com_texto']];
                array_push($html, $rows);
                
            }
            return $html;
        }
        
    }
}