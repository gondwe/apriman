<?php 

require ("../../top/functions.php"); 



// spill($_POST);
// $spl = "</table>";
// $x = explode($spl,$_POST["dat"]);
$html = $_POST["dat"];
// $subtitles = isset($x[1])? $x[1]:null;


$html = str_replace('src="img/settings/','src="../../img/settings/',$html);
$html = str_replace('src="assets/','src="../../assets/',$html);


$html = preg_replace('/<th class="hidden-print sorting".*?>Edit<\/th>/', "", $html);
$html = preg_replace('/<th class="hidden-print sorting".*?>Delete<\/th>/', "", $html);

$html = preg_replace('/<td.*?><a.*?>(.*?) Edit <\/a><\/td>/i', "", $html);
$html = preg_replace('/<td.*?><a.*?>(.*?) Delete <\/a><\/td>/i', "", $html);
// $html .= $spl;
// spill($html);

// if(substr($subtitles,0,1) == "," ){ $subtitles = substr( $subtitles, 1); }
// spill($subtitles);
$_SESSION[$ndk]["rcdata"] = $html;
// $_SESSION[$ndk]["subtitles"] = $subtitles;

?>
