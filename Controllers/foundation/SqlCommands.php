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
            "SELECT pos_id, pos_conteudo, usu_nome, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id ORDER BY pos_data_postagem DESC;",
            "SELECT pos_id, pos_conteudo, usu_nome, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id LEFT JOIN tb_comentarios ON com_pos_id = pos_id ORDER BY com_id DESC, pos_data_postagem DESC;",
            "SELECT pos_id, pos_conteudo, usu_nome, has_hashtag, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id WHERE has_id = ? ORDER BY pos_data_postagem DESC ;",
            "SELECT pos_id, pos_conteudo, usu_nome, has_hashtag, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id ORDER BY pos_data_postagem DESC ;"
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
        "filterTagPost" => [
            "SELECT has_id, has_hashtag FROM tb_hashtag;"
        ]

    );

    private $listHtmlGenarate = array(
        "viewPost" => [
            "<div class='post_div'>
            <div class='left_side'>
            <h1>#nome#</h1>
            <p>Post: #post#</p>
            <form action='Principal.php' method='post'>
                <input type='hidden' name='idPost' value='#id#'>
                <input type='text' name='comment' id='comment'>
                <button><i class='finish_button'><img src='assets/img/button_go.png' alt='Concluir'></i></button>
            </form>
            </div>
            <div class='right_side'>#comentarios#</div>
            </div>",

            "<li class='post'>
                <div class='infoUserPost'>
                    <div class='imgUserPost'></div>
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
                    <button type='button' class='filepost'><i class='bi bi-chat' alt='comentar'></i></button>
                    <button type='button' class='filepost'><i class='bi bi-send' alt='compartilhar'></i></button>
                    <button type='button' class='filepost'><i class='bi bi-bookmark' alt='salvar'></i></button>
                </div>

        </li>"
        ],
        "keyWords-vp" =>[
            "#nome#",
            "#post#",
            "#id#",
            "#comentarios#"
        ],
        "keyWords-vp2" =>[
            "#nome#",
            "#data#",
            "#post#"
        ],

        "viewComment" => [
            "<div class='comment_unit'>
                <h4>#nome# #data#</h4>
                <p>#comentario#</p>
                </div>"
        ],
        "keyWords-vc"=>[
            "#nome#",
            "#data#",
            "#comentario#"
        ]

        );
    public function getCommand($function /*Ex: "userPost" */){
        return $this->listCommandSql[$function];
    }
    public function getHtml($html){
        return $this->listHtmlGenarate[$html];
    }

}