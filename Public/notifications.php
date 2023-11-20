<?php 
include(__DIR__.'/Layout/Layout.php');
?>

<main class="main">
    <div class="headerNot">
        <strong>Notificações</strong>
    </div>

    <ul class="posts">
      <?php if($posts != null): ?>

        <?php include (__DIR__."/Layout/PostStructure.php"); ?>

      <?php else: ?>

        <h1>Sem notificações no momento...</h1>

      <?php endif; ?>
    </ul>

</main>
<script src="../Resources/Assets/js/main.js"></script>
</body>