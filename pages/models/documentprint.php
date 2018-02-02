<?php

require_once('../../top/functions.php');


ini_set('memory_limit','256M');
ini_set('max_execution_time',600);
$html =""; 
// ob_start();

// spill($_SESSION);
// echo $html; 

if(isset($_SESSION[$ndk]["rcdata"])){
$instdata = getlist("select * from settings where id = '$sid'");
$logo = is_file("../../img/settings/".$instdata["logo"]) ? "../../img/settings/".$instdata["logo"] : "../../assets/images/default.png";

$html .= '<style>
	
	
	.rcnames {text-align:center;float:left}
	.rcnames #name {font-size:40px;}
	.rcnames #box {font-size:20px;}
	#logo {width:150px;padding:10px;}
	#plain {border-bottom:3px solid maroon;float:none;clear:both}
	
	
	table {min-width:750px; border:1px solid;border-spacing: 0px;border-right:2px solid;margin:0px auto; margin-top:25px}
	#tablex {border:0px solid; text-align:center; margin:0px auto; width:110%}
	#tablex td{border:0px solid}
	td {border-right:1px solid; border-bottom:1px solid;padding-left: 5px;}
	th {border-right:1px solid; border-bottom:1px solid;padding-left: 5px;border-top:1px solid;}
	
	
	</style>';

	
	
	
$html .= "
<table border=0 id='tablex'>
<tr><td><img id='logo' src='$logo'></td>
<td>
<div class='rcnames '>
	<div id='name' style='font-size:35px;' >".rx($instdata["name"])."</div>
	<div id='box' style='font-size:20px;'>P.O. Box ".$instdata["pobox"]."-".$instdata["postal_code"].", ".$instdata["location"]."</div>
	<div id='tel'>Tel : +254 ".$instdata["pnumber"]."</div>
	<div id='email'>e-mail : ".$instdata["email"]."</div>
</div>
</td><td><img id='logo' src='$logo'></td></tr>
</table>
<div id='plain'></div>";

$thead = $_GET["t"] == ""  || $_GET["t"] == "undefined"?  $_GET["p"] :   $_GET["t"];
$thead = is_numeric($thead)? $_GET["p"]: $thead;
$desc = "";
if(is_string($thead)){
	$f = isset($_SESSION[$ndk]["subtitles"])? "<br>".$_SESSION[$ndk]["subtitles"] : null;
	$f = explode("|",$f);
	$desc .= "<div id='plain2'><h4>".rx(mx($thead));
	foreach($f as $ff){ $desc .= $ff."<br>"; }
	$desc .= "</h4></div>";
}

$html .= $desc;

	// spill($_GET);
$html .=$_SESSION[$ndk]["rcdata"];
// echo $html;
// die();
//==============================================================
//==============================================================
$title = '_'.$_SESSION[$ndk]["GET"]["t"]."_".date("M").date("y").".pdf";
include("../../mpdf/mpdf.php");
$orient = isset($_SESSION[$ndk]["mpdforient"]) ? $_SESSION[$ndk]["mpdforient"] : "L";
$mpdf=new mPDF('','A4','12','century gothic',10,10,10,0,10,10,$orient); 
$mpdf->setTitle('Document');

//$mpdf->setHeader($header);
// $mpdf->SetFooter($footer);
//$img="images/nyakach.png";
//$mpdf->SetWatermarkImage($img);
// $mpdf->showWatermarkImage=true;


$mpdf->WriteHTML($html);
$mpdf->Output($title,'I'); 

exit;
}

