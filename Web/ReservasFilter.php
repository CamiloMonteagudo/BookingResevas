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
<title>Listado de reservaciones</title>

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
      <span class="cond-title">Reservaciones</span> 
      <span class="cond-item" >Reserva:<a id="fReserv" href='javascript:OpenDlg("#dlgReserv");'>Todos</a></span> 
      <span class="cond-item" >Correo:<a id="fCorreo" href='javascript:OpenDlg("#dlgCorreo");'>Todos</a></span> 
      <span class="cond-item" >País:<a id="fPais" href='javascript:OpenDlg("#dlgPais");'>Todos</a></span> 
      <span class="cond-item" >Operador:<a id="fOperad" href='javascript:OpenDlg("#dlgOperad");'>Todos</a></span> 
      <span class="cond-item" >Tipo:<a id="fTipo" href='javascript:OpenDlg("#dlgTipo");'>Todos</a></span> 
      <span class="cond-item" >Estado:<a id="fEstado" href='javascript:OpenDlg("#dlgEstado");'>Todos</a></span> 
      <span class="cond-item" >Mes:<a id="fMes" href='javascript:OpenDlg("#dlgMes");'>Este mes</a></span> 
      <span class="cond-item" >Dias:<a id="fDias" href='javascript:OpenDlg("#dlgDias");'>Todos</a></span> 
      <span class="cond-item" >Personas:<a id="fPers" href='javascript:OpenDlg("#dlgPers");'>Todos</a></span> 
      <span id="fLocalId" style="display:none;"></span> 
    </div>
  </div>

  <div class="panel-body"> 
    <table class='table'>
      <thead>
        <th  title="Persona que realiza la reservación">A Nombre</th>
        <th style='width:240px;' title="Correo para comunicarse con la persona que reservó">Correo</th>
        <th style='width:30px;'  title="País de procedencia de la reservación">País</th>
        <th style='width:30px;'  title="Operador que atiende la reservación">Operador</th>
        <th style='width:20px;'  title="Tipo de reservación">Tipo</th>
        <th style='width:100px;' title="Estado de la reservación">Estado</th>
        <th style='width:65px;' title="Fecha que se inicia la reservación">Fecha</th>
        <th style='width:30px;' title="Número de dias de la reserva">Dias</th>
        <th style='width:10px;' title="Número de Habitaciones que icluye la reserva">H.</th>
        <th style='width:10px;' title="Número de Personas incluidas en la reserva">P.</th>
        <th style='width:10px;' title="Cantidad de dinero depositado con antelación">Deposito</th>
        <th style='width:10px;' title="Número de casas asociadas a la reserva">Casas</th>
      </thead>
      <tbody id="lstCasasBody"></tbody>
    </table>  
  </div>
  
  <div class="panel-footer">
    <div class="btn-group sel-orden" role="group">
      <span class="">Ordenar por:</span>
      <select id="lstOrden" name="lstOrden" onChange="OnChangeOrden();">
        <option value="ORDER BY IdReserva">Sin orden</option>
        <option value="ORDER BY Nombre">Reservación</option>
        <option value="ORDER BY Correo">Correo</option>
        <option value="ORDER BY Pais">País</option>
        <option value="ORDER BY Operador">Operador</option>
        <option value="ORDER BY Tipo">Tipo</option>
        <option value="ORDER BY Estado">Estado</option>
        <option value="ORDER BY Fecha">Fecha de entrada</option>
        <option value="ORDER BY Noches">Número de noches</option>
        <option value="ORDER BY Habitaciones">Habitaciones</option>
        <option value="ORDER BY Personas">Personas</option>
        <option value="ORDER BY Deposito">Deposito</option>
        <option value="ORDER BY Casas">Casas</option>
      </select>
     
    </div>
    <div class="btn-group block-right" role="group" style="top:-37px;">
      <button type="button" id="btnPrev" class="btn btn-default">&lt;</button>
      <button type="button" id="btnNext" class="btn btn-default">&gt;</button>
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

