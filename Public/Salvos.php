<?php include(__DIR__.'/Layout/Layout.php'); ?>

  <main class="main" id="salvos">

    <div class="headersaves">
      <strong>Salvos</strong>
  </div>

    <div class="postsalvos">    
        <?php if($posts != null): ?>
        <ul id="listaRecomendacoes">
          <?php include(__DIR__."/Layout/SimplePostStructure.php"); ?>
        </ul>
        <?php else: ?>
          <h1>Não há nenhum post salvo, ainda...</h1>
        <?php endif; ?>   
    </div>
  </main> 
</body>