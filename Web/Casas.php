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

//var_dump( $_SERVER );
?>

<head>
<title>Listado de casas</title>

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
      <span class="cond-title">Listado de Casas</span> 
      <span class="cond-item" >Localidad:<a id="fLocalid" href='javascript:OpenDlg("#dlgLocalid");'>Todas</a></span> 
      <span class="cond-item" >Propietario:<a id="fProp" href='javascript:OpenDlg("#dlgProp");'>Todos</a></span> 
      <span class="cond-item" >Telefono:<a id="fTelef" href='javascript:OpenDlg("#dlgTelef");'>Todos</a></span> 
      <span class="cond-item" >Cuartos:<a id="fCuartos" href='javascript:OpenDlg("#dlgCuartos");'>Todos</a></span> 
      <span class="cond-item" >Precio:<a id="fPrecio" href='javascript:OpenDlg("#dlgPrecio");'>Todos</a></span> 
      <span id="fLocalId" style="display:none;"></span> 
    </div>
  </div>
  
  <div class="panel-body"> 
    <table id="lstCasas" class='table'>
      <thead><tr>
        <th title="Localidad donde se ubica la casa">Localidad</th>
        <th title="Nombre del propietario de la casa">Propietario</th>
        <th title="Teléfono del propietario">Teléfono</th>
        <th style="width: 40px;" title="Número de cuartos que renta">Hab</th>
        <th style="width: 40px;" title="Número de personas que puede alojar">Per</th>
        <th style="width: 60px;" title="Precio de referencia por habitación">Precio</th>
        <th style="width: 60px;" title="Comisón de referencia por habitación">Comisión</th>
      </thead>
        <tbody id="lstCasasBody">
        </tbody>
    </table>  
  </div>
  
  <div class="panel-footer">
    <div class="btn-group sel-orden" role="group">
      <span class="">Ordenar por:</span>
      <select id="lstOrden" name="lstOrden" onChange="OnChangeOrden();">
        <option value="ORDER BY IdCasa"     >Sin orden</option>
        <option value="ORDER BY Localidad"  >Localidad</option>
        <option value="ORDER BY Propietario">Propietario</option>
        <option value="ORDER BY Telef"      >Telefono</option>
        <option value="ORDER BY Cuartos"    >Habitaciones</option>
        <option value="ORDER BY Personas"   >Personas</option>
        <option value="ORDER BY Precio"     >Precio</option>
        <option value="ORDER BY Comision"   >Comisión</option>
      </select>
      
    </div>
    <div class="btn-group block-right" role="group" style="top:-37px;">
      <button type="button" id="btnPrev" class="btn btn-default">&lt;</button>
      <button type="button" id="btnNext" class="btn btn-default">&gt;</button>
    </div>
  </div>

</div>

<!--Dialogo para filtrar por la localidad-->  
<div id="dlgLocalid" title="Filtrar por localidad" style="padding:0px; width:400px;">
  <div class="container-fluid">
      <div class="col-xs-12 col-my" style="margin:0px; padding:0px;"> <div class="input-group">
        <span class="input-group-addon">Localidad:</span>
        <select id="lstCiudad" name="lstCiudad" class="form-control" >
        </select>
      </div></div>
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

<!--Dialogo filtrar el precio de la habitacion-->  
<div id="dlgPrecio" title="Filtrar por precio" style="padding:0px; width:400px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4 col-my"><div class="input-group text-left">
        <span class="input-group-addon" style="width:0.001%;"><input id="MenosPrec" name="RPrec" type="radio"></span>
        <span class="input-group-addon" style="text-align:left;">Menos</span>
      </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="IgualPrec" name="RPrec" type="radio"></span>
          <span class="input-group-addon" style="text-align:left;">Igual</span>
        </div></div>
      <div class="col-sm-4 col-my"><div class="input-group text-left">
          <span class="input-group-addon" style="width:0.001%;"><input id="MasPrec" name="RPrec" type="radio" checked=1></span>
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

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>

<script src="js/jquery-ui.js"></script>

<script type="text/javascript">
var FilterLocal = "";
var FilterProp = "";
var FilterTelef = "";
var FilterHab = "";
var FilterPrecio = "";
var sOrder = "ORDER BY IdCasa"; 

var Page = 0;  
var nRec = 30;  
var nPages = 1000;  

$(function() 
  {
  if( !(Datos.Perms & 16) )  $(".admin").css("display","none"); 
  
  $("#btnPrev").click( function() { if(Page>0     ) DoQuery(--Page);} );
  $("#btnNext").click( function() { if(Page<nPages) DoQuery(++Page);} );
    
  $("#UserName").text( Datos.UserName ); 
  $("#lstCiudad").load("Handles/FillCombo.php", "All=1&Table=Ciudad&OderBy=Name"); 
  
  DoQuery(-1);  
  });