<!--Dialogo para filtrar por Operador-->  
<div id="dlgOperad" title="Filtrar por Operador" style="padding:0px; width:400px;">
  <div class="container-fluid">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Operador:</span>
        <select id="lstOperad" name="lstOperad" class="form-control" >
        </select>
      </div></div>
    </div>
  </div>

<!--Dialogo para filtrar por el estado de la reservar-->  
<div id="dlgEstado" title="Filtrar por estado de la reserva" style="padding:0px; width:400px;">
  <div class="container-fluid">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Estado:</span>
        <select id="lstReserva_Estado" name="lstReserva_Estado" class="form-control" >
        </select>
      </div></div>
    </div>
  </div>

<!--Dialogo para filtrar por paises-->  
<div id="dlgPais" title="Filtrar por la pais del reserva" style="padding:0px; width:400px;">
  <div class="container-fluid">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">País:</span>
        <select id="lstPais" name="lstPais" class="form-control" >
        </select>
      </div></div>
    </div>
  </div>

<!--Dialogo para filtrar por tipo de reserva-->  
<div id="dlgTipo" title="Filtrar por el tipo de reserva" style="padding:0px; width:400px;">
  <div class="container-fluid">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Tipo:</span>
        <select id="lstReserva_tipo" name="lstReserva_tipo" class="form-control" >
        </select>
      </div></div>
    </div>
  </div>

<!--Dialogo filtrar por dias reservados-->  
<div id="dlgDias" title="Filtrar por dias reservados" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4 col-my"><div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="MenosDias" name="RDias" type="radio"></span>
        <span class="input-group-addon" style="text-align:left;">Menos</span>
      </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="IgualDias" name="RDias" type="radio"></span>
          <span class="input-group-addon" style="text-align:left;">Igual</span>
        </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="MasDias" name="RDias" type="radio" checked=1></span>
          <span class="input-group-addon" style="text-align:left;">Mas</span>
        </div></div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon" style="width:0.001%;">Días:</span>
        <input type="text" id="Dias" class="form-control" placeholder="Todos">
      </div></div>
    </div>
  </div>
</div>

<!--Dialogo filtrar por número de personas-->  
<div id="dlgPers" title="Filtrar por # de personas" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4 col-my"><div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="MenosPers" name="RPers" type="radio"></span>
        <span class="input-group-addon" style="text-align:left;">Menos</span>
      </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="IgualPers" name="RPers" type="radio"></span>
          <span class="input-group-addon" style="text-align:left;">Igual</span>
        </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="MasPers" name="RPers" type="radio" checked=1></span>
          <span class="input-group-addon" style="text-align:left;">Mas</span>
        </div></div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon" style="width:0.001%;">Personas:</span>
        <input type="text" id="Pers" class="form-control" placeholder="Todos">
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
var FilterReserv = "";
var FilterCorreo = "";
var FilterMes = "";
var FilterOperad = "";
var FilterEstado = "";
var FilterPais = "";
var FilterTipo = "";
var FilterDias = "";
var FilterPers = "";

var sOrder = "ORDER BY IdReserva"; 

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

  $("#lstOperad").load("Handles/FillCombo.php", "All=1&Table=Operador"); 
  $("#lstPais").load("Handles/FillCombo.php", "All=1&Table=Pais"); 
  $("#lstReserva_Estado").load("Handles/FillCombo.php", "All=1&Table=Reserva_Estado&OderBy=IdReservaEstado"); 
  $("#lstReserva_tipo").load("Handles/FillCombo.php", "All=1&Table=Reserva_tipo"); 

  DoQuery(-1);  
  });

