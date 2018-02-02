
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["t"] = "finance_ledger";?>
<h1> <?=rx(mx($t))?> <small>add New</small></h1>
</div>
</div>
</div>
<?php include("../nav.php") ?>
<?php 

$vhs = '';
$vh = getlist("
		select distinct repdot2(fvn.names), abbr from finance_votehead_names as fvn 
		left join finance_voteheads as fv on fv.votehead = fvn.id
		where fv.scode = '$sid' and fv.vhyear = year(current_timestamp)
		");
		

foreach($vh as $v=>$k){
	$vhs .= ", sum(`".$v."`) as `$k` ";
}

// spill($vhs);
$sql = "select  month(fp.date) as month_, sum(fp.amount) as paid $vhs
		from finance_payments as fp
		where fp.scode = '$sid' and year(date) = year(current_timestamp)
		group by month_
		";


$data = get($sql);
$_data = [];
foreach($data as $da=>$ta){$_data[$ta["month_"]] = $ta;}
		
// spill($sql);
// spill($_data);

$x = 1;
	table_open("l");
	echo "<thead>";
		echo "<th>Sn</th>";
		echo "<th>Date</th>";
		foreach($vh as $t=>$vv){ echo "<th>".rx(repdot($vv),1)."</th>"; }
		echo "<th>TOTAL</th>";
	echo "</thead>";
	echo "<tbody>";
	foreach($_data as $mm=>$ddata){
		
			echo "<tr>";
			echo "<td>$x</td>";
			echo "<td>".date("M",mktime(0,0,0,$mm,1,2011))."</td>";
			foreach($vh as $t=>$vv){ echo "<td>".addcommas($ddata[$vv],0)."</td>"; }
			echo "<td>".addcommas($ddata['paid'])."</td>";
			echo "</tr>";
			$x++;
	}
	echo "<tbody>";
	table_close();
	
	
