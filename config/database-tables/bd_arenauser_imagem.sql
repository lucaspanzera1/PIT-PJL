
CREATE TABLE `imagem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_imagem` varchar(220) NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) 
INSERT INTO `imagem` VALUES (1,'foto1.jpeg',1),(2,'RB2.jpg',2),(3,'Arena Cantoni Beach.jpg',3),(4,'Quadra Sportball.png',5),(5,'Quadra Sportball.png',6),(6,'Platina.jpg',7),(7,'VillaRica.JPG',8),(8,'VillaRica.JPG',9);

