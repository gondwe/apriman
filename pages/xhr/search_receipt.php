<?php 

require ("../../top/functions.php"); 

// spill($_POST);
if(isset($_POST["receipt_no"])){
	$rno = $_POST["receipt_no"];
	$f = fetch("select count(id) from finance_payments where id = '$rno' ");
	if($f > 0){
		$sql = "select finance_payments.adm_no, finance_payments.bkid, students.names 
			from finance_payments left join students on students.adm_no = finance_payments.adm_no and finance_payments.scode = students.sid
			where finance_payments.id = '$rno'";
		$d = getlist($sql);
		$_SESSION[$ndk]['adm_search'] = $d["adm_no"];
		$_SESSION[$ndk]['bkdownid'] = $d["bkid"];
		success("Receipt No. found for ( Adm ".$d["adm_no"]." | ".$d["names"]." )");
	}else{
		error("Receipt No. Not Found !");
	}
}