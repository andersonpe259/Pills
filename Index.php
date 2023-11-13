<?php

require_once (__DIR__."/App/Controllers/UserController.php");
require_once (__DIR__."/App/Controllers/PostController.php");
require_once (__DIR__."/App/Controllers/SearchController.php");

$postController = new PostController();
$userController = new UserController();
$searchController = new SearchController();

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':  
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController->processLogin();
      } else {
        $userController->showLogin();
      }
      break;

    case 'registro':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController->processRegister();
      } else {
        $userController->showRegister();
      }
      break;

    case 'principal':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postController->processPost();
      } else {
        $postController->viewPost();
      }
      
      break;
      case 'pesquisa':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $searchController->processRequest();
        } else {
          $searchController->viewPost();
        }
        
        break;
      case 'perfil':
        $userController->showPerfil();


    // case 'usuario':
    //     $userController = new UserController();
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $userController->processForm();
    //     } else {
    //         $userController->showUsuario();
    //     }
    //     break;
    // default:
    //     echo "Rota inválida";
    //     break;
}
?>