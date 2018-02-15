<?php 

$adm ="";
if(isset($_SESSION[$ndk]["adm_search"])){
	$cmb = [];
	$adm = $_SESSION[$ndk]["adm_search"];
	// $data = getlist("select id from finance_arrears where adm_no = ".$adm);
	
	// $paid = getlist("select sum(amount) from finance_payments where adm_no = '".$adm."' and arrid is not null group by arrid ");
	$comb = get("select fa.id, fa.amount, sum(fp.amount) as paid 
			from finance_arrears as fa 
			left join finance_payments as fp on fp.arrid = fa.id
			where fa.adm_no = '$adm' and fp.scode = '$sid' 
			group by fa.id");
			
			
	// spill($comb);
	
	foreach($comb as $k=>$m){$pd[$m["id"]] = $m["paid"]; $cmb[$m["id"]] = $m["amount"] > $m["paid"] ? "<span style='color:red'>PENDING</span>" : "<span style='color:green'>CLEARED</span>";}
	
	echo "<div id='arrdata'></div>";
}

echo "<script>arrearsdata('".$adm."')</script>";

?>
<script>

$("input:text[name=adm_no]").keyup(function(){adm_search(this.value); arrearsdata(this.value);});
</script>
