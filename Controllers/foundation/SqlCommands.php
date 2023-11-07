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
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id LEFT JOIN tb_comentarios ON com_pos_id = pos_id ORDER BY com_id DESC, pos_data_postagem DESC;",
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, has_hashtag, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id WHERE has_id = ? ORDER BY pos_data_postagem DESC ;",
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, has_hashtag, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id ORDER BY pos_data_postagem DESC ;"
        ],
        "commentPost" => [
            "INSERT INTO tb_comentarios (com_usu_id, com_pos_id, com_texto) VALUES (?, ?, ?);"
        ],
        "viewComment" => [
            "SELECT com_texto, usu_nome, com_data_comentario FROM tb_comentarios 
                                            LEFT JOIN tb_posts ON com_pos_id = pos_id
                                            LEFT JOIN tb_usuarios on com_usu_id = usu_id 
                                            WHERE com_pos_id = ?;"
        ],
        "tagPost" => [
            "SELECT has_id, has_hashtag FROM tb_hashtag;"
        ]

    );

    private $listHtmlGenarate = array(
        "viewPost" => [
            "<li class='post'>
                <div class='infoUserPost'>
                    <div class='imgUserPost'><img src='#avatar#' alt=''></div>
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
                    <input type='text' name='nome' placeholder='Digite seu comentário'><button>Enviar</button>
                </div>
            </div>
            <button type='button' class='filepost'><i class='bi bi-send' alt='compartilhar'></i></button>
            <button type='button' class='filepost'><i class='bi bi-bookmark' alt='salvar'></i></button>
          </div>

        </li>"
        ],

        "viewComment" => [
            "<div class='comment_unit'>
                <h4>#nome# #data#</h4>
                <p>#comentario#</p>
                </div>"
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
                "#id#"
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