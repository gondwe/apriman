<?php 

require ("../../top/functions.php"); 
$p = $_POST;
$a = $p['finance_order'];
$b = $p['amount'];
$sql = "insert into finance_supplier_payments (supplycombo,amount, scode) values ('$a','$b', '$sid')";

$initial_cost = fetch("select cost from finance_supplies where id ='$a' and scode = '$sid'");
$paidamt = fetch("select ifnull(sum(amount),0) from finance_supplier_payments where supplycombo = '$a' and scode = '$sid'");
$bal  = $initial_cost - $paidamt;


if($b > $bal){
	error("Error in payments");
}else{
	process($sql);
	success('Payment Successful');
}
?>

