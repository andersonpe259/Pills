<?php
require_once (__DIR__.'/../../Config/Controller.php');
require_once (__DIR__.'/../Model/PostModel.php');
// require_once ("CommentController.php");


class SearchController extends Controller{
    public function processRequest(){
        
        $option = "";
        $tag = "";

        if(isset($_POST['filtro'])){
            $option = $_POST['filtro'];
            switch($option){
                case 0:
                    $this->viewPost($option);//Em alta
                    break;
                case 1:
                    $this->viewPost($option, true);//Em Tags
                    break;
            }
            
        }
        if(isset($_POST['tag'])){
            $tag = $_POST['tag'];
            $this->viewPost($option, true, true, $tag);//Em Tags com filtro
        }
            header('Location: Index.php?route=principal');
            return;
        }

    public function viewPost($filtro = 0, $tagbar = false, $filterTag = false, $id = 0){
        $postModel = new PostModel();
        if(!$filterTag){
            $posts = $postModel->getPost("searchPost", $filtro);
        }
        else{
            $posts = $postModel->getPostById("searchPost", 2, $id);
        }
        
        
        $tags = $postModel->getTags();
        $showtag = $tagbar;
           
        include (__DIR__."/../../Public/Pesquisa.php");
    }

}

