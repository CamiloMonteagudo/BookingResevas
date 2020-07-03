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
<title>Listado de Paises</title>

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

<div class="panel panel-info center-block" style="max-width:512px">
  <div class="panel-heading">
    <div class="panel-title">
      <span class="cond-title">Paises</span> 
    </div>
  </div>

  <div class="panel-body"> 
    <table class='table'>
      <thead><tr>
      <th title="Nombre del País">Nombre</th>
      </thead>
        <tbody id="lstCasasBody">
        </tbody>
    </table>  
    
  </div>
  
  <div class="panel-footer">
    <div class="btn-group sel-orden" role="group">
      <button type="button" id="btnNew" class="btn btn-default" onClick="OnNewPais()">Nuevo</button>
    </div>
    <div class="btn-group block-right" role="group" style="top:-37px;">
      <button type="button" id="btnPrev" class="btn btn-default">&lt;</button>
      <button type="button" id="btnNext" class="btn btn-default">&gt;</button>
    </div>
  </div>
</div>

<div id="dlgPais" title="Datos del Pais">
  <div class="input-group"><span class="input-group-addon">Nombre:</span>
    <input type="text" id="Nombre" class="form-control" placeholder="Escriba nombre del País">
  </div>
</div>

<div id="dlgNew" title="Datos del País">
  <div class="input-group"><span class="input-group-addon">Nombre:</span>
    <input type="text" id="NombreNew" class="form-control" placeholder="Escriba nombre del País">
  </div>
</div>

</div>

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.ui.datepicker-es.js"></script>
<script src="js/FechasRange.js"></script>

<script type="text/javascript">

var sOrder = "ORDER BY IdPais"; 

var Page = 0;  
var nRec = 30;  
var nPages = 1000;  
var FechaTipo = 0;  
var NowItem = -1;  

var DatesOcup, DatesFilter;
$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  $("#btnPrev").click( function() { if(Page>0     ) DoQuery(--Page);} );
  $("#btnNext").click( function() { if(Page<nPages) DoQuery(++Page);} );
    
  $("#UserName").text( Datos.UserName ); 
  
  DoQuery(-1);  
  });
  
function DoQuery( page )
  {
  if( page == -1) 
    {
    page = 0;  
    nPages = 10000;
    } 
    
  var sQuery = "SELECT IdPais, Nombre FROM Pais ";

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
      var sHtml = "";
      for( i=0; i<nRows; ++i ) 
        {
        var row = ret.rows[i];  
        
        sHtml += "<tr onClick='OnClickLista(" + row[0] +");'>"; 
        sHtml += "<td id='Item"+ row[0] +"'>" + row[1] + "</td>";
        sHtml += "</tr>"; 
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
  
function showBtns()
  {
  var visNext = (Page>=nPages)? "hidden" : "visible";
  var visPrev = (Page<=0     )? "hidden" : "visible";
  
  $("#btnNext").css("visibility", visNext);
  $("#btnPrev").css("visibility", visPrev);
  }

function OnClickLista( IdPais )
  {
	$("#dlgNew").dialog( "close" );
  
  NowItem = IdPais;
  
  var sId = "#Item" + IdPais;
  var sName = $(sId).text();
  
  $("#Nombre").val( sName );
  
	$("#dlgPais").dialog( "open" );
  }

$("#dlgPais").dialog({
	autoOpen: false,
	width: 350,
	buttons: [ {text:"Borrar", click:function() {BorrarPais();}}, {text:"Modificar", click:function() {ModificarPais(1);}}	]
});

function BorrarPais()
  {
	$("#dlgPais").dialog( "close" );
  
  jQuery.post( "Handles/DoAction.php", "Query=DELETE FROM Pais WHERE IdPais="+ NowItem)
  .success(function(data) 
            {
            if( data=="OK" ) DoQuery(-1);  
            else             alert("Error al borrar la localidad:\r\n" + data ); 
            })
  .error(function(data) 
           { 
           alert("Error al borrar la localidad:\r\n" + data.statusText ); 
           });
  }
  
function ModificarPais()
  {
	$("#dlgPais").dialog( "close" );
  
  jQuery.post( "Handles/DoAction.php", "Query=UPDATE Pais SET Nombre='"+$("#Nombre").val()+"' WHERE IdPais = " + NowItem)
  .success(function(data) 
            {
            if( data=="OK" )  DoQuery(-1);  
            else              alert("Error al adicionar la localidad:\r\n" + data ); 
            })
  .error(function(data) 
           { 
           alert("Error al adicionar la localidad:\r\n" + data.statusText ); 
           });
  }

function OnNewPais()
  {
	$("#dlgPais").dialog( "close" );
	$("#dlgNew").dialog( "open" );
  }
   
$("#dlgNew").dialog({
	autoOpen: false,
	width: 350,
	buttons: [ {text:"Adicionar", click:function() {AddPais();}} ]
});
   
function AddPais()
  {
	$("#dlgNew").dialog( "close" );
  NowItem = -1;
  
  jQuery.post( "Handles/DoAction.php", "Query=INSERT INTO Pais (Nombre) VALUES ('"+ $("#NombreNew").val() +"')" )
  .success(function(data) 
            {
            if( data=="OK" )  DoQuery(-1);  
            else              alert("Error al adicionar la localidad:\r\n" + data ); 
            })
  .error(function(data) 
           { 
           alert("Error al adicionar la localidad:\r\n" + data.statusText ); 
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
