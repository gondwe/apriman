<?php 

require ("../../top/functions.php"); 

$adm = $_POST["dat"];

if($adm !== ""){
	$me = fetch("select names from students where adm_no = '$adm' and sid = '$sid'");
	if($me !== ""){ $_SESSION[$ndk]["adm_search"] = $adm;}
	echo "<h3>Repayment : ".$me."</h3>";
	$comb = get("select fa.id, fa.amount, sum(fp.amount) as paid 
			from finance_arrears as fa 
			left join finance_payments as fp on fp.arrid = fa.id
			where fa.adm_no = '$adm' and fp.scode = '$sid' 
			group by fa.id");
	
	// spill($comb);
	$cmb = [];
	foreach($comb as $k=>$m){$pd[$m["id"]] = $m["paid"]; 
	$cmb[$m["id"]] = $m["amount"] > $m["paid"] ? "<span style='color:red'>PENDING</span>" : "<span style='color:green'>CLEARED</span>";}
	
	// spill($cmb);
	
	if(empty($cmb)) die("<h1> - - </h1>");
	$bal = (int)$comb[0]["amount"] - (int)$comb[0]["paid"];
		echo "<div style='font-size:16px; margin-left:10px'>";
		echo "<div>Amount : ".$comb[0]["amount"]."</div>";
		echo "<div>Paid : ".$comb[0]["paid"]."</div>";
		echo "<div>In Arrears : ".$bal."</div>";
		echo "<div>Status : ".$cmb[$comb[0]["id"]]."</div>";
		echo "</div>";

	
}