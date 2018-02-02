
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php 

$t = $_GET["p"];
$_SESSION[$ndk]["route"] = $route = "vote_candidates";

?>
<h1> <?=rx($t)?> <small>add New</small></h1>
</div>
</div>
</div>
<?=linkbutton( "views", $route, "View ".rx($t), $anchor)?>

