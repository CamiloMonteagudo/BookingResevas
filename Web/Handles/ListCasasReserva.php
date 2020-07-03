<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<table id="lstCasas" class='table'>
    <table id="lstCasas" class='table'>
    <thead><tr>
      <th>Localidad</th>
      <th>Propietario</th>
      <th style="width: 90px;" title="Día de entrada a la casa">Dia Ent.</th>
      <th style="width: 90px;" title="Dia de salida de la casa">Dia Sal.</th>
      <th style="width: 40px;" title="Cantidad de habitaciones">Hab.</th>
      <th style="width: 40px;" title="Cantidad de Personas">Per.</th>
      <th style="width: 40px;" title="Si la reservación esta confirmada">Conf.</th>
      <th style="width: 60px;" title="Deposito para el pago de la casa">Depos.</th>
      <th style="width: 60px;" title="Cosion que ha sido cobrada">Cobrd.</th>
    </thead>
    <tbody>
      <?php 
      $FechaEnt = mktime(0,0,0, $_GET["EntMes"]+1, $_GET["EntDia"], $_GET["EntAno"]);
        
      include 'OpenDb.php';   
      
      $Params  = $_GET["IDResrv"];
        
      $find    = array("\\u005C", "\\u000A", "\\u000A", "\\u000A", "\\u0022", "\\u0027" );
      $replace = array("\\"      , "\r\n"    , "\n"      , "\r"      , "\""      , "'"  );

      $resp = mysqli_query($myDB, "CALL ListCasasPorReserva($Params)") or die(mysqli_error($myDB));
       
      if( $resp ) 
        {
        while( $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
          {
          $Id = $row["IdCasa"]; 
          $Confirmada = ($row["Confirnada"]!=0)? "Si" : "No";
          $EntDay = DayStr($row["DiaEntrada"]);
          $SalDay = DayStr($row["DiaSalida"]);
          $sPropiet   = str_replace($find, $replace,  $row["Propietario"]);
          
          echo "<tr onClick='OnSelectCasa(".$Id.",".$row["DiaEntrada"].");' title='".$row["Notas"]."'>";
          echo "<th scope='row'>" .$row["Localidad"] ."</th>";
          echo "<td>" .$sPropiet."</td>";
          echo "<td>" .$EntDay."</td>";
          echo "<td>" .$SalDay."</td>";
          echo "<td>" .$row["Habitaciones"] ."</td>";
          echo "<td>" .$row["Personas"] ."</td>";
          echo "<td>" .$Confirmada."</td>";
          echo "<td>" .$row["Depositado"] ."</td>";
          echo "<td>" .$row["DineroCobrado"] ."</td>";
          echo "</tr>";
          }
        } 
        
      mysqli_free_result($resp);
      mysqli_close($myDB);

      function DayStr($day)
        {
        static $Dias = array("Dom", "Lun", "Mar", "Mie", "Juv", "Vie", "Sab");  
        global $FechaEnt;  
        
        $newDate = $FechaEnt + (86400 * $day);
        $date_array = getdate($newDate);
        
        return $day ." (".$Dias[ $date_array["wday"]]." ".$date_array["mday"].")" ;
        }
      ?>
    </tbody>
</table>  

<body>
</body>
</html>