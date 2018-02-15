<?php require ("../top/functions.php"); $anchor = null; ?>
<div class="page-header">
<?php $t = $_GET['t'];?>
<h1> <?=rx(mx($t))?> <small>Edit & Update</small></h1>
</div>
</div>
</div>
<?=linkbutton( "views", $t, "View ".rx(mx($t)), $anchor)?>
<?php

$_SESSION[$ndk]["tablo"] = $t;

if(isset($_POST[$t."_form"])){
	// spill($_POST);
	unset($_POST[$t."_form"]);
	update($t, $_GET["i"]);
}


include ("../top/tablo.php");

$d = new tablo($t, $_GET['i']);
include ("sets.php");




