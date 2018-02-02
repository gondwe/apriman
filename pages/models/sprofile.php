<?php require ("../../top/functions.php"); $anchor=null; ?>
<style>
img.col-sm-2 {
	max-width: 150px;
	border-radius: 100px;
	border-style: double;
	border-bottom-left-radius: 0px;
	padding-inline-end: unset;
	padding-inline-start: initial;

}
</style>

<div class="page-header">
<?php $t = $_GET["t"] = "users"; $i = $user["id"]?>
<h1> <?=ucfirst($t)?> <small>add New</small></h1>
</div>
</div>
</div>
<?=linkbutton( "password", "users", "Change Password", $anchor )?>
<?php

$_SESSION[$ndk]["tablo"] = $t;



include ("../nav.php");
include ("../../top/tablo.php");
$d = new tablo($t, $i);
$d->hide("code,password,usertype");
$d->pictures("imagelocation");
$d->update();
include ("../sets.php");




