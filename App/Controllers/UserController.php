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
                $user['imgPerfil'] = $value['usu_imgPerfil'];
                $user['email'] = $value['usu_email'];
            }
        }
        
        $postModel = new PostModel();
        $usersPosts = $postModel->getPostById("viewPost", 1, $id);

        include (__DIR__."/../../Public/Perfil.php");
    }

    public function editarAvatar($id, $avatar) {
        $query = "UPDATE tb_usuarios SET usu_avatar = ? WHERE usu_id = ?";
        $con = $this->conect->conection();
        $stmt = $con->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("si", $avatar, $id);
            if ($stmt->execute()) {
                echo "Registro editado com sucesso!";
                $stmt->close();
                $con->close();
            } else {
                throw new Exception("Erro: " . $con->error);
            }
        } else {
            throw new Exception("Erro: " . $con->error);
        }
    }
    

}