function OpenDlg( id )
  {
	$(id).dialog( "open" );
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
  
$("#dlgMes").dialog({ autoOpen:false,	width:250, buttons:[ {text:"Filtar", click:CloseDlgMes},] });
   
function CloseDlgMes()
  {
	$("#dlgMes").dialog( "close" );

  var mes = $("#lstMeses").val();  
  var ano = $("#lstAnos").val();  

  MakeMesFilter( parseInt(ano), parseInt(mes) ) ;
    
  DoQuery(-1);  
  }

$("#dlgOperad").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgOperad},] });
   
function CloseDlgOperad()
  {
	$("#dlgOperad").dialog( "close" );
  
  var combo = document.getElementById("lstOperad");
  var idx = combo.selectedIndex;
  var name = combo.options[idx].text;
  var val  = combo.options[idx].value;
    
  if( val == 0 ) 
    { 
    FilterOperad = "";
    $("#fOperad").text( "Todas" );
    }
  else
    {
    FilterOperad = "IdOperador =" + val + " ";  
    
    $("#fOperad").text( name );
    }  
  
  DoQuery(-1);  
  }

$("#dlgEstado").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgEstado},] });
   
function CloseDlgEstado()
  {
	$("#dlgEstado").dialog( "close" );
  
  var combo = document.getElementById("lstReserva_Estado");
  var idx = combo.selectedIndex;
  var name = combo.options[idx].text;
  var val  = combo.options[idx].value;
    
  if( val == 0 ) 
    { 
    FilterEstado = "";
    $("#fEstado").text( "Todas" );
    }
  else
    {
    FilterEstado = "IdEstado =" + val + " ";  
    
    $("#fEstado").text( name );
    }  
  
  DoQuery(-1);  
  }
  
$("#dlgPais").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgPais},] });
   
function CloseDlgPais()
  {
	$("#dlgPais").dialog( "close" );
  
  var combo = document.getElementById("lstPais");
  var idx = combo.selectedIndex;
  var name = combo.options[idx].text;
  var val  = combo.options[idx].value;
    
  if( val == 0 ) 
    { 
    FilterPais = "";
    $("#fPais").text( "Todos" );
    }
  else
    {
    FilterPais = "IdPais =" + val + " ";  
    
    $("#fPais").text( name );
    }  
  
  DoQuery(-1);  
  }

$("#dlgTipo").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgTipo},] });
   
function CloseDlgTipo()
  {
	$("#dlgTipo").dialog( "close" );
  
  var combo = document.getElementById("lstReserva_tipo");
  var idx = combo.selectedIndex;
  var name = combo.options[idx].text;
  var val  = combo.options[idx].value;
    
  if( val == 0 ) 
    { 
    FilterTipo = "";
    $("#fTipo").text( "Todos" );
    }
  else
    {
    FilterTipo = "IdTipo =" + val + " ";  
    
    $("#fTipo").text( name );
    }  
  
  DoQuery(-1);  
  }

$("#dlgDias").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgDias},] });
   
function CloseDlgDias()
  {
	$("#dlgDias").dialog( "close" );
  
  var nDias = parseInt( $("#Dias").val() );
  if( isNaN(nDias) ) 
    { 
    FilterDias = "";
    $("#fDias").text( "Todos" );
    }
  else
    {
    var txt = "";  
    FilterDias = "Noches ";
      
    var mas   = document.getElementById("MasDias");
    var menos = document.getElementById("MenosDias");
    var igual = document.getElementById("IgualDias");
    
    if( mas.checked ) txt = "> " ;
    else if( menos.checked ) txt = "< " ;
    else txt = "= " ;

    FilterDias += (txt + nDias + " ");  
    
    $("#fDias").text( txt + nDias);
    }  
    
  DoQuery(-1);  
  }
  
$("#dlgPers").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgPers},] });
   
