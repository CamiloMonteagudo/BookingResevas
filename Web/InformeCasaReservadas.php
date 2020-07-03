<!doctype html>
<html lang="es">
<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  {
  header( 'Location: index.php' );
  exit(0);
  }

if( empty($_GET["mes"]) )  $mes = -1;
else                       $mes = $_GET["mes"];
  
if( empty($_GET["ano"]) )  $ano = -1;
else                       $ano = $_GET["ano"];
  
$Datos = "<script> Datos= { ";
$Datos .= "mes:".$mes.", ";
$Datos .= "ano:".$ano.", ";
$Datos .= "UserName:'".$_SESSION['UserName']."', ";
$Datos .= "Perms:".$_SESSION["Permisos"];
$Datos .= " }; </script>";

echo $Datos;
?>

<head>
<title>Informe de casas reservadas</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="MyStyles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table class='table'>
  <thead><tr>
    <th title="Datos de la casa">Casa</th>
    <th title="Datos de la reservación">Reservación</th>
    <th style='width:60px; white-space: nowrap;' title="Día de entrada a la casa">Desde</th>
    <th style='width:60px; white-space: nowrap;' title="Día de salida de la casa">Hasta</th>
    <th style='width:10px; white-space: nowrap;' title="Número de noches reservadas">N.</th>
    <th style='width:10px; white-space: nowrap;' title="Número de habitaciones reservadas">H.</th>
    <th style='width:10px; white-space: nowrap;' title="Número de Personas">P.</th>
    <th style='width:10px; white-space: nowrap;' title="Precio total acordado">Precio</th>
    <th style='width:10px; white-space: nowrap;' title="Comisión total acordada">Comisión</th>
  </thead>
  <tbody id="lstCasasBody">
  </tbody>
</table>  

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script type="text/javascript">
var FilterMes = "";
var sOrder = "ORDER BY Localidad"; 

$(function() 
  {
  DefaultPeriodo();

  DoQuery();  
  });

function DefaultPeriodo() 
  {
  var now = new Date();
  
  if( Datos.mes<0 || Datos.mes>11 ) Datos.mes = now.getMonth();
  if( Datos.ano<0                 ) Datos.mes = now.getYear() + 1900;
  
  MakeMesFilter( Datos.ano, Datos.mes ); 
  }
  
function MakeMesFilter( ano, mes ) 
  {
  var fIni = ano + '-' + (mes+1) + '-1';
  var fEnd = ano + '-' + (mes+2) + '-1';
  
  FilterMes = "Hasta>='" + fIni + "' AND Hasta<'" + fEnd + "' ";
  }
  
function DoQuery()
  {
  var sQuery = "SELECT IdReserva, IdCasa, DiaEntrada, Propietario, Localidad, Telef, Nombre, Correo, Pais, Desde, Hasta, Noches, Cuartos, Personas, Precio, Comision FROM view_casa_reserva ";
 
  sQuery += ("WHERE " + escape(FilterMes +" AND Estado=5 ")); 
  sQuery += (sOrder + " LIMIT 0, 50");
    
  jQuery.post( "Handles/SelectRows.php", "Query=" + sQuery )
  .success(function(data) 
            {
            if( data.substr(0, 2)=="({" )
              FillTable( data );
            else
              alert("Error al realizar la consulta:\r\n" + data ); 
            })
  .error(function(data) 
           { 
           alert("Error al realizar la consulta:\r\n" + data.statusText ); 
           });
  
  }  

function FillTable( data )
  {
  try
    {  
    var ret = eval(data);
    var nRows = ret.rows.length;

    var sHtml = "";
    for( i=0; i<nRows; ++i ) 
      {
      var row = ret.rows[i];  
      
      sHtml += "<tr>"; 
      sHtml += "<td>" + row[3] + ", " + row[4] + " (" + row[5] + ")</td>";
      sHtml += "<td>" + row[6] + ", " + row[8] + " (" + row[7] + ")</td>";
      sHtml += "<td>" + FormatDate( row[9] )+ "</td>";
      sHtml += "<td>" + FormatDate( row[10] ) + "</td>";
      sHtml += "<td>" + row[11] + "</td>";
      sHtml += "<td>" + row[12] + "</td>";
      sHtml += "<td>" + row[13] + "</td>";
      sHtml += "<td>" + row[14] + "</td>";
      sHtml += "<td>" + row[15] + "</td>";
      sHtml += "</tr>"; 
//                        0         1         2            3            4        5       6      7      8      9     10      11       12       13       14      15
//var sQuery = "SELECT IdReserva, IdCasa,  DiaEntrada, Propietario, Localidad, Telef, Nombre, Correo, Pais, Desde, Hasta, Noches, Cuartos, Personas, Precio, Comision 
      }
   
    $("#lstCasasBody").html(sHtml);
    }
  catch (e)
    {
    alert("Error procesando los datos del servidor:\r\n" + e ); 
    }
  }

var Meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
  
function FormatDate( sfecha )
  {
  var fecha = new Date(sfecha);  
  
  var dia  = fecha.getDate();
  var mes  = fecha.getMonth();
  
  return  dia + ' ' + Meses[mes];  
  }
    
  
</script>  

</body>
</html>