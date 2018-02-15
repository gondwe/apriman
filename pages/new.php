<?php require ("../top/functions.php"); $anchor = null; ?>
<?php 
$modelpath = '..'.DIRECTORY_SEPARATOR.'pages'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR;
$model = $modelpath.$_GET["t"].'.php'; 
if(file_exists($model)){ include ($model);}else{ 

?>

<div class="page-header">
<?php 

/* Reassign Global GET */
$old = $_GET["t"];
switch($_GET["t"]){
	case "access_control":$_GET["t"] = 'crud'; break;
	case "user_accounts":$_GET["t"] = 'users'; break;
	case "registration":$_GET["t"] = 'students'; break;
	case "exams_new":$_GET["t"] = 'exams_examslist'; break;
	case "new_supply":$_GET["t"] = 'finance_supplies'; break;

}










if($old !== $_GET['t']){ reload("#new/".$_GET['t']);}


/* Supply anchor array */
switch($_GET["t"]){
	case "user_types":$anchor = [0]; break;
	case "classnames":$anchor = [0]; break;
	case "menunames":$anchor = [0]; break;
	case "unlisted":$anchor = [0]; break;
	case "finance_accounts":$anchor = [0]; break;
	case "finance_feeclasses":$anchor = [0]; break;
	case "finance_expenditure_names":$anchor = [0]; break;
	case "crud":$anchor = [0,1]; break;
}


$t = $_GET['t'];
$_SESSION[$ndk]["route"] = $route = $t;



/* routes array */
switch($t){
	case "settings":$route = 'school'; break;
	case "crud":$route = 'access_control';break;
}









/* alias array */
$alias = $route;
switch($t){
/* 	we define local names as below 
	case "vote_candidates":$alias = 'candidates';break; 
*/
}

$_SESSION[$ndk]["alias"] = $alias = mx($alias);








?>
<h1> <?=rx($alias)?> <small>add New</small></h1>


</div>
<!-- end: PAGE TITLE & BREADCRUMB -->
</div>
</div>



<div>
<?php


include("nav.php");
linkbutton( "views", $t, "View ".rx($alias), $anchor);
include ("../top/tablo.php");

$d = new tablo($t);
include ("sets.php");
if($anchor !==null ){$d->dtable(0);}


}

$fmodel = $modelpath."_".$_GET["t"].'.php'; 
if(file_exists($fmodel)) include ($fmodel);


?>

