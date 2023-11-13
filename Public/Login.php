<?php
// require (__DIR__."/App/Controllers/UserController.php");

//   $controlador = new UserController();

//   if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     // Obtenha os dados do formulário
//     $email = $_POST["email"];
//     $password = $_POST["password"];

//     if($email != null and $password != null){
//         $controlador->userLogin($email, $password);
//     }
// }

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/pills.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="Resources/Assets/css/style.css" rel="stylesheet">
    <title>Pills - Login</title>
</head>
<body>
    <main >
      <center><img src="Resources/Assets/img/pills.jpg" id= "main"></center>
        <form action="Index.php?route=login" method="post">
        <h1 class="title">Login</h1>
          <p>Não possui conta? <a href="Index.php?route=registro">Crie agora</a></p>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">EMAIL</label>
              <center><input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"></center>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">SENHA</label>
            <center><input type="password" class="form-control" name="password" id="pass"></center>
            </div>
            <center><button type="submit" class="btn btn-primary"><a href="" class="principal">Logar</a></button></center>
            <p><a href="senha.html">Esqueceu sua senha?</a></p>
          </form>
    </main>    
  </body>
</html>
