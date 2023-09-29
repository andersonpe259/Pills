<?php
require 'foundation/Controller.php';

class PostController extends Controller{

    public function userPost($texto){
        
        //Se Não existir nenhum user_id em Session ele não irar rodar
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {

            $query = "INSERT INTO tb_posts (pos_usu_id, pos_conteudo) VALUES (?, ?)";
            $con = $this->conect->conection();
            $stmt = $con->prepare($query);

            if ($stmt) {
                // Vincula os parâmetros e executa a consulta
                $stmt->bind_param("ss", $_SESSION['user_id'], $texto);
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
        }
        else{
            throw new Exception("Erro: User_id não definido");
        }
    }
    public function viewPost(){
        
        $query = "SELECT pos_id, pos_conteudo, usu_nome FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id";
        
            $result = mysqli_query($this->conect->conection(), $query);
            if (!$result) {
                throw new Exception("Erro na consulta");
            }
            else{
                // Processar o resultado, se necessário
                 while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post_div'><div class='left_side'>";
                echo '<h1>'.$row['usu_nome'].'</h1>';
                echo '<p>Post: '.$row['pos_conteudo'] .'</p>';
                echo "<form action='Principal.php' method='post'>
                        <input type='hidden' name='idPost' value='".$row['pos_id']."'>
                        <input type='text' name='comment' id='comment'>
                        <button><i class='finish_button'><img src='assets/img/button_go.png' alt='Concluir'></i></button>
                    </form>
                    </div><div class='right_side'>";
                echo $this->viewComment($row['pos_id']). "</div></div>";
                    
                
            }
            }
             // Fechar conexão quando terminar
            $this->conect->conection()->close();
        
        
        
    }

    public function commentPost($idPost, $text){

            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
            $query = "INSERT INTO tb_comentarios (com_usu_id, com_pos_id, com_texto) VALUES (?, ?, ?)";
            $con = $this->conect->conection();
            $stmt = $con->prepare($query);

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
        $query = "SELECT com_texto, usu_nome, com_data_comentario FROM tb_comentarios 
                                            LEFT JOIN tb_posts ON com_pos_id = pos_id
                                            LEFT JOIN tb_usuarios on com_usu_id = usu_id 
                                            WHERE com_pos_id = ". $idPost .";";

                                
        $result = mysqli_query($this->conect->conection(), $query);
        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            // Processar o resultado, se necessário
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='comment_unit'>";
                echo '<h4>'.$row['usu_nome'].$row['com_data_comentario'].'</h4>';
                echo '<p>'.$row['com_texto'] .'</p>';
                echo "</div>";
            }
        }
        // Feche a conexão quando terminar de usar
        $this->conect->conection()->close();
    }
}