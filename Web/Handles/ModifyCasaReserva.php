<?php 
session_start();
if( empty($_SESSION["UserName"]) || empty($_GET["IdReserv"]) || empty($_GET["IdCasa"])) 
  exit(0);

include 'OpenDb.php';   

$IdReserv = $_GET["IdReserv"];
$IdCasa = $_GET["IdCasa"];
$FromDiaOld = $_GET["FromDiaOld"];
$Confirm = 0;
if( !empty($_POST["Confirmada"]) && $_POST["Confirmada"]=="on") $Confirm = 1;

$CpyProp = 0;
if( !empty($_POST["CopiaP"]) && $_POST["CopiaP"]=="on") $CpyProp = 1;

$find    = array("\\"      , "\r\n"    , "\n"      , "\r"      , "\""      , "'"       );
$replace = array("\\\u005C", "\\\u000A", "\\\u000A", "\\\u000A", "\\\u0022", "\\\u0027" );

$Observ = str_replace($find, $replace,  $_POST["Observ"]);

$Params  = $FromDiaOld.", ".$IdReserv.", ".$IdCasa.", ".$_POST["FromDia"].", ".$_POST["ToDia"].", ".$_POST["Personas"].", ";
$Params .= $_POST["Cuartos"].", ".$_POST["Precio"].", ".$_POST["Comision"].", ".$_POST["Cobrado"].", ".$CpyProp.", ";
$Params .= $Confirm.", '".$Observ."', ".$_POST["Deposito"];

mysqli_query($myDB, "CALL ModifyCasaReserva($Params)") or die(mysqli_error($myDB));

mysqli_close($myDB);

header( 'Location: ../EditReserva.php?IDResrv='.$IdReserv);
?>
