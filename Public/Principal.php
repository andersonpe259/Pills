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
        <?php include(__DIR__."/Layout/PostStructure.php"); ?>
      </ul>

  </main>
  <script src="../Resources/Assets/js/main.js"></script>
</body>