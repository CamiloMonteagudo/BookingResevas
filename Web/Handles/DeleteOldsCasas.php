<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  exit(0);

include 'OpenDb.php';   

mysqli_query($myDB, "CALL DeleteOldsCasas()") or die(mysqli_error($myDB));

mysqli_close($myDB);

echo "OK";
?>
