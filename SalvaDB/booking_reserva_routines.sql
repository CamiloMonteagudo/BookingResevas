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
-- Temporary view structure for view `view_reserva_group_casas`
--

DROP TABLE IF EXISTS `view_reserva_group_casas`;
/*!50001 DROP VIEW IF EXISTS `view_reserva_group_casas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_reserva_group_casas` AS SELECT 
 1 AS `Reserva`,
 1 AS `NCasas`,
 1 AS `IdOperador`,
 1 AS `FechaEntrada`,
 1 AS `Activa`,
 1 AS `Terminada`,
 1 AS `Cancelada`,
 1 AS `Noches`,
 1 AS `Personas`,
 1 AS `Habitaciones`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_casa_reserva_inform`
--

DROP TABLE IF EXISTS `view_casa_reserva_inform`;
/*!50001 DROP VIEW IF EXISTS `view_casa_reserva_inform`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_casa_reserva_inform` AS SELECT 
 1 AS `IdReserva`,
 1 AS `IdCasa`,
 1 AS `Propietario`,
 1 AS `Direccion`,
 1 AS `Localidad`,
 1 AS `PrecioHab`,
 1 AS `Noches`,
 1 AS `Cuartos`,
 1 AS `Pagado`,
 1 AS `Precio`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_reservas_pago`
--

DROP TABLE IF EXISTS `view_reservas_pago`;
/*!50001 DROP VIEW IF EXISTS `view_reservas_pago`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_reservas_pago` AS SELECT 
 1 AS `IdReserva`,
 1 AS `Nombre`,
 1 AS `Correo`,
 1 AS `Pais`,
 1 AS `Salida`,
 1 AS `Casas`,
 1 AS `Noches`,
 1 AS `Personas`,
 1 AS `Cuartos`,
 1 AS `PrecioProm`,
 1 AS `ComisionProm`,
 1 AS `Precio`,
 1 AS `Comision`,
 1 AS `Cobrado`,
 1 AS `Deposito`,
 1 AS `IdEstado`,
 1 AS `IdReservaTipo`,
 1 AS `IdPais`,
 1 AS `Estado`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_resevas_inform`
--

DROP TABLE IF EXISTS `view_resevas_inform`;
/*!50001 DROP VIEW IF EXISTS `view_resevas_inform`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_resevas_inform` AS SELECT 
 1 AS `IdReserva`,
 1 AS `Nombre`,
 1 AS `Correo`,
 1 AS `Entrada`,
 1 AS `Salida`,
 1 AS `Noches`,
 1 AS `Personas`,
 1 AS `Habitaciones`,
 1 AS `VueloInfo`,
 1 AS `Tipo`,
 1 AS `Pais`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_casas_pagos`
--

DROP TABLE IF EXISTS `view_casas_pagos`;
/*!50001 DROP VIEW IF EXISTS `view_casas_pagos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_casas_pagos` AS SELECT 
 1 AS `Propietario`,
 1 AS `Telef`,
 1 AS `Salida`,
 1 AS `Personas`,
 1 AS `Habitaciones`,
 1 AS `nDias`,
 1 AS `PrecioHab`,
 1 AS `ComisionHab`,
 1 AS `PrecioAcordado`,
 1 AS `ComisionAcordada`,
 1 AS `PrecioEsp`,
 1 AS `ComisionEsp`,
 1 AS `PrecioReal`,
 1 AS `ComisionReal`,
 1 AS `Cobrado`,
 1 AS `IdReservaEstado`,
 1 AS `IdReservaTipo`,
 1 AS `IdReserva`,
 1 AS `IdCasa`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_casa_reserva`
--

DROP TABLE IF EXISTS `view_casa_reserva`;
/*!50001 DROP VIEW IF EXISTS `view_casa_reserva`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_casa_reserva` AS SELECT 
 1 AS `IdReserva`,
 1 AS `IdCasa`,
 1 AS `Propietario`,
 1 AS `Telef`,
 1 AS `Localidad`,
 1 AS `Nombre`,
 1 AS `Correo`,
 1 AS `Pais`,
 1 AS `DiaEntrada`,
 1 AS `Desde`,
 1 AS `Hasta`,
 1 AS `Personas`,
 1 AS `Cuartos`,
 1 AS `Precio`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_casas`
--

DROP TABLE IF EXISTS `view_casas`;
/*!50001 DROP VIEW IF EXISTS `view_casas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_casas` AS SELECT 
 1 AS `IdCasa`,
 1 AS `Propietario`,
 1 AS `Telef`,
 1 AS `Localidad`,
 1 AS `Personas`,
 1 AS `Cuartos`,
 1 AS `Precio`,
 1 AS `Comision`,
 1 AS `Notas`,
 1 AS `IdCiudad`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_resevas`
--

DROP TABLE IF EXISTS `view_resevas`;
/*!50001 DROP VIEW IF EXISTS `view_resevas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_resevas` AS SELECT 
 1 AS `IdReserva`,
 1 AS `IdOperador`,
 1 AS `IdTipo`,
 1 AS `IdEstado`,
 1 AS `IdPais`,
 1 AS `Operador`,
 1 AS `Nombre`,
 1 AS `Correo`,
 1 AS `Fecha`,
 1 AS `Noches`,
 1 AS `Personas`,
 1 AS `Habitaciones`,
 1 AS `Deposito`,
 1 AS `Pais`,
 1 AS `Tipo`,
 1 AS `Estado`,
 1 AS `Casas`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_reserva_group_casas`
--

/*!50001 DROP VIEW IF EXISTS `view_reserva_group_casas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_reserva_group_casas` AS select `reserva`.`IdReserva` AS `Reserva`,count(`reserva_casa`.`IdCasa`) AS `NCasas`,`reserva`.`IdOperador` AS `IdOperador`,`reserva`.`FechaEntrada` AS `FechaEntrada`,if((`reserva`.`IdReservaEstado` < 6),1,0) AS `Activa`,if((`reserva`.`IdReservaEstado` = 6),1,0) AS `Terminada`,if((`reserva`.`IdReservaEstado` = 7),1,0) AS `Cancelada`,`reserva`.`Noches` AS `Noches`,`reserva`.`Personas` AS `Personas`,`reserva`.`Habitaciones` AS `Habitaciones` from (`reserva` left join `reserva_casa` on((`reserva_casa`.`IdReserva` = `reserva`.`IdReserva`))) group by `reserva`.`IdReserva`,`reserva`.`FechaEntrada` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_casa_reserva_inform`
--

/*!50001 DROP VIEW IF EXISTS `view_casa_reserva_inform`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_casa_reserva_inform` AS select `reserva_casa`.`IdReserva` AS `IdReserva`,`reserva_casa`.`IdCasa` AS `IdCasa`,`casa`.`Propietario` AS `Propietario`,`casa`.`Direccion` AS `Direccion`,`ciudad`.`Name` AS `Localidad`,`reserva_casa`.`PrecioAcordado` AS `PrecioHab`,(`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`) AS `Noches`,`reserva_casa`.`Habitaciones` AS `Cuartos`,`reserva_casa`.`Depositado` AS `Pagado`,((`reserva_casa`.`PrecioAcordado` * `reserva_casa`.`Habitaciones`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`)) AS `Precio` from ((`reserva_casa` join `casa` on((`reserva_casa`.`IdCasa` = `casa`.`IdCasa`))) join `ciudad` on((`casa`.`IdCiudad` = `ciudad`.`IdCiudad`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_reservas_pago`
--

/*!50001 DROP VIEW IF EXISTS `view_reservas_pago`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_reservas_pago` AS select `reserva`.`IdReserva` AS `IdReserva`,`reserva`.`Nombre` AS `Nombre`,`reserva`.`Correo` AS `Correo`,`pais`.`Nombre` AS `Pais`,(`reserva`.`FechaEntrada` + interval `reserva`.`Noches` day) AS `Salida`,count(`reserva_casa`.`IdCasa`) AS `Casas`,`reserva`.`Noches` AS `Noches`,`reserva`.`Personas` AS `Personas`,`reserva`.`Habitaciones` AS `Cuartos`,format(avg(`reserva_casa`.`PrecioAcordado`),2) AS `PrecioProm`,format(avg(`reserva_casa`.`ComisionAcordada`),2) AS `ComisionProm`,sum(((`reserva_casa`.`Habitaciones` * `reserva_casa`.`PrecioAcordado`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`))) AS `Precio`,sum(((`reserva_casa`.`Habitaciones` * `reserva_casa`.`ComisionAcordada`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`))) AS `Comision`,sum(`reserva_casa`.`DineroCobrado`) AS `Cobrado`,`reserva`.`Deposito` AS `Deposito`,`reserva`.`IdReservaEstado` AS `IdEstado`,`reserva`.`IdReservaTipo` AS `IdReservaTipo`,`reserva`.`IdPais` AS `IdPais`,`reserva_estado`.`Nombre` AS `Estado` from (((`reserva_casa` join `reserva` on((`reserva_casa`.`IdReserva` = `reserva`.`IdReserva`))) join `pais` on((`reserva`.`IdPais` = `pais`.`IdPais`))) join `reserva_estado` on((`reserva`.`IdReservaEstado` = `reserva_estado`.`IdReservaEstado`))) group by `reserva`.`IdReserva` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_resevas_inform`
--

/*!50001 DROP VIEW IF EXISTS `view_resevas_inform`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_resevas_inform` AS select `reserva`.`IdReserva` AS `IdReserva`,`reserva`.`Nombre` AS `Nombre`,`reserva`.`Correo` AS `Correo`,`reserva`.`FechaEntrada` AS `Entrada`,(`reserva`.`FechaEntrada` + interval `reserva`.`Noches` day) AS `Salida`,`reserva`.`Noches` AS `Noches`,`reserva`.`Personas` AS `Personas`,`reserva`.`Habitaciones` AS `Habitaciones`,`reserva`.`VueloInfo` AS `VueloInfo`,`reserva`.`IdReservaTipo` AS `Tipo`,`pais`.`Nombre` AS `Pais` from (`reserva` join `pais` on((`reserva`.`IdPais` = `pais`.`IdPais`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_casas_pagos`
--

/*!50001 DROP VIEW IF EXISTS `view_casas_pagos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_casas_pagos` AS select `casa`.`Propietario` AS `Propietario`,`casa`.`Telef` AS `Telef`,(`reserva`.`FechaEntrada` + interval `reserva_casa`.`DiaSalida` day) AS `Salida`,`reserva_casa`.`Personas` AS `Personas`,`reserva_casa`.`Habitaciones` AS `Habitaciones`,(`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`) AS `nDias`,`casa`.`PrecioHab` AS `PrecioHab`,`casa`.`ComisionHab` AS `ComisionHab`,`reserva_casa`.`PrecioAcordado` AS `PrecioAcordado`,`reserva_casa`.`ComisionAcordada` AS `ComisionAcordada`,((`reserva_casa`.`Habitaciones` * `casa`.`PrecioHab`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`)) AS `PrecioEsp`,((`reserva_casa`.`Habitaciones` * `casa`.`ComisionHab`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`)) AS `ComisionEsp`,((`reserva_casa`.`Habitaciones` * `reserva_casa`.`PrecioAcordado`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`)) AS `PrecioReal`,((`reserva_casa`.`Habitaciones` * `reserva_casa`.`ComisionAcordada`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`)) AS `ComisionReal`,`reserva_casa`.`DineroCobrado` AS `Cobrado`,`reserva`.`IdReservaEstado` AS `IdReservaEstado`,`reserva`.`IdReservaTipo` AS `IdReservaTipo`,`reserva_casa`.`IdReserva` AS `IdReserva`,`reserva_casa`.`IdCasa` AS `IdCasa` from ((`reserva_casa` join `casa` on((`reserva_casa`.`IdCasa` = `casa`.`IdCasa`))) join `reserva` on((`reserva_casa`.`IdReserva` = `reserva`.`IdReserva`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_casa_reserva`
--

/*!50001 DROP VIEW IF EXISTS `view_casa_reserva`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_casa_reserva` AS select `reserva_casa`.`IdReserva` AS `IdReserva`,`reserva_casa`.`IdCasa` AS `IdCasa`,`casa`.`Propietario` AS `Propietario`,`casa`.`Telef` AS `Telef`,`ciudad`.`Name` AS `Localidad`,`reserva`.`Nombre` AS `Nombre`,`reserva`.`Correo` AS `Correo`,`pais`.`Nombre` AS `Pais`,`reserva_casa`.`DiaEntrada` AS `DiaEntrada`,(`reserva`.`FechaEntrada` + interval `reserva_casa`.`DiaEntrada` day) AS `Desde`,(`reserva`.`FechaEntrada` + interval `reserva_casa`.`DiaSalida` day) AS `Hasta`,`reserva_casa`.`Personas` AS `Personas`,`reserva_casa`.`Habitaciones` AS `Cuartos`,((`reserva_casa`.`PrecioAcordado` * `reserva_casa`.`Habitaciones`) * (`reserva_casa`.`DiaSalida` - `reserva_casa`.`DiaEntrada`)) AS `Precio` from ((((`reserva_casa` join `casa` on((`reserva_casa`.`IdCasa` = `casa`.`IdCasa`))) join `ciudad` on((`casa`.`IdCiudad` = `ciudad`.`IdCiudad`))) join `reserva` on((`reserva_casa`.`IdReserva` = `reserva`.`IdReserva`))) join `pais` on((`reserva`.`IdPais` = `pais`.`IdPais`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_casas`
--

/*!50001 DROP VIEW IF EXISTS `view_casas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_casas` AS select `casa`.`IdCasa` AS `IdCasa`,`casa`.`Propietario` AS `Propietario`,`casa`.`Telef` AS `Telef`,`ciudad`.`Name` AS `Localidad`,`casa`.`Personas` AS `Personas`,`casa`.`Habitaciones` AS `Cuartos`,`casa`.`PrecioHab` AS `Precio`,`casa`.`ComisionHab` AS `Comision`,`casa`.`Notas` AS `Notas`,`ciudad`.`IdCiudad` AS `IdCiudad` from (`casa` join `ciudad` on((`casa`.`IdCiudad` = `ciudad`.`IdCiudad`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_resevas`
--

/*!50001 DROP VIEW IF EXISTS `view_resevas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_resevas` AS select `reserva`.`IdReserva` AS `IdReserva`,`reserva`.`IdOperador` AS `IdOperador`,`reserva`.`IdReservaTipo` AS `IdTipo`,`reserva`.`IdReservaEstado` AS `IdEstado`,`reserva`.`IdPais` AS `IdPais`,`operador`.`Nombre` AS `Operador`,`reserva`.`Nombre` AS `Nombre`,`reserva`.`Correo` AS `Correo`,`reserva`.`FechaEntrada` AS `Fecha`,`reserva`.`Noches` AS `Noches`,`reserva`.`Personas` AS `Personas`,`reserva`.`Habitaciones` AS `Habitaciones`,`reserva`.`Deposito` AS `Deposito`,`pais`.`Nombre` AS `Pais`,`reserva_tipo`.`Nombre` AS `Tipo`,`reserva_estado`.`Nombre` AS `Estado`,(select count(0) AS `expr1` from (`reserva_casa` `rs` join `reserva` `r` on((`rs`.`IdReserva` = `r`.`IdReserva`))) where (`r`.`IdReserva` = `reserva`.`IdReserva`)) AS `Casas` from ((((`reserva` join `pais` on((`reserva`.`IdPais` = `pais`.`IdPais`))) join `reserva_tipo` on((`reserva`.`IdReservaTipo` = `reserva_tipo`.`IdReservaTipo`))) join `reserva_estado` on((`reserva`.`IdReservaEstado` = `reserva_estado`.`IdReservaEstado`))) join `operador` on((`reserva`.`IdOperador` = `operador`.`IdOperador`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-24 21:23:22
