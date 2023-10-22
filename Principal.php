<?php
require 'Controllers/PostController.php';
require 'Controllers/PageController.php';

$controlador = new PostController();
$paginaControlador = new PageController();

session_start();

$usuario = $_SESSION["user_name"];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenha os dados do formulário
    $text = $_POST["textarea"];
    $comment = $_POST["comment"];
    $idPost = $_POST["idPost"];

    if($text != null){
        $controlador->userPost($text);
    }
    if($comment != null){
        $controlador->commentPost($idPost, $comment);
    }
}
include('Controllers/foundation/Layout.php');
?>
  <main class="main">
      <!-- Queria dar um espaçamento nos itens dentro da ul, pois não está similar com o campo acima (os itens estão grudados na paredinha da ul, pode ser que criando uma div e colocando todas as ul's dê certo)-->
      <ul class="posts">
      <li class="newPost">
        <div class="infoUser">
          <div class="imgUser"> </div>
          <strong> <?php echo $usuario ?> </strong>
        </div>

        <form class="formPost" id="formPost" action="Principal.php" method="POST">
          <textarea name="textarea" placeholder="O que você está pensando?"> </textarea>
        
        <div class="iconsAndButton">
          <div class="icons">
            <a class="btnFileForm"><i class="bi bi-image" alt="Adicionar uma imagem"></i></a>
            <a class="btnFileForm"><i  class="bi bi-camera-video" alt="Adicionar um vídeo"></i></a>
            <a class="btnFileForm"><i class="bi bi-emoji-smile"  alt="Adicionar um emoji"></i></a>
          </div>

          <button type="submit" class="btnSubmitForm">Publicar</button>
        </div>        
        </form>
      </div>
      <?php $controlador->viewPost() ?>
      </ul>

  </main>
</body>