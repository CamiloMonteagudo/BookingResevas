<!doctype html>
<html lang="es">
<head>
<title>Vincular una casa a una reserva</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="MyStyles.css" rel="stylesheet" type="text/css">
<?php 
session_start();
//echo $_SESSION["UserName"];
//echo $_GET["IdReserv"];
if( empty($_SESSION["UserName"]) || empty($_GET["IdReserv"]) ) 
  {
  header( 'Location: index.php' ) ;
  exit(0);
  }
  
if(!empty($_SERVER["HTTP_REFERER"])) $LastPage = $_SERVER["HTTP_REFERER"]; 
else                                 $LastPage = "ListReservas.php"; 

$Datos  = "<script> Datos= { ";
$Datos .= "LastPage:'".$LastPage."', ";
$Datos .= "UserName:'".$_SESSION['UserName']."', ";
$Datos .= "UserID:".$_SESSION["UserID"].", ";
$Datos .= "Perms:".$_SESSION["Permisos"].", ";
  
$IDResrv = $_GET["IdReserv"];
if( empty($_GET["IdCasa"]) )
  {  
  $Datos .= "IDResrv:".$IDResrv.", ";
  $Datos .= "FechaIni:'".$_POST["fEntra"]."', ";
  $Datos .= "Dias:".$_POST["dias"].", ";
  $Datos .= "Cuartos:".$_POST["Cuartos"].", ";
  $Datos .= "Persons:".$_POST["Personas"].", ";
  $Datos .= "IdEstado:1";
  }
