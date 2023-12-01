<?php include(__DIR__.'/Layout/Layout.php'); ?>

<main class="main">
  <div class="busca">
    <div class="pesquisa">
      <div class="barra">
        <button><i class=" bx bx-search"></i></button>      
        <input type="text" id="filtroInput" placeholder="pesquisar">
      </div>
     
      <form method="POST" action="Index.php?route=pesquisa">
        <div class="pesqFiltro d-flex">
          <button class="btnbusca" type="submit" name="filtro" value="0"><span>EM ALTA</span></button>
          <button class="btnbusca" type="submit" name="filtro" value="1"><span>TAGS</span></button>
        </div>
      </form>

      <?php if($showtag): ?>
        <div class='sugestoes'>
          <ul>
            <form method='post' action='Index.php?route=pesquisa'>
              <?php foreach($tags as $tag => $value): ?>
                <li>
                  <button type='submit' class='nav-link scrollto' name='tag' value='<?= $value['has_id']?>'>
                    <span style="color:#FCDA4D"><?= $value['has_hashtag']?></span>
                  </button>
                </li>
              <?php endforeach; ?>
            </form>
          </ul>
        </div>
      <?php endif; ?>
    </div>
    
    

    
    <ul id="listaRecomendacoes">
      <?php include(__DIR__."/Layout/SimplePostStructure.php"); ?>
    </ul>
  </div>
</main>

<script>
  function filtrarLista() {
    var filtro = document.getElementById('filtroInput').value.toLowerCase();


    var listaRecomendacoes = document.getElementById('listaRecomendacoes').getElementsByTagName('li');

    for (var i = 0; i < listaRecomendacoes.length; i++) {
      var conteudoItem = listaRecomendacoes[i].textContent.toLowerCase();
      
      if (conteudoItem.includes(filtro)) {
        listaRecomendacoes[i].classList.remove('hidden');
      } else {
        listaRecomendacoes[i].classList.add('hidden');
      }
    }
  }

  document.getElementById('filtroInput').addEventListener('input', filtrarLista);
</script>
</body>
