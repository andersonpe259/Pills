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
        <p>Sem notificações no momento</p>
        <img src="/Resources/Assets/img/triste.png" style="height: 150px;">
      <?php endif; ?>
    </ul>
</main>
<script src="../Resources/Assets/js/main.js"></script>
</body>