<?php 
$Rows ="[";
$nRows = 0;
   
include 'OpenDb.php';   

$resp = mysqli_query($myDB, $_POST["Query"]) or die(mysqli_error($myDB));
while( $row = mysqli_fetch_array($resp, MYSQLI_ASSOC)) 
  {
  if( $nRows>0 ) $Rows .= ",[";   
  else           $Rows .= "[";
  
  $nField = 0;  
  foreach( $row as $filed) 
    {
    if( $nField>0 ) $Rows .= ",";  
    $Rows .= "'".nl2br($filed)."'";
      
    ++$nField;  
    }
    
  $Rows .= "]";
  ++$nRows;
  }
    
$Rows .= "]";
  
mysqli_free_result($resp);
mysqli_close($myDB);

echo '({rows:'.$Rows.'})';
?>