else
  {
  $IdCasa = $_GET["IdCasa"];
  $DiaIni = $_GET["DiaIni"];
  include 'Handles/OpenDb.php';   

  $resp = mysqli_query($myDB, "CALL ReservaCasaDatos($IDResrv,$IdCasa,$DiaIni)") or die(mysqli_error($myDB));

  if( $resp && $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
    {
    $Datos .= "IDResrv:".$IDResrv.", ";
    $Datos .= "IdCasa:".$IdCasa.", ";
    $Datos .= "FechaIni:'".$row["FechaEntrada"]."', ";
    $Datos .= "DiaIni:'".$row["DiaEntrada"]."', ";
    $Datos .= "DiaEnd:".$row["DiaSalida"].", ";
    $Datos .= "Noches:".$row["Noches"].", ";
    $Datos .= "Cuartos:".$row["Habitaciones"].", ";
    $Datos .= "Persons:".$row["Personas"].", ";
    $Datos .= "Precio:".$row["PrecioAcordado"].", ";
    $Datos .= "Comision:".$row["ComisionAcordada"].", ";
    $Datos .= "Cobrado:".$row["DineroCobrado"].", ";
    $Datos .= "CopiaProp:".$row["CopiaProp"].", ";
    $Datos .= "Observ:'".$row["Observ"]."', ";
    $Datos .= "Confirmada:".$row["Confirnada"].", ";
    $Datos .= "Propietario:'".$row["Propietario"]."', ";
    $Datos .= "IdEstado:".$row["IdReservaEstado"].", ";
    $Datos .= "IdOperador:".$row["IdOperador"].", "; 
    $Datos .= "Deposito:".$row["Depositado"];
    } 
  else 
    {
    printf("Could not retrieve records: %s\n", mysqli_error($myDB));
    }
  
  mysqli_free_result($resp);
  mysqli_close($myDB);
  }  
  
$Datos .= " }; </script>";
  
echo $Datos;  
?>

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
        <li class="dropdown" id="InfoMenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Informes<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="javascript:OnInfoReserva()">Datos de la reserva</a> </li>
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

<div class="container-fluid center-block">
<div class="jumbotron center-block" style="border-radius:30px; width:90%;">
  <div class="row datos-title"> Datos de reserva de casa</div>
  <form role="form" id="DataForm" class="text-left" method="POST">
  
<!--Sección con los datos para la reservación-->  
  <div class="row">
    <div class="col-sm-4 col-my"> <div class="input-group">
      <span class="input-group-addon" style="padding:6px;">Desde:</span>
      <span class="input-group-addon" style="padding:1px; width:65%;"><input type="text" id="FromFecha" name="FromFecha" class="form-control" style="line-height:1;"></span>
      <span class="input-group-addon" style="padding:1px; width:20%;"><input type="text" id="FromDia" name="FromDia" class="form-control" style="line-height:1;" maxlength="2" size="2"></span>
    </div></div>
    
    <div class="col-sm-4 col-my"> <div class="input-group">
      <span class="input-group-addon" style="padding:6px;">Hasta:</span>
      <span class="input-group-addon" style="padding:1px; width:65%;"><input type="text" id="ToFecha" name="ToFecha" class="form-control" style="line-height:1;"></span>
      <span class="input-group-addon" style="padding:1px; width:20%;"><input type="text" id="ToDia" name="ToDia" class="form-control" style="line-height:1;" maxlength="2" size="2"></span>
    </div></div>
    
    <div class="col-sm-3 col-my"><div class="input-group">
      <span class="input-group-addon">D&iacute;as:</span>
      <input type="text" id="nDias" value="1" name="nDias" class="form-control" >
    </div></div>
  </div>

  <div class="row">
    <div class="col-sm-4 col-my">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12 col-my"><div class="input-group">
            <span class="input-group-addon">Personas:</span>
            <input type="text" id="Personas" name="Personas" class="form-control num2" maxlength="2" autocomplete="off">
          </div></div>
          
          <div class="col-sm-12 col-my"><div class="input-group">
            <span class="input-group-addon">Cuartos:</span>
            <input type="text" id="Cuartos" name="Cuartos" class="form-control num2" maxlength="2" autocomplete="off">
          </div></div>
        </div>
      </div>
    </div>
      
    <div class="col-sm-8 col-my"><div class="input-group">
      <span class="input-group-addon">Observaciones:</span>
      <textarea type="text" id="Observ" name="Observ" class="form-control" placeholder="Escriba observaciones" style="height:80px; min-height:80px;"></textarea>
    </div></div>
  </div>

  <div class="row"  style="height:2px; background-color:#cccccc; margin-bottom:8px; margin-top:8px;">
  </div>

<!--Sección con los datos de la casa seleccionada-->  
  <div class="row">
  <div id="CasaPanel" class="col-sm-4 col-my">
    <div class="input-group text-left">
      <span class="input-group-addon" style="width:0.001%;">
        Casa: <b><span id="Casa"></span></b>
      </span>
      <span class="input-group-addon" style="text-align:right;">
          <img id="btnQuitaCasa" src="img/DelCasa.png" title="Quita la casa para cambiarla por otra" onClick="QuitarCasa();">
          <img id="btnCasaOcupada" src="img/CasaOcupada.png" title="Quita la casa y la marca como ocupada" onClick="OpenDlg(2);">
<!--        <button type="button" id="btnNoDisponible" class="btn btn-primary btn-xs" onClick="OpenDlg(2);"> no disponible</button>
-->      </span>
    </div>
  </div>
    
  <div class="col-sm-4 col-my">
    <div class="input-group text-left">
      <span class="input-group-addon" style="width:0.001%;"><input id="CopiaP" name="CopiaP" type="checkbox"></span>
      <span class="input-group-addon" style="text-align:left;">
        Popia a propietario
      </span>
    </div>
  </div>
  
  <div class="col-sm-4 col-my">
    <div class="input-group text-left">
      <span class="input-group-addon" style="width:0.001%;"><input id="Confirmada" name="Confirmada" type="checkbox"></span>
      <span class="input-group-addon" style="text-align:left;">
        Confirmada
      </span>
    </div>
  </div>
  
  </div>
  
  <div class="row">
    <div class="col-sm-6 col-my"> <div class="input-group">
      <span class="input-group-addon" style="padding:6px;">Precio:</span>
      <span class="input-group-addon" style="padding:1px; width:50%;">
        <input type="text" id="Precio" name="Precio" class="form-control num1" autocomplete="off">
      </span>
      <span class="input-group-addon" style="padding:6px;">Deposito:</span>
      <span class="input-group-addon" style="padding:1px; width:50%;">
        <input type="text" id="Deposito" name="Deposito" class="form-control num1" autocomplete="off">
      </span>
    </div></div>
    
    <div class="col-sm-6 col-my"> <div class="input-group">
      <span class="input-group-addon" style="padding:6px;">Comisión:</span>
      <span class="input-group-addon" style="padding:1px; width:50%;">
        <input type="text" id="Comision" name="Comision" class="form-control num1" autocomplete="off">
      </span>
      <span class="input-group-addon" style="padding:6px;">Cobrado:</span>
      <span class="input-group-addon" style="padding:1px; width:50%;">
        <input type="text" id="Cobrado" name="Cobrado" class="form-control num1" autocomplete="off">
      </span>
    </div></div>
    
  </div>

  <div class="row">
    <div class="col-sm-4 col-my">
      <button type="button" id="btnClose" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="Cerrar();">Cerrar</button>
    </div>
    <div class="col-sm-4 col-my">
      <button type="button" id="btnQuitar" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="Quitar();">Quitar</button>
    </div>
    <div class="col-sm-4 col-my">
      <button type="button" id="btnAction" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="ValidateDatos();">Adicionar</button>
    </div>
  </div>

  <div class="row"  style="height:2px; background-color:#cccccc; margin-bottom:5px; margin-top:10px;">
  </div>

<!--Sección con la lista de las casas disponibles-->  
<div id="LstCasas" class="row" style="margin-top:15px;">
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><span>Casas Disponibles</span> 
      <div class="btn-group block-right" role="group" style="margin-top:-8px;">
        <button type="button" class="btn btn-default"  onClick="OpenDlg(1);">Buscar Casas</button>
      </div>
    </h3>
  </div>
  <div class="panel-body">
    <table id="lstCasas" class='table'>
      <thead><tr><th>Localidad</th><th>Propietario</th><th>Telefono</th><th>Habitaciones</th><th>Personas</th><th>Precio</th><th>Comisión</th></thead>
        <tbody id="lstCasasBody">
        </tbody>
    </table>  
  </div>
</div>
</div>

<input type="hidden" id="fEntra" name="fEntra">
<input type="hidden" id="IdCasa" name="IdCasa">
</form>
</div>

<!--Dialogo para buscar casa-->  
<div id="dlgFiltrar" title="Filtrar las casas a seleccionar" style="padding-bottom:0px; width:400px;">
  <div class="container-fluid" style="margin:0px; padding:0px;">
    <div class="row">
      <div class="col-xs-12"> <div class="input-group">
        <span class="input-group-addon">Propietario:</span>
        <input type="text" id="fPropiet" class="form-control" placeholder="Todos">
      </div></div>
      
      <div class="col-xs-12"> <div class="input-group">
        <span class="input-group-addon">Localidad:</span>
        <select id="lstCiudad" name="lstCiudad" class="form-control" >
        </select>
      </div></div>
    </div>
  </div>
  <div style="font-size:xx-small"><b>Nota:</b> Se tienen en cuenta los datos de la primera sección y los datos de ocupación.</div>
</div>

<!--Dialogo para marcar una casa como ocupada-->  
<div id="dlgOcupada" >
  <div class="container-fluid" style="margin:0px; padding:0px;">
    
    <div class="row">
      <div class="col-sm-12 col-my"><div class="input-group">
        <span class="input-group-addon">Quedarán:</span>
        <input type="text" id="OcupCuartos" name="OcupCuartos" class="form-control num3" maxlength="2" autocomplete="off" style="width:50px">
        <span class="input-group-addon" style="width:100%; text-align:left;">cuartos disponibles</span>
      </div></div>
    </div>
    
    <div class="row">
      <span style="padding-left:10px; font-size:14px;	color: #555;">Mientras la casa este ocupada en el período </span>
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
  </div>
</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<!-- <script src="js/jquery.js"></script> -->
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>

<script src="js/jquery-ui.js"></script>
<script src="js/jquery.ui.datepicker-es.js"></script>

<script src="js/FechasRange.js"></script>

<script type="text/javascript">
var DateObjs, DatesOcup;
var ReadOnly = false;
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  if( !(Datos.Perms & 8) )
    {
    $("#Precio").keypress(function() {return false;});
    $("#Deposito").keypress(function() {return false;});
    $("#Comision").keypress(function() {return false;});
    $("#Cobrado").keypress(function() {return false;});
    
    $("#Precio").css("background-color", "#EEE");
    $("#Deposito").css("background-color", "#EEE");
    $("#Comision").css("background-color", "#EEE");
    $("#Cobrado").css("background-color", "#EEE");
    }
  
  $("#UserName").text( Datos.UserName ); 
  
  DateObjs  = new LinkDates2( "#FromFecha", "#FromDia", "#ToFecha", "#ToDia", "#nDias")
  DatesOcup = new LinkDates3( "#FOcupIni", "#FOcupEnd")
    
  $("#lstCiudad").load("Handles/FillCombo.php", "All=1&Table=Ciudad&OderBy=Name"); 
  UpdatePage();
  });
  
