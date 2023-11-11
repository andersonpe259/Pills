<?php
require (__DIR__."/../App/Controllers/PostController.php");
require (__DIR__."/../App/Controllers/UserController.php");

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
            $diretorio_destino = "../Resources/Assets/img/perfil/";
            
            // Renomeie o arquivo para evitar conflitos de nome
            $imgSave = $_SESSION['user_id'] . "." . $extensao;
            $caminho_destino = $diretorio_destino . $imgSave;

            
            if (move_uploaded_file($nome_temporario, $caminho_destino)) {
                echo "A imagem foi carregada com sucesso.";
                $userEdit->editarAvatar($_SESSION['user_id'], $imgSave);
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

include(__DIR__.'/Layout/Layout.php');

?>
    <main class="main">

    <div class="informacoes">
      <div class="fundo"> 
        <img src="../Storage/fundo/generico01.svg">
      </div>
      
      <div class="imgperfil ">
      <?php echo '<img src="../Storage/perfil/'.$_SESSION['avatar'].'" alt="">' ?>
      <div class="editar">
        <button>Editar perfil</button>
      </div>
      </div>

      

      <div class="dados"> 
        <h3> <?php echo $_SESSION['user_name']?> </h3>
        <a class="arroba"><span>@Usuario</span></a>
      </div>

      <div class="infoseguidores">
        <p><h5>753</h5>Seguindo</p>
        <p><h5>127K</h5>Seguidores</p>
      </div>

    </div>
    <ul class="posts">
            <?php $controlador->viewPost() ?>
    </ul>
</div>
</main>


</body>
