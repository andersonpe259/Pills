<?php
require_once ('foundation/Controller.php');


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
    /***
     * - drawing_post é responsável por fazer a montagem do código Html que será renderizado
     * $result -> Dados do Banco de Dados
     * $html -> String do html básico(Sem os valores, como nome, post, etc)
     * $keywords -> São as palavras "reservadas" do html básico
     * 
     * Como Funciona: 
     * A função usuará da função substituteValues para substituir as $keywords do $html pelos 
     * valores de $result, que serão exibidos com o echo.
     */
    public function drawing_post($result, $html, $keywords, $required_row){

        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            // Processar o resultado, se necessário
            switch($required_row){
                case "viewPost":
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows = [
                            $row['usu_avatar'],
                            $row['usu_nome'],
                            $row['pos_data_postagem'],
                            $row['pos_conteudo'],
                            $row['pos_id']
                        ];
                        $showHtml = $this->substituteValues($html[0], $keywords, $rows);
                        echo $showHtml;
                    }
                    break;
                    
                case "tagPost":
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows = [
                            $row["has_id"],
                            $row["has_hashtag"]
                        ];
                        $showHtml = $this->substituteValues($html[0], $keywords, $rows);
                        echo $showHtml;
                    }
                    break;
            }
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

    public function viewPost($filtro = 0, $tag = 0){
        //Simplificação para chamar a variável
        $f = $filtro;
        $t = $tag;
        $values = $this->initValues(__FUNCTION__);//Valores Padrões: Html, Keywords e comandos Sql
        $con = $this->conect->conection();//Conexão com o banco

        switch($f){
            case 0:
            case 1:

               $result = mysqli_query(
                $con,
                $values['s'][$f]
                );

                $this->drawing_post(
                    $result,
                    $values['h'],
                    $values['k'],
                    __FUNCTION__
                );
                
                    // Fechar conexão quando terminar
                $con->close(); 
                break;

            case 2:

                if($t != 0){
                $result = $con->prepare($values['s'][$f]);
                $result->bind_param('i', $t);
                $result->execute();
                $result = $result->get_result();
                $this->drawing_post($result, $values['h'], $values['k'], __FUNCTION__);
                }
                else{
                    $con = $this->conect->conection();
                    $result = mysqli_query($con, $values['s'][3]);
                    $this->drawing_post($result, $values['h'], $values['k'], __FUNCTION__);
                }
                $con->close();
                break;
        }
         
    }
    public function tagPost(){
        $values = $this->initValues(__FUNCTION__);
        $con = $this->conect->conection();

        $result = mysqli_query(
            $con,
            $values['s'][0]
        );

        $this->drawing_post(
            $result,
            $values['h'],
            $values['k'],
            __FUNCTION__
        );
             
        }
    }
