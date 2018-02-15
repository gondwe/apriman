
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> <?=rx(mx($t))?> <small></small></h1>
</div>
</div>
</div>
<?php include("../nav.php") ?>
<?php 


$vhs = '';

$vh = getlist("select id, abbr from finance_votehead_names");
$sql = "select fp.id, day(fp.date) as day_, month(fp.date) as month_, votehead, expenditure, sum(fp.amount) as paid
		from finance_exp_payments as fp
		where fp.scode = '$sid' and year(date) = year(current_timestamp)
		group by fp.id
		";



$data = get($sql);
$_data = [];
foreach($data as $da=>$ta){$_data[$ta["month_"]][$ta["id"]] = $ta;}

// spill($_data);
$x = 1;

	table_open("l");
	echo "<thead>";
		echo "<th>Sn</th>";
		echo "<th>Date</th>";
		foreach($vh as $t=>$vv){ echo "<th>".rx($vv,1)."</th>"; }
		echo "<th>TOTAL</th>";
	echo "</thead>";
	echo "<tbody>";
	foreach($_data as $mm=>$daata){
		
			echo "<tr>";
			echo "<td>$x</td>";
			echo "<td>".date("M",mktime(0,0,0,$mm,1,2011))."</td>";
			foreach($vh as $t=>$vv){ 
			$k = [];
			$j = "-";
				foreach($daata as $d=>$dbata){
					if($dbata["votehead"] == $t){
						$j = $dbata["paid"]+$j;
					}
						$k[] = $dbata["paid"];
				}
				echo "<td>$j</td>";
			}
			echo "<td>".addcommas(array_sum($k))."</td>";
			echo "</tr>";
			$x++;
			
	}
	echo "<tbody>";
	table_close();
	
	