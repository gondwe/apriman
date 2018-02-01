
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["t"] = "finance_cashbook"; ?>
<h1> <?=rx(mx($t))?> <small>data</small></h1>
</div>
</div>
</div>

<?php 
include "../nav.php";
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
$sql = "select day(fp.date) as day_, month(fp.date) as month_, sum(fp.amount) as paid $vhs
		from finance_payments as fp
		where fp.scode = '$sid' and year(date) = year(current_timestamp) and arrid is null
		group by month_, day_
		";



$data = get($sql);
$_data = [];
foreach($data as $da=>$ta){$_data[$ta["month_"]][$ta["day_"]] = $ta;}
		
// spill($_data);
foreach($_data as $month=>$days){
	foreach($days as $day=>$daydata){
		$sql = "select min(id), max(id) from finance_payments where month(date) = '$month' and day(date) ='$day'";
		$folio[$month][$day] = getlist($sql);
	}
}



// spill($folio);
$x = 1;

	table_open("l");
	echo "<thead>";
		echo "<th>Sn</th>";
		echo "<th>Date</th>";
		echo "<th>Folio</th>";
		foreach($vh as $t=>$vv){ echo "<th>".rx(repdot($vv),1)."</th>"; }
		echo "<th>TOTAL</th>";
	echo "</thead>";
	echo "<tbody>";
	foreach($_data as $mm=>$ddata){
		
		foreach($ddata as $d=>$vvs){
			echo "<tr>";
			echo "<td>$x</td>";
			echo "<td>".date("M",mktime(0,0,0,$mm,1,2011)).",".$d."</td>";
			echo "<td style='text-align:right; color:red'>".array_keys($folio[$mm][$d])[0]."-".current($folio[$mm][$d])."</td>";
			foreach($vh as $t=>$vv){ echo "<td style='text-align:right;'>".addcommas($vvs[$vv],0)."</td>"; }
			echo "<td style='text-align:right;'>".addcommas($vvs['paid'])."</td>";
			echo "</tr>";
			$x++;
		}
	}
	echo "<tbody>";
	table_close();
	
	

// date("F",mktime(0,0,0,$monthnumber,1,2011));

// date('F', strtotime("2000-$monthnumber-01"));
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

