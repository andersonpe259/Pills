<?php include(__DIR__.'/Layout/Layout.php'); ?>

  <main class="main">

    <div class="headerNot">
      <strong>Salvos</strong>
  </div>

    <div class="postsalvos">
      <ul class="recomendacoes">
        <?php if($posts != null): ?>
          <?php foreach($posts as $post=> $value): ?>
            <li class="search">
              <div class="infoUserPost">
                <div class="imgUserPost"></div>
                  <div class="nameAndHour">
                    <strong><?= $value['usu_nome'] ?></strong>
                    <p>21h</p>
                  </div>
              </div>

              <p>
                <?= $value['pos_conteudo'] ?>
              </p>
              <a class="hashtags"><span>#Poema</span></a>
              <a class="hashtags"><span>#recuperaçãodaadolescencia</span></a>
              <a class="hashtags"><span>@CristinaCésar</span></a>

            <button class=""><i class="bx bx-bookmark"></i></button>

            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <h1>Não há nenhum post salvo, ainda...</h1>
        <?php endif; ?>
        
      </ul>
    </div>
  </main> 
</body>