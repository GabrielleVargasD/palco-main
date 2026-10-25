CREATE DATABASE palco;
USE palco;

CREATE TABLE categoria (
    id_categ INT AUTO_INCREMENT PRIMARY KEY,
    nome_categoria varchar(100) UNIQUE default("Sem categoria")
);

INSERT INTO categoria (id_categ, nome_categoria) VALUES (null, 'Rock japones');
INSERT INTO categoria (id_categ, nome_categoria) VALUES (null, 'J-pop');
INSERT INTO categoria (id_categ, nome_categoria) VALUES (null, 'City Pop');

CREATE TABLE shows (
    id_show INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    descricao VARCHAR(200),
    data_show DATE NOT NULL,
    locals VARCHAR(200) NOT NULL,
    preco float NOT NULL,
    capacidade INT NOT NULL,
    ing_disponiveis INT NOT NULL,
    imagem varchar(200),
    nome_categoria varchar(100),
    FOREIGN KEY (nome_categoria) REFERENCES categoria(nome_categoria)
);

Create table vendas (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome_comprador varchar(200) NOT NULL,
 email varchar(300) NOT NULL,
 cpf varchar(14) NOT NULL,
 qtd_ing INT NOT NULL,
 valor_total float NOT NULL,
 data_compra TIMESTAMP NOT NULL,
 id_show INT NOT NULL,
 FOREIGN KEY (id_show) REFERENCES shows(id_show)
);

CREATE TABLE usuarios 
  ( id INT AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(100) NOT NULL, 
    email VARCHAR(100) UNIQUE NOT NULL, 
    senha VARCHAR(255) NOT NULL ); 
INSERT INTO usuarios (nome, email, senha) VALUES ('admin', 'admin@email.com', '123');