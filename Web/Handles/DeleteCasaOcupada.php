<?php 
session_start();
if( empty($_SESSION["UserName"]) || empty($_POST["IdCasa"])) 
  {
  echo "El usuario no esta logeado o falta identificador de la casa";
  exit(0);
  }

include 'OpenDb.php';   

$Params  = $_POST["IdCasa"].",'".$_POST["FIni"]."'";

//echo $Params;

mysqli_query($myDB, "CALL DeleteCasaOcupada($Params)") or die(mysqli_error($myDB));

mysqli_close($myDB);

echo "OK";
?>