function OpenDlg( id )
  {
	$(id).dialog( "open" );
  }
  
$("#dlgLocalid").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgLocalid},] });
   
function CloseDlgLocalid()
  {
	$("#dlgLocalid").dialog( "close" );
  
  var sLocId = $("#lstCiudad").val();
  if( sLocId == 0 ) 
    { 
    FilterLocal = "";
    $("#fLocalid").text( "Todas" );
    }
  else
    {
    FilterLocal = "IdCiudad =" + sLocId + " ";  
    
    var combo = document.getElementById("lstCiudad");
    var idx = combo.selectedIndex;
    var name = combo.options[idx].text;
    
    $("#fLocalid").text( name );
    }  
  
  DoQuery(-1);  
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
    FilterHab = "Cuartos ";
      
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
  
$("#dlgPrecio").dialog({ autoOpen:false,	width:300, buttons:[ {text:"Filtar", click:CloseDlgPrecio},] });
   
function CloseDlgPrecio()
  {
	$("#dlgPrecio").dialog( "close" );
  
  var precio = parseInt( $("#Precio").val() );
  if( isNaN(precio) ) 
    { 
    FilterPrecio = "";
    $("#fPrecio").text( "Todos" );
    }
  else
    {
    var txt = "";  
    FilterPrecio = "Precio ";
      
    var mas   = document.getElementById("MasPrec");
    var menos = document.getElementById("MenosPrec");
    var igual = document.getElementById("IgualPrec");
    
    if( mas.checked ) txt = "> " ;
    else if( menos.checked ) txt = "< " ;
    else txt = "= " ;

    FilterPrecio += (txt + precio + " ");  
    
    $("#fPrecio").text( txt + precio);
    }  
    
  DoQuery(-1);  
  }
 
function OnChangeOrden() 
  {
  sOrder = $("#lstOrden").val();
    
  DoQuery(-1);  
  }
  
function DoQuery( page )
  {
  if( page == -1) 
    {
    page = 0;  
    nPages = 10000;
    } 
    
  var sQuery = "SELECT IdCasa, Localidad, Propietario, Telef, Cuartos, Personas, Precio, Comision, Notas FROM view_casas ";

  var sAnd   = "";
  var sWhere = "";
  
  if( FilterProp.length>0   ) {sWhere += FilterProp; sAnd="AND ";}
  if( FilterLocal.length>0  ) {sWhere += (sAnd + FilterLocal ); sAnd="AND ";} 
  if( FilterTelef.length>0  ) {sWhere += (sAnd + FilterTelef ); sAnd="AND ";} 
  if( FilterHab.length>0    ) {sWhere += (sAnd + FilterHab   ); sAnd="AND ";} 
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
 
  
//  jQuery.post( "Handles/QueryString.php", "Query=" + sQuery )
//  .success(function(data) 
//            {
//            if( data.substr(0, 2)=="({" )
//              {  
//              var ret = eval(data);
//              var nRows = ret.nRows;
//              if( nRows>0 ) 
//                {
//                $("#lstCasasBody").html(ret.rows);
//                Page = page;
//                }
//                 
//              if( nRows==0 ) nPages = page-1; 
//              else if( nRows<nRec )  nPages = page; 
//              
//              showBtns();
//              }
//            else
//              {
//              alert("Error al realizar la consulta:\r\n" + data ); 
//              }  
//            })
//  .error(function(data) 
//           { 
//           alert("Error al realizar la consulta:\r\n" + data.statusText ); 
//           });
  
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
        
        sHtml += "<tr onClick='OnClickLista(" + row[0] +");' title='"+row[8]+"'>"; 
        sHtml += "<td style='white-space: nowrap;'>" + row[1] + "</td>";
        sHtml += "<td>" + row[2] + "</td>";
        sHtml += "<td>" + row[3] + "</td>";
        sHtml += "<td>" + row[4] + "</td>";
        sHtml += "<td>" + row[5] + "</td>";
        sHtml += "<td>" + row[6] + "</td>";
        sHtml += "<td>" + row[7] + "</td>";
          
        sHtml += "</tr>"; 
//    0        1         2           3       4        5        6        7       8
// IdCasa, Localidad, Propietario, Telef, Cuartos, Personas, Precio, Comision, Notas FROM view_casas ";
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

function OnClickLista( idCasa )
  {
//  var loc = window.location;  
  
//  loc.target="new"
//  loc.href = "EditCasa.php?IdCasa="+idCasa;
  window.open( "EditCasa.php?IdCasa="+idCasa, "EditCasa"+Date() );
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