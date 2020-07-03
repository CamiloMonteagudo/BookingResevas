<?php
  session_start();
  $_SESSION["UserName"] = NULL; 
  
  header( 'Location: ../index.php' ) ;
?>