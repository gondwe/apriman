<?php //require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php 

$t = $_GET["p"];
$_SESSION[$ndk]["route"] = $route = "finance_payment_modes";

?>
<h1> <?=rx("payment modes")?> <small>configure </small></h1>
</div>
</div>
</div>
<br>
<?php 
include("nav.php");
include("../top/tablo.php");
$d = new tablo('vdata', "vprop = 'paymodes' and xdat='$sid'");
include("sets.php");
// $d->newform();
$d->dtable();
