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
<title>Listado de casas ocupadas</title>

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

<div class="panel panel-info center-block" style="max-width:1024px">
  <div class="panel-heading">
    <div class="panel-title">
      <span class="cond-title">Casas Ocupadas</span> 
      <span class="cond-item" >Propietario:<a id="fProp" href='javascript:OpenDlg("#dlgProp");'>Todos</a></span> 
      <span class="cond-item" >Localidad:<a id="fLocalid" href='javascript:OpenDlg("#dlgLocalid");'>Todas</a></span> 
      <span class="cond-item" >Período:<a id="fFechas" href='javascript:OpenDlg("#dlgFechas");'>Este mes</a></span> 
      <span class="cond-item" >Habitaciones:<a id="fCuartos" href='javascript:OpenDlg("#dlgCuartos");'>Todos</a></span> 
      <span id="fLocalId" style="display:none;"></span> 
    </div>
  </div>
  
  <div class="panel-body"> 
    <table class='table'>
      <thead><tr><th>Propietario</th><th>Localidad</th><th>Telefono</th><th>Desde</th><th>Hasta</th><th>Hab. Libres</th></thead>
        <tbody id="lstCasasBody">
        </tbody>
    </table>  
  </div>
  <div class="panel-footer">
    <div class="btn-group" role="group" style="top:3px;">
      <button type="button" id="btnCreate" class="btn btn-default" style="margin-right:20px;" onClick='OpenDlg("#dlgOcupada");'>Crear una nueva</button>
      <button type="button" id="btnDelOlds" class="btn btn-default" onClick='DeleteOlds();'>Borrar las anteriores</button>
    </div>
    <div class="btn-group block-right" role="group" style="top:3px;">
      <button type="button" id="btnPrev" class="btn btn-default">&lt;</button>
      <button type="button" id="btnNext" class="btn btn-default">&gt;</button>
    </div>
  </div>

</div>


<!--Dialogo filtrar por el propietario-->  
<div id="dlgProp" title="Filtrar por propietario" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon">Propietario:</span>
        <input type="text" id="Propiet" class="form-control" placeholder="Todos">
      </div></div>
    </div>
  </div>
</div>

<!--Dialogo para filtrar por la localidad-->  
<div id="dlgLocalid" title="Filtrar por localidad" style="padding:0px; width:400px;">
  <div class="container-fluid">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Localidad:</span>
        <select id="lstFilterLoc" name="lstFilterLoc" class="form-control" >
        </select>
      </div></div>
    </div>
  </div>

<!--Dialogo filtrar por número de cuartos-->  
<div id="dlgCuartos" title="Filtrar por num. de cuartos" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4 col-my"><div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="MenosHab" name="RHab" type="radio"></span>
        <span class="input-group-addon" style="text-align:left;">Menos</span>
      </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="IgualHab" name="RHab" type="radio"></span>
          <span class="input-group-addon" style="text-align:left;">Igual</span>
        </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="MasHab" name="RHab" type="radio" checked=1></span>
          <span class="input-group-addon" style="text-align:left;">Mas</span>
        </div></div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-my"> <div class="input-group">
        <span class="input-group-addon" style="width:0.001%;">Cuartos:</span>
        <input type="text" id="Cuartos" class="form-control" placeholder="Todos">
      </div></div>
    </div>
  </div>
</div>

<!--Dialogo filtrar por Fechas-->  
<div id="dlgFechas" title="Filtrar por Fechas" style="padding:0px; width:500px;">
  <div class="container-fluid" style1="margin:0px; padding:0px;">
    <div class="row">
      <div class="col-sm-12 col-my"><div class="input-group">
        <span class="input-group-addon" style="width:0.001%;"><input id="now" name="RRango" type="radio" checked=1 onChange="ChangeTipo(0);"></span>
        <span class="input-group-addon" style="text-align:left;">En los proximos 30 días</span>
      </div></div>
    </div>
      
    <div class="row">
      <div class="col-sm-12 col-my"><div class="input-group">
        <span class="input-group-addon" style="width:0.001%;"><input id="last" name="RRango" type="radio" onChange="ChangeTipo(1);"></span>
        <span class="input-group-addon" style="text-align:left;">En los dias anteriores</span>
      </div></div>
    </div>
      
    <div class="row">
      <div class="col-sm-12 col-my"><div class="input-group">
        <span class="input-group-addon" style="width:0.001%;"><input id="rango" name="RRango" type="radio" onChange="ChangeTipo(2);"></span>
        <span class="input-group-addon" style="text-align:left;">En el rango</span>
      </div></div>
    </div>
          
    <div class="row" id="FechaDatos" style="display:none;">
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">Desde:</span>
          <input type="text" id="FIniFilter" name="FIniFilter" class="form-control" style="height:30px;">
      </div></div>
      
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">Hasta:</span>
        <input type="text" id="FEndFilter" name="FEndFilter" class="form-control" style="height:30px;">
      </div></div>
    </div>
    
  </div>
</div>

