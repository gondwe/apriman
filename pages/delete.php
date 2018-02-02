<?php 
require ("../top/functions.php"); 
$g = explode("/",$_POST["id"]);
$t = next($g);
$i = end($g);
?>
<?php 

$sql = "delete from $t where id = $i";
if(process($sql)){ error("Delete Successful"); }
	
