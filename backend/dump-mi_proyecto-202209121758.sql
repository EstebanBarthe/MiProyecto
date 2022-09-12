-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: mi_proyecto
-- ------------------------------------------------------
-- Server version	5.7.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administradores` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `mail` text,
  `clave` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT INTO `administradores` VALUES (1,'Esteban','estebanbarthe99@gmail.com','fbc71ce36cc20790f2eeed2197898e71',1);
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deportistas`
--

DROP TABLE IF EXISTS `deportistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deportistas` (
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `genero` enum('masculino','femenino','otros') DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `documento` int(9) NOT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `categorias` enum('futbol5','futbol7') DEFAULT NULL,
  `imagen` char(36) DEFAULT NULL,
  `posicion` enum('por','def','med','del','dt') DEFAULT NULL,
  PRIMARY KEY (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deportistas`
--

LOCK TABLES `deportistas` WRITE;
/*!40000 ALTER TABLE `deportistas` DISABLE KEYS */;
INSERT INTO `deportistas` VALUES ('test','test','masculino','6201-02-15',123456,0,NULL,NULL,NULL),('test2','test2','masculino','1999-12-15',222222,0,'futbol5',NULL,NULL),('Pepe','alfajores','masculino','1999-04-15',325432,0,'futbol5',NULL,NULL),('Gonzalo','Araujo',NULL,'1997-01-15',1111111,0,'futbol7',NULL,NULL),('TEST','TEST','masculino','1999-12-15',1232654,0,'futbol7',NULL,NULL),('Nombre','TEST','masculino','2000-02-15',3174657,0,'futbol7',NULL,NULL),('nombre','apellido',NULL,'1999-07-15',3333333,0,'futbol7',NULL,NULL),('Juan','Fernandez','masculino','2000-07-16',4645823,0,'futbol7',NULL,NULL),('Nombre','Enserio','masculino','0622-02-15',6455649,0,'futbol7',NULL,NULL),('Prueba','Prueba','masculino','2066-02-15',6523597,0,NULL,NULL,NULL),('sladlkmad','asÃ±ldÃ±a',NULL,'1995-07-15',6545645,0,'futbol7',NULL,NULL),('Nombre','Nombre','masculino','6123-02-15',12365498,0,NULL,NULL,NULL),('Gonzalo','Araujo',NULL,'1989-04-15',15141312,0,'futbol7',NULL,NULL),('Camilo','Carballo','masculino','1995-01-19',32645735,1,'futbol7',NULL,'med'),('Santiago','Burgoa','masculino','1999-08-17',42131498,1,'futbol7',NULL,'med'),('Enzo','Arcamone','masculino','2000-03-18',42695853,1,'futbol7',NULL,'del'),('Gonzalo','Araujo',NULL,'1997-01-15',45763224,0,'futbol7',NULL,NULL),('German','Ipes','masculino','2000-02-27',45896432,1,'futbol7',NULL,'por'),('Nombre','TEST','masculino','1999-05-18',52120964,0,'futbol5','631f7dda58215.png','del'),('esteban','TEST','otros','2000-05-18',52120965,0,'futbol7','631f7c6c82bec.png','def'),('Esteban','Barthe','masculino','1999-05-19',52120969,1,'futbol7',NULL,'def'),('Sebastian','Suarez','masculino','1999-05-15',52643252,1,'futbol7',NULL,'def'),('Joaquin','De Los Santos','masculino','1999-03-15',54645219,1,'futbol7',NULL,'del'),('Matias','Fructos','masculino','1999-06-29',56432128,1,'futbol7',NULL,'def'),('pepito','gonzales',NULL,'2001-07-19',65453221,0,'futbol7',NULL,NULL),('Nombre','Fernandez','masculino','0654-05-18',123456789,0,'futbol5',NULL,NULL);
/*!40000 ALTER TABLE `deportistas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticias` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `cuerpo` text,
  `categorias` enum('futbol 5','futbol 7') DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `imagen` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` VALUES (1,'prueba','estoy probando noticias','futbol 7',0,'631ec7439a2c1.jpg'),(2,'test',NULL,'futbol 7',0,NULL),(3,'Nueva ilusion','PMH vs RCB se disputarÃ¡n el inicio del torneo local el proximo domingo 21 de agosto.\r\nUn partido en principio complicado ya que el rival hizo un gran mercado de pases y trajo muchas figuras a la liga.\r\nSe espera ver una evolucion en el juego por parte de PMH desde la incorporacion del nuevo tecnico','futbol 7',1,'631f847622f1a.jpg'),(4,'test2','estoy probando2','futbol 7',0,NULL),(5,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH. Llego para dirigir y orientar al equipo durante su trayectoria en el campeonato de Futbol 5. Firmo un acuerdo que finalizara, una vez termine la presente temporada. Cabe destacar que PMH no ha tenido director tecnico desde su fundacion, pero dado los resultados de la pasada campaÃ±a puede que sea una solucion al sistema de juego de PMH para la presente campaÃ±a.','futbol 7',0,'631f5949bf8ee.jpg'),(6,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH. Llego para dirigir y orientar al equipo durante su trayectoria en el campeonato de Futbol 5. Firmo un acuerdo que finalizara, una vez termine la presente temporada. Cabe destacar que PMH no ha tenido director tecnico desde su fundacion, pero dado los resultados de la pasada campaÃ±a puede que sea una solucion al sistema de juego de PMH para la presente campaÃ±a.','futbol 7',0,NULL),(7,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH.','futbol 7',0,NULL),(8,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH.','futbol 7',0,NULL),(9,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH.','futbol 7',0,NULL),(10,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH. Llego para dirigir y orientar al equipo durante su trayectoria en el campeonato de Futbol 5. Firmo un acuerdo que finalizara, una vez termine la presente temporada. Cabe destacar que PMH no ha tenido director tecnico desde su fundacion, pero dado los resultados de la pasada campaÃ±a puede que sea una solucion al sistema de juego de PMH para la presente campaÃ±a.','futbol 7',0,NULL),(11,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH. Llego para dirigir y orientar al equipo durante su trayectoria en el campeonato de Futbol 5. Firmo un acuerdo que finalizara, una vez termine la presente temporada. Cabe destacar que PMH no ha tenido director tecnico desde su fundacion, pero dado los resultados de la pasada campaÃ±a puede que sea una solucion al sistema de juego de PMH para la presente campaÃ±a.','futbol 7',0,NULL),(12,'Â¿Solucion?','Hoy, 15 de agosto, Gustavo Fernandez asumio como entrenador de PMH.\r\nEs el primer entrenador que asume desde que se fundo la institucion hace 2 aÃ±os, por lo que no sera facil para \"Gusta\" integrarse a un equipo el cual ya se habia acostumbrado a depender de ellos mismos.\r\nÂ¿Sera esta la solucion a levantarse de la caida en la final en el torneo pasado?','futbol 7',1,'631f846609b78.jpg'),(13,'test2','estoy probando','futbol 7',0,NULL),(14,'test','estoy probando','futbol 7',0,NULL),(15,'test','estoy probando','futbol 7',0,NULL),(16,'LLamado de aspirantes','PMH decidio expandirse en el area deportiva para aplicar en la liga uruguaya de futbol 5. Presentarse en el complejo de la institucion el proximo 10/10/21 aquellos interesados. Por consultas en el footer de nuestra web se encuentra nuestros contactos!','futbol 5',1,'631f854e2c79f.jpg'),(17,'Baja sensible para el equipo','El jugador Matias Fructos sufrio un accidente automovilistico por lo que se ha lesionado gravemente, aunque no hay un diagnostico aun, \"Maty\" era el alma del equipo, ahora toca a PMH afrontar esta nueva temporada sin uno de sus hombres mas habilidosos. Â¡Ojala no sea nada Maty, te estaremos esperando!','futbol 7',1,'631f8630b1012.png');
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarioweb`
--

DROP TABLE IF EXISTS `usuarioweb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarioweb` (
  `documento` int(9) NOT NULL,
  `mail` varchar(120) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `clave` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarioweb`
--

LOCK TABLES `usuarioweb` WRITE;
/*!40000 ALTER TABLE `usuarioweb` DISABLE KEYS */;
INSERT INTO `usuarioweb` VALUES (52120969,'estebanbarthe99@gmail.com','Esteban',1,'e10adc3949ba59abbe56e057f20f883e');
/*!40000 ALTER TABLE `usuarioweb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'mi_proyecto'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-12 17:58:56
