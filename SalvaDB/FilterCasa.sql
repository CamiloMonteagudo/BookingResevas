CREATE DEFINER=`root`@`localhost` PROCEDURE `FilterCasas`(IN pFechaIni DATE, IN pNDias INT(2), IN pPropietario VARCHAR(255), IN pLocalidad INT(2), IN pCuartos INT(2))
BEGIN

DECLARE pFechaEnd DATE;
DECLARE SkipProp bool;

SET pFechaEnd = DATE_ADD(pFechaIni, INTERVAL pNDias DAY);

IF ISNULL(pPropietario) OR LENGTH(pPropietario)=0 THEN
  SET SkipProp = TRUE;
ELSE
  SET SkipProp = FALSE;
END IF;

SELECT
  casa.IdCasa,
  casa.IdCiudad,
  casa.Propietario,
  casa.Telef,
  casa.Habitaciones,
  casa.Personas,
  casa.PrecioHab AS Precio,
  casa.ComisionHab AS Comision,
  ciudad.Name AS Localidad,
  casa.Direccion,
  casa.Notas,
  CasaYaReservada(casa.IdCasa, pFechaIni, pFechaEnd) as enUso
FROM casa
  INNER JOIN ciudad
    ON casa.IdCiudad = ciudad.IdCiudad
WHERE NOT CasaOcupada(casa.IdCasa, pFechaIni, pFechaEnd, pCuartos)
/*AND NOT CasaYaReservada(casa.IdCasa, pFechaIni, pFechaEnd)*/
AND (SkipProp=TRUE OR casa.Propietario LIKE pPropietario)
AND (pLocalidad<=0 OR casa.IdCiudad = pLocalidad)
AND (pCuartos<=0 OR casa.Habitaciones >= pCuartos)
ORDER BY casa.Propietario
;

END