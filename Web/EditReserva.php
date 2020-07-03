<!doctype html>
<html lang="es">
<head>
<title>Edicci&oacute;n de una reserva</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link href="MyStyles.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet">

<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  {
  header( 'Location: index.php' ) ;
  exit(0);
  }

$LastPage = $_SERVER["HTTP_REFERER"]; 
if( strstr( $LastPage, "EditReserva") ) 
  {
  if( !empty($_SESSION["LastPage"]) ) $LastPage = $_SESSION["LastPage"];
  else                                $LastPage = "ListReservas.php";
  }
else $_SESSION["LastPage"] =  $LastPage;
  
$Datos  = "<script> Datos= { ";
$Datos .= "LastPage:'".$LastPage."', ";
$Datos .= "UserName:'".$_SESSION['UserName']."', ";
$Datos .= "UserID:".$_SESSION["UserID"].", ";
$Datos .= "Perms:".$_SESSION["Permisos"].", ";

if( empty($_GET["IDResrv"]) )
  {
  $Datos .= "Nombre:'', Correo:'', Personas:2, Cuartos:1, Deposito:0, VueloInfo:'', Observ:'', Trasfer:0, ResDia:0, ResMes:0, ResAno:0, InDia:0, InMes:0, InAno:0, Noches:1, IdPais:0, IdTipo:1, Estado:'', IdEstado:1, Operador:''";
  }
