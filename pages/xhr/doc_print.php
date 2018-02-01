<?php 

require ("../../top/functions.php"); 
$html = $_POST["dat"];
$html = str_replace('src="img/settings/','src="../../img/settings/',$html);
$html = str_replace('src="assets/','src="../../assets/',$html);
// $html = str_replace('src="assets/','src="../../assets/',$html);




$_SESSION[$ndk]["rcdata"] = $html;

// echo $_POST["dat"]
?>

