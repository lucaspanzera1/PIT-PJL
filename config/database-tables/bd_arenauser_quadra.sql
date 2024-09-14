
CREATE TABLE `quadra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_quadra` varchar(255) NOT NULL,
  `esporte` varchar(255) NOT NULL,
  `localizacao` varchar(255) NOT NULL,
  `descricao` text,
  `valor` decimal(10,2) NOT NULL,
  `id_user` int NOT NULL,
  `nome_dono` varchar(255) NOT NULL,
  `horario_abre` varchar(5) NOT NULL,
  `horario_fecha` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `nome_dono` (`nome_dono`(250))
) 
INSERT INTO `quadra` VALUES (1,'Celpe','futebol','Rua Padre Eustáquio','Blablala',120.00,1,'Lucas','',''),(2,'Arena RB2 Sports','Futvôlei','Av. Teresa Cristina, 4575','Quadra do Kevinho',100.00,2,'Pedro','',''),(3,'Arena Cantoni Beach','Futvôlei','Av. Prof. Clóvis Salgado, 1101','Arena do Juan.',110.00,3,'Juan','',''),(5,'Quadra Sportboll','Futebol','R. Juscelino Barbosa, 251','Quadra do Miguel.',111.00,6,'Miguel','',''),(6,'Platina Ball Esportes','Futebol','R. Platina, 1385 - Prado','Quadra do Biel',140.00,7,'Biel','',''),(7,'Centro Esportivo Vila Rica','Futsal','R. Vila Rica, 1114','Quadra do Duncho.',80.00,9,'Duncho','','');

