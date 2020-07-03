<?php 
session_start();
if( empty($_SESSION["UserName"]) || empty($_GET["IdReserv"])) 
  {
  header( 'Location: index.php' ) ;
  exit(0);
  }   

include 'OpenDb.php';   

$bTrasf = 0;
if( !empty($_POST["Trasfer"]) && $_POST["Trasfer"]=="on") $bTrasf = 1;

$find    = array("\\"      , "\r\n"    , "\n"      , "\r"      , "\""      , "'"       );
$replace = array("\\\u005C", "\\\u000A", "\\\u000A", "\\\u000A", "\\\u0022", "\\\u0027" );

$Nombre = str_replace($find, $replace,  $_POST["Nombre"]);
$Correo = str_replace($find, $replace,  $_POST["Correo"]);
$Observ = str_replace($find, $replace,  $_POST["Observ"]);
$VueloInfo = str_replace($find, $replace,  $_POST["VueloInfo"]);

$Params  = $_GET["IdReserv"].", ".$_POST["Tipo"].", ".$_POST["lstPais"].", '".$Nombre."', '".$Correo."', '";
$Params .= $_POST["fEntra"]."', ".$_POST["dias"].", ".$_POST["Personas"].", ".$_POST["Cuartos"].", ".$bTrasf.", ";
$Params .= $_POST["Deposito"].", '".$VueloInfo."', '".$Observ."'";

//echo $Params."<br/>";

mysqli_query($myDB, "CALL ModifyReserva($Params)") or die(mysqli_error($myDB));
mysqli_close($myDB);

header( 'Location: ../EditReserva.php?IDResrv='.$_GET["IdReserv"] );
?>
