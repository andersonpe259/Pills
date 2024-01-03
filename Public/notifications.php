<?php 
include(__DIR__.'/Layout/Layout.php');
?>

<main class="main" id="not">
    <div class="headerNot">
        <strong class="notificacoes">Notificações</strong>
    </div>
    <ul class="posts">
      <?php if($posts != null): ?>
        <?php include (__DIR__."/Layout/PostStructure.php"); ?>
      <?php else: ?>
        <h6>Sem notificações no momento</h6>
      <?php endif; ?>
    </ul>
</main>
<script src="../Resources/Assets/js/main.js"></script>
</body>