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

if( !empty($_GET["IdCasa"]) ) 
  $Datos .= ", IdCasa:".$_GET["IdCasa"];

if( !empty($_GET["FechaIni"]) ) 
  $Datos .= ", FechaIni:'".$_GET["FechaIni"]."'";

if( !empty($_GET["NDias"]) ) 
  $Datos .= ", NDias:".$_GET["NDias"];

$Datos .= " }; </script>";

echo $Datos;
?>

<head>
<title>Listado de casas reservadas</title>

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

<div class="panel panel-info center-block" style="max-width:1400px">
  <div class="panel-heading">
    <div class="panel-title">
      <span class="cond-title">Casas Reservadas</span> 
      <span class="cond-item" >Propietario:<a id="fProp" href='javascript:OpenDlg("#dlgProp");'    >Todos</a></span> 
      <span class="cond-item" >Telefono:   <a id="fTelef" href='javascript:OpenDlg("#dlgTelef");'  >Todos</a></span> 
      <span class="cond-item" >Reserva:    <a id="fReserv" href='javascript:OpenDlg("#dlgReserv");'>Todos</a></span> 
      <span class="cond-item" >Correo:     <a id="fCorreo" href='javascript:OpenDlg("#dlgCorreo");'>Todos</a></span> 
      <span class="cond-item" >Mes:        <a id="fMes" href='javascript:OpenDlg("#dlgMes");'      >Este mes</a></span> 
      <span class="cond-item" >Precio:     <a id="fPrecio" href='javascript:OpenDlg("#dlgPrecio");'>Todos</a></span> 
    </div>
  </div>

  <div class="panel-body"> 
    <table class='table'>
      <thead>
        <th title="Propietarios de la casa reservada">Propietario</th>
        <th style='min-width:180px;' title="Teléfono de la casa reservada">Telef</th>
        <th title="Persona a nombre de la reserva">A Nombre</th>
        <th style='width:10px;' title="Correo de la reserva">Correo</th>
        <th style='width:60px; white-space: nowrap;' title="Día de entrada a la casa">Desde</th>
        <th style='width:60px; white-space: nowrap;' title="Día de salida de la casa">Hasta</th>
        <th style='width:10px;' title="Habitaciones reservadas/Habitaciones de la casa">H.</th>
        <th style='width:10px;' title="Personas en la reservación">P.</th>
        <th style='width:10px;' title="Precio total acordado">Precio</th>
      </thead>
      <tbody id="lstCasasBody">
      </tbody>
    </table>  
  </div>
  
  <div class="panel-footer">
    <div class="btn-group sel-orden" role="group">
      <span class="">Ordenar por:</span>
      <select id="lstOrden" name="lstOrden" onChange="OnChangeOrden();">
        <option value="ORDER BY IdReserva">Sin orden</option>
        <option value="ORDER BY Propietario">Propietario</option>
        <option value="ORDER BY Localidad">Localidad</option>
        <option value="ORDER BY Telef">Telefono</option>
        <option value="ORDER BY Nombre">Reserva</option>
        <option value="ORDER BY Correo">Correo</option>
        <option value="ORDER BY Pais">País</option>
        <option value="ORDER BY Desde">Fecha de entrada</option>
        <option value="ORDER BY Hasta">Fecha de salida</option>
        <option value="ORDER BY Precio">Precio</option>
      </select>
    </div>
    
    <div class="btn-group" role="group" style="top:-37px; margin-left: 300px;">
      <a id="linkInforme" href="InformeCasaReservadas.php" target="new"> <button type="button" id="btnInforme" class="btn btn-default">Informe</button> </a>
    </div>
    
    <div class="btn-group block-right" role="group" style="top:-37px;">
      <button type="button" id="btnPrev" class="btn btn-default">&lt;</button>
      <button type="button" id="btnNext" class="btn btn-default">&gt;</button>
    </div>
  </div>

</div>

<!--Dialogo filtrar por el propietario-->  
<div id="dlgProp" title="Filtrar por Propietario" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon">Propietario:</span>
        <input type="text" id="Propiet" class="form-control" placeholder="Todos">
      </div></div>
    </div>
  </div>
</div>

<!--Dialogo filtrar por el telefono-->  
<div id="dlgTelef" title="Filtrar por Telefono" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon">Telefono:</span>
        <input type="text" id="Telef" class="form-control" placeholder="Todos">
      </div></div>
    </div>
  </div>
</div>

<!--Dialogo filtrar por la reservación-->  
<div id="dlgReserv" title="Filtrar por Reservación" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon">A Nombre:</span>
        <input type="text" id="Reserv" class="form-control" placeholder="Todos">
      </div></div>
    </div>
  </div>
</div>

<!--Dialogo filtrar por la reservación-->  
<div id="dlgCorreo" title="Filtrar por Correos" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon">Correo:</span>
        <input type="text" id="Correo" class="form-control" placeholder="Todos">
      </div></div>
    </div>
  </div>
