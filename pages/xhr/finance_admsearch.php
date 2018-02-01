<?php 

require ("../../top/functions.php"); 

if(fetch("select count(id) from students where adm_no ='".$_POST["adm_no"]."' and sid = '$sid'")){
	$_SESSION[$ndk]['adm_search'] = $_POST["adm_no"];
}else{
	error("Reg No. Not Found");
	unset($_SESSION[$ndk]['adm_search']);
}

?>

