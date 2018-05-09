<?php 

require ("../../top/functions.php"); 
$adm = $_SESSION[$ndk]["adm_search"];
$opt = $_POST["opt"];

$lower = fetch("select min(id) from classes");
$upper = fetch("select max(id) from classes");
$class = fetch("select class from students where adm_no = '$adm'");

$sql = $opt == "1" ? "update students set class = class + 1 where adm_no ='$adm'" : "update students set class = class - 1 where adm_no ='$adm'";
if($opt == 2 and $class == $lower){
	echo "Lowest Class Reached!";
}else{
	process($sql);
}
	
	
?>

