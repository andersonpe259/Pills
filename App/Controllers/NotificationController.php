<?php
require_once (__DIR__.'/../../Config/Controller.php');
require_once (__DIR__.'/../Model/PostModel.php');
// require_once ("CommentController.php");


class NotificationController extends Controller{
    public function viewPost(){
        $postModel = new PostModel();
        $posts = $postModel->getPostCompartilhado($_SESSION['user_id']);

        include (__DIR__."/../../Public/Notifications.php");
    }

    public function processRequest(){
        $postModel = new PostModel();
        
        $texto = "";
        $idPost = "";
        $idUser = "";

        if(isset($_POST['comentario']) && isset($_POST['idPost'])){
            $texto = $_POST['comentario'];
            $idPost = $_POST['idPost'];
            $idUser = $_SESSION['user_id'];

            $postModel->insertComment($texto, $idUser, $idPost);

            header('Location: Index.php?route=notifications');
            return;
        }
        if(isset($_POST['salvar'])){
            $idPost = $_POST['salvar'];
            $idUser = $_SESSION['user_id'];
            try{
                $postModel->insertSave($idUser, $idPost); //Envia o texto para o banco e pega o id do post recem criado
            }
            catch(Exception $e){
                header('Location: Index.php?route=notifications');
                return;
            }//Envia o texto para o banco e pega o id do post recem criado
            
            header('Location: Index.php?route=notifications');
            return;
        }
        if(isset($_POST['apagar'])){
            $idPost = $_POST['apagar'];
    
            $postModel->deleteCompartilhado($idPost);
    
            header('Location: Index.php?route=notifications');
            return;
        
    }
}
   
    }

