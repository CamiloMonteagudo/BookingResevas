<!doctype html>
<html lang="es">
<head>
<title>Modificación de los datos de una casa</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="MyStyles.css" rel="stylesheet" type="text/css">
<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  {
  header( 'Location: index.php' ) ;
  exit(0);
  }

if(!empty($_SERVER["HTTP_REFERER"])) $LastPage = $_SERVER["HTTP_REFERER"]; 
else                                 $LastPage = "ListReservas.php"; 

$Datos = "<script> Datos= { ";
$Datos .= "LastPage:'".$LastPage."', ";
$Datos .= "UserName:'".$_SESSION['UserName']."', ";
$Datos .= "Perms:".$_SESSION["Permisos"].", ";

if( empty($_GET["IdCasa"]) )
  {  
  $Datos .= "IdCiudad:0, ";
  $Datos .= "Propietario:'', ";
  $Datos .= "Telef:'', ";
  $Datos .= "Cuartos:1, ";
  $Datos .= "Personas:2, ";
  $Datos .= "Precio:20, ";
  $Datos .= "Comision:5, ";
  $Datos .= "Direccion:'', ";
  $Datos .= "Notas:''";
  }
else
  {
  $IdCasa = $_GET["IdCasa"];
  include 'Handles/OpenDb.php';   

  $resp = mysqli_query($myDB, "CALL CasaDatos($IdCasa)") or die(mysqli_error($myDB));

  if( $resp && $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
    {
    $Datos .= "IdCasa:".$IdCasa.", ";
    $Datos .= "IdCiudad:".$row["IdCiudad"].", ";
    $Datos .= "Propietario:'".$row["Propietario"]."', ";
    $Datos .= "Telef:'".$row["Telef"]."', ";
    $Datos .= "Cuartos:".$row["Habitaciones"].", ";
    $Datos .= "Personas:".$row["Personas"].", ";
    $Datos .= "Precio:".$row["PrecioHab"].", ";
    $Datos .= "Comision:".$row["ComisionHab"].", ";
    $Datos .= "Direccion:'".$row["Direccion"]."', ";
    $Datos .= "Notas:'".$row["Notas"]."'";
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
<div class="jumbotron center-block" style="border-radius:30px; max-width:750px;">
  <div class="row datos-title"> Datos de la casa</div>
  <form role="form" id="DataForm" class="text-left" method="POST">

  <div class="row">
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Propietario:</span>
      <input type="text" id="Propietario" name="Propietario" class="form-control" autocomplete="off">
    </div></div>
    
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Teléfono:</span>
      <input type="text" id="Telef" name="Telef" class="form-control" autocomplete="off">
    </div></div>
  </div>
    
  <div class="row">
    <div class="col-sm-12 col-my"><div class="input-group">
      <span class="input-group-addon">Dirección:</span>
      <textarea type="text" id="Direcc" name="Direcc" class="form-control" placeholder="Escriba la dirección" style="height:35px; min-height:35px;"></textarea>
    </div></div>
  </div>
    
  <div class="row">
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Localidad:</span>
      <select id="lstCiudad" name="lstCiudad" class="form-control" >
      </select>
    </div></div>
  </div>

  <div class="row">
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Habitaciones:</span>
      <input type="text" id="Cuartos" name="Cuartos" maxlength="2" class="form-control num2" >
    </div></div>
    
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Personas:</span>
      <input type="text" id="Persons" name="Persons" maxlength="2" class="form-control num2" >
    </div></div>
  </div>

  <div class="row">
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Precio:</span>
      <input type="text" id="Precio" name="Precio" class="form-control num1" >
    </div></div>
    
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Comisión:</span>
      <input type="text" id="Comision" name="Comision" class="form-control num1" >
    </div></div>
  </div>
  
  <div class="row">
    <div class="col-sm-12 col-my"><div class="input-group">
      <span class="input-group-addon">Notas:</span>
      <textarea type="text" id="Notas" name="Notas" class="form-control" placeholder="Escriba notas de la casa" style="height:75px; min-height:35px;"></textarea>
    </div></div>
  </div>

  <div class="row">
    <div class="col-sm-4 col-my">
      <button type="button" id="btnClose" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="Cerrar();">Cerrar</button>
    </div>
    <div class="col-sm-4 col-my">
      <button type="button" id="btnQuitar" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="QuitarCasa();">Borrar</button>
    </div>
    <div class="col-sm-4 col-my">
      <button type="button" id="btnAction" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="ValidateDatos();">Adicionar</button>
    </div>
  </div>

</form>
</div>
  
<div id="dialog" title="Adicionar una localidad nueva">
  <div class="input-group"><span class="input-group-addon">Nombre:</span>
    <input type="text" id="LocNombre" class="form-control" placeholder="Escriba nombre de la localidad">
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
var lastLoc;
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 

  $("#UserName").text( Datos.UserName ); 
  
  $("#lstCiudad").load("Handles/FillCombo.php", "New=1&OderBy=name&Table=ciudad&SelVal="+Datos.IdCiudad, LocalidadLoaded); 
  
  UpdatePage();
  });

function LocalidadLoaded()
  {
  $("#lstCiudad").click(function() 
    { 
    if( this.value==1000 ) $( "#dialog" ).dialog( "open" );
    else                   lastLoc=this.value; 
    });
  }

$( "#dialog" ).dialog({
	autoOpen: false,
	width: 350,
	buttons: [ {text:"Cerrar", click:function() {CloseDialog(0);}}, {text:"Adicionar", click:function() {CloseDialog(1);}}	]
});
   
function CloseDialog( ok )
  {
  if( ok ) 
    {
    var name = $("#LocNombre").val();
      
    $("#lstCiudad").load("Handles/FillCombo.php", "New=1&Add=1&OderBy=name&AddProc=AddLocalidad&Table=ciudad&SelName="+name, LocalidadLoaded); 
    }
 
	$("#dialog"   ).dialog( "close" );
  $("#lstCiudad").val(lastLoc);
  }
   
function QuitarCasa()
  {
  if( !Datos.IdCasa ) return;
               
  jQuery.post( "Handles/DoAction.php", "Query=DELETE FROM casa WHERE IdCasa="+ Datos.IdCasa)
  .success(function(data) 
            {
            if( data=="OK" ) Cerrar();  
            else             alert("Error al borrar la casa:\r\n" + data ); 
            })
  .error(function(data) 
           { 
           alert("Error al borrar la casa:\r\n" + data.statusText ); 
           });
  }
  
function UpdatePage()
  {
  if( !(Datos.Perms & 4) ) SetReadOnly();
  
  if( !Datos.IdCasa )  
    {
    $("#btnAction").text("Adicionar");
    $("#btnQuitar").css("visibility", "hidden");
    }
  else
    {
    $("#btnAction").text("Modificar");
    $("#btnQuitar").css("visibility", "visible");
    }  
    
  $("#lstCiudad").val( Datos.IdCiudad );
  $("#Propietario").val( Datos.Propietario );
  $("#Telef").val( Datos.Telef );
  $("#Cuartos").val( Datos.Cuartos );
  $("#Persons").val( Datos.Personas );
  $("#Precio").val( Datos.Precio );
  $("#Comision").val( Datos.Comision );
  $("#Direcc").val( Datos.Direccion );
  $("#Notas").val( Datos.Notas );
  }
  
function GetParams()
  {
  var Params = "IdLoc=" + $("#lstCiudad").val() + "&" +
               "Propiet=" + encodeURIComponent($("#Propietario").val()) + "&" +
               "Telef=" + encodeURIComponent($("#Telef").val()) + "&" +
               "Cuartos=" + $("#Cuartos").val() + "&" +
               "Persons=" + $("#Persons").val() + "&" +
               "Precio=" + $("#Precio").val() + "&" +
               "Comision=" + $("#Comision").val() + "&" +
               "Direcc=" + encodeURIComponent($("#Direcc").val()) + "&" +
               "Notas=" + encodeURIComponent($("#Notas").val()); 
               
  if( Datos.IdCasa )  
    Params += "&IdCasa=" + Datos.IdCasa;
    
  return Params;             
  }

//function strNoOk(s)
//  {
//  if( s.indexOf('"') >= 0 ) return true; 
//  if( s.indexOf("'") >= 0 ) return true; 
//  if( s.indexOf("&") >= 0 ) return true; 
//  }

function SetReadOnly()
  {
  $("input").attr("disabled",true);
  $("button").attr("disabled",true);
  $("select").attr("disabled",true);
  $("textarea").attr("disabled",true);
  
  $("#btnClose").attr("disabled",false);
  }

function ValidateDatos()
  {
  var prop  = $("#Propietario").val();
  var Telef = $("#Telef").val(); 
  
  if( !prop || !Telef )
    {
    alert("Hay especificar un propietario y un teléfono");
    return;  
    }
    
//  if( strNoOk(prop) || strNoOk(Telef) || strNoOk($("#Direcc").val())  || strNoOk($("#Notas").val()) )
//    {
//    alert("Los caracteres ', \" o & no son permitidos en los datos de texto");
//    return;  
//    }
  
  jQuery.post( "Handles/ModifyCasa.php", GetParams() )
  .success(function(data) 
            {
            if( data=="OK") { Cerrar(); }
            else            { alert("Error al adicionar/modificar Casa:\r\n" + data); }
            })
  .error(function(data) 
           { 
           alert("Error al adicionar/modificar Casa:\r\n" + data.statusText ); 
           });
  }
  
function Cerrar()
  {
  document.location =  Datos.LastPage;  
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