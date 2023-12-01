<?php include(__DIR__.'/Layout/Layout.php'); ?>

  <main class="main" id="salvos">

    <div class="headersaves">
      <strong>Salvos</strong>
  </div>

    <div class="postsalvos">
      <ul class="recomendacoes">
        <?php if($posts != null): ?>
          <?php include(__DIR__."/Layout/SimplePostStructure.php"); ?>
        <?php else: ?>
          <h1>Não há nenhum post salvo, ainda...</h1>
        <?php endif; ?>
        
      </ul>
    </div>
  </main> 
</body>