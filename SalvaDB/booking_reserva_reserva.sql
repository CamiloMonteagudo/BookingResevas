-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: booking_reserva
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.10-MariaDB

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
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva` (
  `IdReserva` int(11) NOT NULL AUTO_INCREMENT,
  `IdOperador` int(2) NOT NULL,
  `IdReservaTipo` int(2) NOT NULL,
  `IdReservaEstado` int(2) NOT NULL,
  `IdPais` int(2) NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Correo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `FechaReserv` date NOT NULL,
  `FechaEntrada` date NOT NULL,
  `Noches` int(2) unsigned NOT NULL DEFAULT '1',
  `Personas` int(2) unsigned NOT NULL DEFAULT '1',
  `Habitaciones` int(2) unsigned NOT NULL DEFAULT '1',
  `Trasfer` tinyint(1) NOT NULL DEFAULT '0',
  `Deposito` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `VueloInfo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Observ` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `Hora` time NOT NULL,
  PRIMARY KEY (`IdReserva`),
  KEY `FK_reserva_operador_IdOperador` (`IdOperador`),
  KEY `FK_reserva_pais_IdPais` (`IdPais`),
  KEY `FK_reserva_reserva_estado_IdReservaEstado` (`IdReservaEstado`),
  KEY `FK_reserva_reserva_tipo_IdReservaTipo` (`IdReservaTipo`),
  CONSTRAINT `FK_reserva_operador_IdOperador` FOREIGN KEY (`IdOperador`) REFERENCES `operador` (`IdOperador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reserva_pais_IdPais` FOREIGN KEY (`IdPais`) REFERENCES `pais` (`IdPais`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reserva_reserva_estado_IdReservaEstado` FOREIGN KEY (`IdReservaEstado`) REFERENCES `reserva_estado` (`IdReservaEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reserva_reserva_tipo_IdReservaTipo` FOREIGN KEY (`IdReservaTipo`) REFERENCES `reserva_tipo` (`IdReservaTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=5461;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (1,2,1,7,5,'XXX un tipo','reserva1@gmail.com','2016-03-07','2016-03-23',3,8,1,0,250.00,'CA-456 a a las 7pm','Cualquier mierda','00:00:00'),(2,2,1,7,8,'Segundo Tur','kk2@gmail.com','2016-03-01','2016-03-29',4,1,1,1,0.00,'','','00:00:00'),(3,2,2,2,4,'Otro tipo XXXXXX','correo@gmail.com','2016-03-01','2016-03-30',10,6,4,1,0.00,'Prueba con info','Prueba con observa jkjkjkjk','00:00:00'),(5,2,1,1,7,'John fulanito','fulano@kkyte.com','2016-02-16','2016-03-29',8,4,3,0,0.00,'','','00:00:00'),(9,1,1,7,3,'Cualquiera','kkkk@fsfs.com','2016-03-20','2016-03-31',4,6,3,0,0.00,' ',NULL,'00:00:00'),(10,1,1,7,2,'Cualquiera','kkkk@fsfs.com','2016-03-20','2016-03-31',4,6,3,0,200.00,NULL,NULL,'00:00:00'),(11,1,1,6,8,'Cualquiera','kkkk@fsfs.com','2016-03-20','2016-04-15',4,6,3,0,0.00,'','','00:00:00'),(13,1,1,7,4,'Fulano','cualquiera','2016-03-20','2016-04-15',4,6,3,0,0.00,NULL,NULL,'00:00:00'),(14,2,1,6,9,'yo modificado','kk2@gmail.com','2016-03-20','2016-03-24',1,2,4,0,0.00,'Cubana CU-346 a las 7:30 pm','Cualquier mierda es este lugar','00:00:00'),(15,2,1,1,9,'camilo tur','my@vvv.com','2016-03-20','2016-03-29',1,2,1,0,0.00,'','','00:00:00'),(16,2,1,7,5,'adiconada','add','2016-03-20','2016-03-29',1,2,1,0,0.00,'','','00:00:00'),(19,2,1,2,7,'Lorena','ffsfsfs@sfsfsf.ffgfgf','2016-03-24','2016-03-29',4,6,2,0,0.00,'','','00:00:00'),(21,2,2,7,2,'Con dos casas','dsdasadsad','2016-03-28','2016-04-29',9,3,1,1,300.00,'asffssa sfsafsaf','fsf gfd gdfgdsgdsg','00:00:00'),(22,2,1,1,7,'xcbbbxcb','ddsg dgdsgds','2016-03-28','2016-03-28',1,2,1,0,0.00,'','','00:00:00'),(23,2,1,6,4,'fulanito perez','KK@sdsf.com','2016-03-30','2016-03-30',1,2,1,0,0.00,'','','00:00:00'),(24,2,1,1,28,'wrwrwrw','wrw wrwrwrwrwrw','2016-03-30','2016-03-30',1,2,1,0,0.00,'','','00:00:00'),(25,2,1,1,8,'grettel','grettel.monteagudo@gmail.com','2016-03-31','2016-03-31',1,2,1,1,0.00,'','','00:00:00'),(26,2,1,1,3,'r32v3 3535','wrwrw@kkk.com','2016-04-10','2016-04-10',1,2,1,0,2.00,'','','00:00:00'),(27,2,1,2,1,'nuevo tipo','Tipo@correo.com','2016-04-10','2016-04-10',15,2,1,0,0.00,'','','00:00:00'),(28,2,1,2,3,'Otra prueba mÃ¡s','otro.correo@hotmail.com ','2016-04-10','2016-04-10',1,1,1,0,0.00,'','','00:00:00'),(29,2,1,2,3,'Otro turista','correo@gmail.com','2016-04-11','2016-04-15',5,2,3,0,300.00,'','','00:00:00'),(30,2,1,2,3,'Un monton','ferer@dfefe.fddf','2016-04-11','2016-04-11',1,15,10,0,0.00,'','','00:00:00'),(31,2,1,1,3,'Otra hostal pepe','pepe@kkk.com','2016-04-12','2016-04-15',5,2,2,0,0.00,'','','00:00:00'),(32,2,1,1,1,'Incluye el tiempo','correo@gmail.com','2016-04-13','2016-04-13',1,2,1,0,0.00,'','','17:05:51'),(33,2,1,1,3,'Una prueba mÃ¡s','Este correo','2016-04-13','2016-04-13',1,2,1,0,0.00,'','','19:34:28'),(34,2,1,2,3,'hrreyre','ryryryr','2016-04-20','2016-04-20',1,2,1,0,0.00,'ryryr','ryryrey','18:42:23'),(35,2,1,2,10,'Nueva reservaciÃ³n','reserva@gmail.com','2016-04-23','2016-04-24',6,4,2,1,240.00,'Cubana CU-346 a las 7:30 pm','nada que observar','11:59:03');
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-24 21:23:21
