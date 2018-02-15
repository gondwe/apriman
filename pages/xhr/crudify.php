<?php 

require ("../../top/functions.php"); 
$reg = $_POST["dat"];

$d = explode(",",$reg);
$new = $d[0] == 1 ? 0 : 1;


if(isadmin()){
	process("update crud set `$d[2]` = $new where id = '$d[1]'");
	success("UAC Successful (".rx($d[2],1).")");
}else{
	error("Access Denied");
}

?>

