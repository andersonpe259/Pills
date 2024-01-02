<?php
include(__DIR__.'/Layout/Layout.php');
?>

<main class="main" id="perfil">

    <div class="informacoes">
      <div class="fundo"> 
        <img src="../../Storage/fundo/<?= $user['imgPerfil']; ?>">
      </div>
      
      <div class="imgperfil">
      <img src="../../Storage/perfil/<?= $user['avatar']; ?>">  
      <div class="actionBtnPost editar">
        
      <div class="dropdown">
        <button class="dropbtn">Editar perfil</button>
        <div class="dropdown-content">
          <a class="filepost openModal editar" data-modal="modal0">Perfil</a>
          <a class="filepost openModal editar" data-modal="modal1">Fundo</a>
        </div>
      </div>
            <div class="modal" id="modal0">
                <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" enctype="multipart/form-data" action="Index.php?route=perfil"> 
                  <label for="conteudo">Alterar Perfil:</label>
                  <input type="file" name="perfil" accept="image/*" id="input-imagem0" onchange="previewImagem(0)">  
                  <label>Preview: </label>  
                    <img id="imagem-preview0" alt="Prévia da Imagem">
                    <button type="submit">Enviar imagem de perfil</button>
                </form>
                </div>
            </div>
           <div class="modal" id="modal1">
                <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" enctype="multipart/form-data" action="Index.php?route=perfil" id="formulario">
                    <label for="conteudo">Alterar Imagem de Fundo:</label>
                    <input type="file" name="fundo" accept="image/*" id="input-imagem1" onchange="previewImagem(1)">   
                    <label>Preview: </label>
                    <div class="preview-fundo">
                      <img id="imagem-preview1" alt="Prévia da Imagem">
                    </div> 
                    
                    <button type="submit">Enviar imagem de fundo</button>
                </form>
                </div>
            </div>
      </div>
    </div>

      

      <div class="dados"> 
        <h3> <?= $user['nome']; ?> </h3>
        <a class="arroba"><span><?= $user['email']; ?></span></a>
      </div>


    </div>

    <ul class="posts">

      <?php include (__DIR__."/Layout/PostStructure.php"); ?>

    </ul>
  </main>
  <script src="../Resources/Assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
      function previewImagem(modal) {
        var inputImagem = document.getElementById('input-imagem'+modal);
        var imagemPreview = document.getElementById('imagem-preview'+modal);

        var arquivoImagem = inputImagem.files[0];
        if (arquivoImagem) {
            var leitor = new FileReader();

            leitor.onload = function(e) {
                imagemPreview.src = e.target.result;
                imagemPreview.style.display = 'block'; // Exibe a imagem quando uma imagem é selecionada
            };

            leitor.readAsDataURL(arquivoImagem);
        } else {
            imagemPreview.src = '';
            imagemPreview.style.display = 'none'; // Oculta a imagem se nenhum arquivo for selecionado
        }
    }
</script>
</body>