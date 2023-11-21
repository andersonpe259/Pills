<?php

require_once (__DIR__."/App/Controllers/UserController.php");
require_once (__DIR__."/App/Controllers/PostController.php");
require_once (__DIR__."/App/Controllers/SearchController.php");
require_once (__DIR__."/App/Controllers/NotificationController.php");

error_reporting(0);
ini_set('display_errors', 0);

$postController = new PostController();
$userController = new UserController();
$searchController = new SearchController();
$notiController = new NotificationController();

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $userController->processPerfil();
        } else{
          $userController->showPerfil();
        }
        break;
      case 'saves':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $postController->processDeleteSave();
        } else{
          $postController->viewSave();
        }
        break;
      case 'notifications':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $notiController->processRequest();
        } else{
          $notiController->viewPost();
        }
        break;
        
}
?>