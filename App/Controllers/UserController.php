<?php
require_once (__DIR__."/../../Config/Controller.php");
require_once (__DIR__.'/../Model/UserModel.php');
require_once (__DIR__.'/../Model/PostModel.php');
class UserController extends Controller{

    public function showLogin(){
        include (__DIR__."/../../Public/Login.php");
    }

    public function processLogin() {
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        $email = "";
        $senha = "";

        if(isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $senha = $_POST['password'];

            foreach($users as $user=>$value){
                if ($email == $value['usu_email'] && $senha == $value['usu_senha']) {
                    $_SESSION['user_id'] = $value['usu_id'];
                    $_SESSION['user_name'] = $value['usu_nome'];
                    $_SESSION['avatar'] = $value['usu_avatar'];
                    header('Location: Index.php?route=principal');
                    return; // Termina o script para evitar execução adicional.
                }
            }
            header('Location: Index.php?route=login');
            return;
        }  
        
    }
    public function showRegister(){
        include (__DIR__."/../../Public/Registro.php");
    }
    public function processRegister(){
        // prepared statements para evitar SQL injection
        $userModel = new UserModel();
        
        $nome = "";
        $email = "";
        $senha = "";

        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['nome'])){
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['password'];

            $userModel->insertUsers($nome, $email, $senha);
            header('Location: Index.php?route=login');
            return;
        }
           
    }
    public function showPerfil(){
        $id = $_SESSION['user_id'];
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        $user = [
            'nome' => "",
            'avatar' => "",
            'imgPerfil' => "",
            'email' => ""
        ];
        foreach($users as $u => $value){
            if($value['usu_id'] == $id){
                $user['nome'] = $value['usu_nome'];
                $user['avatar'] = $value['usu_avatar'];
                $user['imgPerfil'] = $value['usu_img_fundo'];
                $user['email'] = $value['usu_email'];
            }
        }
        
        $postModel = new PostModel();
        $posts = $postModel->getPostById("viewPost", 1, $id);

        include (__DIR__."/../../Public/Perfil.php");
    }

    public function processPerfil() {
        $userModel = new UserModel();
        $postModel = new PostModel();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->upImg("perfil", $userModel);
            
            $this->upImg("fundo", $userModel);

        if(isset($_POST['comentario']) && isset($_POST['idPost'])){
            $texto = $_POST['comentario'];
            $idPost = $_POST['idPost'];
            $idUser = $_SESSION['user_id'];

            $postModel->insertComment($texto, $idUser, $idPost);

            header('Location: Index.php?route=perfil');
            return;
        }
        if(isset($_POST['apagar'])){
            $idPost = $_POST['apagar'];

            $postModel->deletePost($idPost);

            header('Location: Index.php?route=perfil');
            return;
        }
    }

    
}
    

    public function upImg($type, $userModel){
        if(isset($_FILES[$type]) && $_FILES[$type]["error"] == UPLOAD_ERR_OK){
            $nome_temporario = $_FILES[$type]["tmp_name"];
            $nome_arquivo = basename($_FILES[$type]["name"]);
            
            // Verifique se o arquivo é uma imagem
            $extensoes_permitidas = array("jpg", "jpeg", "png", "gif", "svg");
            $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
            if (in_array($extensao, $extensoes_permitidas)) {
                // Diretório de destino para salvar a imagem
                $diretorio_destino = "Storage/$type/";
                
                // Renomeie o arquivo para evitar conflitos de nome
                $imgSave = $_SESSION['user_id'] . "." . $extensao;
                $caminho_destino = $diretorio_destino . $imgSave;
    
                
                if (move_uploaded_file($nome_temporario, $caminho_destino)) {
                    echo "A imagem foi carregada com sucesso.";

                    if($type == "perfil"){
                        $userModel->updateAvatar($imgSave, $_SESSION['user_id']);
                        $_SESSION['avatar'] = $imgSave;
                        
                    }
                    elseif($type == "fundo"){
                        $userModel->updateImgPerfil($imgSave, $_SESSION['user_id']);
                        $_SESSION['imgPerfil'] = $imgSave;
                    }
                    
                } else {
                    echo "Erro ao carregar a imagem.";
                }
            } else {
                echo "Apenas arquivos de imagem (jpg, jpeg, png, gif) são permitidos.";
            }
        } else {
            echo "Erro ao processar o upload da imagem.";
        }

        header('Location: Index.php?route=perfil');
        return;
    }
    
}