
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
