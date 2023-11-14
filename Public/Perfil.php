<?php

include(__DIR__.'/Layout/Layout.php');

?>

<main class="main">

    <div class="informacoes">
      <div class="fundo"> 
        <img src="../../Storage/fundo/<?= $user['imgPerfil']; ?>">
      </div>
      
      <div class="imgperfil">
      <img src="../../Storage/perfil/<?= $user['avatar']; ?>">  
      <div class="actionBtnPost editar">
            <button type="button" class="filepost openModal editar" data-modal="modal1">Editar perfil</button>
            <div class="modal" id="modal1">
                <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" enctype="multipart/form-data" action="Index.php?route=perfil"> 
                  <label for="conteudo">Alterar Perfil:</label>
                  <input type="file" name="perfil" accept="image/*">    
                    <button type="submit">Enviar imagem</button>
                </form>
                <form method="POST" enctype="multipart/form-data" action="Index.php?route=perfil"> 
                  <label for="conteudo">Alterar Imagem de Fundo:</label>
                  <input type="file" name="fundo" accept="image/*">    
                    <button type="submit">Enviar imagem</button>
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