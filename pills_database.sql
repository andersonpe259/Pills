DROP DATABASE IF EXISTS db_pills;
CREATE DATABASE db_pills;
USE db_pills;

-- create da tabela usuários
CREATE TABLE tb_usuarios (
    usu_id INT AUTO_INCREMENT PRIMARY KEY,
    usu_nome VARCHAR(100) NOT NULL,
    usu_nome_usuario VARCHAR(50) NOT NULL,
    usu_email VARCHAR(100) NOT NULL UNIQUE,
    usu_senha VARCHAR(100) NOT NULL,
    usu_avatar VARCHAR(100) DEFAULT 'avatar.jpg',
    usu_img_fundo VARCHAR(100) DEFAULT 'generico.svg',
    usu_data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_usu_nome_usuario_no_spaces CHECK (usu_nome_usuario NOT LIKE '% %')
);

-- insert da tabela usuários
INSERT INTO tb_usuarios (usu_nome, usu_nome_usuario, usu_email, usu_senha) VALUES
('Udsu', 'udsu', 'udsu@exemplo.com.br', 'A141414'),
('Joarlitwosson', 'joarli2son', 'joarli2son@exemplo.com.br', 'G232323');

-- create da tabela posts
CREATE TABLE tb_posts (
    pos_id INT AUTO_INCREMENT PRIMARY KEY,
    pos_usu_id INT NOT NULL,
    pos_conteudo TEXT,
    pos_data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pos_usu_id) REFERENCES tb_usuarios(usu_id)
);
-- insert da tabela posts
INSERT INTO tb_posts (pos_usu_id, pos_conteudo) VALUES
(1, 'Ta Bunitu Heim!'),
(2, 'And I need coffee');

-- Tabela de Posts Salvos Pelo Usuário 
CREATE TABLE tb_salvarpost (
  sal_id INT AUTO_INCREMENT PRIMARY KEY, 
  sal_usu_id INT NOT NULL,
  sal_pos_id INT NOT NULL,
  foreign key (sal_usu_id) references tb_usuarios(usu_id),
  foreign key (sal_pos_id) references tb_posts(pos_id)
  );

-- Insert na tabela salvarpost
insert into tb_salvarpost (sal_usu_id, sal_pos_id) values (1, 1);

-- Tabela de Posts compartilhados 
CREATE TABLE tb_compartilharpost (
  cpo_id INT AUTO_INCREMENT PRIMARY KEY, 
  cpo_ususend_id INT NOT NULL,
  cpo_usureceive_id INT NOT NULL,
  cpo_pos_id INT NOT NULL,
  foreign key (cpo_ususend_id) references tb_usuarios(usu_id),
  foreign key (cpo_usureceive_id) references tb_usuarios(usu_id),
  foreign key (cpo_pos_id) references tb_posts(pos_id)
  );

-- Insert na tabela compartilharpost
insert into tb_compartilharpost (cpo_ususend_id, cpo_usureceive_id, cpo_pos_id) values (1, 2, 1); 
-- create da tabela comentários
CREATE TABLE tb_comentarios (
    com_id INT AUTO_INCREMENT PRIMARY KEY,
    com_pos_id INT NOT NULL,
    com_usu_id INT NOT NULL,
    com_texto TEXT,
    com_data_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (com_pos_id) REFERENCES tb_posts(pos_id),
    FOREIGN KEY (com_usu_id) REFERENCES tb_usuarios(usu_id)
);
-- insert da tabela comentários
INSERT INTO tb_comentarios (com_pos_id, com_usu_id, com_texto) VALUES
(1, 2, 'incrível!'),
(2, 1, 'café!!!');

-- create da tabela respostas
CREATE TABLE tb_respostas (
    res_id INT AUTO_INCREMENT PRIMARY KEY,
    res_com_id INT NOT NULL,
    res_usu_id INT NOT NULL,
    res_texto TEXT,
    res_data_resposta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (res_com_id) REFERENCES tb_comentarios(com_id),
    FOREIGN KEY (res_usu_id) REFERENCES tb_usuarios(usu_id)
);
-- insert da tabela respostas
INSERT INTO tb_respostas (res_com_id, res_usu_id, res_texto) VALUES
(1, 1, 'Agradeço muitão'),
(2, 2, 'Nada como um bom café antes das 15h99');

CREATE TABLE tb_hashtag (
	has_id INT AUTO_INCREMENT PRIMARY KEY,
    has_hashtag VARCHAR(45)
);
insert into tb_hashtag (has_hashtag) values ('#funciona');

CREATE TABLE tb_hashdosposts (
  hdp_id INT AUTO_INCREMENT PRIMARY KEY, 
  hdp_has_id INT NOT NULL,
  hdp_pos_id INT NOT NULL,
  foreign key (hdp_has_id) references tb_hashtag(has_id),
  foreign key (hdp_pos_id) references tb_posts(pos_id)
  );
insert into tb_hashdosposts (hdp_has_id, hdp_pos_id) values (1, 1);
-- selects que podem vir a usar(verificar se serão criados no php mesmo ou não)

-- Criação do Trigger para evitar a repetição de emails iguais e nomes de usuario iguais no banco.

DELIMITER //
CREATE TRIGGER before_insert_tb_usuarios
BEFORE INSERT ON tb_usuarios FOR EACH ROW
BEGIN
    DECLARE username_count INT;
    DECLARE email_count INT;

    -- Verifica se o nome de usuário já existe na tabela
    SELECT COUNT(*) INTO username_count
    FROM tb_usuarios
    WHERE usu_nome_usuario = NEW.usu_nome_usuario;

    -- Verifica se o e-mail já existe na tabela
    SELECT COUNT(*) INTO email_count
    FROM tb_usuarios
    WHERE usu_email = NEW.usu_email;

    -- Se o nome de usuário ou e-mail já existirem, gera um erro
    IF username_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Este nome de usuário já está cadastrado';
    END IF;

    IF email_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Este e-mail já está cadastrado';
    END IF;
END;
//
DELIMITER ;

-- Criação do Trigger e ações para quando o usuário deletar um post.
DELIMITER //
CREATE TRIGGER after_delete_tb_posts
BEFORE DELETE ON tb_posts FOR EACH ROW
BEGIN
    -- Deletar entradas da tabela tb_compartilharpost associadas ao post deletado
    DELETE FROM tb_compartilharpost WHERE cpo_pos_id = OLD.pos_id;

    -- Deletar entradas da tabela tb_comentarios associadas ao post deletado
    DELETE FROM tb_comentarios WHERE com_pos_id = OLD.pos_id;

    -- Deletar entradas da tabela tb_hashdosposts associadas ao post deletado,
    -- exceto se outras entradas ainda estiverem usando a mesma tag
    DELETE FROM tb_hashdosposts
    WHERE hdp_pos_id = OLD.pos_id;
    
    DELETE FROM tb_salvarpost
    WHERE sal_pos_id = OLD.pos_id;

END;
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER before_insert_tb_salvarpost
BEFORE INSERT ON tb_salvarpost FOR EACH ROW
BEGIN
    DECLARE count_records INT;

    -- Verifica se o sal_pos_id já existe na tabela tb_salvarpost
    SELECT COUNT(*) INTO count_records
    FROM tb_salvarpost
    WHERE sal_pos_id = NEW.sal_pos_id AND sal_usu_id = NEW.sal_usu_id;

    -- Se já existir, gera um erro
    IF count_records > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Este post já foi salvo pelo usuário';
    END IF;
END;
//
DELIMITER ;

