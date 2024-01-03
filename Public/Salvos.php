<?php include(__DIR__.'/Layout/Layout.php'); ?>

  <main class="main" id="salvos">
    <div class="headersaves">
        <strong>Salvos</strong>
    </div>
    <div class="postsalvos">    
        <?php if($posts != null): ?>
        <ul id="listaRecomendacoes">
          <?php include(__DIR__."/Layout/SimplePostStructure.php"); ?>        
        <?php else: ?>
          <h6>Sem posts salvos no momento</h6>
        <?php endif; ?>   
      </ul>
    </div>
  </main> 
</body>