<?php 

require ("../../top/functions.php"); 
$id = $_POST["dat"];


$activated = fetch("select count(id) from unlisted where names = '$id'");
if($activated){
	$sql = "delete from unlisted where names = '$id' ";
}else{
	$sql = "insert into unlisted (names) values ('$id')";
}

process($sql);
unset($_SESSION[$ndk]["menus"]);
$_SESSION[$ndk]["menus"] = menus();

success("Module Change Validated");

?>
