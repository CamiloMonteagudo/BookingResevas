<?php 
session_start();
if( empty($_SESSION["UserName"]) || empty($_GET["IdReserv"]) || empty($_GET["IdCasa"])) 
  exit(0);

include 'OpenDb.php';   

$IdReserv = $_GET["IdReserv"];
$IdCasa = $_GET["IdCasa"];
$DiaIni = $_GET["DiaIni"];

$Params  = $IdReserv.", ".$IdCasa.", ".$DiaIni;

mysqli_query($myDB, "CALL DeleteCasaReserva($Params)") or die(mysqli_error($myDB));

mysqli_close($myDB);

if( empty($_GET["JSon"]) )
  header( 'Location: ../EditReserva.php?IDResrv='.$IdReserv);
else
  {
  echo "OK";
  }  
?>
