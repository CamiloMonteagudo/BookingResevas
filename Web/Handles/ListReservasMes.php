<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php 
$ResvTable ="<tbody>";
   
session_start();
include 'OpenDb.php';   

$StartMes = (empty($_GET["StartMes"]))? 0 : $_GET["StartMes"];
$IdUser   = (empty($_GET["AllUsers"]))? $_SESSION["UserID"] : 0;

$Params  = $IdUser.", ".$StartMes;
//echo $Params."<br/>";
//$Params  = "2, 0";
  
$find    = array("\\u005C", "\\u000A", "\\u000A", "\\u000A", "\\u0022", "\\u0027" );
$replace = array("\\"      , "\r\n"    , "\n"      , "\r"      , "\""      , "'"  );

$resp = mysqli_query($myDB, "CALL ReservasMesuales($Params)") or die(mysqli_error($myDB));
while( $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
  {
  $ResvTable .= "<tr onClick='OnClickReserva(" .$row["IdReserva"] .");'>";
  $ResvTable .= "<th scope='row' style='white-space:nowrap;'>" .$row["IdReserva"];
  if( $IdUser == 0 ) $ResvTable .= " (".$row["IdOperador"].")";
  
  $Nombre   = str_replace($find, $replace,  $row["Nombre"]);
  $Correo   = str_replace($find, $replace,  $row["Correo"]);
  
  $ResvTable .= "</th>";
  $ResvTable .= "<td>" .$Correo."</td>";
  $ResvTable .= "<td>" .$Nombre."</td>";
  $ResvTable .= "<td>" .$row["Pais"] ."</td>";
  $ResvTable .= "<td>" .$row["fReserva"] ."</td>";
  $ResvTable .= "<td>" .$row["fEntrada"] ."</td>";
  $ResvTable .= "<td>" .$row["Noches"] ."</td>";
  $ResvTable .= "<td>" .$row["Personas"] ."</td>";
  $ResvTable .= "<td>" .$row["Habitaciones"] ."</td>";
  $ResvTable .= "<td>" .$row["Tipo"] ."</td>";
  $ResvTable .= "<td>" .$row["Estado"] ."</td>";
  $ResvTable .= "</tr>";
  }
  
$ResvTable .= "</tbody>";
 
mysqli_free_result($resp);
mysqli_close($myDB);

echo $ResvTable;
?>
</body>
</html>