<!--Dialogo para marcar una casa como ocupada-->  
<div id="dlgOcupada" title="Adicionar una ocupación nueva">
  <div class="container-fluid" style="margin:0px; padding:0px;">
    <div class="row">
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">Cuartos disponibles:</span>
        <input type="text" id="OcupCuartos" name="OcupCuartos" class="form-control num3" maxlength="2" autocomplete="off">
      </div></div>
    </div>
    
    <div class="row">
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">Desde:</span>
          <input type="text" id="FOcupIni" name="FOcupIni" class="form-control" style="height:30px;">
      </div></div>
      
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">Hasta:</span>
        <input type="text" id="FOcupEnd" name="FOcupEnd" class="form-control" style="height:30px;">
      </div></div>
    </div>
    
    <div class="row">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Localidad:</span>
        <select id="lstCiudad" name="lstCiudad" class="form-control" onChange="FindCasaByLoc();" >
        </select>
      </div></div>
    </div>
    
    <div class="row">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Casa:</span>
        <select id="lstCasas" name="lstCasas" class="form-control" >
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
var FilterLocal = "";
var FilterHab = "";
var FilterFechas = "";
var sOrder = "ORDER BY casa.Propietario"; 

var Page = 0;  
var nRec = 30;  
var nPages = 1000;  
var FechaTipo = 0;  

var DatesOcup, DatesFilter;
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  $("#UserName").text( Datos.UserName ); 
  
  $("#btnPrev").click( function() { if(Page>0     ) DoQuery(--Page);} );
  $("#btnNext").click( function() { if(Page<nPages) DoQuery(++Page);} );
    
  $("#UserName").text( Datos.UserName ); 
  $("#lstCiudad").load("Handles/FillCombo.php", "All=1&Table=Ciudad&OderBy=Name", OnLoadedCiudades ); 
  
  DatesFilter = new LinkDates3( "#FIniFilter", "#FEndFilter");
  DatesOcup   = new LinkDates3( "#FOcupIni", "#FOcupEnd")
  
  var fIni = new Date();
  var fEnd = Date.AddDays(fIni, 30);
  
  DatesFilter.IniDatos( fIni, fEnd );
  DatesOcup.IniDatos( fIni, fEnd );
  
  DefaultPeriodo();

  DoQuery(-1);  
  });

function OnLoadedCiudades()
  {
  var html = $("#lstCiudad").html();
  $("#lstFilterLoc").html( html ); 
  $("#OcupCuartos").val(0);
  
  var combo = document.getElementById("lstCiudad");
  var name = combo.options[0].text = "";
  }

function OpenDlg( id )
  {
	$(id).dialog( "open" );
  }
  
function ChangeTipo( tipo )
  {
  FechaTipo = tipo;
  
  if( tipo<2 ) $("#FechaDatos").css("display","none");
  else         $("#FechaDatos").css("display","block");
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
    FilterProp = 'casa.Propietario LIKE "%' + sProp + '%" ';  
    $("#fProp").text(sProp);
    }  
  
  DoQuery(-1);  
  }
  
$("#dlgLocalid").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgLocalid},] });
   
function CloseDlgLocalid()
  {
	$("#dlgLocalid").dialog( "close" );
  
  var sLocId = $("#lstFilterLoc").val();
  if( sLocId == 0 ) 
    { 
    FilterLocal = "";
    $("#fLocalid").text( "Todas" );
    }
  else
    {
    FilterLocal = "casa.IdCiudad =" + sLocId + " ";  
    
    var combo = document.getElementById("lstFilterLoc");
    var idx = combo.selectedIndex;
    var name = combo.options[idx].text;
    
    $("#fLocalid").text( name );
    }  
  
  DoQuery(-1);  
  }
  
$("#dlgCuartos").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgCuartos},] });
   
function CloseDlgCuartos()
  {
	$("#dlgCuartos").dialog( "close" );
  
  var nCuartos = parseInt( $("#Cuartos").val() );
  if( isNaN(nCuartos) ) 
    { 
    FilterHab = "";
    $("#fCuartos").text( "Todos" );
    }
  else
    {
    var txt = "";  
    FilterHab = "casa_ocupada.HabLibres ";
      
    var mas   = document.getElementById("MasHab");
    var menos = document.getElementById("MenosHab");
    var igual = document.getElementById("IgualHab");
    
    if( mas.checked ) txt = "> " ;
    else if( menos.checked ) txt = "< " ;
    else txt = "= " ;

    FilterHab += (txt + nCuartos + " ");  
    
    $("#fCuartos").text( txt + nCuartos);
    }  
    
  DoQuery(-1);  
  }
  
$("#dlgFechas").dialog({ autoOpen:false,	width:400, buttons:[ {text:"Filtar", click:CloseDlgFechas},] });
   
function CloseDlgFechas()
  {
	$("#dlgFechas").dialog( "close" );
  
  if( FechaTipo==0 ) 
    { 
    DefaultPeriodo();
    }
  else if( FechaTipo==1 ) 
    { 
    var fnow = new Date();
    FilterFechas = "FechaFin<'" + FormatDbFecha(fnow) + "' ";
    $("#fFechas").text( "Antes de " + FormatDate(fnow) );
    }
  else
    {
    var fIni = DatesFilter.GetFechaIni();
    var fEnd = DatesFilter.GetFechaEnd();
    FilterFechas = "FechaIni<='" + fEnd + "' AND FechaFin>='" + fIni + "' ";
    $("#fFechas").text( "Entre " + $("#FIniFilter").val() + " y " + $("#FEndFilter").val() );
    }  
    
  DoQuery(-1);  
  }