function SetReadOnly()
  {
  $("input").attr("disabled",true);
  $("button").attr("disabled",true);
  $("select").attr("disabled",true);
  $("textarea").attr("disabled",true);
  
  $("#btnClose").attr("disabled",false);
  
  $("#btnQuitaCasa").css("visibility", "hidden");
  $("#btnCasaOcupada").css("visibility", "hidden");
  
  ReadOnly = true;
  }

function OpenDlg( tipo )
  {
  if( tipo==1 )
    {  
  	$("#dlgOcupada").dialog( "close" );
    $("#dlgFiltrar").dialog( "open" );  
    }
  else
    {
  	$("#dlgFiltrar").dialog( "close" );
    
    var casa = $("#Casa").text();
    var caption = "Casa de '" + casa + "'.";
    
    $("#OcupCuartos").val(0);
    
    var fIni = new Date( DateObjs.getFechaIni() );
    var fFin = new Date( DateObjs.getFechaEnd() );
    DatesOcup.IniDatos( fIni, fFin );
    
    $("#dlgOcupada").dialog( { title: caption} );  
    $("#dlgOcupada").dialog( "open" );  
    }  
  }
  
$( "#dlgFiltrar" ).dialog({	autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseFilter},] });
   
function CloseFilter()
  {
	$("#dlgFiltrar").dialog( "close" );
  
  var FechaIni = DateObjs.getFechaIni();
  var DiaIni   = DateObjs.getDiaIni();
  var DiaFin   = DateObjs.getDiaEnd();
  var Cuartos  = $("#Cuartos").val();

  var Propietario = $("#fPropiet").val();
  var Localidad   = $("#lstCiudad").val();

  var nDias  = DiaFin-DiaIni;
    
  var Params = "IDResrv=" + Datos.IDResrv + "&" +
               "FechaIni=" + FechaIni + "&" +
               "NDias=" + nDias  + "&" +
               "Cuartos=" + Cuartos + "&" +
               "Propietario=" + Propietario + "&" +
               "Localidad=" + Localidad ;

  $("#lstCasas").load("Handles/FiltrarCasas.php",Params); 
  }
  
