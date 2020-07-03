<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Informe de reserva realizada</title>

<?php 
session_start();
if( empty($_SESSION["UserName"]) || empty($_GET["IdReserv"]) ) 
  {
  header( 'Location: index.php' );
  exit(0);
  }
  
$Datos = "<script> Datos= { ";
$Datos .= "UserName:'".$_SESSION['UserName']."', ";
$Datos .= "IdReserv:".$_GET["IdReserv"].", ";
$Datos .= "IdCasa:".$_GET["IdCasa"].", ";
$Datos .= "Perms:".$_SESSION["Permisos"];
$Datos .= " }; </script>";

echo $Datos;
?>

<style type="text/css">
label
  {
  text-align:left;  
  color:#252525;
  font-weight:bold;
  }
  
#BodyInfo
  {
  display:table;   
  margin-left:auto;
  margin-right:auto;
  }
  
#BodyInfo h3
  {
  color:#5178F5; 
  margin-top:10px;
  margin-bottom:6px;  
  }
  
.ReservaInfo, .CasaInfo 
  {
  margin-bottom:20px; 
  }  
  
.ReservaInfo label, .CasaInfo label
  {
  display:inline-block;  
  width:150px;  
  }  

.Logo
  {
  padding:5px; 
  font-size:40px; 
  color:#5178F5; 
  font-weight:bold;  
  }  

</style>

</head>
<body>
<header>
<div id="Logo1" class="Logo"> Booking Havana </div>
<hr/>
</header>

<div id="BodyInfo">
  <div class="ReservaInfo">
    <h3>Datos del Huésped</h3>
    <div><label>Nombre:             </label><span id="Name"    ></span></div>
    <div><label>Fecha de llegada:   </label><span id="Llegada" ></span></div>
    <div><label>Fecha de Salida:    </label><span id="Salida"  ></span></div>
    <div><label>Habitaciones:       </label><span id="Cuartos" ></span></div>
    <div><label>Número de noches:   </label><span id="Noches"  ></span></div>
    <div><label>Número de personas: </label><span id="Personas"></span></div>
    <div><label>País:               </label><span id="Pais"    ></span></div>
    <div><label>Datos del vuelo:    </label><span id="Vuelo"   ></span></div>
  </div>

  <div class='CasaInfo'>
    <h3>Datos de la casa</h3>
    <div><label>Propietario:       </label><span id="cProp"    ></span></div>
    <div><label>Dirección:         </label><span id="cDir"     ></span></div>
    <div><label>Precio por noche:  </label><span id="cPrecio"  ></span></div>
    <div><label>Número de noches:  </label><span id="cNoches"  ></span></div>
    <div><label>Habitaciones:      </label><span id="cCuartos" ></span></div>
    <div><label>Total a Pagar:     </label><span id="cAPagar"  ></span></div>
    <div><label>Pagado:            </label><span id="cPagado"  ></span></div>
    <div><label>Pendiente a pagar: </label><span id="cPend"    ></span></div>
  </div>

  <div class="Firma">
    <br/>
    <div><label>______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;______________________________</label></div>
    <div><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jaisner Chinea García&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Propietario </label></div>
    <br/>
  </div>

</div>


<footer>
<br/>
<hr/>
<div style="height:80px; position:relative;" >
  <div id="Logo2" style="position:absolute; top:0px; left:0px; width:150px; font-size:25px; color:#5178F5; font-weight:bold;" >
    Booking Cuba Tours
  </div>
  <div style="position:absolute; top:0px; left:150px; font-size:16px;" >
    www.bookingcubaturs.com<br/> +53-78356141<br/> +53-53465756<br/> 
  </div>
  <div style="position:absolute; top:0px; left:350px; font-size:16px;" >
    Jaisner Chinea García<br/> Ave. Línea 901 entre 6 y 8, Vedado, La Habana<br/>  <b>NIT:</b> 73013109688  
  </div>
</div>
</footer>

<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>

<script type="text/javascript">
var lastLoc;
$(function() 
  {
  LoadReserva();  
  });

function LoadReserva()
  {
  var sQuery = "SELECT Nombre, Habitaciones, Entrada, Salida, Noches, Personas, Pais, VueloInfo, Tipo FROM view_resevas_inform WHERE IdReserva=" + Datos.IdReserv;
  
  jQuery.post( "Handles/SelectRows.php", "Query=" + sQuery )
  .success(function(data) 
          {
          if( data.substr(0, 2)=="({" )
            {  
            var ret = eval(data);
            var row = ret.rows[0];  
            
            $("#Name"    ).text( row[0] );
            $("#Cuartos" ).text( row[1] );
            $("#Llegada" ).text( FormatDate(row[2]) );
            $("#Salida"  ).text( FormatDate(row[3]) );
            $("#Noches"  ).text( row[4] );
            $("#Personas").text( row[5] );
            $("#Pais"    ).text( row[6] );
            $("#Vuelo"   ).text( row[7] );
            
            if( row[8] == 1 )
              {
              $("#Logo1").text( "Booking Havana" );
              $("#Logo2").text( "Booking Havana" );
              }
            else
              {
              $("#Logo1").text( "Booking Cuba Tours" );
              $("#Logo2").text( "Booking Cuba Tours" );
              }  
              
            LoadDatosCasa( Datos.IdCasa );
            }
          else {alert("Error cargando los datos del informe:\r\n" + data ); }  
          })
  .error(function(data) { alert("Error cargando los datos del informe:\r\n" + data.statusText ); });
  }  
  
function LoadDatosCasa( IdCasa )
  {
  var sQuery = "SELECT Propietario, Direccion, Localidad, PrecioHab, Noches, Cuartos, Pagado, Precio FROM view_casa_reserva_inform WHERE IdReserva=" + Datos.IdReserv +" AND IdCasa=" + IdCasa;
  
  jQuery.post( "Handles/SelectRows.php", "Query=" + sQuery )
  .success(function(data) 
          {
          if( data.substr(0, 2)=="({" )
            {  
            var ret = eval(data);
            var row = ret.rows[0];  
            
            $("#cProp"   ).text(row[0]);
            $("#cDir"    ).text(row[1]);
            $("#cPrecio" ).text(row[3]);
            $("#cNoches" ).text(row[4]);
            $("#cCuartos").text(row[5]);
            $("#cAPagar" ).text(row[7]);
            $("#cPagado" ).text(row[6]);
            $("#cPend"   ).text( parseFloat(row[7])-parseFloat(row[6]) );
            
//      0          1          2          3         4       5        6       7                   
// Propietario, Direccion, Localidad, PrecioHab, Noches, Cuartos, Pagado, Precio 
            
            }
          else {alert("Error cargando los datos del informe:\r\n" + data ); }  
          })
  .error(function(data) { alert("Error cargando los datos del informe:\r\n" + data.statusText ); });
  }

var _Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  
function FormatDate( sfecha )
  {
  var fecha = new Date(sfecha);  
  
  var dia  = fecha.getDate();
  var mes  = fecha.getMonth();
  var ano  = fecha.getYear() + 1900;
  
  return  dia.toString() + ' ' + _Meses[mes] + ' ' + ano;  
  }
    

</script>

</body>
</html>