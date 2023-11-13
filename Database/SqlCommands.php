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
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id LEFT JOIN tb_comentarios ON com_pos_id = pos_id ORDER BY com_id DESC, pos_data_postagem DESC;",
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, has_hashtag, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id ORDER BY pos_data_postagem DESC ;",
            "SELECT pos_id, pos_conteudo, usu_nome, usu_avatar, has_hashtag, pos_data_postagem FROM tb_posts LEFT JOIN tb_usuarios ON pos_usu_id = usu_id JOIN tb_hashdosposts ON hdp_pos_id = pos_id LEFT JOIN tb_hashtag ON hdp_has_id = has_id WHERE has_id = ? ORDER BY pos_data_postagem DESC ;"
        ],
        "commentPost" => [
            "INSERT INTO tb_comentarios (com_usu_id, com_pos_id, com_texto) VALUES (?, ?, ?);"
        ],
        "viewComment" => [
            "SELECT com_pos_id, usu_avatar, com_texto, usu_nome, com_data_comentario FROM tb_comentarios 
                                            LEFT JOIN tb_posts ON com_pos_id = pos_id
                                            LEFT JOIN tb_usuarios on com_usu_id = usu_id;"
        ],
        "tagPost" => [
            "SELECT has_id, has_hashtag FROM tb_hashtag;"
        ]

    );

    public function getCommand($function /*Ex: "userPost" */){
        return $this->listCommandSql[$function];
    }
}