<?php
require 'foundation/Controller.php';


class PostController extends Controller{

    public function userPost($texto){
         // $sqlCom[0] -> insert into tb_posts || $sqlCom[1] -> insert into tb_hashtag || $sqlCom[2] -> insert into tb_hashdosposts
        //Se Não existir nenhum user_id em Session ele não irar rodar
        $sqlCom = $this->commands->getCommand("userPost");

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
            /**
             * $reservedWords destrincha a String $texto
             * em busca de # e @, assim ela retorna uma matriz
             * onde # -> se refere ao array com Hashtag
             * e @ -> se refere ao array com marcações 
             */
            $reservedWords = $this->analyzeString($texto);

            
            $con = $this->conect->conection();
            $stmt = $con->prepare($sqlCom[0]);

            if ($stmt) {
                // Vincula os parâmetros e executa a consulta
                $stmt->bind_param("ss", $_SESSION['user_id'], $texto);

                if ($stmt->execute()) 
                {
                    $id = mysqli_insert_id($con);
                    if($reservedWords["#"] != null){
                        for($i = 0; $i < count($reservedWords["#"]); $i++){
                            $existe = false;
                            $result = mysqli_query($con, $sqlCom[2]);

                            if(!$result){
                                throw new Exception("Erro na consulta");
                            }
                            else{
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if($row["has_hashtag"] == $reservedWords["#"][$i]){
                                        //Se a hashtag já estiver cadastrada, então só vai adicionar o id em hashdosPosts
                                        $hash = $con->prepare($sqlCom[3]);
                                        $hash->bind_param("ii", $row["has_id"], $id);
                                        $hash->execute();
                                        $existe = true;
                                    }
                                }
                                if($existe == false){
                                    $hash = $con->prepare($sqlCom[1]);
                                    $hash->bind_param("s", $reservedWords["#"][$i]);
                                    $hash->execute();
                                    $id_hash = mysqli_insert_id($con);
                                    $hashCon = $con->prepare($sqlCom[3]);
                                    $hashCon->bind_param("ii", $id_hash, $id);
                                    $hashCon->execute();
                                }
                            }
                        }

                        
                    }
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

    }
    public function drawing_post($result, $html, $keywords){

        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            // Processar o resultado, se necessário
                while ($row = mysqli_fetch_assoc($result)) {
                    $comentarios = $this->viewComment($row['pos_id']);
                    $rows = [$row['usu_avatar'], $row['usu_nome'], $row['pos_data_postagem'], $row['pos_conteudo'], $row['pos_id'], $comentarios];
                    $showHtml = $this->substituteValues($html[1], $keywords, $rows);
                    echo $showHtml;
                }
        }
            
        }
    public function viewPost($filtro = 0, $tag = 0){
        /**
         * Os htmls que serão feitos estão no arquivo SqlCommands e são pegos com variável $html
         * já Keywords pega as palavras chaves desse html, que serão substituidas
         */
        $html = $this->commands->getHtml("viewPost");
        $keywords = $this->commands->getHtml("keyWords-vp2");
        $sqlCom = $this->commands->getCommand("viewPost"); //Comandos MYSQL

        if($filtro == 0 or $filtro == 1){
            $result = mysqli_query($this->conect->conection(), $sqlCom[$filtro]);
            $this->drawing_post($result, $html, $keywords);
                // Fechar conexão quando terminar
            $this->conect->conection()->close();
        }
        elseif($filtro == 2){
            if($tag != 0){
                $con = $this->conect->conection();

                $result = $con->prepare($sqlCom[$filtro]);
                $result->bind_param('i', $tag);
                $result->execute();
                $result = $result->get_result();
                $this->drawing_post($result, $html, $keywords);
            }
            else{
                $con = $this->conect->conection();
                $result = mysqli_query($con, $sqlCom[3]);
                $this->drawing_post($result, $html, $keywords);
            }
            

        }
         
    }
    public function filterTagPost(){
        $sqlCom = $this->commands->getCommand("filterTagPost");
        $con = $this->conect->conection();
        $result = mysqli_query($con, $sqlCom[0]);
        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            // Processar o resultado, se necessário
            echo "<div class='sugestoes'> <ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<form method='post' action='Pesquisa.php'>
                            <li><button type='submit' class='nav-link scrollto' name='tag' value=".$row["has_id"].">"."<i class='bi bi-hash'></i> <span>".$row["has_hashtag"]."</span></button></li>
                            
                        </form>";
                    
                }
                echo "</ul></div>";
        }
    }
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
        // Feche a conexão quando terminar de usar
        $con->close();
    }
}