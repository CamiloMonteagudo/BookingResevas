<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  exit(0);

$Params  = "'".$_POST["Nombre"]."', '".$_POST["PassWord"]."', '".$_POST["Correo"]."', '".$_POST["Telefono"]."', ";
$Params .= $_POST["Permisos"].", ".$_POST["Ganacia"];
               
if( empty($_POST["IdOperador"]) )
  $Cmd = "CALL AddOperador($Params)";
else
  {
  $Params = $_POST["IdOperador"].", ".$Params;  
  $Cmd = "CALL ModifyOperador($Params)";
  
  if( $_SESSION["UserID"] = $_POST["IdOperador"] )
    $_SESSION["Permisos"] = $_POST["Permisos"]; 
  }  

include 'OpenDb.php';   

mysqli_query($myDB, $Cmd) or die(mysqli_error($myDB));
mysqli_close($myDB);

echo("OK");
?>
