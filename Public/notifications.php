<?php include(__DIR__.'/Layout/Layout.php'); ?>
<main class="main">
    <div class="headerNot">
        <strong>Notificações</strong>
    </div>

    <ul class="posts">
      <?php if($posts != null): ?>
<?php foreach($posts as $post=>$value): ?>
  <?php $comments = $postModel->getComment($value['pos_id']); ?>
      <li class='post'>
                <div class='infoUserPost'>
                    <div class='imgUserPost'><img src="../Storage/perfil/<?= $value['post_avatar']; ?>" alt=''></div>
                    <div class='nameAndHour'>
                        <strong><?= $value['criador_post'];?></strong> <p>Compartilhado por <?= $value['sender_name']; ?></p>
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

                  
                  <form action="Index.php?route=notifications" method="POST">
                    <div class='seu-comentario'>
                      <input type='text' name='comentario' placeholder='Digite seu comentário'><button type='submit' class='btnSubmitForm coment' name='idPost' value='<?= $value['pos_id'] ?>'>Enviar</button>
                    </div>
                  </form>
                       
              </div>
          </div>

          
          <form action="Index.php?route=notifications" method="POST">
            <button type='submit' class='filepost' name='salvar' value='<?= $value['pos_id'];?>'><i class='bi bi-bookmark' alt='salvar'></i></button>
          </form>
          </div>

        </li>
<?php endforeach; ?>
<?php else: ?>
  <h1>Sem notificações no momento...</h1>
<?php endif; ?>
      </ul>


</main>
<script src="../Resources/Assets/js/main.js"></script>
</body>