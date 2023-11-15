<?php

include(__DIR__.'/Layout/Layout.php');
?>
  <main class="main">
      <!-- Queria dar um espaçamento nos itens dentro da ul, pois não está similar com o campo acima (os itens estão grudados na paredinha da ul, pode ser que criando uma div e colocando todas as ul's dê certo)-->
      <ul class="posts">
      <li class="newPost">
        <div class="infoUser">
          <div class="imgUser"><img src="<?php echo "../Storage/perfil/".$_SESSION["avatar"] ?>" alt=""></div>
          <strong> <?= $_SESSION["user_name"] ?> </strong>
        </div>

        <form class="formPost" id="formPost" action="Index.php?route=principal" method="POST">
          <textarea name="textarea" placeholder="O que você está pensando?"> </textarea>
        
        <div class="iconsAndButton">
          <div class="icons">
            <a class="btnFileForm"><i class="bi bi-emoji-smile"  alt="Adicionar um emoji"></i></a>
          </div>

          <button type="submit" class="btnSubmitForm">Publicar</button>
        </div>        
        </form>
      </div>
<?php foreach($posts as $post=>$value): ?>
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
                
                  <?php foreach($comments as $comment => $item): ?>
                    <h5><?= $item['usu_nome']; ?></h5>
                    <p><?= $item['com_texto']; ?></p>  
                  <?php endforeach; ?>

                  
                  <form action="Index.php?route=principal" method="POST">
                    <div class='seu-comentario'>
                      <input type='text' name='comentario' placeholder='Digite seu comentário'><button type='submit' class='btnSubmitForm coment' name='idPost' value='<?= $value['pos_id'] ?>'>Enviar</button>
                    </div>
                  </form>
                       
              </div>
          </div>

          <button type='button' class='filepost'><i class='bi bi-send' alt='compartilhar'></i></button>
          <form action="Index.php?route=principal" method="POST">
            <button type='submit' class='filepost' name='salvar' value='<?= $value['pos_id'];?>'><i class='bi bi-bookmark' alt='salvar'></i></button>
          </form>
          </div>

        </li>
<?php endforeach; ?>
      </ul>

  </main>
  <script src="../Resources/Assets/js/main.js"></script>
</body>