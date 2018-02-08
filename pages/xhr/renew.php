<?php 

require ("../../top/functions.php"); 

$id = count($_POST);
$key = strtolower(clean($_POST["key"]));

if($id > 1){
	/* prepare registration */
	
	$names = clean($_POST["names"]);
	$hash = gethash($names);
	
	if($key == $hash){
		process("insert into settings (name) values('$names')");
		$idx = fetch("select id from settings where name = '$names'");
		process("insert into xdata (vprop,vdat,xdat) values('keyfile','$hash','$idx')");
		success("Registration Successful");
	}else{
		error("Failed ! ");
		
	}
	
	
}else{
	/* prepare renewal */
	
	$names = fetch("select name from settings where id = '$sid'");
	$hash = gethash($names);
	
	if($key == $hash){
		process("delete from vdata where vprop = 'keyfile' and xdat = '$sid'");
		process("insert into vdata (vdat,vprop, xdat) values ('$hash','keyfile','$sid')");
		success("Renewal Successful");
		$_SESSION[$ndk]["dirty"] = false;
	}else{
		error("Operation Failed !");
	}
	
}



?>

