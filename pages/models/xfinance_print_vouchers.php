
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"]; $alias = "Payment Vouchers" ?>
<h1> <?=rx(mx($alias))?> <small>View & Print</small></h1>
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
spill($j);

$cbo = $j["cbo"];
$paidon = $j["paidon"];
$cost = $j["cost"];


$paidup = fetch("select sum(amount) as paid from finance_supplier_payments where supplycombo = '$cbo' and date <= '$paidon'");
$bal = $cost - $paidup;

spill($paidup);
spill($bal);