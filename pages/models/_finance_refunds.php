<?php 

if(isset($_SESSION[$ndk]["adm_search"])){
	// $cmb = [];
	// $adm = $_SESSION[$ndk]["adm_search"];

	// $comb = get("select fa.id, fa.amount, sum(fp.amount) as paid from finance_arrears as fa left join finance_payments as fp 
	// on fp.arrid = fa.id and fp.arrid is not null where fa.adm_no = '$adm'  group by fa.id");
	// foreach($comb as $k=>$m){$cmb[$m["id"]] = $m["amount"] > $m["paid"] ? "<span style='color:red'>PENDING</span>" : "<span style='color:green'>CLEARED</span>";}
	
	
	
	
	
	// $d = new tablo("finance_arrears","adm_no =".$adm);
	// $d->deleteset = false;
	// $d->editset = false;
	// $d->morecols[] = "Status";
	// $d->morecolsdata = ["Status"=>$cmb];
	// $d->dtable(0);
	
}



?>
<script>
$("input:text[name=adm_no]").keyup(function(){adm_search(this.value);});
</script>
