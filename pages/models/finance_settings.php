
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<style>.alert {background:none; border-right:none; border-left:none}</style>
<div class="page-header">
<?php 
$t = $_GET["t"]; // = 'finance_transfer_voteheads';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
 ?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>


<?php 
/* get registered classes */
$fclasses  = getlist("select id, names from finance_feeclasses where scode  = '$sid'");

?>

<h3>Set Main Feeclass</h3>
<div class='col-md-12'>
<form action="finance_set_mainclass" method='post' class='col-sm-6' style='margin:10px'>
	<div class='form-group'>
	<label class='label'>Main Fee Class</label>
	<select name='fee_class' class='form-control'>
		<?php foreach($fclasses as $f=>$c): ?>
		<option value='<?=$f?>' ><?=$c?></option>
		<?php endforeach; ?>
	</select>
	<br />
	<input type='submit' value='SAVE' class='form-control btn btn-primary'/>
	
</div>
</form>
</div>




<h3>Transfer Voteheads</h3>
<?php


$years = getlist("select distinct vhyear from finance_voteheads where vhyear <> year(current_timestamp) and vhyear < year(current_timestamp)");
echo "<div class='panel-default row'>";
if(empty($years)){echo("<button class=' pull-right btn btn-squared btn-orange'>IMPORTING VOTEHEADS is not allowed at the moment.</button>");}else{

foreach($years as $yr){
	echo "
	<div class='col-md-12'>
	<div class='col-sm-6' style='margin:10px'>
	<button onclick='ftranfervh($yr)'class='form-control btn btn-squared btn-warning'>CLICK TO IMPORT $yr VOTEHEADS</button>
	</div></div>";
}
}
echo "</div>";

echo "<div class='panel-default row'>";
	echo "
	<div class='col-md-12'>
	<div class='col-sm-6' style='margin:10px'>
	"; ?> 
	<button onclick='fvhclear("voteheads")'class='form-control btn btn-squared btn-warning'>CLEAR CURRENT VOTEHEADS</button><?php echo "
	</div></div>";
echo "</div>";


echo "<div class='panel-default row'>";
	echo "
	<div class='col-md-12'>
	<div class='col-sm-6' style='margin:10px'>
	"; ?> 
	<button onclick='fvhclear("payments")'class='form-control btn btn-squared btn-warning'>CLEAR ALL PAYMENTS</button><?php echo "
	</div></div>";
echo "</div>";





?>

