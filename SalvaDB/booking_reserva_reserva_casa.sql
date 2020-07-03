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
-- Table structure for table `reserva_casa`
--

DROP TABLE IF EXISTS `reserva_casa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva_casa` (
  `IdReserva` int(11) NOT NULL,
  `IdCasa` int(2) NOT NULL,
  `DiaEntrada` int(2) NOT NULL DEFAULT '1',
  `DiaSalida` int(2) NOT NULL,
  `Personas` int(2) NOT NULL DEFAULT '1',
  `Habitaciones` int(2) NOT NULL DEFAULT '1',
  `PrecioAcordado` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `ComisionAcordada` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `DineroCobrado` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `CopiaProp` tinyint(1) NOT NULL DEFAULT '0',
  `Observ` varchar(512) NOT NULL,
  `Confirnada` tinyint(1) NOT NULL,
  `Depositado` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`IdReserva`,`IdCasa`,`DiaEntrada`),
  KEY `FK_reserva_casa_casa_IdCasa` (`IdCasa`),
  CONSTRAINT `FK_reserva_casa_casa_IdCasa` FOREIGN KEY (`IdCasa`) REFERENCES `casa` (`IdCasa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reserva_casa_reserva_IdReserva` FOREIGN KEY (`IdReserva`) REFERENCES `reserva` (`IdReserva`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=8192;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva_casa`
--

LOCK TABLES `reserva_casa` WRITE;
/*!40000 ALTER TABLE `reserva_casa` DISABLE KEYS */;
INSERT INTO `reserva_casa` VALUES (1,1,2,4,1,3,30.00,6.00,0.00,1,'kkk',0,0.00),(3,11,0,10,6,1,25.00,5.00,0.00,0,'',0,0.00),(11,5,0,4,6,3,25.00,5.00,60.00,0,'',0,25.00),(13,12,0,4,6,3,50.00,15.00,0.00,0,'',1,0.00),(14,8,0,1,2,4,40.00,10.00,40.00,0,'',1,0.00),(19,10,0,4,6,2,30.00,6.00,0.00,0,'',0,0.00),(21,2,6,9,3,1,30.00,6.00,0.00,0,'',1,0.00),(21,6,3,6,3,2,25.00,5.00,0.00,0,'',1,0.00),(23,12,0,1,2,2,30.00,10.00,20.00,0,'',1,0.00),(28,12,0,1,1,1,50.00,15.00,0.00,0,'',0,0.00),(29,6,0,5,2,1,25.00,5.00,0.00,0,'',0,0.00),(29,10,0,5,2,2,30.00,6.00,5.00,0,'',0,100.00),(30,4,0,1,5,3,40.00,8.00,0.00,0,'',0,0.00),(34,12,0,1,2,1,50.00,15.00,0.00,0,'',0,0.00),(35,18,0,6,4,2,20.00,5.00,0.00,0,'',0,0.00);
/*!40000 ALTER TABLE `reserva_casa` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-24 21:23:22
