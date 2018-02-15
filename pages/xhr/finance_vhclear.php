<?php 

require ("../../top/functions.php"); 
$tbl = $_POST["dat"];
// spill($tbl);

$yr = date("Y");
switch($tbl){
	case "voteheads" : 
	$sql = "delete from finance_voteheads where vhyear = '$yr' and scode ='$sid'"; 
	break;
	case "payments" : 
	$sql = "delete from finance_payments where year(date) = '$yr' and scode ='$sid'"; 
	break;
	case "reset" : 
	$sql = ""; 
	break;
}

// spill($sql);
if(process($sql)){ success("$tbl Cleared !");}