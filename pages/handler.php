<?php 
include("../top/functions.php");

$g = explode(',',$_REQUEST['d']);

foreach($g as $a=>$h):
$n = explode('=',$h);
$k = $n[0];
$v = $n[1];
$_SESSION[$ndk]["GET"][$k] = $v;
endforeach;

$file  = $_SESSION[$ndk]["GET"]["p"].'.php';

$home = "../pages/index.php";
$error = $appmode == 'p' ? "../pages/404.php" : "../pages/error.php";
$fail = "../pages/register.php";
$file_a = "../pages/".$file;
$file_b = "../pages/models/".$file;



$fbi = ["logout","maps"];
$aspecialpage = (in_array($_SESSION[$ndk]["GET"]['t'],$fbi) || in_array($_SESSION[$ndk]["GET"]['p'],$fbi))? true : false;

if(strlen($_SESSION[$ndk]["GET"]["p"])>0){

if($_SESSION[$ndk]["dirty"] && !$aspecialpage ){
	$path = $fail;}else{
if(file_exists($file_a)){$path = $file_a;
}else{if(file_exists($file_b)){$path = $file_b;
	}else{$path = $error;}}
}
}else{
	$path = $home;
}

$a = explode("/",$_SERVER["PHP_SELF"]);array_pop($a);$a = implode("/",$a);
echo($a.substr($path, 8));



?>
