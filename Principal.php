<?php
require 'Controllers/PostController.php';
require 'Controllers/PageController.php';

$controlador = new PostController();
$paginaControlador = new PageController();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/css/Style.css">
    <title>Página Principal</title>
</head>
<body>
    <form action="Principal.php" method="post">
        <input type="text" name="post" id="post">
        <button><i class="finish_button"><img src="assets/img/button_go.png" alt="Concluir"></i></button>
    </form>
    <?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtenha os dados do formulário
        $text = $_POST["post"];
        $comment = $_POST["comment"];
        $idPost = $_POST["idPost"];

        if($text != null){
            $controlador->userPost($text);
        }
        if($comment != null){
            $controlador->commentPost($idPost, $comment);
        }
    }
    ?>

    <h1>Tela de Comentários</h1>

    <?php
    $controlador->viewPost();
    $paginaControlador->pages_bar();
    ?>



</body>
</html>