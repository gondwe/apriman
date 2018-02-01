
<?php 
require ("../top/functions.php");
$newpage = 'models/'.$_GET["t"];

$md = fopen($newpage.".php","w");	
fwrite($md,'
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> <?=rx(mx($t))?> <small>add New</small></h1>
</div>
</div>
</div>
<?=linkbutton( "views", $t, "View ".rx($t), $anchor)?>
<?php include("../nav.php") ?>
');
	
fclose($md);$go = "#".$_GET["t"];
?>
<script>window.location.href = '<?=$go?>';</script>