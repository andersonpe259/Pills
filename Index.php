<?php

require_once (__DIR__."/App/Controllers/UserController.php");
require_once (__DIR__."/App/Controllers/PostController.php");
require_once (__DIR__."/App/Controllers/SearchController.php");
require_once (__DIR__."/Config/PathOrganizer.php");
$pathOrganizer = new PathOrganizer();
$postController = new PostController();
$userController = new UserController();
$searchController = new SearchController();

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':  
      //GET POST
      $pathOrganizer->path($userController->showLogin(), $userController->processLogin());
      break;

    case 'registro':
      $pathOrganizer->path($userController->showRegister(), $userController->processRegister());
      break;

    case 'principal':
      $pathOrganizer->path($postController->viewPost(), $searchController->processRequest());
      break;

    case 'pesquisa':
      $pathOrganizer->path($searchController->viewPost(), $postController->processPost());
      break;

    case 'perfil':  
      $pathOrganizer->path($userController->showPerfil(), $userController->processPerfil());
        

}
?>