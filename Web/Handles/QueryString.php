<?php 
$TableRows ="";
$nRows = 0;  
   
include 'OpenDb.php';   

$Tipo = "";
if( !empty($_POST["Tipo"]) ) $Tipo = $_POST["Tipo"];

$resp = mysqli_query($myDB, $_POST["Query"]) or die(mysqli_error($myDB));
while( $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
  {
  $nField = 0;  
  foreach( $row as $filed) 
    {
    if( $nField == 0)  
      {
      if( $Tipo == "COcupada")
        $TableRows .= "<tr onClick='OnClickLista(".$row["IdCasa"].", \u0022".$row["FechaIni"]."\u0022);'>";
      else if( $Tipo == "CReservada")
        $TableRows .= "<tr onClick='OnClickLista(".$row["IdCasa"].", ".$row["IdReserva"].");'>";
      else
        $TableRows .= "<tr onClick='OnClickLista(".$filed.");'>";
      }
    else  
      {
      if( $nField != 1 || $Tipo != "CReservada" )  
        $TableRows .= "<td>".$filed."</td>";
      }
      
    ++$nField;  
    }
    
  $TableRows .= "</tr>";
  ++$nRows;
  }
  
mysqli_free_result($resp);
mysqli_close($myDB);

echo '({rows:"'.$TableRows.'", nRows:'.$nRows.'})';
?>
