
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["t"] = "finance_fee_structure";?>
<h1> <?=rx(mx($t))?> <small>Details</small></h1>
</div>
</div>
</div>
<?php include("../nav.php") ?>
<?php 

$cls = getlist("select id, names from classes where scode = '$sid'"); 

$fsclass = isset($_SESSION[$ndk]["fsclass"]) ? $_SESSION[$ndk]["fsclass"] : current(array_keys($cls));

// spill($_SESSION);
?>

<form method='post' action="finance_fsclass" class='col-md-12 form'>
	<div class = 'form-group col-md-4'>
	<select name='class' class='form-control '>
		<?php foreach($cls as $c=>$l): ?>
		<option <?=$fsclass==$c?'selected':null?> value='<?=$c?>' ><?=$l?></option>
		<?php endforeach; ?>
	</select>
	</div>
	<div class='col-md-2'>
	<input type='submit' value='Search' class='btn btn-primary form-control' >
	</div>
</form>

<?php 



$qstring = "SELECT fv.id, fvn.id as votehead, 
					ucase(cl.names) as class, format(fv.amount,2)as amount, fv.position, fv.term, fa.names as 'account' 
					FROM finance_voteheads as fv
					INNER JOIN finance_feeclasses as feeclasses on fv.feeclass = feeclasses.id
					LEFT JOIN finance_votehead_names as fvn on fv.votehead = fvn.id
					LEFT JOIN finance_accounts as fa on fv.account = fa.id
					LEFT JOIN classes as cl on cl.id = fv.class
					WHERE fv.class = '$fsclass' and fv.amount <> '' and fv.feeclass = '999' and fv.scode = '$sid' and fv.vhyear = year(current_timestamp)
					";
					
$vdata = get($qstring);
$vd = [];
foreach($vdata as $v=>$d){
	$vd[$d["class"]][$d["term"]][rx($d["votehead"])] = $d["amount"];
	$vds[$d["class"]][$d["term"]][$d["id"]] = rx($d["votehead"]);
}



$x = 1;
$vh = getvoteheads();

if(empty($vh)) error("VOTHEADS NOT FOUND!");

foreach($vd as $cl=>$txd){
	
table_open("p");
	echo "<thead>";
		echo "<tr><th colspan='5'>FEE STRUCTURE ".$cl." ".date("Y")."</th></tr>";
		echo "<tr>";
		echo "<th>Sn</th>";
		echo "<th>Votehead</th>";
		foreach(terms() as $t=>$tt){ echo "<th>".rx($tt,1)."</th>"; }
		echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
		$r = 1;
		$total = [];
		foreach($vh as $v=>$h){
			echo "<tr>";
			echo "<td>$r</td>";
			echo "<td>".rx($h,1)."</td>";
			foreach(terms() as $tr=>$vv){ 
				$amt = isset($txd[$tr][$v]) ? $txd[$tr][$v] : "";
				echo "<td>".$amt ."</td>";
				$total[$tr][] = remcommas($amt);
			}
			echo "</tr>";
			$r++;
		}
			/* empty */
			$s = 20-$r;$u = $r;for($t = 1; $t<$s+1; $t++){echo "<tr >";echo "<td >$u</td><td ></td>";foreach(terms() as $to=>$tal){echo "<td ></td>";}echo "</tr>";$u++;}
			
			echo "<tr >";
			echo "<td style='background:#aaa'>-</td><td style='background:#aaa'>TOTAL</td>";
			foreach(terms() as $to=>$tal){
				echo "<td style='background:#aaa'>".addcommas(array_sum($total[$to]))."</td>";
			}
			echo "</tr>";
			echo "<tr><td colspan=5><br><br><br>";
			bank_details();
			echo "</td></tr>";
	echo "</tbody>"; $x++;
table_close(0); 

}
table_foot();

	
/* isset($vv[$v]) ? $vv[rx($h)] : null */


