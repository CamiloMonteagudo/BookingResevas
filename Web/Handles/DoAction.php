<?php 
include 'OpenDb.php';   

mysqli_query($myDB, $_POST["Query"]) or die(mysqli_error($myDB));
mysqli_close($myDB);

echo 'OK';
?>
