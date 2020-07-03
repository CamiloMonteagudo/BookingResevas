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
$Datos .= "UserID:".$_SESSION["UserID"].", ";
$Datos .= "Perms:".$_SESSION["Permisos"].", ";

if( empty($_GET["IdOperador"]) )
  {  
  $Datos .= "Nombre:'', ";
  $Datos .= "PassWord:'', ";
  $Datos .= "Correo:'', ";
  $Datos .= "Telefono:'', ";
  $Datos .= "Permisos:0, ";
  $Datos .= "Ganacia:0";
  }
else
  {
  $IdOperador = $_GET["IdOperador"];
  include 'Handles/OpenDb.php';   

  $resp = mysqli_query($myDB, "CALL OperadorDatos($IdOperador)") or die(mysqli_error($myDB));

  if( $resp && $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
    {
    $Datos .= "IdOperador:".$IdOperador.", ";
    $Datos .= "Nombre:'".$row["Nombre"]."', ";
    $Datos .= "PassWord:'".$row["PassWord"]."', ";
    $Datos .= "Correo:'".$row["Correo"]."', ";
    $Datos .= "Telefono:'".$row["Telefono"]."', ";
    $Datos .= "Permisos:".$row["Permisos"].", ";
    $Datos .= "Ganacia:".$row["Ganacia"];
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
<div class="jumbotron center-block" style="border-radius:30px; max-width:600px;">
  <div class="row datos-title"> Datos del operador</div>
  <form role="form" id="DataForm" class="text-left" method="POST">

  <div class="row">
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Nombre:</span>
      <input type="text" id="Operador" class="form-control" autocomplete="off">
    </div></div>
    
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Teléfono:</span>
      <input type="text" id="Telef"class="form-control" autocomplete="off">
    </div></div>
  </div>
    
  <div class="row">
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Contraseñas:</span>
      <input type="text" id="Password" class="form-control" autocomplete="off">
    </div></div>
    
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Correo:</span>
      <input type="text" id="Correo" class="form-control" autocomplete="off">
    </div></div>
  </div>
    
  <div class="row">
    <div class="col-sm-6 col-my"><div class="input-group">
      <span class="input-group-addon">Ganacia:</span>
      <input type="text" id="Ganancia" class="form-control" autocomplete="off">
    </div></div>
  </div>
    
  <div class="row"  style="height:2px; background-color:#cccccc; margin-bottom:8px; margin-top:8px;"></div>
  <div class="row" style="text-align:center; font-size:16px; color:#3395F0; font-weight:bold;">Permisos</div>

  <div class="row">
    <div class="col-sm-4 col-my"><div class="input-group">
      <div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="P_User" type="checkbox"></span>
        <span class="input-group-addon" style="text-align:left;">Administrar usuarios</span>
      </div>
    </div></div>
    
    <div class="col-sm-4 col-my"><div class="input-group">
      <div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="P_Reserv" type="checkbox"></span>
        <span class="input-group-addon" style="text-align:left;">Tramitar reservas</span>
      </div>
    </div></div>
    
    <div class="col-sm-4 col-my"><div class="input-group">
      <div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="P_Casas" type="checkbox"></span>
        <span class="input-group-addon" style="text-align:left;">Administrar casas</span>
      </div>
    </div></div>
    
  </div>

  <div class="row">
    <div class="col-sm-4 col-my"><div class="input-group">
      <div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="P_Precios" type="checkbox"></span>
        <span class="input-group-addon" style="text-align:left;">Modificar precios</span>
      </div>
    </div></div>
    
    <div class="col-sm-4 col-my"><div class="input-group">
      <div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="P_Admin" type="checkbox"></span>
        <span class="input-group-addon" style="text-align:left;">Administrar el sistema</span>
      </div>
    </div></div>
    
  </div>

  <div class="row">
    <div class="col-sm-4 col-my">
      <button type="button" id="btnClose" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="Cerrar();">Cerrar</button>
    </div>
    <div class="col-sm-4 col-my">
      <button type="button" id="btnQuitar" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="Quitar();">Borrar</button>
    </div>
    <div class="col-sm-4 col-my">
      <button type="button" id="btnAction" class="btn btn-primary center-block" style="margin-top: 10px;" onClick="ValidateDatos();">Adicionar</button>
    </div>
  </div>

</form>
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
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  $("#UserName").text( Datos.UserName ); 
  
  UpdatePage();
  });

function UpdatePage()
  {
  if( !(Datos.Perms & 1) ) SetReadOnly();
  
  if( !Datos.IdOperador )  
    {
    $("#btnAction").text("Adicionar");
    $("#btnQuitar").css("visibility", "hidden");
    }
  else
    {
    $("#btnAction").text("Modificar");
    $("#btnQuitar").css("visibility", "visible");
    }  
    
  $("#Operador").val( Datos.Nombre );
  $("#Password").val( Datos.PassWord );
  $("#Correo").val( Datos.Correo );
  $("#Telef").val( Datos.Telefono );
  $("#Ganancia").val( Datos.Ganacia );
  
  var perm = Datos.Permisos;
  if( Datos.IdOperador==1 )  
    {
    perm = 31;
    
    $("#P_User").attr("disabled",true);
    $("#P_Reserv").attr("disabled",true);
    $("#P_Casas").attr("disabled",true);
    $("#P_Precios").attr("disabled",true);
    $("#P_Admin").attr("disabled",true);
    }
  
  if( perm & 1 ) $("#P_User").attr("checked", true );
  else           $("#P_User").removeAttr("checked");
  
  if( perm & 2 ) $("#P_Reserv").attr("checked", true );
  else           $("#P_Reserv").removeAttr("checked");
  
  if( perm & 4 ) $("#P_Casas").attr("checked", true );
  else           $("#P_Casas").removeAttr("checked");
  
  if( perm & 8 ) $("#P_Precios").attr("checked", true );
  else           $("#P_Precios").removeAttr("checked");
  
  if( perm & 16 ) $("#P_Admin").attr("checked", true );
  else            $("#P_Admin").removeAttr("checked");
  }

function SetReadOnly()
  {
  $("input").attr("disabled",true);
  $("button").attr("disabled",true);
  $("select").attr("disabled",true);
  $("textarea").attr("disabled",true);
  
  $("#btnClose").attr("disabled",false);
  }
  
function GetParams()
  {
  var Params = "Nombre=" + $("#Operador").val() +
               "&PassWord=" + $("#Password").val() +
               "&Correo=" + $("#Correo").val() +
               "&Telefono=" + $("#Telef").val() +
               "&Ganacia=" + $("#Ganancia").val();
               
  if( Datos.IdOperador )  
    Params += "&IdOperador=" + Datos.IdOperador;
    
  Params += "&Permisos=" + GetPermisos();
  
  return Params;             
  }

function GetPermisos()
  {
  var perm = 0;
  
  if( isChecked("P_User")    ) perm |= 1;
  if( isChecked("P_Reserv")  ) perm |= 2;
  if( isChecked("P_Casas")   ) perm |= 4;
  if( isChecked("P_Precios") ) perm |= 8;
  if( isChecked("P_Admin")   ) perm |= 16;
  
  return perm;  
  }

function isChecked(s)
  {
  return document.getElementById(s).checked;  
  }
  
function strNoOk(s)
  {
  if( s.indexOf('"') >= 0 ) return true; 
  if( s.indexOf("'") >= 0 ) return true; 
  if( s.indexOf("&") >= 0 ) return true; 
  }

function ValidateDatos()
  {
  var prop  = $("#Operador").val();
  var Telef = $("#Telef").val(); 
  var PassWrd = $("#Password").val(); 
  
  if( !prop || !Telef || !PassWrd)
    {
    alert("Hay especificar al menos el nombre del operador, la contraseñas y el teléfono.");
    return;  
    }
    
  if( strNoOk(prop) || strNoOk(Telef) ||  strNoOk(PassWrd) || strNoOk($("#Correo").val()) )
    {
    alert("Los caracteres ', \" o & no son permitidos en los datos de texto");
    return;  
    }
    
  jQuery.post( "Handles/ModifyOperador.php", GetParams() )
  .success(function(data) 
            {
            if( data=="OK") { Cerrar(); } 
            else            { alert("Error al adicionar/modificar un operador:\r\n" + data); }
            })
  .error(function(data) 
           { 
           alert("Error al adicionar/modificar un operador:\r\n" + data.statusText ); 
           });
  }
  
function Cerrar()
  {
  document.location =  Datos.LastPage;  
  }

function Quitar()
  {
  if( Datos.IdOperador==1 )  
    {
    alert("El administrador del sistema no se puede quitar, ni modificar sus permisos");  
    return;  
    }
    
  jQuery.post( "Handles/DoAction.php", "Query=DELETE FROM operador WHERE IdOperador="+ Datos.IdOperador)
  .success(function(data) 
            {
            if( data=="OK" ) Cerrar();  
            else             alert("Error al borrar el operador:\r\n" + data ); 
            })
  .error(function(data) 
           { 
           alert("Error al borrar el operador:\r\n" + data.statusText ); 
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
  
</script>

</body>
</html>