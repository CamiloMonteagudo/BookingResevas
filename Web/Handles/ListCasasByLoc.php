<!doctype html>
<html>
<head><meta charset="utf-8"></head>
<body>
  <select id="lstCasas" class="form-control" >
  <?php 
  if( !empty($_GET["All"]) )
    echo "<option value='0'>Todas</option>";
 
  include 'OpenDb.php';   
  
  $IdLoc = "";
  
  if( !empty($_GET["IdLoc"]) ) $IdLoc = $_GET["IdLoc"];
  
  $resp = mysqli_query($myDB, "SELECT IdCasa,Propietario FROM casa WHERE IdCiudad =".$IdLoc." ORDER BY Propietario") or die(mysqli_error($myDB));

  if( $resp ) 
    {
    while( $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
      {
      $Id = $row["IdCasa"];  
      $Name = $row["Propietario"];  
      
      echo "<option value='".$Id."'>".$Name."</option>";
      }
    } 
    
  mysqli_free_result($resp);
  mysqli_close($myDB);
  ?>
  </select>
</body>
</html>