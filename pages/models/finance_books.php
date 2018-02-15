
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<style>.alert {background:none; border-right:none; border-left:none}</style>
<div class="page-header">
<?php $t = $_GET["t"] = 'finance_books';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>

<style>
	.col-md-12 { margin-bottom:3%; border-bottom:1px solid #ddd}
</style>


<?php
include ("nav.php");
echo "<div class=' col-md-12'>";
echo "<h4 class='col-sm-2'>INCOME</h4>";
echo "<div class='col-sm-2'>";form_button("cash_book",1,"finance_cashbook");echo "</div>";
echo "<div class='col-sm-2'>";form_button("ledger",1,"finance_ledger");echo "</div>";
echo "<div class='col-sm-2'>";form_button("arrears",1,"views/finance_arrears");echo "</div>";
echo "</div>";

echo "<div class=' col-md-12'>";
echo "<h4 class='col-sm-2'>EXPENDITURE</h4>";
echo "<div class='col-sm-2'>";form_button("cash_book",1,"finance_expenditure_cashbook");echo "</div>";
echo "<div class='col-sm-2'>";form_button("ledger",1,"finance_expenditure_ledger");echo "</div>";
echo "</div>";

echo "<div class=' col-md-12'>";
echo "<h4 class='col-sm-2'>OTHER</h4>";
echo "<div class='col-sm-2'>";form_button("trial_balance",1,"finance_trial_balance");echo "</div>";
echo "<div class='col-sm-2'>";form_button("fees_register",1,"finance_fees_register");echo "</div>";
echo "<div class='col-sm-2'>";form_button("qr_payments",1,"finance_qr_payments");echo "</div>";
echo "<div class='col-sm-2'>";form_button("balances",1,"new/finance_balances");echo "</div>";
echo "</div>";

echo "<div class=' col-md-12'>";
echo "<h4 class='col-sm-2'>MISC</h4>";
echo "<div class='col-sm-2'>";form_button("refunds",1,"new/finance_refunds");echo "</div>";
echo "<div class='col-sm-2'>";form_button("reviews",1,"finance_reviews");echo "</div>";
echo "<div class='col-sm-2'>";form_button("fee_structure",1,"finance_fee_structure");echo "</div>";
echo "</div>";
