<?php 
session_start();
if( empty($_SESSION["UserName"]) || empty($_GET["IdCasa"])) 
  exit(0);

include 'OpenDb.php';   

$Params  = $_GET["IdCasa"].",".$_GET["FIni"].",".$_GET["FEnd"].",".$_GET["Hab"];

//echo $Params;

mysqli_query($myDB, "CALL MarkCasaOcupada($Params)") or die(mysqli_error($myDB));

mysqli_close($myDB);

echo "OK";
?>