else  
  {
  $IDResrv = $_GET["IDResrv"];
  
  include 'Handles/OpenDb.php';   

  $resp = mysqli_query($myDB, "CALL ReservaDatos($IDResrv)") or die(mysqli_error($myDB));

  if( $resp && $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
    {
    $Datos .= "IdReserv:'".$IDResrv."', ";
    $Datos .= "Nombre:'".$row["Nombre"]."', ";
    $Datos .= "Correo:'".$row["Correo"]."', ";
    $Datos .= "Personas:".$row["Personas"].", ";
    $Datos .= "Cuartos:".$row["Cuartos"].", ";
    $Datos .= "Deposito:".$row["Deposito"].", ";
    $Datos .= "VueloInfo:'".$row["VueloInfo"]."', ";
    $Datos .= "Observ:'".$row["Observ"]."', ";
    $Datos .= "Trasfer:".$row["Trasfer"].", ";
    
    $Datos .= "ResDia:".$row["ResDia"].", "; 
    $Datos .= "ResMes:".($row["ResMes"]-1).", "; 
    $Datos .= "ResAno:".$row["ResAno"].", "; 
    
    $Datos .= "InDia:".$row["InDia"].", "; 
    $Datos .= "InMes:".($row["InMes"]-1).", "; 
    $Datos .= "InAno:".$row["InAno"].", "; 
    
    $Datos .= "Noches:".$row["Noches"].", "; 
    
    $Datos .= "IdPais:".$row["IdPais"].", "; 
    $Datos .= "IdTipo:".$row["IdTipo"].", "; 
    $Datos .= "Estado:'".$row["Estado"]."', "; 
    $Datos .= "IdEstado:".$row["IdReservaEstado"].", "; 
    $Datos .= "IdOperador:".$row["IdOperador"].", "; 
    $Datos .= "Operador:'".$row["Operador"]."', "; 
    $Datos .= "Hora:'".$row["Hora"]."'"; 
    } 
    
  else 
    {
    printf("Could not retrieve records: %s\n", mysqli_error($myDB));
    }
  
  mysqli_free_result($resp);
  mysqli_close($myDB);
  }
  
$Datos .= "}; </script>";
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
<div class="jumbotron" style="border-radius:30px; padding-bottom:0px;">
  <div class="row datos-title"> Datos de Reservación </div>
  <form role="form" id="DataForm" class="text-left" method="POST">
  
    <div class="row">
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">A nombre:</span>
        <input type="text" id="Nombre" name="Nombre" class="form-control" placeholder="Escriba quien realiza la reservación">
      </div></div>
      
      <div class="col-sm-6 col-my">
      <div class="input-group">
        <span class="input-group-addon">Correo:</span>
        <input type="text" id="Correo" name="Correo" class="form-control" placeholder="Escriba correo de contacto">
      </div></div>
    </div>

    <div class="row">
      <div class="col-sm-3 col-my"><div class="input-group">
        <span class="input-group-addon">Pais:</span>
        <select id="lstPais" name="lstPais" class="form-control" >
        </select>
      </div></div>
      
      <div class="col-sm-3 col-my"><div class="input-group">
        <span class="input-group-addon">Personas:</span>
        <input type="text" id="Personas" name="Personas" class="form-control num2" >
      </div></div>
      
      <div class="col-sm-3 col-my"><div class="input-group">
        <span class="input-group-addon">Cuartos:</span>
        <input type="text" id="Cuartos" name="Cuartos" class="form-control num2"" >
      </div></div>
      
      <div class="col-sm-3 col-my"><div class="input-group">
        <span class="input-group-addon">Deposito:</span>
        <input type="text" id="Deposito" name="Deposito" class="form-control num1"" >
      </div></div>
    </div>

    <div class="row">
      <div class="col-sm-3 col-my"><div class="input-group">
        <span class="input-group-addon">Desde:</span>
        <input type="text" id="from" class="form-control" style="line-height:1;">
      </div></div>
    
      <div class="col-sm-3 col-my"><div class="input-group">
        <span class="input-group-addon">Hasta:</span>
        <input type="text" id="to" class="form-control" style="line-height:1;">
      </div></div>
    
      <div class="col-sm-3 col-my"><div class="input-group">
        <span class="input-group-addon">D&iacute;as:</span>
        <input type="text" id="dias" value="1" name="dias" class="form-control" >
      </div></div>
      
    </div>

    <div class="row">
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">Info. Vuelo:</span>
        <input type="text" id="VueloInfo" name="VueloInfo" class="form-control" placeholder="Escriba información sobre el vuelo">
      </div></div>
      
      <div class="col-sm-6 col-my"><div class="input-group">
        <span class="input-group-addon">Observaciones:</span>
        <input type="text" id="Observ" name="Observ" class="form-control" placeholder="Escriba observaciones">
      </div></div>
    </div>

<div class="row">
  <div class="col-sm-3 col-my">
    <div class="input-group text-left">
      <span class="input-group-addon" style="width:0.001%;"><input id="Trasfer" name="Trasfer" type="checkbox"></span>
      <span class="input-group-addon" style="text-align:left;">
        Solicitud de deposito
      </span>
    </div>
  </div>
  
  <div id="EstadoPanel" class="col-sm-3 col-my">
    <div class="input-group text-left">
      <span class="input-group-addon" style="width:0.001%;">
        Estado:
      </span>
      <span id="Estado" class="input-group-addon" style="text-align:left; font-weight:bold">
      </span>
    </div>
  </div>
  
  <div class="col-sm-offset-3 col-sm-3 col-my"><div class="input-group">
    <span class="input-group-addon">Tipo:</span>
    <select id="Tipo" name="Tipo" class="form-control" >
      <option value="1">Casas</option>
      <option value="2">Turs</option>
    </select>
  </div></div>
</div>

<div id="LstCasas" class="row" style="margin-top:15px;">
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><span>Casas asociadas</span>
      <div class="btn-group block-right" role="group" style="margin-top:-8px;">
        <button type="button" class="btn btn-default"  onClick="AddCasa();">Adicionar</button>
      </div>
    </h3>
  </div>
  <div class="panel-body">
    <table id="lstCasas" class='table'>
      <thead><tr>
        <th>Localidad</th>
        <th>Propietario</th>
        <th style="width: 80px;" title="Día de entrada a la casa">Dia Ent.</th>
        <th style="width: 80px;" title="Dia de salida de la casa">Dia Sal.</th>
        <th style="width: 40px;" title="Cantidad de habitaciones">Hab.</th>
        <th style="width: 40px;" title="Cantidad de Personas">Per.</th>
        <th style="width: 40px;" title="Si la reservación esta confirmada">Confirmada</th>
        <th style="width: 60px;" title="Deposito para el pago de la casa">Deposito</th>
      </thead>
      <tbody>
      </tbody>
    </table>  
  </div>
</div>
</div>

<div class="row">
  <div class="col-sm-3 col-my">
    <button type="button" id="btnCerrar" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="OnCerrar();"> Cerrar </button>
  </div>
  <div class="col-sm-3 col-my">
    <button type="button" id="btnBorrar" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="OnBorrar();"> Borrar Reserva </button>
  </div>
  <div class="col-sm-3 col-my">
    <button type="button" id="btnCancel" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="OnCancelar();"> Cancelar Reserva</button>
  </div>
  <div class="col-sm-3 col-my">
    <button type="button" id="btnAction" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="ValidateDatos();"> Actualizar </button>
  </div>
</div>

<div class="row" style="margin-top:10px;">
  <div id="CreateInfo" class="col-sm-offset-4 col-sm-4 col-my">
    <div class="input-group text-left">
      <span class="input-group-addon" style="width:0.001%;">
          Creada: <b><span id="fReserv"></span></b> a las: <b><span id="fHora"></span></b>
      </span>
      <span class="input-group-addon">
          por: <b><span id="cOperador"></span></b>
      </span>
    </div>
  </div>
</div>

<input type="hidden" id="fEntra" name="fEntra">
</form>
</div>
  
<div id="dialog" title="Adicionar un país nuevo">
  <div class="input-group"><span class="input-group-addon">Nombre:</span>
    <input type="text" id="PaisNombre" class="form-control" placeholder="Escriba nombre del pais">
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
var lastPais = 0;
var DateObj; 
var ReadOnly = false;
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  $("#UserName").text( Datos.UserName ); 
  DateObj = new LinkDates( "#from", "#to", "#dias");
  
  $("#lstPais").load("Handles/FillCombo.php", "New=1&Table=Pais&SelVal="+Datos.IdPais, PaisesLoaded); 
  
  var Lst = "IDResrv=" + Datos.IdReserv + "&" +
            "EntDia="  + Datos.InDia + "&" +
            "EntMes="  + Datos.InMes + "&" +
            "EntAno="  + Datos.InAno ;
  
  $("#lstCasas").load("Handles/ListCasasReserva.php", Lst); 
  
  UpdatePage();
  });

