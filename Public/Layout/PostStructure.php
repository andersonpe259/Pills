
<!-- Sumário de Variáveis:
- $posts: Array com todos os posts do database.
- $comments: Array com todos os comentários de cada post
- $value['usu_avatar']: Nome da imagem de perfil do Usuário que fez o post
- $value['usu_nome']: Nome do Usuário que fez o post
- $value['pos_data_postagem']: Data de postagem do post
- $value['pos_conteudo']: Conteúdo do post
- $value['pos_id']: id do Post
- $item['usu_nome']: Nome do Usuario que fez o Comentários
- $item['com_texto']: Comentário do Usuario
- $route: Rota Atual -->



 <?php foreach($posts as $post=>$value): ?> <!-- Loop para imprimir todos os Valores dentro da variável $posts -->

  <?php $comments = $postModel->getComment($value['pos_id']); ?>  <!-- Guardando os comentários de cada post em $comments -->
    <?php $route = $_GET['route']; ?>
      <li class='post'>
        <div class='infoUserPost'>
            <div class='imgUserPost'><img src="../Storage/perfil/<?= $value['usu_avatar']; ?>" alt=''></div>
            <div class='nameAndHour'>
                <?php if($route == 'notifications'): ?>
                    <p><strong><?= $value['usu_nome'];?></strong>| Post Compartilhado por <?= $value['sender_name'];?></p>
                <?php else: ?>
                    <strong><?= $value['usu_nome'];?></strong>
                <?php endif; ?>
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
                
                  <form action="Index.php?route=<?= $route ?>" method="POST">
                    <div class='seu-comentario'>
                      <input type='text' name='comentario' placeholder='Digite seu comentário'><button type='submit' class='btnSubmitForm coment' name='idPost' value='<?= $value['pos_id'] ?>'>Enviar</button>
                    </div>
                  </form>     
              </div>
          </div>
          
            <?php if($route == 'principal'): ?>
                <button type='button' class='filepost openModal' data-modal='modalUsers1'><i class='bi bi-send' alt='compartilhar'></i></button>
                    <div class='modal' id='modalUsers1'>
                    <div class='modal-content'>
                        <span class='close'>&times;</span>
                        <h2>Usuários</h2>
                        <form action="Index.php?route=<?= $route ?>" method="POST">
                            <input type="hidden" name="idPost" value="<?= $value['pos_id'] ?>">
                        <?php foreach($users as $user => $item): ?>
                            <button type='submit' class='filepost' name='marcar' value='<?= $item['usu_id'];?>'><h5><?= $item['usu_nome']; ?></h5></button>
                        <?php endforeach; ?>
                        </form>   
                        <form action="Index.php?route=<?= $route ?>" method="POST">
                            <div class='seu-comentario'>
                            <input type='text' name='comentario' placeholder='Digite seu comentário'><button type='submit' class='btnSubmitForm coment' name='idPost' value='<?= $value['pos_id'] ?>'>Enviar</button>
                            </div>
                        </form>     
                    </div>
                    </div>

                <form action="Index.php?route=<?= $route ?>" method="POST">
                    <button type='submit' class='filepost' name='salvar' value='<?= $value['pos_id'];?>'><i class='bi bi-bookmark' alt='salvar'></i></button>
                </form>

            <?php elseif($route == 'notifications'): ?>

                <form action="Index.php?route=<?= $route ?>" method="POST">
                    <button type='submit' class='filepost' name='salvar' value='<?= $value['pos_id'];?>'><i class='bi bi-bookmark' alt='salvar'></i></button>
                </form>
            <?php elseif($route == 'perfil'): ?>
              <form action="Index.php?route=<?= $route ?>" method="POST">
                    <button type='submit' class='filepost' name='apagar' value='<?= $value['pos_id'];?>'><i class='bi bi-trash' alt=''></i></button>
                </form>
            <?php endif; ?>
          </div>

        </li>
<?php endforeach; ?>