<!doctype html>
<html lang="es">
<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  {
  header( 'Location: index.php' );
  exit(0);
  }
  
$Datos = "<script> Datos= { ";
$Datos .= "UserName:'".$_SESSION['UserName']."', ";
$Datos .= "Perms:".$_SESSION["Permisos"];
$Datos .= " }; </script>";

echo $Datos;
?>

<head>
<title>Estadística de reservaciones por operador</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="MyStyles.css" rel="stylesheet" type="text/css">
</head>

<body>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="ListReservas.php">Booking Reserva</a>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Entrada de Datos <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="EditReserva.php">Nueva Reservacion</a> </li>
            <li><a href="EditCasa.php">Nueva Casa</a> </li>
            <li><a href="javascript:OnUpdateEstados()">Actualizar Estados</a> </li>
          </ul>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Consultas <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="ReservasFilter.php">Listado de Reservaciones</a> </li>
            <li><a href="Casas.php">Listado Casas</a> </li>
            <li><a href="CasasOcupadas.php">Listado Casas Ocupadas</a> </li>
            <li><a href="CasasReservadas.php">Listado Casas Reservadas</a> </li>
            <li class="divider admin"></li>
            <li class="admin"><a href="PagosPorCasas.php">Pagos por casas</a> </li>
            <li class="admin"><a href="PagosPorReserva.php">Pagos por reservaciones</a> </li>
            <li class="divider"></li>
            <li><a href="ReservasCancelables.php">Reservaciones Cancelables</a> </li>
          </ul>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administar <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="ListOperadores.php">Operadores</a> </li>
            <li><a href="ListCasas.php">Casas</a></li>
            <li><a href="ListLocalidades.php">Localidades</a> </li>
            <li><a href="ListPaises.php">Paises</a> </li>
            <li class="divider admin"></li>
            <li class="admin"><a href="ReservaOperador.php">Reservaciones por operador</a> </li>
          </ul>
        </li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span id="UserName" style="font-weight: 600; color: #000000;"></span></a> </li>
        <li><a href="Handles/UserOut.php">Salir</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>

<div class="panel panel-info center-block" style="max-width:850px">
  <div class="panel-heading">
    <div class="panel-title">
      <span class="cond-title">Reservaciones por Operador</span> 
      <span class="cond-item" >Mes:<a id="fMes" href='javascript:OpenDlg("#dlgMes");'>Este mes</a></span> 
      <span id="fLocalId" style="display:none;"></span> 
    </div>
  </div>

  <div class="panel-body"> 
    <table class='table'>
      <thead><tr><th>Operador</th><th>Reservas</th><th>Casas</th><th>Noches</th><th>Personas</th><th>Cuartos</th><th>Activas</th><th>Cobradas</th><th>Canceladas</th></thead>
        <tbody id="lstCasasBody">
        </tbody>
    </table>  
  </div>
  
  <div class="panel-footer">
    <div class="btn-group sel-orden" role="group">
    </div>
    <div class="btn-group block-right" role="group" style="top:-37px;">
      <button type="button" id="btnPrev" class="btn btn-default">&lt;</button>
      <button type="button" id="btnNext" class="btn btn-default">&gt;</button>
    </div>
  </div>

</div>

<!--Dialogo filtrar por Meses-->  
<div id="dlgMes" title="Filtrar por Meses" style="padding:0px; width:500px;">
  <div class="container-fluid" style1="margin:0px; padding:0px;">
    <div class="row">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Año:</span>
        <select id="lstAnos" name="lstAnos" class="form-control" onChange="FindCasaByLoc();" >
          <option value='2016'>2016</option>
          <option value='2017'>2017</option>
          <option value='2018'>2018</option>
          <option value='2019'>2019</option>
          <option value='2020'>2020</option>
          <option value='2021'>2021</option>
          <option value='2022'>2022</option>
          <option value='2023'>2023</option>
          <option value='2024'>2024</option>
          <option value='2025'>2025</option>
          <option value='2026'>2026</option>
        </select>
      </div></div>
    </div>
    
    <div class="row">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Mes:</span>
        <select id="lstMeses" name="lstMeses" class="form-control" onChange="FindCasaByLoc();" >
          <option value='0'>Enero</option>
          <option value='1'>Febrero</option>
          <option value='2'>Marzo</option>
          <option value='3'>Abril</option>
          <option value='4'>Mayo</option>
          <option value='5'>Junio</option>
          <option value='6'>Julio</option>
          <option value='7'>Agosto</option>
          <option value='8'>Septiembre</option>
          <option value='9'>Octubre</option>
          <option value='10'>Noviembre</option>
          <option value='11'>Diciembre</option>
          <option value='12'>Todos</option>
        </select>
      </div></div>
    </div>
    
  </div>
</div>

</div>

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.ui.datepicker-es.js"></script>
<script src="js/FechasRange.js"></script>

<script type="text/javascript">

var sMes = "1";
var sAno = "2016";

var Page = 0;  
var nRec = 30;  
var nPages = 1000;  
var FechaTipo = 0;  

