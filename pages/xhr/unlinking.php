<?php 

require ("../../top/functions.php"); 
$file = "../../".$_POST["dat"];
unlink($file);
echo "Delete Successful";