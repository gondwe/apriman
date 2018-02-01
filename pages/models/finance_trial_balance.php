
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> <?=rx(mx($t))?> <small>add New</small></h1>
</div>
</div>
</div>
<?php 

include("../nav.php");
function df($i){ return date_format(new DateTime($i),'d, M Y'); }

/* by default lets get cumulative */

$mymonth = isset($_GET['imo'])? (int)$_GET['imo'] : (int)date('m');
$lastday = $mymonth == date('m')? date('d') : cal_days_in_month(CAL_GREGORIAN,$mymonth, date('Y'));
$monthwhere = " month(date) = ".$mymonth." and year = '".date("Y")."'"; 



$df = "d-m-Y";
if(isset($_SESSION[$ndk]["tbdates"])){
	$fd=$_SESSION[$ndk]["tbdates"]["fromdate"];
	$td=$_SESSION[$ndk]["tbdates"]["todate"];
}else{
	$fd = date($df,mktime(0,0,0,date("m"),1,date("Y")));
	$td = date($df);
}




?>
<div style='margin:20px' class='col-md-12'>
<form action='finance_trial_balance.php' method='post' ><input class='col-md-2' type='date' name='fromdate'  value='<?=$fd?>'>
<input class='col-md-2 col-sm-offset-1' name='todate' type='date'  value='<?=$td?>'><input type='submit' class='col-sm-offset-1 btn btn-success col-md-2' value='Load'></form>
</div>
<?php 
$p_modes = getlist("select id, vdat from vdata where vprop = 'paymodes' and xdat = '$sid'");
$fdd = date("Y-m-d",strtotime($fd));$tdd = date("Y-m-d",strtotime($td));

foreach($p_modes as $p=>$m):
$$m = get("select * from finance_payments where date(date) >= '$fdd' and date(date) <= '$tdd' and pmode = '$p' and arrid is null");
endforeach;


$bank_e = getlist("select repdot2(fv.names) as votehead, sum(fe.amount) as amount  from finance_exp_payments as fe left join finance_votehead_names as fv on fv.id = fe.votehead where fe.date >= '$fdd' and fe.date <= '$tdd' group by votehead");

$a = array_column(getlist("describe finance_payments"),"Field");
$b = getlist("select repdot2(names) from finance_votehead_names");
$v = array_intersect($a,$b);
	
	
	
	$t = [];
	$ct = [];
	foreach($p_modes as $i=>$j):
		foreach($v as $d):
			$t[$j][$d] = array_sum(array_column($$j, $d));
			$ct[$d] = array_sum(array_column($t,$d));
		endforeach;
	endforeach;

	?>
<?php 

$title =  "<h3>Period ( ".df($fdd)." - ".df($tdd)." ) </h3>";
table_open("l", $title);

?>
<thead >
<tr>
	<th><b>Particulars</b></th>
	<th><b>Folio</b></th>
	<th><b>Dr</b></th>
	<th><b>Cr</b></th>
	<th><b>Commitments</b></th>
</tr>
</thead>
<tbody>
	<tr><td><b>Opening Balance</b></td></tr>
	<tr><td class='text-center'>Bank</td></tr>
	<tr><td class='text-center'>Cash</td></tr>
	
	<?php foreach($v as $vh): ?>
		<tr class='text-right'>
			<td><?=rx(repdot($vh),2)?></td>
			<td>-</td>
			<td><?=addcommas(isset($bank_e[$vh])? $bank_e[$vh] : 0 ,0) ?></td>
			<td><?=addcommas($ct[$vh],0)?></td>
			<td>-</td>
		</tr>
	<?php endforeach; ?>
	<tr><td ><b>Closing Balance</b></td></tr>
	<tr><td class='text-center'>Bank</td></tr>
	<tr><td class='text-center'>Cash</td></tr>


</tbody>
<?php echo table_close() ?>

<hr />
<h3>Collections</h3>
<?php
$x = 10;
foreach($t as $i=>$cc){
	$x++;
	$tid = "sampletable".$x;
	echo "<h3>$i</h3>";
	// panela($i, 1);
	printA4($tid,"p",$i);
	echo '<table class="table table-striped" id="'.$tid.'">';
	
		foreach($cc as $id=>$d){
			echo "<tr><td>".rx($id,2)."</td><td>".addcommas($d)."</td></tr>";
		}

	echo "<tr><td><td></td><h4><b>$i Total </b>".addcommas(array_sum($cc))."</h3></td></tr>";
	echo '</table>';
	// panelb();
}