function SetReadOnly()
  {
  $("input").attr("disabled",true);
  $("button").attr("disabled",true);
  $("select").attr("disabled",true);
  
 $("#btnCerrar").attr("disabled",false);

  ReadOnly = true;
  }
  
function PaisesLoaded()
  {
  $("#lstPais").click(function() 
    { 
    if( this.value==1000 ) $( "#dialog" ).dialog( "open" );
    else                   lastPais=this.value; 
    });
  }

$( "#dialog" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [ {text:"Ok",	click:function() {CloseDialog(1);}}, {text:"Cancel", click:function() {CloseDialog(0);}}	]
});
   
function CloseDialog( ok )
  {
  if( ok ) 
    {
    var name = $("#PaisNombre").val();
      
    $("#lstPais").load("Handles/FillCombo.php", "New=1&Add=1&AddProc=AddPais&Table=Pais&SelName="+name, PaisesLoaded); 
    }
  else  
    $("#lstPais").val(lastPais);
 
	$("#dialog").dialog( "close" );
  }
  
function UpdatePage()
  {
  if( !(Datos.Perms & 2) ) SetReadOnly();
  
  if( Datos.IdReserv ) 
    {
    if( Datos.IdEstado>=6 ) SetReadOnly();
    if( !(Datos.Perms & 16) &&  (Datos.IdOperador!=Datos.UserID) ) SetReadOnly();
    
    $("#LstCasas").css("display","block");
    $("#EstadoPanel").css("visibility", "visible");
    $("#CreateInfo").css("visibility", "visible");
    $("#btnAction").text("Actualizar");   
    $("#btnCancel").css("visibility", "visible");
    
    if( Datos.UserID == 1 ) $("#btnBorrar").css("visibility", "visible");
    else                    $("#btnBorrar").css("visibility", "hidden");
    
    $("#Estado").text( Datos.Estado);
  
    if( Datos.ResDia > 0 )
      {
      var fCreate = new Date(Datos.ResAno,Datos.ResMes,Datos.ResDia);
      $("#fReserv").text( FormatDate(fCreate) );
      $("#fHora").text( Datos.Hora );
      }
  
    $("#cOperador").text( Datos.Operador);
    $("#Deposito").val("0");
    }
  else
    {
    $("#LstCasas").css("display","none"); 
    $("#EstadoPanel").css("visibility", "hidden");
    $("#CreateInfo").css("visibility", "hidden");
    $("#btnAction").text("Adicionar");   
    $("#btnCancel").css("visibility", "hidden");
    $("#btnBorrar").css("visibility", "hidden");
    }
   
  $("#Nombre").val( Datos.Nombre );  
  $("#Correo").val( Datos.Correo );
    
  $("#Personas").val( Datos.Personas );
  $("#Cuartos").val( Datos.Cuartos );
  $("#Deposito").val( Datos.Deposito );
  
  var fEnt = new Date();
  if( Datos.InDia > 0 )
    fEnt = new Date(Datos.InAno,Datos.InMes,Datos.InDia);
  
  DateObj.IniDatos( fEnt, Datos.Noches);
  
  $("#VueloInfo").val( Datos.VueloInfo );
  $("#Observ").val( Datos.Observ );
  
  $("#Tipo").val( Datos.IdTipo );
  
  if( Datos.Trasfer )  $("#Trasfer").attr("checked", true );
  else                 $("#Trasfer").removeAttr("checked");
  }

