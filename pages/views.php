<?php require ("../top/functions.php"); ?>
<div class="page-header">
<?php 

$modelpath = '..'.DIRECTORY_SEPARATOR.'pages'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR;
$model = $modelpath.$_GET["t"].'_.php'; 
if(file_exists($model)){ include ($model);}else{ 


$t = $_GET['t']; 
$route = isset($_SESSION[$ndk]['route'])? $_SESSION[$ndk]['route'] : $t;

// switch($t){
	// case "settings": $route = 'school'; break;
// }

/* alias array */

$alias = isset($_SESSION[$ndk]["alias"]) ? $_SESSION[$ndk]["alias"] : $route;
// switch($t){
	// case "vote_candidates":$alias = 'candidates'; break;
// }
?>
<h1> <?=rx(mx($alias))?> <small>View</small></h1>
</div>
<!-- end: PAGE TITLE & BREADCRUMB -->
</div>
</div>

<?php


include("nav.php");
include ("../top/tablo.php");

$d = new tablo($t);
include ("sets.php");

}



