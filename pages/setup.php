<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>ndk :: 2.21 Setup</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="nardtec ims" name="description" />
		<meta content="gondwe benard" name="author" />

		<link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">

		<link rel="shortcut icon" href="favicon.ico" />
	</head>
<?php require ("../top/functions.php"); 
?>




<style>
	body { text-align:center}
	form {
		margin: 15% auto;
		padding-top: 2%;
		border-radius: 20px;
		width: 60%;
		background-image: repeating-radial-gradient(#c8f9a5,#5fea79);
		display: block;
		min-width: 300px;

	}

	input {
		width: 100%;
	} 
</style>


<?php
	if(!empty($_POST)){
		$names = clean($_POST["names"]);
		$hash = gethash($names);
		$key = strtolower(clean($_POST["key"]));
		$uname = rxx($names)."_admin";
		if($key == $hash){
			process("insert into settings (name) values('$names')");
			$idx = fetch("select id from settings where name = '$names'");
			process("insert into vdata (vprop,vdat,xdat) values('keyfile','$hash','$idx')");
			
			process("insert into user_types (names,scode) values('admin','$idx')");
			$idy = fetch("select id from user_types where scode = '$idx' ");
			
			process("insert into users (username, usertype,scode,names) values('$uname','$idy','$idx','admin')");
			
			error("Registration Successful");
			echo "<h3>Username = $uname</h3>";
			echo "<h3>Password = 1234</h3>";
			echo "<a href='../index.php'>Proceed to Login</a>";
			
		}else{
			error("Failed ! ");
			
		}
	}

	form_open("setup");
	form_input("names");
	form_input("key");
	form_close(1,"Register");













echo "<center >";require ("../top/foot.php"); echo "</center>";

?>
							

		
		