</div>

<!--Dialogo filtrar por el precio-->  
<div id="dlgPrecio" title="Filtrar por num. de cuartos" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4 col-my"><div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="MenosPrecio" name="RPrecio" type="radio"></span>
        <span class="input-group-addon" style="text-align:left;">Menos</span>
      </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="IgualPrecio" name="RPrecio" type="radio"></span>
          <span class="input-group-addon" style="text-align:left;">Igual</span>
        </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="MasPrecio" name="RPrecio" type="radio" checked=1></span>
          <span class="input-group-addon" style="text-align:left;">Mas</span>
        </div></div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon" style="width:0.001%;">Precio:</span>
        <input type="text" id="Precio" class="form-control" placeholder="Todos">
      </div></div>
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
var FilterProp = "";
var FilterTelef = "";
var FilterReserv = "";
var FilterCorreo = "";
var FilterMes = "";
var FilterPrecio = "";
var FilterIdCasa = "";

var sOrder = "ORDER BY Propietario"; 

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
  
  if( Datos.IdCasa && Datos.FechaIni && Datos.NDias )
    {
    $(".cond-item").css("display","none");  
    $("#linkInforme").css("display","none");   
       
    FilterIdCasa = "IdCasa=" + Datos.IdCasa + " ";    
    
    var fIni = Datos.FechaIni;
    var dIni = FechaFromStr( fIni );
    var dEnd = Date.AddDays(dIni, Datos.NDias);
    var fEnd = FormatDbFecha( dEnd );
    
    FilterMes = "Desde<='" + fEnd + "' AND Hasta>'" + fIni + "' ";
    }
  else  
    DefaultPeriodo();

  DoQuery(-1);  
  });

function OpenDlg( id )
  {
	$(id).dialog( "open" );
  }
  
$("#dlgProp").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgProp},] });
   
function CloseDlgProp()
  {
	$("#dlgProp").dialog( "close" );
  
  var sProp = $("#Propiet").val();
  if( sProp.length==0 ) 
    { 
    FilterProp = "";
    $("#fProp").text("Todos");
    }
  else
    {
    FilterProp = 'Propietario LIKE "%' + sProp + '%" ';  
    $("#fProp").text(sProp);
    }  
  
  DoQuery(-1);  
  }

$("#dlgTelef").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgTelef},] });
   
function CloseDlgTelef()
  {
	$("#dlgTelef").dialog( "close" );
  
  var sTelef = $("#Telef").val();
  if( sTelef.length==0 ) 
    { 
    FilterTelef = "";
    $("#fTelef").text("Todos");
    }
  else
    {
    FilterTelef = 'Telef LIKE "%' + sTelef + '%" ';  
    $("#fTelef").text(sTelef);
    }  
  
  DoQuery(-1);  
  }
  
$("#dlgReserv").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgReserv},] });
   
function CloseDlgReserv()
  {
	$("#dlgReserv").dialog( "close" );
  
  var sReserv = $("#Reserv").val();
  if( sReserv.length==0 ) 
    { 
    FilterReserv = "";
    $("#fReserv").text("Todos");
    }
  else
    {
    FilterReserv = 'Nombre LIKE "%' + sReserv + '%" ';  
    $("#fReserv").text(sReserv);
    }  
  
  DoQuery(-1);  
  }
  
$("#dlgCorreo").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgCorreo},] });
   
function CloseDlgCorreo()
  {
	$("#dlgCorreo").dialog( "close" );
  
  var sCorreo = $("#Correo").val();
  if( sCorreo.length==0 ) 
    { 
    FilterCorreo = "";
    $("#fCorreo").text("Todos");
    }
  else
    {
    FilterCorreo = 'Correo LIKE "%' + sCorreo + '%" ';  
    $("#fCorreo").text(sCorreo);
    }  
  
  DoQuery(-1);  
  }
  
$("#dlgPrecio").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgPrecio},] });
   
function CloseDlgPrecio()
  {
	$("#dlgPrecio").dialog( "close" );
  
  var nPrecio = parseInt( $("#Precio").val() );
  if( isNaN(nPrecio) ) 
    { 
    FilterPrecio = "";
    $("#fPrecio").text( "Todos" );
    }
  else
    {
    var txt = "";  
    FilterPrecio = "Precio ";
      
    var mas   = document.getElementById("MasPrecio");
    var menos = document.getElementById("MenosPrecio");
    var igual = document.getElementById("IgualPrecio");
    
    if( mas.checked ) txt = "> " ;
    else if( menos.checked ) txt = "< " ;
    else txt = "= " ;

    FilterPrecio += (txt + nPrecio + " ");  
    
    $("#fPrecio").text( txt + nPrecio);
    }  
    
  DoQuery(-1);  
  }
  
$("#dlgMes").dialog({ autoOpen:false,	width:250, buttons:[ {text:"Filtar", click:CloseDlgMes},] });
   
