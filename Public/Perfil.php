<?php
// require (__DIR__."/../App/Controllers/PostController.php");
// require (__DIR__."/../App/Controllers/UserController.php");

// $userEdit = new UserController();

// function verificarEIniciarSessao() {
//     if (session_status() == PHP_SESSION_NONE) {
//         session_start();
//     }
// }

// verificarEIniciarSessao();

// $controlador = new PostController();
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
//         $nome_temporario = $_FILES["imagem"]["tmp_name"];
//         $nome_arquivo = basename($_FILES["imagem"]["name"]);
        
//         // Verifique se o arquivo é uma imagem
//         $extensoes_permitidas = array("jpg", "jpeg", "png", "gif");
//         $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
//         if (in_array($extensao, $extensoes_permitidas)) {
//             // Diretório de destino para salvar a imagem
//             $diretorio_destino = "../Resources/Assets/img/perfil/";
            
//             // Renomeie o arquivo para evitar conflitos de nome
//             $imgSave = $_SESSION['user_id'] . "." . $extensao;
//             $caminho_destino = $diretorio_destino . $imgSave;

            
//             if (move_uploaded_file($nome_temporario, $caminho_destino)) {
//                 echo "A imagem foi carregada com sucesso.";
//                 $userEdit->editarAvatar($_SESSION['user_id'], $imgSave);
//                 $_SESSION['avatar'] = $caminho_destino;
//             } else {
//                 echo "Erro ao carregar a imagem.";
//             }
//         } else {
//             echo "Apenas arquivos de imagem (jpg, jpeg, png, gif) são permitidos.";
//         }
//     } else {
//         echo "Erro ao processar o upload da imagem.";
//     }
// }

include(__DIR__.'/Layout/Layout.php');

?>
    <!-- <main class="main">

    <div class="informacoes">
      <div class="fundo"> 
        <img src="../Storage/fundo/generico01.svg">
      </div>
      
      <div class="imgperfil ">
      <?php// echo '<img src="../Storage/perfil/'.$_SESSION['avatar'].'" alt="">' ?>
      <div class="editar">
        <button>Editar perfil</button>
      </div>
      </div>

      

      <div class="dados"> 
        <h3> <?php// echo $_SESSION['user_name']?> </h3>
        <a class="arroba"><span>@Usuario</span></a>
      </div>

      <div class="infoseguidores">
        <p><h5>753</h5>Seguindo</p>
        <p><h5>127K</h5>Seguidores</p>
      </div>

    </div>
    <ul class="posts">
            <?php //$controlador->viewPost() ?>
    </ul>
</div>
</main>


</body> -->
<main class="main">

    <div class="informacoes">
      <div class="fundo"> 
        <img src="../../Storage/fundo/<?= $user['imgPerfil']; ?>">
      </div>
      
      <div class="imgperfil">
      <img src="../../Storage/perfil/<?= $user['avatar']; ?>">  
      <div class="editar">
        <button>Editar perfil</button>
      </div>
      </div>

      

      <div class="dados"> 
        <h3> <?= $user['nome']; ?> </h3>
        <a class="arroba"><span><?= $user['email']; ?></span></a>
      </div>


    </div>

    <ul class="posts">

    <?php foreach($usersPosts as $post => $value):?>
      <li class="post">
        <div class="infoUserPost">
            <div class="nameAndHour">
              <p><?= $value['pos_data_postagem']; ?></p>
            </div>
        </div>

        <p>
          <?= $value['pos_conteudo']; ?>
      </p>

        <div class="actionBtnPost">
          <button type="button" class="filepost openModal" data-modal="modal1"><i class="bi bi-chat" alt="comentar"></i></button>
          <div class="modal" id="modal1">
              <div class="modal-content">
                <span class="close">&times;</span>
                  <h2>Comentários</h2>
                  <h5>Wallison</h5>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                  <h5>Anderson</h5>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                  <div class="seu-comentario">
                    <input type="text" name="nome" placeholder="Digite seu comentário"><button type="submit" class="btnSubmitForm">Enviar</button>
                  </div>     
              </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>

  </ul>
  </main>
  <script src="../Resources/Assets/js/main.js"></script>
</body>