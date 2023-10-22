DROP DATABASE IF EXISTS db_pills;
CREATE DATABASE db_pills;
USE db_pills;

-- create da tabela usuários
CREATE TABLE tb_usuarios (
    usu_id INT AUTO_INCREMENT PRIMARY KEY,
    usu_nome VARCHAR(100) NOT NULL,
    usu_email VARCHAR(100) NOT NULL UNIQUE,
    usu_senha VARCHAR(100) NOT NULL,
    usu_data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- insert da tabela usuários
INSERT INTO tb_usuarios (usu_nome, usu_email, usu_senha) VALUES
('Udsu', 'udsu@exemplo.com.br', 'A141414'),
('Joarlitwosson', 'joarli2son@exemplo.com.br', 'G232323');

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