<?php
// require (__DIR__."/../App/Controllers/UserController.php");

// $controlador = new UserController();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/pills.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="../Resources/Assets/css/style.css" rel="stylesheet">
    <title>Pills - Registro</title>
</head>
<body>
<main>
<main>
    <center><img src="../Resources/Assets/img/pills.jpg" id="main"></center>
    <form action="Index.php?route=registro" method="post" onsubmit="return validarFormulario()">
        <h1 class="title">Criar conta no Pills</h1>
        <p>Já possui conta? <a href="../Index.php">Faça login</a></p>
        <div class="mb-3">
            <label class="form-label">NOME</label>
            <center><input type="text" name="nome" id="nome" class="form-control" oninput="habilitarBotao()"></center>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">EMAIL</label>
            <center><input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" oninput="habilitarBotao()"></center>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">SENHA</label>
            <center><input type="password" class="form-control" name="password" id="pass" oninput="validarSenha(); habilitarBotao()"></center>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">CONFIRMAR SENHA</label>
            <center><input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" oninput="validarSenha(); habilitarBotao()"></center>
            <p id="mensagemSenha" style="color: red;"></p>
        </div>
        <center><button type="submit" class="btn btn-primary" id="btnRegistrar" disabled><a href="" class="principal">Registrar</a></button></center>
    </form>
</main>
<script>
    function validarSenha() {
        var senha = document.getElementById('pass').value;
        var confirmarSenha = document.getElementById('confirmarSenha').value;
        var mensagemSenha = document.getElementById('mensagemSenha');

        if (senha !== confirmarSenha) {
            mensagemSenha.textContent = "As senhas não coincidem. Por favor, digite novamente.";
        } else {
            mensagemSenha.textContent = "";
        }
    }

    function habilitarBotao() {
        var nome = document.getElementById('nome').value;
        var email = document.getElementById('email').value;
        var senha = document.getElementById('pass').value;
        var confirmarSenha = document.getElementById('confirmarSenha').value;
        var btnRegistrar = document.getElementById('btnRegistrar');

        if (nome && email && senha && confirmarSenha && senha === confirmarSenha) {
            btnRegistrar.disabled = false;
        } else {
            btnRegistrar.disabled = true;
        }
    }

    function validarFormulario() {
        // Adicione aqui qualquer lógica adicional de validação se necessário
        return true; // Permite o envio do formulário se as senhas coincidirem
    }
</script>


    
    <?php
            // if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //     // Obtenha os dados do formulário
            //     $nome = $_POST["nome"];
            //     $email = $_POST["email"];
            //     $senha = $_POST["password"];

            //     if($nome != null and $email != null and $senha != null){
            //         $controlador->userRegister($nome, $email, $senha);
            //     }
            // }
            
            
        ?>
</body>
</html>