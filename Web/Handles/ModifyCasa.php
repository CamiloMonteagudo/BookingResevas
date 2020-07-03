<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  exit(0);

$find    = array("\\"      , "\r\n"    , "\n"      , "\r"      , "\""      , "'"       );
$replace = array("\\\u005C", "\\\u000A", "\\\u000A", "\\\u000A", "\\\u0022", "\\\u0027" );

$Propiet = str_replace($find, $replace,  $_POST["Propiet"]);
$Telef   = str_replace($find, $replace,  $_POST["Telef"]);
$Notas   = str_replace($find, $replace,  $_POST["Notas"]);
$Direc   = str_replace($find, $replace,  $_POST["Direcc"]);

$Params  = $_POST["IdLoc"].", '".$Propiet."', '".$Telef."', ".$_POST["Cuartos"].", ";
$Params .= $_POST["Persons"].", ".$_POST["Precio"].", ".$_POST["Comision"].", '".$Direc."', '".$Notas."'";
               
if( empty($_POST["IdCasa"]) )
  $Cmd = "CALL AddCasa($Params)";
else
  {
  $Params = $_POST["IdCasa"].", ".$Params;  
  $Cmd = "CALL ModifyCasa($Params)";
  }  

include 'OpenDb.php';   

//echo($Cmd);

mysqli_query($myDB, $Cmd) or die(mysqli_error($myDB));
mysqli_close($myDB);

echo("OK");
?>
