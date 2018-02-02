<?php 

require ("../../top/functions.php"); 
$i = $_POST["dat"];

switch($i){
	case 1 : echo suppliers(); break;
	case 2 : echo expenditures(); break;
}

echo "<div id='arena' class='col-md-12'>";

function expenditures(){
	global $ndk, $sid;
	$_SESSION[$ndk]["expchoice"] = 2;
	inmenu(["new/finance_expenditure_names"]);
	echo '<div class="col-sm-8"><hr>';
	form_open("finance_loadexp2_post");
	form_cbo_("finance_expenditure", getlist("select id, names from finance_expenditure_names  where scode = '$sid'"));
	form_cbo_("finance_votehead",getlist("select id, names from finance_votehead_names where scode = '$sid'"));
	form_cbo_("term",terms());
	form_input("amount");
	form_close(1,"PAY");
	echo "</div>";
}



function suppliers(){
	global $ndk, $sid;
	$_SESSION[$ndk]["expchoice"] = 1;
	inmenu(["new/finance_suppliers",]);
	// $who = isset($_SESSION[$ndk]['supplier'])? $_SESSION[$ndk]['supplier'] : "-";
	// $what = isset($_SESSION[$ndk]['supplier_product'])?$_SESSION[$ndk]['supplier_product']: [];
	$names =["-"=>"SELECT SUPPLIER"]+getlist("select id, names from finance_suppliers  where scode = '$sid'");
	echo '<div class="col-sm-8"><hr>';
	form_open("finance_loadexp_post");
	form_cbo_("finance_name", $names);
	form_cbo_("finance_order",[]);
	form_input("amount");
	form_close(1,"PAY");
	echo "</div>";
	echo '<div id="supply_details" class="col-sm-4"></div>';


	
}

echo "</div>";
?>


<script>

</script>

