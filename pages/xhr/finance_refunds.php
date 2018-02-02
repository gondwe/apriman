<?php 

require ("../../top/functions.php"); 

if(isset($_SESSION[$ndk]["adm_search"])){
$cmb = [];
$adm = $_SESSION[$ndk]["adm_search"];
// $paid = getlist("select sum(amount) from finance_payments where adm_no = '".$adm."' and arrid is not null and scode = '$sid' group by arrid ");
$c = getlist("select fa.id, fa.adm_no, fa.amount from finance_refunds as fa where fa.scode = '$sid' and adm_no = '".$adm."' ");
// spill($c);

if(isset($c["id"])){
	$me = fetch("select names from students where adm_no = '".$c['adm_no']."' and sid ='$sid' ");
	if($c["amount"] > 0){
		error("<a onclick='changeGET();' href='#edit/finance_refunds/".$c['id']."' style='text-decoration:none; color:yellow'>$me : Refunds ( Kshs.".addcommas($c['amount']) ." )</a>") ;}
	}
}

