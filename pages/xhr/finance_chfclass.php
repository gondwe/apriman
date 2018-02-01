<?php 

require ("../../top/functions.php"); 

$f = array_keys($_POST)[0];
$i = $_POST[$f];

// die();
$adm = $_SESSION[$ndk]["adm_search"];


if(process("update finance_fdata set feeclass ='$i' where adm_no = '$adm' and fyear = year(current_timestamp)")){
	success("Fee Class Changed Successfully.");
}
