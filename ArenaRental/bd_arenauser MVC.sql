create database bd_arenauser;

use bd_arenauser;

CREATE TABLE cadastro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(14) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

create table imagem (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome_imagem VARCHAR(220) NOT NULL,
 id_user INT NOT null,
 email_user VARCHAR(255) NOT NULL
 
);

SELECT * FROM cadastro;
SELECT * FROM imagem;



