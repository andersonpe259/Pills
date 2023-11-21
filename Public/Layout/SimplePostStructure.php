<?php foreach($posts as $post=>$value): ?>
    <?php $route = $_GET['route']; ?>
    <li class="search post-item">
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
    <?php if($route == "pesquisa"): ?>
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
    <?php elseif($route == "saves"): ?>
        <form action="Index.php?route=<?= $route ?>" method="POST">
            <button type='submit' class='filepost' name='apagar' value='<?= $value['pos_id'];?>'><i class='bi bi-trash' alt=''></i></button>
        </form>
    <?php endif; ?>
    </li>
<?php endforeach; ?>