<?php 

require ("../../top/functions.php"); 



if(isset($_POST['mychoice'])){
	// spill($_POST);
	$vid = clean($_SESSION[$ndk]["me"]);
	$cid = clean($_POST["mychoice"]);
	$pid = clean($_SESSION[$ndk]["dat"]);
	
	$sql = "insert into vote_elections (c_id, v_id, p_id) values ('$cid','$vid','$pid')";
	process($sql);

	echo "Success";
}