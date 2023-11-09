<?php
require (__DIR__."/../App/Controllers/PostController.php");


$controlador = new PostController();


if($_SERVER["REQUEST_METHOD"] === "GET") {
    $_SESSION["search"] = "";
    $_SESSION["filtro"] = 1;
    $_SESSION["tag"] = 0;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenha os dados do formulário
    $_SESSION["search"] = $_POST["search"];
    $comment = $_POST["comment"];
    $idPost = $_POST["idPost"];
    if($_POST["filtro"] != null){
        $_SESSION["filtro"] = $_POST["filtro"];
    }
    if($_POST["tag"] != null){
        $_SESSION["tag"] = $_POST["tag"];
    }
    

    if($comment != null){
        //$controlador->commentPost($idPost, $comment);
    }
}
include(__DIR__.'/Layout/Layout.php');
?>

<main id="main">
<div class="busca">
    <div class="pesquisa">
      <div class="barra">
        <form action="Pesquisa.php" method="post">
          <button><i class=" bx bx-search"></i></button>      
          <input type="text" name="search" id="post" placeholder="pesquisar">
        </form>
      </div>
      <div class="pesqFiltro d-flex">
        <form method="post" action="Pesquisa.php">
          <button class="btnbusca" type="submit" name="filtro" value="1"><span>EM ALTA</span></button>
          <button class="btnbusca" type="submit" name="filtro" value="2"><span>TAGS</span></button>
          <button class="btnbusca" type="submit" name="filtro" value="3"><span>CONTAS</span></button>
        </form>
      </div>
  
  </div>  

  <ul class="posts">
<?php

    if($_SESSION["filtro"] == 1){
        $controlador->viewPost($_SESSION["filtro"]);
    }
    elseif($_SESSION["filtro"] == 2){

      echo "<div class='sugestoes'>
              <ul>
                <form method='post' action='Pesquisa.php'>";
                  $controlador->tagPost();
      echo "    </form>
              </ul>
            </div>";

      $controlador->viewPost($_SESSION["filtro"], $_SESSION["tag"]);
    }

?>
  </ul>

  </div>
</main>
<script src="../Resources/Assets/js/main.js"></script>
</body>