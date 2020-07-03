<?php
  global $myDB;

  $myDB = mysqli_connect("localhost", "root", "", "booking_reserva");

  if( mysqli_connect_errno()) 
    {
    printf('Error al abrir la base de datos: %s\n', mysqli_connect_error());
    exit();
    }
?>