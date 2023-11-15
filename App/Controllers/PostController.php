<?php
require_once (__DIR__.'/../../Config/Controller.php');
require_once (__DIR__.'/../Model/PostModel.php');
// require_once ("CommentController.php");


class PostController extends Controller{
    public function processPost(){
        $postModel = new PostModel();
        
        $texto = "";
        $idPost = "";
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
        if(isset($_POST['comentario']) && isset($_POST['idPost'])){
            $texto = $_POST['comentario'];
            $idPost = $_POST['idPost'];
            $idUser = $_SESSION['user_id'];

            $postModel->insertComment($texto, $idUser, $idPost);

            header('Location: Index.php?route=principal');
            return;
        }
        if(isset($_POST['salvar'])){
            $idPost = $_POST['salvar'];
            $idUser = $_SESSION['user_id'];
            $postModel->insertSave($idUser, $idPost); //Envia o texto para o banco e pega o id do post recem criado
            
            header('Location: Index.php?route=principal');
            return;
        }
}
public function processSave(){
    $postModel = new PostModel();  
    $idPost = "";
    $idUser = "";

    if(isset($_POST['salvar'])){
        $idPost = $_POST['salvar'];
        $idUser = $_SESSION['user_id'];
        $postModel->insertSave($idUser, $idPost); //Salva os ids do Usuário e do Post na tabela

        header('Location: Index.php?route=principal');
        return;
    }
}
    public function viewPost(){
        $postModel = new PostModel();
        $posts = $postModel->getPost("viewPost");
        
        include (__DIR__."/../../Public/Principal.php");
    }
   public function viewSave(){
        $postModel = new PostModel();
        $id = $_SESSION["user_id"];
        $posts = $postModel->getPostSave($id);
        
        include (__DIR__."/../../Public/Salvos.php");
   }
    }

