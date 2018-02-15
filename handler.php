<?php 
$file = "pages/$page.php";
if(file_exists($file)){
	include($file);
}else{
	include("pages/error.php");
}




?>