function CloseDlgMes()
  {
	$("#dlgMes").dialog( "close" );

  var mes = $("#lstMeses").val();  
  var ano = $("#lstAnos").val();  

  MakeMesFilter( parseInt(ano), parseInt(mes) ) ;
    
  DoQuery(-1);  
  }

function DefaultPeriodo() 
  {
  var now = new Date();
  MakeMesFilter( now.getYear() + 1900, now.getMonth() ) 
  }
  
function MakeMesFilter( ano, mes ) 
  {
  if( mes>11 )
    {
    FilterMes = "";
    $("#fMes").text( "Todos");
    $("#linkInforme").attr("hRef", "InformeCasaReservadas.php" );
    }  
  else
    {  
    var fIni = ano + '-' + (mes+1) + '-1';
    var fEnd = ano + '-' + (mes+2) + '-1';
    
    FilterMes = "Hasta>='" + fIni + "' AND Hasta<'" + fEnd + "' ";
    
    $("#fMes").text( Meses[mes] + " " + ano );
    $("#linkInforme").attr("hRef", "InformeCasaReservadas.php?mes=" + mes +"&ano=" + ano );
    }
  }
  
function DoQuery( page )
  {
  if( page == -1) 
    {
    page = 0;  
    nPages = 10000;
    } 
    
  var sQuery = "SELECT IdReserva, IdCasa, DiaEntrada, Propietario, Localidad, Telef, Nombre, Correo, Pais, Desde, Hasta, Cuartos, Personas, Precio, CasaHab FROM view_casa_reserva ";
  var sAnd   = "";
  var sWhere = "";
 
  if( FilterIdCasa.length>0 ) {sWhere += FilterIdCasa; sAnd="AND ";}
  if( FilterProp.length>0   ) {sWhere += FilterProp; sAnd="AND ";}
  if( FilterTelef.length>0  ) {sWhere += (sAnd + FilterTelef ); sAnd="AND ";} 
  if( FilterReserv.length>0 ) {sWhere += (sAnd + FilterReserv   ); sAnd="AND ";} 
  if( FilterCorreo.length>0 ) {sWhere += (sAnd + FilterCorreo   ); sAnd="AND ";} 
  if( FilterMes.length>0    ) {sWhere += (sAnd + FilterMes   ); sAnd="AND ";} 
  if( FilterPrecio.length>0 ) {sWhere += (sAnd + FilterPrecio);} 

  if( sWhere.length>0 ) {sQuery += ("WHERE " + escape(sWhere));} 

  var off = nRec*page;
  sQuery += (sOrder + " LIMIT " + off + ", " + nRec);
  
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
      var total = 0;  
      var sHtml = "";
      for( i=0; i<nRows; ++i ) 
        {
        var row = ret.rows[i];  
        
        sHtml += "<tr onClick='OnClickLista(" + row[0] + ", " + row[1]  + ", " + row[2] + ");'>"; 
        sHtml += "<td title='" + row[4] + "'>" + row[3] + "</td>";
        sHtml += "<td>" + row[5] + "</td>";
        sHtml += "<td title='" + row[8] + "'>" + row[6] + "</td>";
        sHtml += "<td>" + row[7] + "</td>";
        sHtml += "<td>" + DiaMes(row[9] ) + "</td>";
        sHtml += "<td>" + DiaMes(row[10]) + "</td>";
        sHtml += "<td>" + row[11] + "/" + row[14] + "</td>";
        sHtml += "<td>" + row[12] + "</td>";
        sHtml += "<td>" + row[13] + "</td>";
        sHtml += "</tr>"; 
//                        0         1         2            3           4         5      6       7      8      9     10      11        12       13     14 
//var sQuery = "SELECT IdReserva, IdCasa, DiaEntrada, Propietario, Localidad, Telef, Nombre, Correo, Pais, Desde, Hasta, Cuartos, Personas, Precio, CasaHab FROM view_casa_reserva ";
        total += parseInt( row[13] );
        }
        
      sHtml += "<tr><td colspan='8' align='right'><b>Total:</b></td><td>" + total + "</td></tr>"; 
      
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
  
function showBtns()
  {
  var visNext = (Page>=nPages)? "hidden" : "visible";
  var visPrev = (Page<=0     )? "hidden" : "visible";
  
  $("#btnNext").css("visibility", visNext);
  $("#btnPrev").css("visibility", visPrev);
  }

function OnClickLista( IdReserva, IdCasa, DiaEntrada )
  {
  var URL = "EditReservaCasa.php?IdReserv="+IdReserva+"&IdCasa="+IdCasa+"&DiaIni="+DiaEntrada; 
  
//  document.location = URL;  
  window.open( URL, "EditReservaCasa"+Date() );
  }

function OnChangeOrden() 
  {
  sOrder = $("#lstOrden").val();
    
  DoQuery(-1);  
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