
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> <?=rx(mx($t))?> <small>add New</small></h1>
</div>
</div>
</div>
<?php include("../nav.php") ?>
<?php 


$i = $_GET["t"];

$j = getlist("select fc.amount, fc.supplycombo as cbo, fb.cost, fc.date as paidon, fb.supply_id as supplies, fb.description, fb.date as supply_date, fa.names, fa.contacts, fa.address
				from finance_supplier_payments as fc
				left join finance_supplies as fb on fb.id = fc.supplycombo
				left join finance_suppliers as fa on fb.supplier_id = fa.id
				
				where fc.id = '$i'");
// spill($j);

$cbo = $j["cbo"];
$paidon = $j["paidon"];
$cost = $j["cost"];


$paidup = fetch("select sum(amount) as paid from finance_supplier_payments where supplycombo = '$cbo' and date <= '$paidon'");
$bal = $cost - $paidup;

spill(new DateTime($j["paidon"]));
// spill($bal);


?>
<style> /* table {width:100%}	 */</style>
<div class='row'>
<?php 

printA4("voucher","p", "Payee Name and Address : <u>".rx($j["names"])."</u>|Date : ".$j["paidon"]);
?>

</div>
<div class='row'>
<div id="" style="">

<table id='voucher' >
<tr style='border:0px'><td width=20px colspan=4 >Voucher No.<?=$i?></td></tr>
<tr><td width=20px>Date</td><td colspan=3>Description</td></tr>

<tr>
	<td width=10%><?=$j["paidon"] ?></td>
	<td width=70%>Being Payment for : <br><?=$j["supplies"]?><br><i><?=$j["description"]?></i></td>
	<td width=20%>Paid:<?=$paidup?></td>
</tr>
</table>

</div>
</div>