$( "#dlgOcupada" ).dialog({	autoOpen:false,	width:400, 	buttons:[ {text:"Marcar Ocupada", click:MarcarOcupada} ] });
   
function QuitarCasa()
  {
  if( !Datos.IdCasa ) {BorrarCasaDatos(); return;}
   
  var Params = "IdReserv=" + Datos.IDResrv + "&" +
               "IdCasa=" + Datos.IdCasa + "&" +
               "DiaIni=" + Datos.DiaIni + "&" +
               "JSon=1";
               
  jQuery.get("Handles/DeleteCasaReserva.php?"+Params)
  .success(function(data) 
            {
            if( data=="OK") { BorrarCasaDatos(); }
            else            { alert("Error al quitar la casa de reserva:\r\n" + data); }
            })
  .error(function(data) 
           { 
           alert("Error al quitar la casa de reserva:\r\n" + data.statusText ); 
           });
  }

function BorrarCasaDatos()
  {
  $("#Casa").text("");
  $("#Precio").val("");
  $("#Comision").val("");
  
  $("#btnQuitaCasa").css("visibility", "hidden");
  $("#btnCasaOcupada").css("visibility", "hidden");
  
  $("#btnQuitar").css("visibility", "hidden");
  $("#LstCasas").css("display","block");
  Datos.IdCasa = undefined;
  $("#IdCasa").val(undefined);
  }
  
function MarcarOcupada()
  {
  var Params = "IdCasa=" + $("#IdCasa").val() + "&" +
               "FIni='" + DatesOcup.GetFechaIni() + "'&" +
               "FEnd='" + DatesOcup.GetFechaEnd() + "'&" +
               "Hab=" + $("#OcupCuartos").val();
               
  jQuery.get("Handles/MarkCasaOcupada.php?"+Params)
  .success(function(data) 
     {
     if( data!="OK") { alert("Error al poner casa como ocupada:\r\n" + data); }
     else { $("#lstCasasBody").text(""); }
     })
  .error(function(data)   { alert("Error al poner casa como ocupada:\r\n" + data.statusText ); });
           
  QuitarCasa();         
  }
  
