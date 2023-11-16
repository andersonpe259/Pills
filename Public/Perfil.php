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
            <button type="button" class="filepost openModal editar" data-modal="modal0">Editar perfil</button>
            <div class="modal" id="modal0">
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

    <?php foreach($usersPosts as $post=>$value): ?>
  <?php $comments = $postModel->getComment($value['pos_id']); ?>
      <li class='post'>
                <div class='infoUserPost'>
                    <div class='imgUserPost'><img src="../Storage/perfil/<?= $value['usu_avatar']; ?>" alt=''></div>
                    <div class='nameAndHour'>
                        <strong><?= $value['usu_nome'];?></strong>
                        <p><?= $value['pos_data_postagem']; ?></p>
                    </div>
                </div>
                <p>
                <?= $value['pos_conteudo']; ?>
                </p>
        
                <div class='actionBtnPost'>
          
          <button type='button' class='filepost openModal' data-modal='modal<?= $value['pos_id'] ?>'><i class='bi bi-chat' alt='comentar'></i></button>
          
          <div class='modal' id='modal<?= $value['pos_id'] ?>'>
              <div class='modal-content'>
                <span class='close'>&times;</span>
                  <h2>Comentários</h2>
                
                  <?php if($comments != null): ?>
                  <?php foreach($comments as $comment => $item): ?>
                    <h5><?= $item['usu_nome']; ?></h5>
                    <p><?= $item['com_texto']; ?></p>  
                  <?php endforeach; ?>
                <?php else: ?>
                  <h5>Tenha coragem e faça o primeiro comentário do Post</h5>
                <?php endif; ?>

                  
                  <form action="Index.php?route=perfil" method="POST">
                    <div class='seu-comentario'>
                      <input type='text' name='comentario' placeholder='Digite seu comentário'><button type='submit' class='btnSubmitForm coment' name='idPost' value='<?= $value['pos_id'] ?>'>Enviar</button>
                    </div>
                  </form>
                       
              </div>
                  </div>
          </div>

        </li>
<?php endforeach; ?>

  </ul>
  </main>
  <script src="../Resources/Assets/js/main.js"></script>
</body>