
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
<?=linkbutton( "new", "finance_supplier_payments", "View Supplier Payments", $anchor)?>
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
// spill($vh);
foreach($data as $da=>$ta){$_data[$ta["month_"]][$ta["day_"]][$ta["id"]] = $ta;}

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
		
		foreach($daata as $d=>$dbata){
			echo "<tr>";
			echo "<td>$x</td>";
			echo "<td>".date("M",mktime(0,0,0,$mm,1,2011)).", ".$d."</td>";
			
			$k = [];
			foreach($vh as $t=>$vv){ 
				$j = "-";
				foreach($dbata as $d=>$vvs){
					if($vvs["votehead"] == $t){
						$k[] = $vvs["paid"];
						$j = $vvs["paid"]+$j;
					}
				}
					echo "<td>$j</td>";
			}
					$k = array_sum($k);
			echo "<td>".addcommas($k)."</td>";
			echo "</tr>";
			$x++;
			
		}
	}
	echo "<tbody>";
	table_close();
	
	