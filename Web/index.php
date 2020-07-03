<!doctype html>
<html>
<?php 
  $ErrorMsg="";
  session_start();
  
  $_SESSION["UserName"] = NULL; 
  $_SESSION["UserID"] = NULL; 
  
  if( $_POST ) 
    {
    include 'Handles/OpenDb.php';   
  
    $s_name = mysqli_real_escape_string($myDB, $_POST["name"]);
    $s_pass = mysqli_real_escape_string($myDB, $_POST["password"]);
    
    $resp = mysqli_query($myDB, "CALL login('$s_name','$s_pass')") or die(mysqli_error($myDB));
    $NRec = mysqli_num_rows($resp);
    
    if( $NRec == 0 )
      {
      $ErrorMsg='<span class="help-block" style="color: #D82427;">Entre un operador y/o contraseñas correcto.</span>';
      }
    else
      {
      $DataArray = mysqli_fetch_array($resp, MYSQLI_ASSOC);
      
      $_SESSION["UserID"]   = $DataArray["IdOperador"]; 
      $_SESSION["UserName"] = $DataArray["Nombre"]; 
      $_SESSION["Permisos"] = $DataArray["Permisos"]; 
      
      header( 'Location: ListReservas.php' ) ;
      }  
      
    mysqli_free_result($resp);
    mysqli_close($myDB);
    }
?>
<head>
<title>Entrada a Booking Reserva</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Entrada a Booking Reserva</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <span class="navbar-brand" style="font-weight: 600; color: #000000;">Booking Reserva</span> 
    </div>
    
  </div>
  <!-- /.container-fluid --> 
</nav>

<div class="container" style="margin-top:60px;" class="center-block">
  <div class="row center-block">
    <div style="width:400px;" class="center-block">
      <div class="jumbotron" style="border-radius:30px;">
        <div class="row text-center">
          <div class="text-center col-lg-12">
            <h2>Entrada</h2>
          </div>
          <div class="col-lg-12"> 
            <!-- CONTACT FORM https://github.com/jonmbake/bootstrap3-contact-form -->
            <form role="form" class="text-left" method="POST" action='<?php "$_SERVER[PHP_SELF]"?>'>
            
              <div class="form-group">
                <label for="name">Operador</label>
                <input type="text" class="form-control" name="name" placeholder="Escriba el nombre del operador">
              </div>
            
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Escriba la contraseñas del operador">
              </div>
            
              <?php echo $ErrorMsg ?>
              <button type="submit" class="btn btn-primary btn-lg center-block" style=" margin-top: 10px;"> Entrar</button>
                
            </form>
            <!-- END CONTACT FORM --> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>