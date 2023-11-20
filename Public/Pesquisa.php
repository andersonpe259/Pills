<?php
include(__DIR__.'/Layout/Layout.php');
?>

<main class="main">
  <div class="busca">
    <div class="pesquisa">
      <div class="barra">
        <button><i class=" bx bx-search"></i></button>      
        <input type="text" placeholder="pesquisar">
      </div>
      
      <form method="POST" action="Index.php?route=pesquisa">
        <div class="pesqFiltro d-flex">
          <button class="btnbusca" type="submit" name="filtro" value="0"><span>EM ALTA</span></button>
          <button class="btnbusca" type="submit" name="filtro" value="1"><span>TAGS</span></button>
          <button class="btnbusca" type="submit" name="filtro" value="2"><span>CONTAS</span></button>
      </div>
    </form>
      
      <?php if($showtag):  ?>
      <div class='sugestoes'>
        <ul>
          <form method='post' action='Index.php?route=pesquisa'>
            <?php foreach($tags as $tag => $value): ?>
              <li>
                <button type='submit' class='nav-link scrollto' name='tag' value='<?= $value['has_id']?>'>
                    <i class='bi bi-hash'></i> <span><?= $value['has_hashtag']?></span>
                </button>
              </li>
            <?php endforeach; ?>
          </form>
        </ul>
      </div>
      <?php endif; ?>
  </div>  
 
  <ul class="recomendacoes">
  <?php foreach($posts as $post=>$value): ?>
      <li class="search">
        <div class="infoUserPost">
          <div class="imgUserPost"><img src="../Storage/perfil/<?= $value['usu_avatar']; ?>" alt=''></div>
            <div class="nameAndHour">
              <strong><?= $value["usu_nome"] ?></strong>
              <p><?= $value["pos_data_postagem"]?></p>
            </div>
        </div>
      
        <p>
          <?= $value["pos_conteudo"]?>
        </p>

        <?php 
        $hashs = array();
        if($value["hashtags"] != null){
          $hashs = explode(",",$value["hashtags"]);
          $has_ids = explode(",", $value["has_ids"]);
        }
        ?>
        
       <form method='post' action='Index.php?route=pesquisa'>
          <?php $indice = 0; ?>
          <?php foreach($hashs as $has): ?>
            <button type='submit' class='nav-link scrollto' name='tag' value='<?= $has_ids[$indice] ?>'><a class="hashtags"> <span><?= $has ?></span></a></button>
            <?php $indice++; ?>
          <?php endforeach; ?>
       </form>

      </li>
    <?php endforeach; ?>

  </ul>

  </main>
</body>
