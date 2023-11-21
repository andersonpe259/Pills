<?php

class SqlCommands{

    private $listCommandSql = array(

        "userPost" => [
            "INSERT INTO tb_posts (pos_usu_id, pos_conteudo) VALUES (?, ?);",
            "INSERT INTO tb_hashtag (has_hashtag) VALUES (?);",
            "SELECT has_id, has_hashtag FROM tb_hashtag;",
            "INSERT INTO tb_hashdosposts (hdp_has_id, hdp_pos_id) values (?, ?);",
        
        ],
        "viewPost" => [
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id ORDER BY pos_data_postagem DESC;",
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id WHERE pos_usu_id = ? ORDER BY pos_data_postagem DESC;",
         ],
        "searchPost" => [
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, GROUP_CONCAT(has_hashtag) AS hashtags, GROUP_CONCAT(has_id) AS has_ids, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id LEFT JOIN tb_comentarios ON com_pos_id = pos_id LEFT JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id GROUP BY pos_id, pos_conteudo, usu_nome, usu_avatar, pos_data_postagem ORDER BY com_id DESC, pos_data_postagem DESC;",
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, GROUP_CONCAT(has_hashtag) AS hashtags, GROUP_CONCAT(has_id) AS has_ids, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id GROUP BY pos_id, pos_conteudo, usu_nome, usu_avatar, pos_data_postagem ORDER BY pos_data_postagem DESC ;",
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, has_hashtag AS hashtags, has_id AS has_ids, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id WHERE has_id = ? ORDER BY pos_data_postagem DESC ;"
        ],
        "commentPost" => [
            "INSERT INTO tb_comentarios (com_usu_id, com_pos_id, com_texto) VALUES (?, ?, ?);"
        ],
        "viewComment" => [
            "SELECT com_pos_id, usu_avatar, com_texto, usu_nome, com_data_comentario FROM tb_comentarios 
                                            LEFT JOIN tb_posts ON com_pos_id = pos_id
                                            LEFT JOIN tb_usuarios on com_usu_id = usu_id WHERE com_pos_id = ?;"
        ],
        "tagPost" => [
            "SELECT has_id, has_hashtag FROM tb_hashtag;"
        ],
        "savePost" => [
            "INSERT INTO tb_salvarpost (sal_usu_id, sal_pos_id) VALUES (?, ?);"
        ],
        "viewSave" => [
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, pos_data_postagem FROM tb_usuarios INNER JOIN tb_salvarpost ON usu_id = sal_usu_id INNER JOIN tb_posts ON sal_pos_id = pos_id WHERE sal_usu_id = ?;"
        ],
        "viewNotification" => [
            "SELECT po.pos_id, po.pos_conteudo, us1.usu_nome, us1.usu_avatar, po.pos_data_postagem, us2.usu_nome AS sender_name FROM tb_compartilharpost cp INNER JOIN tb_posts po ON cp.cpo_pos_id = po.pos_id  INNER JOIN tb_usuarios us1 ON po.pos_usu_id = us1.usu_id INNER JOIN tb_usuarios us2 ON cp.cpo_ususend_id = us2.usu_id  WHERE cp.cpo_usureceive_id = ?;"
        ],
        "insertNotification" => [
            "INSERT INTO tb_compartilharpost (cpo_ususend_id, cpo_usureceive_id, cpo_pos_id) VALUES (?, ?, ?); "
        ],
        "deletePost" => [
            "DELETE FROM tb_posts WHERE pos_id= ?;"
        ],
        "deleteSalvar" => [
            "DELETE FROM tb_salvarpost WHERE sal_pos_id = ?;"
        ],
        "deleteCompartilhado" => [
            "DELETE FROM tb_compartilharpost WHERE cpo_pos_id = ?;"
        ],

    );

    private $listHtmlGenarate = array(
        "viewPost" => [
            "<li class='post'>
                <div class='infoUserPost'>
                    <div class='imgUserPost'><img src='../Storage/perfil/#avatar#' alt=''></div>
                    <div class='nameAndHour'>
                        <strong>#nome#</strong>
                        <p>#data#</p>
                    </div>
                </div>

                <p>
                    #post#
                </p>

                <div class='actionBtnPost'>
          <button type='button' class='filepost'><i class='bi bi-heart' alt='curtir'></i></button>
          <button type='button' class='filepost openModal' data-modal='modal1'><i class='bi bi-chat' alt='comentar'></i></button>
          <div class='modal' id='modal1'>
              <div class='modal-content'>
                <span class='close'>&times;</span>
                  <h2>Comentários</h2>
                  <h5>Wallison</h5>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                  <h5>Ana Júlia</h5>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                  <div class='seu-comentario'>
                    <input type='text' name='nome' placeholder='Digite seu comentário'><button type='submit' class='btnSubmitForm coment'>Enviar</button>
                  </div>     
              </div>
          </div>
          <button type='button' class='filepost'><i class='bi bi-send' alt='compartilhar'></i></button>
          <button type='button' class='filepost'><i class='bi bi-bookmark' alt='salvar'></i></button>
        </div>

        </li>"
        ],

        "viewComment" => [
            "
                <h5>#nome# #data#</h5>
                <p>#comentario#</p>
            "
        ],
       
        "tagPost"=>[
            "<li>
                <button type='submit' class='nav-link scrollto' name='tag' value='#id#'>
                    <i class='bi bi-hash'></i> <span>#hashtag#</span>
                </button>
            </li>"
        ]

        );
        private $listKeywords = array(
            "viewPost" =>[
                "#avatar#",
                "#nome#",
                "#data#",
                "#post#",
                
                
            ],

            "viewComment"=>[
                
                "#nome#",
                "#data#",
                "#comentario#"
            ],
            "tagPost"=>[
                "#id#",
                "#hashtag#"
            ]
        );
    public function getCommand($function /*Ex: "userPost" */){
        return $this->listCommandSql[$function];
    }
    public function getHtml($html){
        return $this->listHtmlGenarate[$html];
    }
    public function getKeywords($keyword){
        return $this->listKeywords[$keyword];
    }

}