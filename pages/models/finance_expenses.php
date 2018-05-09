
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->

<style>
	#tt {background: #aabdbd;font-weight:bold}
	#tt #fc {color:#aabdbd}
	#sample_1 {margin-bottom:13%}
</style>


<div class="page-header">
<?php $t = $_GET["t"] = 'finance_expenses';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
?>
<h1> <?=rx(mx($alias))?> <small>pay expenses</small></h1>
</div>
</div>
</div>


<?php
include("nav.php");

echo "<h3>Select Option</h3>";
echo "<a href='javascript:loadexp(1)' class='btn btn-orange btn-squared' >Suppliers</a><a href='javascript:loadexp(2)' class='btn btn-purple btn-squared'>Expenditures</a>"


?>
<div id='arena' class='col-md-12'></div>
<?php 

	echo "<div class='col-sm-12' id='paylog'>";
		if(isset($_SESSION[$ndk]['supplier'])){ get_supplier_paylog($_SESSION[$ndk]['supplier']);}
	echo "</div>";
	
	
	if(isset($_SESSION[$ndk]["expchoice"])){
		$i = $_SESSION[$ndk]["expchoice"];
		echo "<script>ajpost($i, 'pages/xhr/finance_loadexp.php', 1, 0, 'arena');</script>";
	}
	
	$_GET["t"] = "finance_supplier_payments";
?>


<script>
	function loadexp(i){
		ajpost(i, "pages/xhr/finance_loadexp.php", 1, 0, "arena"); 
		/* document.getElementById("paylog").innerHTML = "";  */
	}
	
	function cancelpay(id){
		del('#delete/finance_supplier_payments/'+id, id);
	}
	function cancelexppay(id){
		del('#delete/finance_exp_payments/'+id, id);
	}
</script>