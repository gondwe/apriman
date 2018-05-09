<?php 

require ("../../top/functions.php"); 

$i = $_POST["dat"];
$adm = fetch("select adm_no from finance_payments where bkid = '$i'");

if(is_string($adm)){
	require ("../../pages/models/studentclass.php"); 
	$a = new fee($adm);
	$v = $a->voteheadslist();
	$qstr = implode("` = NULL, `", $v);
	$str = "update finance_payments set `".$qstr."`= NULL where `bkid` = '$i'";
	process($str);
	process("update finance_payments set amount = '0' where bkid = '$i'");

success("TRANSACTION CANCELLED. !");}else{error("Error !");}