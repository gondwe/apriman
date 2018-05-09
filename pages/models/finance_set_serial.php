
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->

<style>
	#tt {background: #aabdbd;font-weight:bold}
	#tt #fc {color:#aabdbd}
	#sample_1 {margin-bottom:13%}
</style>


<div class="page-header">
<?php $t = $_GET["t"] = 'finance_set_serial';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
?>
<h1> <?=rx(mx($alias))?> <small>view</small></h1>
</div>
</div>
</div>


<?php


include ("nav.php");


?>

<form action="setserial" method="post">
<div class="form-group col-md-3">
<label>New Serial</label>
<input type="number" name="newserial" class="form-control">
<input type="submit" class='col-md-2 btn btn-primary' value="Set">
</div>
</form>