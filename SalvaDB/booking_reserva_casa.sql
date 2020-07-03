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
-- Table structure for table `casa`
--

DROP TABLE IF EXISTS `casa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `casa` (
  `IdCasa` int(2) NOT NULL AUTO_INCREMENT,
  `IdCiudad` int(2) NOT NULL,
  `Propietario` varchar(255) NOT NULL,
  `Telef` varchar(255) NOT NULL,
  `Habitaciones` int(2) NOT NULL DEFAULT '1',
  `Personas` int(2) NOT NULL DEFAULT '1',
  `PrecioHab` decimal(10,2) NOT NULL DEFAULT '20.00',
  `ComisionHab` decimal(10,2) NOT NULL DEFAULT '5.00',
  `Direccion` varchar(255) NOT NULL,
  `Notas` varchar(255) NOT NULL,
  PRIMARY KEY (`IdCasa`),
  KEY `FK_casa_ciudad_IdCiudad` (`IdCiudad`),
  CONSTRAINT `FK_casa_ciudad_IdCiudad` FOREIGN KEY (`IdCiudad`) REFERENCES `ciudad` (`IdCiudad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4096;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `casa`
--

LOCK TABLES `casa` WRITE;
/*!40000 ALTER TABLE `casa` DISABLE KEYS */;
INSERT INTO `casa` VALUES (1,15,'Chinea','55 555 5555, rtrtrt 464564, yyuyuyu899, 457665766 hjjkjk kll yuuy',4,4,25.00,5.00,'Otra direcciÃ³n','Nota'),(2,2,'Pepito','56 677 7899',3,5,30.00,6.00,'',''),(3,2,'Juanito','56 678  345',1,2,20.00,4.00,'',''),(4,3,'Josefa','50 567 7654',4,6,40.00,8.00,'',''),(5,1,'Monga, alargado el nombre','346 567 677, con dos tres telefonos adicionales a ver que pasa',3,5,25.00,5.00,'',''),(6,9,'Abel','56 567 532',2,4,25.00,5.00,'','Esta es la casa de Abel'),(7,10,'Come Gofio','44 694 6932',1,2,25.00,5.00,'',''),(8,4,'Maseta','45 567 8743',4,8,40.00,10.00,'',''),(9,3,'Hostal pepe','45 879 33847',6,12,50.00,10.00,'',''),(10,12,'Guanajo','34 567 7888',3,5,30.00,6.00,'',''),(11,12,'Elsa','3 563 9870',21,31,251.00,51.00,'',''),(12,1,'Camilo','7 832 8768',6,6,50.00,15.00,'','Esta casa esta en ruinas'),(17,4,'prueba nueva','5 678 1256',1,2,20.00,5.00,'',''),(18,1,'My casa','7 832 8768',2,2,20.00,5.00,'LÃ­nea #901 % 6 y 8 apto 1','Esta es la mejor casa');
/*!40000 ALTER TABLE `casa` ENABLE KEYS */;
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
