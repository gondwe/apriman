<?php 

$_SESSION[$ndk]['route'] = $t = "finance_arrears"; 
$route = isset($_SESSION[$ndk]['route'])? $_SESSION[$ndk]['route'] : $t;

// switch($t){
	// case "settings": $route = 'school'; break;
// }

/* alias array */

$alias = isset($_SESSION[$ndk]["alias"]) ? $_SESSION[$ndk]["alias"] : $route;
// switch($t){
	// case "vote_candidates":$alias = 'candidates'; break;
// }
?>
<h1> <?=rx(mx($route))?> <small>View</small></h1>
</div>
<!-- end: PAGE TITLE & BREADCRUMB -->
</div>
</div>

<?php

$arr = "select fa.id, fa.adm_no, st.names, replace(cl.abbr,' ','_') as class, format(fa.amount,2) as amount, fa.arryear as year_ 
		from finance_arrears as fa
		left join students as st on st.adm_no = fa.adm_no and fa.scode = st.sid
		left join classes as cl on cl.id = st.class
		where fa.scode = '$sid' 
		group by fa.id";

$cmb = [];
$comb = get("select fa.id, format(fa.amount,2) as amount, format(sum(fp.amount),2) as paid 
from finance_arrears as fa 
left join finance_payments as fp on fp.arrid = fa.id 
where fp.scode = '$sid'
group by fa.id");

// spill($comb);

foreach($comb as $k=>$m){
	$cmb[$m["id"]] = (int)$m["amount"] > (int)$m["paid"] 
	? "<span style='color:red'>PENDING</span>" : "<span style='color:green'>CLEARED</span>";
}
	

include("nav.php");
include ("../top/tablo.php");


$d = new tablo($t,null,$arr);
// $d->deleteset = false;
	$d->editset = true;
	$d->morecols[] = "Status";
	$d->morecolsdata = ["Status"=>$cmb];
$d->dtable();
// include ("sets.php");