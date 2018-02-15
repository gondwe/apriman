<?php 

require ("../../top/functions.php"); 
$i = explode(',',$_POST['dat']);$j = current($i);$k = end($i);

switch($j){
	
	case 'finance_name' :
		$supplies = getlist("select fb.id, concat( ucase(supply_id), ' on ',date_format(fb.date,'%W %D %M %Y') ) as names from finance_suppliers as fa left join finance_supplies as fb on fb.supplier_id = fa.id and fa.id = $k");
		echo '<option value="-">SELECT SUPPLY BY DATE</option>';
		foreach($supplies as $a=>$b){echo '<option value="'.$a.'">'.$b.'</option>';}
		$_SESSION[$ndk]['supplier'] = $k;
	break;

	case 'finance_order' :
		$sdata = fetch("select names  from finance_suppliers as fa left join finance_supplies as fb on fa.id = fb.supplier_id  
		where fb.id ='$k'");
		
		$initial_cost = fetch("select cost from finance_supplies where id ='$k'");
		$paidamt = fetch("select ifnull(sum(amount),0) from finance_supplier_payments where supplycombo = '$k'");
		$bal  = addcommas($initial_cost - $paidamt);
		echo "<h3>".rx($sdata)."</h3>";
		echo "<h4>Initial : ".addcommas($initial_cost)."</h4><h4>Paid : ".addcommas($paidamt)."</h4><h4>Balance : $bal</h4>";
		// $_SESSION[$ndk]['supplier_product'] = $k;
	break;
}
?>

