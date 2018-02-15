
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["t"] = "finance_supplier_payments";?>
<h1> <?=rx(mx($t))?> <small>Details</small></h1>
</div>
</div>
</div>
<?php include("nav.php") ?>
<?php 

include ("../top/tablo.php");

printA4("sample-table-2","p");
$d = new tablo($t);
	$d->combos["supplycombo"] = "select id, supply_id from finance_supplies";
	$d->aliases["supplycombo"] = "item";
	$d->editset=false;
	$d->deleteset=false;
	$d->morecols = ["supplier","date",];
	$d->morecolsdata = ["supplier"=>getlist("select fsp.id, fs.names from finance_supplier_payments as fsp
							right join finance_supplies as fss on fss.id = fsp.supplycombo
							left join finance_suppliers as fs on fs.id = fss.supplier_id
							"),
						"date"=>getlist("select id, date_format(date, '%D %M, %Y') from finance_supplier_payments")];
$d->dtable(0);