function ValidateDatos()
  {
  $("#fEntra").val( DateObj.GetFecha() );
  
  if( !$("#Nombre").val() || !$("#Correo").val() )
    {
    alert("Hay especificar un nombre y un correo");
    return;  
    }
    
  var URL = "Handles/AddReserva.php";  
  if( Datos.IdReserv ) URL = "Handles/ModifyReserva.php?IdReserv="+Datos.IdReserv; 
  $("#DataForm").attr( "action", URL );

  $("#DataForm").submit();  
  }
  
function AddCasa()
  {
  $("#fEntra").val( DateObj.GetFecha() );
    
  var URL = "EditReservaCasa.php?IdReserv="+Datos.IdReserv; 
  
  $("#DataForm").attr( "action", URL );
  $("#DataForm").submit();  
  }
  
function OnSelectCasa( IdCasa, DiaIni )
  {
 // if( ReadOnly ) return;
  
  $("#fEntra").val( DateObj.GetFecha() );
    
  var URL = "EditReservaCasa.php?IdReserv="+Datos.IdReserv+"&IdCasa="+IdCasa+"&DiaIni="+DiaIni; 
  
  $("#DataForm").attr( "action", URL );
  $("#DataForm").submit();  
  }

function OnCerrar()
  {
  document.location = Datos.LastPage;  
  }
  
function OnBorrar()
  {
  var ret = confirm("¿Esta seguro que quire borrar la reservación?\r\nLos datos de las reservaciones borradas no se pueden recuperar.");  
  if( !ret ) return;

  jQuery.post( "Handles/DoAction.php", "Query=DELETE FROM reserva WHERE IdReserva = " + Datos.IdReserv)
  .success(function(data) 
            {
            if( data=="OK" ) {OnCerrar();}
            else             {alert("Al borrar la reservación:\r\n" + data ); }  
            })
  .error(function(data) 
           { 
           alert("Al borrar la reservación:\r\n" + data.statusText ); 
           });
  }

function OnCancelar()
  {
  var ret = confirm("¿Desea Cancelar la reservación?\r\nLa reservación después de cancelada no puede ser modificada.");  
  if( !ret ) return;

  jQuery.post( "Handles/DoAction.php", "Query=UPDATE reserva SET IdReservaEstado = 7 WHERE IdReserva = " + Datos.IdReserv)
  .success(function(data) 
            {
            if( data=="OK" ) {document.location = document.location;}
            else             {alert("Error al cancelar la reservación:\r\n" + data ); }  
            })
  .error(function(data) 
           { 
           alert("Error al cancelar la reservación:\r\n" + data.statusText ); 
           });
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
  window.open( "InformeReserva.php?IdReserv="+Datos.IdReserv, "InfoReserva"+Datos.IdReserv );
  } 
  
</script>  

</body>
</html>