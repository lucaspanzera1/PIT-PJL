CREATE TABLE `imagem_quadra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_imagem` varchar(220) NOT NULL,
  `id_dono` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dono` (`id_dono`)
) 
INSERT INTO `imagem_quadra` VALUES (1,'IMG_20210803_193430.jpg',1),(2,'RB2.jpg',2),(3,'ArenaCantoni.png',3),(5,'Quadra Sportboll.jpg',5),(6,'Quadra Sportboll.jpg',6),(7,'Platina.jpg',7),(8,'VillaRica.jpg',9);
