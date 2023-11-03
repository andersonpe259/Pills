<?php
require 'Controllers/PostController.php';
require 'Controllers/UserController.php';

$userEdit = new UserController();

function verificarEIniciarSessao() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

verificarEIniciarSessao();

$controlador = new PostController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
        $nome_temporario = $_FILES["imagem"]["tmp_name"];
        $nome_arquivo = basename($_FILES["imagem"]["name"]);
        
        // Verifique se o arquivo é uma imagem
        $extensoes_permitidas = array("jpg", "jpeg", "png", "gif");
        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
        if (in_array($extensao, $extensoes_permitidas)) {
            // Diretório de destino para salvar a imagem
            $diretorio_destino = "./Assets/img/perfil/";
            
            // Renomeie o arquivo para evitar conflitos de nome
            $caminho_destino = $diretorio_destino . $_SESSION['user_id'] . "." . $extensao;
            
            if (move_uploaded_file($nome_temporario, $caminho_destino)) {
                echo "A imagem foi carregada com sucesso.";
                $userEdit->editarAvatar($_SESSION['user_id'], $caminho_destino);
                $_SESSION['avatar'] = $caminho_destino;
            } else {
                echo "Erro ao carregar a imagem.";
            }
        } else {
            echo "Apenas arquivos de imagem (jpg, jpeg, png, gif) são permitidos.";
        }
    } else {
        echo "Erro ao processar o upload da imagem.";
    }
}

include('Controllers/foundation/Layout.php');

?>
<div class="perfil_div">
    <div class="img_fundo">
        <img src="./Assets/img/perfil/generico01.svg" alt="">
    </div>

    <form action="Perfil.php" method="post" enctype="multipart/form-data">
        Selecione uma imagem de perfil:
        <input type="file" name="imagem" accept="image/*">
        <input type="submit" value="Enviar Imagem">
    </form>

    <div class="avatar">
        <?php echo '<img src="'.$_SESSION['avatar'].'" alt="">' ?>
        
    </div>
    <div class="info_pessoal">
        <h2><?php echo $_SESSION['user_name']?></h2>
        <h4>@Usuario</h4>

        <p><span></span> Seguindo             <span></span> Seguidores</p>

        
    </div>
    <ul class="posts">
            <?php $controlador->viewPost() ?>
    </ul>
</div>

