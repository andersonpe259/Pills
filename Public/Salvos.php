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
          <p>Sem posts salvos no momento</p>
          <img src="/Resources/Assets/img/triste.png" style="height: 150px;">
        <?php endif; ?>   
    </div>
  </main> 
</body>