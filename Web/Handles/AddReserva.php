<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  exit(0);

$userID = $_SESSION['UserID'];

include 'OpenDb.php';   

$bTrasf = 0;
if( !empty($_POST["Trasfer"]) && $_POST["Trasfer"]=="on") $bTrasf = 1;

$find    = array("\\"      , "\r\n"    , "\n"      , "\r"      , "\""      , "'"       );
$replace = array("\\\u005C", "\\\u000A", "\\\u000A", "\\\u000A", "\\\u0022", "\\\u0027" );

$Nombre = str_replace($find, $replace,  $_POST["Nombre"]);
$Correo = str_replace($find, $replace,  $_POST["Correo"]);
$Observ = str_replace($find, $replace,  $_POST["Observ"]);
$VueloInfo = str_replace($find, $replace,  $_POST["VueloInfo"]);

$Params  = $userID.", ".$_POST["Tipo"].", ".$_POST["lstPais"].", '".$Nombre."', '".$Correo."', '";
$Params .= $_POST["fEntra"]."', ".$_POST["dias"].", ".$_POST["Personas"].", ".$_POST["Cuartos"].", ".$bTrasf.", ";
$Params .= $_POST["Deposito"].", '".$VueloInfo."', '".$Observ."'";

$resp = mysqli_query($myDB, "CALL AddReserva($Params)") or die(mysqli_error($myDB));
$row = mysqli_fetch_array($resp, MYSQLI_ASSOC);

$IdReserv = $row["IdReserva"];

mysqli_free_result($resp);
mysqli_close($myDB);

header( 'Location: ../EditReserva.php?IDResrv='.$IdReserv);
?>
