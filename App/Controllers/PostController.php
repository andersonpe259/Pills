<?php
require_once (__DIR__.'/../../Config/Controller.php');
require_once (__DIR__.'/../Model/PostModel.php');
// require_once ("CommentController.php");


class PostController extends Controller{
    public function processPost(){
        $postModel = new PostModel();
        
        $texto = "";
        $idUser = "";

        if(isset($_POST['textarea'])){
            $texto = $_POST['textarea'];
            $idUser = $_SESSION['user_id'];
            
            $idPost = $postModel->insertPost($texto, $idUser); //Envia o texto para o banco e pega o id do post recem criado
            $hashtags = $this->analyze->analyzeString($texto); //Procura hashtags no texto
            
            if($hashtags["#"] != null){ //Se o texto possuir alguma hashtag, o if será executado
                for($i = 0; $i < count($hashtags["#"]); $i++){
                    $existe = false;
                    $hashExistente = $postModel->getHashtag(); //Pegar as hashtags existentes
                    foreach($hashExistente as $hash=>$value){
                        if($value["has_hashtag"] == $hashtags["#"][$i]){
                            //Se a hashtag já estiver cadastrada, então só vai adicionar o id em hashdosPosts
                            $postModel->insertHashDosPost($idPost, $value["has_id"]);
                            $existe = true;
                        }
                    }
                    if(!$existe){
                        $idHash = $postModel->insertHashtag($hashtags["#"][$i]); //Insert Hashtag e pegar id da nova hashtag
                        $postModel->insertHashDosPost($idPost, $idHash); //Conecta a hashtag ao post
                    }
            
                }
            }
            header('Location: Index.php?route=principal');
            return;
        }
}
    public function viewPost(){
        $postModel = new PostModel();
        $posts = $postModel->getPost("viewPost");
        $comments = $postModel->getComment();
        
        
        include (__DIR__."/../../Public/Principal.php");
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

