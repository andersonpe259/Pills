<?php
include(__DIR__.'/Layout/Layout.php');
?>

<main class="main" id="perfil">

    <div class="informacoes">
      <div class="fundo"> 
        <img src="../../Storage/fundo/<?= $user['imgPerfil']; ?>">
      </div>
      
      <div class="imgperfil">
      <img src="../../Storage/perfil/<?= $user['avatar']; ?>">  
      <div class="actionBtnPost editar">
            <button type="button" class="filepost openModal editar" data-modal="modal0">Editar perfil</button>
            <div class="modal" id="modal0">
                <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" enctype="multipart/form-data" action="Index.php?route=perfil"> 
                  <label for="conteudo">Alterar Perfil:</label>
                  <input type="file" name="perfil" accept="image/*">    
                    <button type="submit">Enviar imagem de perfil</button>
                </form>
                <form method="POST" enctype="multipart/form-data" action="Index.php?route=perfil"> 
                  <label for="conteudo">Alterar Imagem de Fundo:</label>
                  <input type="file" name="fundo" accept="image/*">    
                    <button type="submit">Enviar imagem de fundo</button>
                </form>
                </div>
            </div>
        </div>
      </div>

      

      <div class="dados"> 
        <h3> <?= $user['nome']; ?> </h3>
        <a class="arroba"><span><?= $user['email']; ?></span></a>
      </div>


    </div>

    <ul class="posts">

      <?php include (__DIR__."/Layout/PostStructure.php"); ?>

    </ul>
  </main>
  <script src="../Resources/Assets/js/main.js"></script>
</body>