function UpdatePage()
  {
  if( !(Datos.Perms & 2) ) SetReadOnly();
  
  if( !Datos.IdCasa )  
    {
    $("#btnAction").text("Adicionar");
    $("#btnQuitar").css("visibility", "hidden");
    
    $("#btnQuitaCasa").css("visibility", "hidden");
    $("#btnCasaOcupada").css("visibility", "hidden");
    
    $("#LstCasas").css("display","block");
    $("#InfoMenu").css("visibility", "hidden");
    
    DateObjs.IniDatos( Datos.FechaIni, Datos.Dias, 0, Datos.Dias );
    
    $("#Cuartos").val( Datos.Cuartos );
    $("#Personas").val( Datos.Persons );
    }
  else
    {
    if( Datos.IdEstado>=6 )   SetReadOnly();
    if( !(Datos.Perms & 16) &&  (Datos.IdOperador!=Datos.UserID) ) SetReadOnly();
    
    $("#btnAction").text("Modificar");
    $("#btnQuitar").css("visibility", "visible");
    $("#LstCasas").css("display","none");
    
    DateObjs.IniDatos( Datos.FechaIni, Datos.Noches, Datos.DiaIni, Datos.DiaEnd);
    
    $("#IdCasa").val(Datos.IdCasa);
    
    $("#Cuartos").val( Datos.Cuartos );
    $("#Personas").val( Datos.Persons );

    $("#Casa").text(Datos.Propietario);
    $("#Precio").val(Datos.Precio);
    $("#Comision").val(Datos.Comision);

    $("#Cobrado").val(Datos.Cobrado);
    $("#Observ").text(Datos.Observ);
    $("#Deposito").val(Datos.Deposito);
  
    if( Datos.CopiaProp ) $("#CopiaP").attr("checked", true );
    else                  $("#CopiaP").removeAttr("checked");
    
    if( Datos.Confirmada ) $("#Confirmada").attr("checked", true );
    else                   $("#Confirmada").removeAttr("checked");
    
    
    }  
  }
  
function OnSelectCasa( idCasa )
  {
  $("#IdCasa").val(idCasa);
    
  var IdPropiet  = "#Propietario" + idCasa;
  var IdPrecio   = "#Precio" + idCasa;
  var IdComision = "#Comision" + idCasa;
  
  var Propiet  = $(IdPropiet).text();
  var Precio   = $(IdPrecio).text();
  var Comision = $(IdComision).text();
  
  $("#Casa").text(Propiet);
  $("#Precio").val(Precio);
  $("#Comision").val(Comision);
  $("#btnQuitaCasa").css("visibility", "visible");
  $("#btnCasaOcupada").css("visibility", "visible");
  }

function ValidateDatos()
  {
  if( !$("#IdCasa").val() )
    {
    alert("Debe seleccionar una casa primero");  
    return;
    }
    
  var Cob = $("#Cobrado").val();
  if( Cob.length==0 ) $("#Cobrado").val(0);
    
  var Dep = $("#Deposito").val();
  if( Dep.length==0 ) $("#Deposito").val(0);
    
  var URL = "Handles/AddCasaReserva.php?IdReserv="+Datos.IDResrv;  
  if( Datos.IdCasa ) URL = "Handles/ModifyCasaReserva.php?IdReserv="+Datos.IDResrv+"&IdCasa="+Datos.IdCasa+"&FromDiaOld="+Datos.DiaIni;  
  
  $("#DataForm").attr( "action", URL );
  $("#DataForm").submit();  
  }
  
function Cerrar()
  {
  document.location = Datos.LastPage;  
  }
  
function Quitar()
  {
  var Params = "IdReserv=" + Datos.IDResrv + "&" +
               "IdCasa=" + Datos.IdCasa + "&" +
               "DiaIni=" + Datos.DiaIni ;
               
  document.location = "Handles/DeleteCasaReserva.php?"+Params;  
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
  
function OnInfoReserva()
  {
  window.open( "InformeReserva.php?IdReserv="+Datos.IDResrv+"&IdCasa="+Datos.IdCasa, "InfoReserva"+Datos.IDResrv );
  } 
  
</script>

</body>
</html>