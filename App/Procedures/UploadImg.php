<?php

class UploadImg{
    public function upload($type, $userModel){
        if(isset($_FILES[$type]) && $_FILES[$type]["error"] == UPLOAD_ERR_OK){
            $nome_temporario = $_FILES[$type]["tmp_name"];
            $nome_arquivo = basename($_FILES[$type]["name"]);
            
            // Verifique se o arquivo é uma imagem
            $extensoes_permitidas = array("jpg", "jpeg", "png", "gif", "svg");
            $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
            if (in_array($extensao, $extensoes_permitidas)) {
                // Diretório de destino para salvar a imagem
                $diretorio_destino = "Storage/$type/";
                
                // Renomeie o arquivo para evitar conflitos de nome
                $imgSave = $_SESSION['user_id'] . "." . $extensao;
                $caminho_destino = $diretorio_destino . $imgSave;
    
                
                if (move_uploaded_file($nome_temporario, $caminho_destino)) {
                    echo "A imagem foi carregada com sucesso.";
                    $userModel->updateAvatar($imgSave, $_SESSION['user_id']);
                    if($type == "perfil"){
                        $_SESSION['avatar'] = $imgSave;
                    }
                } else {
                    echo "Erro ao carregar a imagem.";
                }
            } else {
                echo "Apenas arquivos de imagem (jpg, jpeg, png, gif) são permitidos.";
            }
        } else {
            echo "Erro ao processar o upload da imagem.";
        }
    }
}