<?php 

require ("../../top/functions.php"); 
if(isset($_POST["password"])){$_POST["password"] = md5($_POST["password"]);}
echo(insert($_GET['t']));

?>