function DefaultPeriodo() 
  {
  var fIni = new Date();
  var fEnd = Date.AddDays(fIni, 30);
  
  FilterFechas = "FechaIni<='" + FormatDbFecha(fEnd) + "' AND FechaFin>='" + FormatDbFecha(fIni) + "' ";
  $("#fFechas").text( "En los proximos 30 días" );
  }
  
function DoQuery( page )
  {
  if( page == -1) 
    {
    page = 0;  
    nPages = 10000;
    } 
    
  var sQuery = "SELECT casa_ocupada.IdCasa, casa.Propietario, ciudad.Name AS localidad, casa.Telef, casa_ocupada.FechaIni, casa_ocupada.FechaFin, casa_ocupada.HabLibres FROM casa_ocupada INNER JOIN casa ON casa_ocupada.IdCasa = casa.IdCasa INNER JOIN ciudad ON casa.IdCiudad = ciudad.IdCiudad ";
  var sAnd   = "";
  var sWhere = "";
  
  if( FilterProp.length>0   ) {sWhere += FilterProp; sAnd="AND ";}
  if( FilterLocal.length>0  ) {sWhere += (sAnd + FilterLocal ); sAnd="AND ";} 
  if( FilterHab.length>0    ) {sWhere += (sAnd + FilterHab   ); sAnd="AND ";} 
  if( FilterFechas.length>0 ) {sWhere += (sAnd + FilterFechas);} 

  if( sWhere.length>0 ) {sQuery += ("WHERE " + escape(sWhere));} 

  var off = nRec*page;
  sQuery += (sOrder + " LIMIT " + off + ", " + nRec);
    
  jQuery.post( "Handles/QueryString.php", "Tipo=COcupada&Query=" + sQuery )
  .success(function(data) 
            {
            if( data.substr(0, 2)=="({" )
              {  
              var ret = eval(data);
              var nRows = ret.nRows;
              if( nRows>0 || page==0) 
                {
                $("#lstCasasBody").html(ret.rows);
                Page = page;
                }
                 
              if( nRows==0 ) nPages = page-1; 
              else if( nRows<nRec )  nPages = page; 
              
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
  
function showBtns()
  {
  var visNext = (Page>=nPages)? "hidden" : "visible";
  var visPrev = (Page<=0     )? "hidden" : "visible";
  
  $("#btnNext").css("visibility", visNext);
  $("#btnPrev").css("visibility", visPrev);
  }

function OnClickLista( idCasa, fecha )
  {
  var ret = confirm("¿Desea quitar la ocupación seleccionada?");  
  if( !ret ) return;
  
  jQuery.post( "Handles/DeleteCasaOcupada.php", "FIni="+ fecha + "&IdCasa=" + idCasa )
  .success(function(data) 
            {
            if( data != "OK" ) alert("Error al quitar la ocupación:\r\n" + data ); 
            else               DoQuery(-1);  
            })
  .error(function(data) 
           { 
           alert("Error al quitar la ocupación:\r\n" + data.statusText ); 
           });
  }

$( "#dlgOcupada" ).dialog({	autoOpen:false,	width:400, 	buttons:[ {text:"Marcar Ocupada", click:MarcarOcupada} ] });
  
function MarcarOcupada()
  {
	$("#dlgOcupada").dialog( "close" );
  
  var IdCasa = $("#lstCasas").val();
  if( !IdCasa )
    {
    alert("Se debe de seleccionar una localidad y luego una casa");  
    return;
    }
  
  var Params = "IdCasa=" + IdCasa + "&" +
               "FIni='" + DatesOcup.GetFechaIni() + "'&" +
               "FEnd='" + DatesOcup.GetFechaEnd() + "'&" +
               "Hab=" + $("#OcupCuartos").val();
               
  jQuery.get("Handles/MarkCasaOcupada.php?"+Params)
  .success(function(data) 
     {
     if( data!="OK") { alert("Error al poner casa como ocupada:\r\n" + data); }
     else             DoQuery(-1);  
     })
  .error(function(data)   { alert("Error al poner casa como ocupada:\r\n" + data.statusText ); });
  }
 
function FindCasaByLoc()
  {
  var IdLoc = $("#lstCiudad").val();
   
  $("#lstCasas").load("Handles/ListCasasByLoc.php", "IdLoc="+IdLoc); 
  }

function DeleteOlds()
  {
  jQuery.get("Handles/DeleteOldsCasas.php")
  .success(function(data) 
     {
     if( data!="OK") { alert("Error al poner casa como ocupada:\r\n" + data); }
     else             DoQuery(-1);  
     })
  .error(function(data)   { alert("Error al poner casa como ocupada:\r\n" + data.statusText ); });
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