var DatesOcup, DatesFilter;
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  $("#btnPrev").click( function() { if(Page>0     ) DoQuery(--Page);} );
  $("#btnNext").click( function() { if(Page<nPages) DoQuery(++Page);} );
    
  $("#UserName").text( Datos.UserName ); 
  
  DefaultPeriodo();

  DoQuery(-1);  
  });

function OpenDlg( id )
  {
	$(id).dialog( "open" );
  }
  
$("#dlgMes").dialog({ autoOpen:false,	width:250, buttons:[ {text:"Filtar", click:CloseDlgMes},] });
   
function CloseDlgMes()
  {
	$("#dlgMes").dialog( "close" );

  sMes = $("#lstMeses").val();  
  sAno = $("#lstAnos").val();  

  $("#fMes").text( Meses[ parseInt(sMes) ] + " " + sAno );
    
  DoQuery(-1);  
  }

function DefaultPeriodo() 
  {
  var now = new Date();
  
  sMes = String( now.getMonth() );  
  sAno = String( now.getYear() + 1900 );  

  $("#fMes").text( Meses[ parseInt(sMes) ] + " " + sAno );
  }
  
function DoQuery( page )
  {
  if( page == -1) 
    {
    page = 0;  
    nPages = 10000;
    } 
    
  var sQuery = "CALL ReservaOperador("+ sMes +", "+ sAno +" )";
    
  jQuery.post( "Handles/SelectRows.php", "Query=" + sQuery )
  .success(function(data) 
            {
            if( data.substr(0, 2)=="({" )
              {  
              FillTable( data, page );
    
              showBtns();
              }
            else
              {
              alert("Error al realizar la consulta:\r\n" + data ); 
              }  
            })
  .error(function(data) 
           { 
           alert("Error al realizar la consulta:\r\n" + data.statusText ); 
           });
  
  }  

function FillTable( data, page )
  {
  try
    {  
    var ret = eval(data);
    var nRows = ret.rows.length;
    if( nRows>0 || page==0) 
      {
      var sHtml = "";
      for( i=0; i<nRows; ++i )    
        {
        var row = ret.rows[i];  
        
        sHtml += "<tr>"; 
        sHtml += "<td >" + row[1] + "</td>";
        sHtml += "<td style='width:60px;'>" + row[2] + "</td>";
        sHtml += "<td style='width:60px;'>" + row[3] + "</td>";
        sHtml += "<td style='width:60px;'>" + row[4] + "</td>";
        sHtml += "<td style='width:60px;'>" + row[5] + "</td>";
        sHtml += "<td style='width:60px;'>" + row[6] + "</td>";
        sHtml += "<td style='width:95px;'>" + PorCien(row[7],row[2]) + "</td>";
        sHtml += "<td style='width:95px;'>" + PorCien(row[8],row[2]) + "</td>";
        sHtml += "<td style='width:95px;'>" + PorCien(row[9],row[2]) + "</td>";
        sHtml += "</tr>"; 
//   1        2        3      4        5        6        7         8          9
// Nombre, Reservas, Casas, Noches, Personas, Cuartos, Activas, Terminadas, Canceladas
        }
        
      $("#lstCasasBody").html(sHtml);
      Page = page;
      }
       
    if( nRows==0 ) nPages = page-1; 
    else if( nRows<nRec )  nPages = page; 
    }
  catch (e)
    {
    alert("Error procesando los datos del servidor:\r\n" + e ); 
    }
  }

function PorCien( num, total )
  {
  if( num=="0" || total=="0")  
    return "0 (0 %)";
    
  return num + " (" + parseInt( (num*100)/total )+ " %)";  
  }
  
function showBtns()
  {
  var visNext = (Page>=nPages)? "hidden" : "visible";
  var visPrev = (Page<=0     )? "hidden" : "visible";
  
  $("#btnNext").css("visibility", visNext);
  $("#btnPrev").css("visibility", visPrev);
  }

function OnUpdateEstados()   
  {
  jQuery.post( "Handles/SelectRows.php", "Query=CALL UpdateEstado(0)")
  .success(function(data) 
            {
            if( data.substr(0, 2)=="({" )
              {  
              var ret = eval(data);
              var row = ret.rows[0];  
              alert( "ESTADOS ACTUALIZADOS:\r\n\r\n" + 
                     "Reservaciones en Proceso:"+row[0]+"\r\n" + 
                     "Reservaciones Tramitadas:"+row[1]+"\r\n" + 
                     "Reservaciones en Curso:"+row[2]+"\r\n" + 
                     "Reservaciones Concluidas:"+row[3]+"\r\n" + 
                     "Reservaciones Cobradas:"+row[4]+"\r\n" + 
                     "Reservaciones Cancelables:"+row[5]+"\r\n"  
                    ); 
                    
              document.location = document.location;     
              }
            else
              {
              alert("Error al actualizar el estado:\r\n" + data ); 
              }  
            })
  .error(function(data) 
           { 
           alert("Error al actualizar el estado:\r\n" + data.statusText ); 
           });
  }
  
</script>  

</body>
</html>