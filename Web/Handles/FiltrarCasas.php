<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<table id="lstCasas" class='table'>
  <thead><tr><th>Localidad</th><th>Propietario</th><th>Telefono</th><th>Habitaciones</th><th>Personas</th><th>Precio</th><th colspan='2'>Comisión</th></thead>
    <tbody id="lstCasasBody">
      <?php 
      include 'OpenDb.php';   
      
      $find    = array("\\u005C", "\\u000A", "\\u000A", "\\u000A", "\\u0022", "\\u0027" );
      $replace = array("\\"      , "\r\n"    , "\n"      , "\r"      , "\""      , "'"  );

      $Params  = "'".$_GET["FechaIni"]."', ".$_GET["NDias"].", '".$_GET["Propietario"]."', ".$_GET["Localidad"].", ".$_GET["Cuartos"];
        
      $resp = mysqli_query($myDB, "CALL FilterCasas($Params)") or die(mysqli_error($myDB));
    
      if( $resp ) 
        {
        while( $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
          {
          $Id = $row["IdCasa"]; 
          
          $IdPropiet  = "<td id='Propietario".$Id."'>";
          $sPropiet   = str_replace($find, $replace,  $row["Propietario"]);
          
          $IdPrecio   = "<td id='Precio".$Id."'>";
          $IdComision = "<td id='Comision".$Id."' style='padding-right:0px; width:10px;'>";
          $RowClas    = ($row["enUso"])? "class='enUso' " : "" ; 
          $Link       = ($row["enUso"])? " <a href='CasasReservadas.php?IdCasa=".$Id."&FechaIni=".$_GET["FechaIni"]."&NDias=".$_GET["NDias"]."' target='new' title='Revisar reservaciones de la casa'> &gt;&gt; </a> " : "" ; 
          
          echo "<tr onClick='OnSelectCasa(".$Id.");' title='".$row["Notas"]."' ".$RowClas.">";
          echo "<th scope='row'>".$row["Localidad"]."</th>";
          echo $IdPropiet.$sPropiet."</td>";
          echo "<td>" .$row["Telef"]."</td>";
          echo "<td>" .$row["Habitaciones"] ."</td>";
          echo "<td>" .$row["Personas"]."</td>";
          echo $IdPrecio.$row["Precio"]."</td>";
          echo $IdComision.$row["Comision"]."</td>";
          echo "<td style='padding-right:0px; padding-left:0px; width:10px;'>".$Link."</td>";
          echo "</tr>";
          }
        } 
        
      mysqli_free_result($resp);
      mysqli_close($myDB);
      ?>
    </tbody>
</table>  

<body>
</body>
</html>