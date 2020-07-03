<!doctype html>
<html>
<head><meta charset="utf-8"></head>
<body>
  <?php 
  if( empty($_GET["Table"]) )
    {
    echo "<select class='form-control'></select>";
    exit(1);  
    }
  
  $Table = $_GET["Table"];
  
  echo "<select id='lst".$Table."' class='form-control'>";
  
  if( !empty($_GET["All"]) )
    echo "<option value='0'>Todas</option>";
 
  include 'OpenDb.php';   
  
  $SelVal  = "";
  $SelName = "";
  $AddProc = "";
  $OderBy  = "Nombre";
    
  if( !empty($_GET["SelVal"])  ) $SelVal  = $_GET["SelVal"];
  if( !empty($_GET["SelName"]) ) $SelName = $_GET["SelName"];
  if( !empty($_GET["AddProc"]) ) $AddProc = $_GET["AddProc"];
  if( !empty($_GET["OderBy"])  ) $OderBy  = $_GET["OderBy"];
  
  if( $SelName != "" && $AddProc!="" ) 
    mysqli_query($myDB, "CALL ".$AddProc."('".$SelName."')");
  
  $resp = mysqli_query($myDB, "SELECT * FROM ".$Table." ORDER BY ".$OderBy) or die(mysqli_error($myDB));

  if( $resp ) 
    {
    while( $row = mysqli_fetch_row($resp)) 
      {
      $Id = $row[0];  
      $Name = $row[1];  
      
      $sel = ($Id==$SelVal || $Name==$SelName)? " selected" : ""; 
      
      echo "<option value='".$Id."'".$sel.">".$Name."</option>";
      }
    } 
    
  if( !empty($_GET["New"]) )
    echo '<option value="1000" style="color:#0700B8; font-weight:700;">Nueva</option>';
 
  mysqli_free_result($resp);
  mysqli_close($myDB);
  ?>
  </select>
</body>
</html>