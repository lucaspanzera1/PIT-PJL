
CREATE TABLE `cadastro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `data_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) 
INSERT INTO `cadastro` VALUES (1,'126.595.936-63','Lucas','lucas@gmail.com','123','Dono','2024-09-13 07:24:52'),(2,'903.764.840-12','Pedro','pedro@gmail.com','123','Dono','2024-09-13 07:58:19'),(3,'334.528.160-01','Juan','juan@gmail.com','123','Dono','2024-09-13 08:16:36'),(6,'912.431.210-09','Miguel','miguel@gmail.com','123','Dono','2024-09-13 08:28:06'),(7,'799.427.690-30','Biel','biel@gmail.com','123','Dono','2024-09-13 08:42:09'),(9,'242.552.360-03','Duncho','duncho@gmail.com','123','Dono','2024-09-13 08:50:51');
