<?php 

require ("../../top/functions.php"); 

if(isset($_SESSION[$ndk]["adm_search"])){
$cmb = [];
$adm = $_SESSION[$ndk]["adm_search"];
$class = fetch("select class from students where adm_no = '$adm'");
$arr_years = getlist("select distinct(year(date)) from finance_payments where year(date) < year(current_timestamp)");

$arrears = [];
/* list over accumulated  years */
foreach($arr_years as $yr){
	$feeclass = fetch("select feeclass from finance_fdata where adm_no = '$adm' and fyear = '$yr'");
	$byclass = fetch("select sum(amount) as tot from finance_voteheads where scode = '$sid' and vhyear = '$yr' and class = '$class' and feeclass = '$feeclass' ");
	$bypaid = fetch("select sum(amount) as tot from finance_payments where arrid is null and scode = '$sid' and year(date) = '$yr' and adm_no = '$adm' ");
	$arrears[$yr] = $byclass - $bypaid; 
}

// spill($arrears);

/* check_entries for each  */
foreach($arrears as $yr=>$amt){
	if($amt > 0){
			$exists = fetch("select count(id) from finance_arrears where adm_no = '$adm' and scode = '$sid' and arryear = '$yr' ");
			if($exists){
				process("update finance_arrears set amount = '$amt' where adm_no = '$adm' and scode = '$sid' and arryear = '$yr' ");
			}else{
				$sql = "insert into finance_arrears (adm_no,amount,arryear,scode) values ('$adm','$amt','$yr','$sid')";process($sql);
			}
		}
}
		

$yramt = getlist("select id, amount from finance_arrears where adm_no = '$adm'  and scode = '$sid'");
$yramtpaid = get("select arrid, amount from finance_payments where adm_no = '$adm'  and arrid is not null and scode = '$sid'");
// spill($yramt);

/* display status information */

foreach($yramtpaid as $y=>$z){
	if(isset($yramt[$z["arrid"]])){ $yramt[$z["arrid"]] -= $z["amount"]; }
}
// spill($yramt);
$a = array_sum($yramt);
	if($a > 0){error("In Arrears : KES.".addcommas($a));}
}