<?php 

require ("../../top/functions.php"); 
$p = $_POST;
$a = $p['finance_expenditure'];
$b = $p['finance_votehead'];
$c = $p['amount'];
$d = $p['term'];

$sql = "insert into finance_exp_payments (expenditure,votehead, amount, term, scode ) values ('$a','$b','$c','$d','$sid')";

if(process($sql)){
	success('Payment Successful');
}else{
	error("Error in payments");
}
?>

