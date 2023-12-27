
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
                    <p id="data"><strong><?= $value['usu_nome'];?></strong>| Post Compartilhado por <?= $value['sender_name'];?></p>
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
                <strong id='coment'>Comentários</strong>
                <?php if($comments != null): ?>
                <div class="conteudo_comment">
                  <?php foreach($comments as $comment => $item): ?>
                    <div class="infoUserPost">
                      <div class="imgUserPost">
                        <img src="../Storage/perfil/<?= $item['usu_avatar']; ?>" alt=''>                        
                      </div>
                      <strong><?= $item['usu_nome']; ?></strong>
                      <p id="comentario"><?= $item['com_texto']; ?></p>    
                    </div>       
                  <?php endforeach; ?>
                </div>
                  <?php else: ?>
                    <div>
                    <p>Faça o primeiro comentário do post</p>
                    </div>                    
                  <?php endif; ?>
                
                  <form class="formCom" action="Index.php?route=<?= $route ?>" method="POST">
                    <div class='seu-comentario'>
                      <textarea name='comentario' placeholder='Digite seu comentário'></textarea><button id="envio" type='submit' class='btnSubmitForm coment' name='idPost' value='<?= $value['pos_id'] ?>'>Enviar</button>
                    </div>
                  </form>     
              </div>
          </div>
          
            <?php if($route == 'principal'): ?>
                <button type='button' class='filepost openModal' data-modal='modalC<?= $value['pos_id'] ?>'><i class='bi bi-send' alt='compartilhar'></i></button>
                    <div class='modal' id='modalC<?= $value['pos_id'] ?>'>
                    <div class='modal-content'>
                        <span class='close'>&times;</span>
                        <strong id='coment'>Usuários</strong>
                        <form action="Index.php?route=<?= $route ?>" method="POST">
                            <div class='seu-comentario' id="buscaUsu">
                            <i class="bi bi-search" style="color: #FCDA4D; padding: 10px"></i><input type='text' name='comentario' placeholder='Pesquise o usuário' id="filtroInput">
                            </div>
                        </form>
                        
                        <form action="Index.php?route=<?= $route ?>" method="POST">
                            <input type="hidden" name="idPost" value="<?= $value['pos_id'] ?>">
                            <ul id="listaRecomendacoes">
                              <?php foreach($users as $user => $item): ?>
                                <li class="post-item">
                                <div class="infoUserPost">
                                <div class="imgUserPost">
                                  <img src="../Storage/perfil/<?= $item['usu_avatar']; ?>" alt=''>                        
                                </div>
                                  <button id="usuario" type='submit' class='filepost' name='marcar' value='<?= $item['usu_id'];?>'><strong><?= $item['usu_nome']; ?></strong></button>
                              </div>   
                                </li> 
                              <?php endforeach; ?>
                            </ul>
                        
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
                <form action="Index.php?route=<?= $route ?>" method="POST">
                    <button type='submit' class='filepost' name='apagar' value='<?= $value['pos_id'];?>'><i class='bi bi-eye' alt='salvar'></i></button>
                </form>
            <?php elseif($route == 'perfil'): ?>
              <form action="Index.php?route=<?= $route ?>" method="POST">
                    <button type='submit' class='filepost' name='apagar' value='<?= $value['pos_id'];?>'><i class='bi bi-trash' alt=''></i></button>
                </form>
            <?php endif; ?>
          </div>

        </li>
<?php endforeach; ?>