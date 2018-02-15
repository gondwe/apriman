<?php 

require ("../../top/functions.php"); 

$cp = $_SESSION[$ndk]["user"]["password"];

if($_POST["np"] == $_POST["npw"]){
	$ncp = md5($_POST["cp"]);
	$np = md5($_POST["np"]);
	$me = $_SESSION[$ndk]["user"]["id"];
	
	if($ncp == $cp){
		process("update users set password ='$np' where id ='$me'");
		$_SESSION[$ndk]["user"]["password"] = fetch("select password from users where id = '$me'");
		success("change successful");
	}else{
		error("Wrong current password supplied");
	}
	
}else{
	error("Passwords dont Match");
}