function CloseDlgPers()
  {
	$("#dlgPers").dialog( "close" );
  
  var nPers = parseInt( $("#Pers").val() );
  if( isNaN(nPers) ) 
    { 
    FilterPers = "";
    $("#fnPers").text( "Todos" );
    }
  else
    {
    var txt = "";  
    FilterPers = "Personas ";
      
    var mas   = document.getElementById("MasPers");
    var menos = document.getElementById("MenosPers");
    var igual = document.getElementById("IgualPers");
    
    if( mas.checked ) txt = "> " ;
    else if( menos.checked ) txt = "< " ;
    else txt = "= " ;

    FilterPers += (txt + nPers + " ");  
    
    $("#fnPers").text( txt + nPers);
    }  
    
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
    }  
  else
    {  
    var fIni = ano + '-' + (mes+1) + '-1';
    var fEnd = ano + '-' + (mes+2) + '-1';
    
    FilterMes = "Fecha>='" + fIni + "' AND Fecha<'" + fEnd + "' ";
    
    $("#fMes").text( Meses[mes] + " " + ano );
    }
  }
  
function DoQuery( page )
  {
  if( page == -1) 
    {
    page = 0;  
    nPages = 10000;
    } 
    
  var sQuery = "SELECT IdReserva, Nombre, Correo, Pais, Operador, Tipo, Estado, Fecha, Noches, Habitaciones, Personas, Deposito, Casas FROM view_resevas ";
  var sAnd   = "";
  var sWhere = "";
 
  if( FilterReserv.length>0 ) {sWhere += (sAnd + FilterReserv ); sAnd="AND ";} 
  if( FilterCorreo.length>0 ) {sWhere += (sAnd + FilterCorreo ); sAnd="AND ";} 
  if( FilterMes.length>0    ) {sWhere += (sAnd + FilterMes    ); sAnd="AND ";} 
  if( FilterOperad.length>0 ) {sWhere += (sAnd + FilterOperad ); sAnd="AND ";} 
  if( FilterEstado.length>0 ) {sWhere += (sAnd + FilterEstado ); sAnd="AND ";} 
  if( FilterPais.length>0   ) {sWhere += (sAnd + FilterPais   ); sAnd="AND ";} 
  if( FilterTipo.length>0   ) {sWhere += (sAnd + FilterTipo   ); sAnd="AND ";} 
  if( FilterDias.length>0   ) {sWhere += (sAnd + FilterDias   ); sAnd="AND ";} 
  if( FilterPers.length>0   ) {sWhere += (sAnd + FilterPers   ); sAnd="AND ";} 

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
        
        sHtml += "<tr onClick='OnClickLista(" + row[0] + ");'>"; 
        sHtml += "<td>" + row[1] + "</td>";
        sHtml += "<td>" + row[2] + "</td>";
        sHtml += "<td>" + row[3] + "</td>";
        sHtml += "<td>" + row[4] + "</td>";
        sHtml += "<td>" + row[5] + "</td>";
        sHtml += "<td>" + row[6] + "</td>";
        sHtml += "<td>" + DiaMes(row[7]) + "</td>";
        sHtml += "<td>" + row[8] + "</td>";
        sHtml += "<td>" + row[9] + "</td>";
        sHtml += "<td>" + row[10] + "</td>";
        sHtml += "<td>" + row[11] + "</td>";
        sHtml += "<td>" + row[12] + "</td>";
        sHtml += "</tr>"; 
//                         0         1       2      3       4      5       6      7          8         9        10         11      12
// var sQuery = "SELECT IdReserva, Nombre, Correo, Pais, Operador, Tipo, Estado, Fecha, Noches, Habitaciones, Personas, Deposito, Casas FROM view_resevas ";
        total += parseInt( row[11] );
        }
        
      sHtml += "<tr><td colspan='10' align='right'><b>Total:</b></td><td>" + total + "</td></tr>"; 
      
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

function OnClickLista( IdReserva )
  {
  var URL = "EditReserva.php?IDResrv="+IdReserva; 
  
//  document.location = URL;  
  window.open( URL, "EditReserva"+Date() );
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