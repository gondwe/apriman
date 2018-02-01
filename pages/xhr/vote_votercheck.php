<?php 

require ("../../top/functions.php"); 


if(isset($_POST['me'])){
	$me = $_POST["me"];
	$found = fetch("select * from students where adm_no = '$me'");
	if($found == ""){
		echo "Adm/Reg Not Found !";
	}else{
		$_SESSION[$ndk]["me"]  = $_POST["me"];
		echo "Please proceed with your Voting";
	}
}


