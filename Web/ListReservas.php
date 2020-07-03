<!doctype html>
<html lang="es">
<?php 
session_start();
if( empty($_SESSION["UserName"]) ) 
  {
  header( 'Location: index.php' ) ;
  }
  
$Datos = "<script> Datos= { ";
$Datos .= "Perms:".$_SESSION["Permisos"].", ";
$Datos .= "UserName:'".$_SESSION['UserName']."'";
$Datos .= " }; </script>";

echo $Datos;
?>

<head>
<title>Proximas reservas</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
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

<div class="panel panel-info center-block" style="max-width:1050px;">
  <div class="panel-heading">
    <h3 class="panel-title">Proximas Reservas    
    <div class="btn-group block-right" role="group" style="margin-top:-7.5px;">
      <button type="button" id="NewReserva" class="btn btn-default" style="margin-right:20px;">Nueva</button>
      <button type="button" id="MesPrev" class="btn btn-default">Anteriores</button>
      <div id="NowMes" class="btn">0</div>
      <button type="button" id="MesNext" class="btn btn-default">Proximas</button>
    </div>
    </h3>
  </div>
  <div class="panel-body"> 
    <table class='table'>
       <thead><tr>
         <th style="width:60px;">#</th>
         <th title="Correo del que realiza la reservación">Correo</th>
         <th title="Persona que realiza la reservación">Nombre</th>
         <th style="width:100px;" title="País de origen de la reservación">Pais</th>
         <th style="width:80px;" title="Fecha de creación la reservación">Reservada</th>
         <th style="width:80px;" title="Fecha de inicio de la reservación">Inicio</th>
         <th style="width:20px;" title="Número de noches de la reservación">Noc.</th>
         <th style="width:20px;" title="Número de personas de la reservación">Per.</th>
         <th style="width:20px;" title="Número de habitaciones de la reservación">Hab.</th>
         <th style="width:20px;" title="Tipo de reservación">Tipo</th>
         <th style="width:95px;" title="Estado ejecución de reservación">Estado</th>
       </tr></thead>
       <tbody id="listReservas">
       </tbody>
    </table>  
  </div>
  
  <div class="panel-footer">
    <div class="btn-group block-right" role="group">
      <button type="button" id="btnAllUsers" class="btn btn-default">Todos los operadores</button>
    </div>
  </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>

<script type="text/javascript">
var nowMes  = 0;
var AllUser = 0;
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  $("#UserName").text( Datos.UserName ); 
  
  $("#NewReserva").click(function() { document.location = "EditReserva.php"; });
  $("#MesPrev").click( function() { OnChangeMes(-1);} );
  $("#MesNext").click( function() { OnChangeMes(1);} );
  $("#NowMes").click( function() { OnChangeMes(0);} );
  $("#btnAllUsers").click( AllUsers );
  
  $("#listReservas").load("Handles/ListReservasMes.php");
  });

function OnClickReserva(idReserva)
  {
  document.location = "EditReserva.php?IDResrv=" + idReserva;  
  }
   
function OnChangeMes( addMes )
  {
  if( addMes==0 ) {nowMes=0;}
  else            {nowMes += addMes};  
  
  UpdateReservas();
  
  $("#NowMes").text(nowMes);
  }
   
function AllUsers()
  {
  if( AllUser ) 
    {
    AllUser=0;
    $("#btnAllUsers").text("Todos los operadores");
    }
  else
    {
    AllUser=1; 
    $("#btnAllUsers").text("Operador actual");
    }
   
  UpdateReservas();
  }

function UpdateReservas()
  {
  var sUsers = (AllUser==0)? "" : "&AllUsers=1";
  $("#listReservas").load("Handles/ListReservasMes.php?StartMes="+nowMes+sUsers);
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