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
            <a class="btnFileForm"><i class="bi bi-image" alt="Adicionar uma imagem"></i></a>
            <a class="btnFileForm"><i  class="bi bi-camera-video" alt="Adicionar um vídeo"></i></a>
            <a class="btnFileForm"><i class="bi bi-emoji-smile"  alt="Adicionar um emoji"></i></a>
          </div>

          <button type="submit" class="btnSubmitForm">Publicar</button>
        </div>        
        </form>
      </div>
<?php foreach($posts as $post=>$value): ?>
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
          <button type='button' class='filepost'><i class='bi bi-heart' alt='curtir'></i></button>
          <button type='button' class='filepost openModal' data-modal='modal1'><i class='bi bi-chat' alt='comentar'></i></button>
          <div class='modal' id='modal1'>
              <div class='modal-content'>
                <span class='close'>&times;</span>
                  <h2>Comentários</h2>
                  <?php foreach($comments as $comment=>$item):?>
                    <h1>Id comentario: <?= $item["com_pos_id"] ?></h1>
                    <h1>Id Post: <?= $value["pos_id"] ?></h1>
                    <?php if($item["com_pos_id"] == $value["pos_id"]) : ?>
                      <h5><?= $item["usu_nome"]; ?></h5>
                      <p><?= $item["com_texto"]; ?></p>  
                    <?php endif; ?>  
                  <?php endforeach; ?>
                  <h5>Ana Júlia</h5>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                  <div class='seu-comentario'>
                    <input type='text' name='nome' placeholder='Digite seu comentário'><button type='submit' class='btnSubmitForm coment'>Enviar</button>
                  </div>     
              </div>
          </div>
          <button type='button' class='filepost'><i class='bi bi-send' alt='compartilhar'></i></button>
          <button type='button' class='filepost'><i class='bi bi-bookmark' alt='salvar'></i></button>
        </div>

        </li>
<?php endforeach; ?>
      </ul>

  </main>
  <script src="../Resources/Assets/js/main.js"></script>
</body>