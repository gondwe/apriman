<?php 

require ("../../top/functions.php"); 
require ("../../pages/models/studentclass.php"); 

// spill($_POST);

	$p = new fee($_SESSION[$ndk]["adm_search"], $_POST["amount"]);
	
	$p->prepare(
		$_POST["mode"],
		$_POST["bank"],
		$_POST["bank_charges"]
		);
		
	$v = $p->pay();

?>

