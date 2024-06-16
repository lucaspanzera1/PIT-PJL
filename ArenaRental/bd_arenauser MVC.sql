create database bd_arenauser;

use bd_arenauser;

    CREATE TABLE cadastro (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cpf VARCHAR(14) NOT NULL,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        tipo VARCHAR(10) NOT NULL,
        data_registro DATETIME
    );

    CREATE TABLE imagem (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_imagem VARCHAR(220) NOT NULL,
        id_user INT NOT NULL,
        FOREIGN KEY (id_user) REFERENCES cadastro(id)
    );

SELECT * FROM cadastro;	
SELECT * FROM imagem;



