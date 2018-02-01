
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->

<style>
	#tt {background: #aabdbd;font-weight:bold}
	#tt #fc {color:#aabdbd}
	#sample_1 {margin-bottom:13%}
</style>


<div class="page-header">
<?php $t = $_GET["t"] = 'finance_balances';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
?>
<h1> <?=rx(mx($alias))?> <small>view</small></h1>
</div>
</div>
</div>


<?php


include ("nav.php");
$cl = null; $str = null;
if(isset($_SESSION[$ndk]["balances"])){
$cl = array_keys($_SESSION[$ndk]["balances"])[0];$str = array_values($_SESSION[$ndk]["balances"])[0];}
$classes = namelist("classes");
$streams = namelist("streams");
$fcls = namelist("finance_feeclasses");

$terms = terms();
$year = date("Y");
$mainstr[] = array_search("MAIN",$streams);
$mainstr[] = array_search("ALL",$streams);

form_open("finance_balances");
echo "<div class='col-sm-3' >";form_cbo_("class",$classes, $cl);echo "</div>";
echo "<div class='col-sm-3' >";form_cbo_("stream",$streams, $str);echo "</div>";
echo "<div class='col-sm-6' >";form_close(1,"FILTER");echo "</div>";


if(!is_null($cl)){
	$strw = in_array($str,$mainstr) ? null : " and stream = '$str' ";
	$bd = [];
	$bda = [];
	$bdata = [];
	$fcld = [];
	$balances = [];
	$tpaid = [];
	$tbal = [];
	
	$qstrall = "
		select st.adm_no, st.names, fd.feeclass  from students as st 
		left join finance_fdata as fd on fd.adm_no = st.adm_no 
		where st.class = '$cl' and st.sid = '$sid'
		$strw
		group by st.adm_no
		";	
	
	/* get the count of student in that category */
	$st_count = fetch("select count(st.adm_no) from students as st 
		left join finance_fdata as fd on fd.adm_no = st.adm_no 
		where st.class = '$cl' and st.sid = '$sid'
		$strw
		group by st.adm_no");
	
	/* use the right method to fetch data */
	$bdall = $st_count > 1 ? getlist($qstrall) : get($qstrall);
	if(empty($bdall)){ error("0 RESULT"); }
	foreach($bdall as $tt=>$d){$bda[current($d)] = $d;}

	foreach($terms as $t=>$tt){
		$qstr = "
		select st.adm_no, st.names, sum(fp.amount) as amt from students as st 
		left join finance_payments as fp on fp.adm_no = st.adm_no 
		where st.class = '$cl' 
		$strw
		and fp.term = '$t'
		and fp.arrid is null
		group by st.adm_no
		";
		$bdata[$t] = get($qstr);
		foreach($fcls as $k=>$f){
			$fcld[$k][$t] = fetch("select sum(amount) from finance_voteheads where feeclass = '$k' and class='$cl' and term = '$t' and vhyear = '$year'");
		}
	
	}
	
	
	// spill($bdata);
	foreach($bdata as $tt=>$d){foreach($d as $e=>$f){$bd[$tt][current($f)] = $f;}}
	
	foreach($bda as $b=>$da){
		$balances[$b]["names"] = $da["names"];
		$ttp = [];
		$ttb = [];
	foreach($terms as $t=>$tt){
		$fc = is_null($da["feeclass"])? "999" : $da["feeclass"];
		$ttp[] = $paid = $balances[$b][$t]["paid"] = isset($bd[$t][$b])? $bd[$t][$b]["amt"] : 0;
		$ttb[] = $bal = $balances[$b][$t]["balance"] = $fcld[$fc][$t] - $paid;
		$tpaid[$t][] = $paid;
		$tbal[$t][] = $bal;
		}

		$balances[$b]["ttp"] = array_sum($ttp);
		$balances[$b]["ttb"] = array_sum($ttb);
		
	}
	
		
		
	// spill($tpaid);
	// spill($fcld);
	// spill($bda);
	// spill($bd);
	// printA4("sampletablefbal",'l');

	if(!empty($balances)){
	$r = 1;
	table_open("l");
	echo "<thead>";
		echo "<th>Sn</th>";
		echo "<th>Reg No</th>";
		echo "<th>Names</th>";
		foreach($terms as $t=>$tt){ echo "<th>".abbr(rx($tt))."Paid</th>"; echo "<th>".abbr(rx($tt))."Bal</th>"; }
		echo "<th>P.Total</th>";
		echo "<th>B.Total</th>";
	echo "</thead>";
	echo "<tbody>";
	foreach($balances as $b=>$lances){
		echo "<tr>";
		echo "<td>$r</td>";
		echo "<td>$b</td>";
		echo "<td>".$lances['names']."</td>";
		foreach($terms as $t=>$tt){ echo "<td>".addcommas($lances[$t]["paid"],0)."</td><td>".addcommas($lances[$t]["balance"],0)."</td>"; }
		echo "<td>".addcommas($lances['ttp'],0)."</td>";
		echo "<td>".addcommas($lances['ttb'],0)."</td>";
		echo "</tr>";
		$r++;
	}
		if(!empty($tpaid)){
		echo "<tr id='tt'>";
		echo "<td id='fc'></td>";
		echo "<td></td>";
		echo "<td>TOTAL</td>";
		
		foreach($terms as $t=>$tt){ $paids = array_sum($tpaid[$t]); $bals = array_sum($tbal[$t]); $tbals[] = $bals;$tpaids[] = $paids; echo "<td>".addcommas($paids,0)."</td><td>".addcommas($bals,0)."</td>"; }
		echo "<td>".addcommas(array_sum($tpaids),0)."</td>";
		echo "<td>".addcommas(array_sum($tbals),0)."</td>";
		echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";
	
	
	// spill($balances);
	
	
	}	
}