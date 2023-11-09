<?php
require_once (__DIR__.'/../../Config/Controller.php');
// require_once ("CommentController.php");


class PostController extends Controller{
   
    public function userPost($texto){
         // $sqlCom[0] -> insert into tb_posts || $sqlCom[1] -> insert into tb_hashtag || $sqlCom[2] -> insert into tb_hashdosposts
        //Se Não existir nenhum user_id em Session ele não irar rodar
        $global_name = __FUNCTION__;
        $values = $this->initValues($global_name);

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
            /**
             * $reservedWords destrincha a String $texto
             * em busca de # e @, assim ela retorna uma matriz
             * onde # -> se refere ao array com Hashtag
             * e @ -> se refere ao array com marcações 
             */
            $reservedWords = $this->analyze->analyzeString($texto);  
            $con = $this->conect->conection();
            $stmt = $con->prepare($values['s'][0]);

            if ($stmt) {
                // Vincula os parâmetros e executa a consulta
                $stmt->bind_param("ss", $_SESSION['user_id'], $texto);

                if ($stmt->execute()) 
                {
                    $id = mysqli_insert_id($con);
                    if($reservedWords["#"] != null){
                        for($i = 0; $i < count($reservedWords["#"]); $i++){
                            $existe = false;
                            $result = mysqli_query($con, $values['s'][2]);

                            if(!$result){
                                throw new Exception("Erro na consulta");
                            }
                            else{
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if($row["has_hashtag"] == $reservedWords["#"][$i]){
                                        //Se a hashtag já estiver cadastrada, então só vai adicionar o id em hashdosPosts
                                        $hash = $con->prepare($values['s'][3]);
                                        $hash->bind_param("ii", $row["has_id"], $id);
                                        $hash->execute();
                                        $existe = true;
                                    }
                                }
                                if($existe == false){
                                    $hash = $con->prepare($values['s'][1]);
                                    $hash->bind_param("s", $reservedWords["#"][$i]);
                                    $hash->execute();
                                    $id_hash = mysqli_insert_id($con);
                                    $hashCon = $con->prepare($values['s'][3]);
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


    public function viewPost($filtro = 0, $tag = 0){
        $draw = $this->drawing;
        //Simplificação para chamar a variável
        $f = $filtro;
        $t = $tag;
        $global_name = __FUNCTION__; 
        $values = $this->initValues($global_name);//Valores Padrões: Html, Keywords e comandos Sql
        $con = $this->conect->conection();//Conexão com o banco
       

        switch($f){
            case 0:
            case 1:

               $result = mysqli_query($con, $values['s'][$f]);

                $draw->drawing_post(
                    $result,
                    $values['h'][0],
                    $values['k'],
                    $global_name, 
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
                $this->drawing->drawing_post($result, $values['h'][0], $values['k'], $global_name);
                }
                else{
                    $con = $this->conect->conection();
                    $result = mysqli_query($con, $values['s'][3]);
                    $this->drawing->drawing_post($result, $values['h'][0], $values['k'], $global_name);
                }
                $con->close();
                break;
        }
         
    }
    public function tagPost(){
        $global_name = __FUNCTION__;
        $values = $this->initValues($global_name);
        $con = $this->conect->conection();

        $result = mysqli_query(
            $con,
            $values['s'][0]
        );

        $this->drawing->drawing_post($result, $values['h'][0], $values['k'], $global_name);
             
        }
    }

