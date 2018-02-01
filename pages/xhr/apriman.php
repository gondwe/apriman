<?php 

require ("../../top/functions.php"); 


$p = $_POST["p"];

$pwd = "donna_".date("m").date("Y");
$hash = gethash($pwd);

$hash = explode("-",$hash);
$pwd = "donna".$hash[1];


if($p == $pwd){
	$_SESSION[$ndk]["dev"] = true;
	success("Logged in as developer !");
}else{
	error("Wrong Password !");
}

?>

