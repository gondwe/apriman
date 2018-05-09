<?php

require_once('../../top/functions.php');


ini_set('memory_limit','256M');
ini_set('max_execution_time',600);
$html =""; 

error_reporting(0);

if(isset($_SESSION[$ndk]["rcdata"])){
$instdata = getlist("select * from settings where id = '$sid'");
$logo = is_file("../../img/settings/".$instdata["logo"]) ? "../../img/settings/".$instdata["logo"] : "../../assets/images/default.png";

$html .= '<style>
	
	
	.rcnames {text-align:center;float:left}
	.rcnames #name {font-size:40px;}
	.rcnames #box {font-size:20px;}
	#logo {width:150px;padding:10px;}
	#plain {border-bottom:3px solid maroon;float:none;clear:both}
	
	
	table {min-width:750px;  solid;border-spacing: 0px;margin:0px auto; margin-top:25px}
	#tablex {border:0px solid; text-align:center; margin:0px auto; width:110%}
	#tablex td{border:0px solid}
	
	#bdr {border-bottom:1px solid; border-left:1px solid; padding-left: 5px;}
	#rgt {border-right:1px solid;border-bottom:1px solid; border-left:1px solid}
	#btr {border-right:1px solid;border-bottom:1px solid; border-top:1px solid}
	#bth {border-top:1px solid;border-bottom:1px solid; border-left:1px solid; border-right:1px solid }
	#bth-rgt {border-top:1px solid;border-bottom:1px solid; border-right:1px solid }
	
	th {border-right:1px solid; border-bottom:1px solid;padding-left: 5px;border-top:1px solid;}
	#plain2 {width:100%;text-align:center;margin-bottom:0px}
	#btm {border-bottom:1px solid #333;}
	
	
	</style>';

	
	
	
$html .= "
<table border=0 id='tablex'>
<tr><td><img id='logo' src='$logo'></td>
<td>
<div class='rcnames '>
	<div id='name' style='font-size:15px;' >MINISTRY OF EDUCATION</div><hr>
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
if(strtolower($thead) == "exp_payment_voucher"){
	$thead = "PAYMENT VOUCHER";
}
$desc = "";
if(is_string($thead)){
	$f = isset($_SESSION[$ndk]["subtitles"])? "<br>".$_SESSION[$ndk]["subtitles"] : null;
	$f = explode("|",$f);
	$desc .= "<div ><h2 id='plain2'>".rx(mx($thead),2)."</h2>";
	foreach($f as $ff){ $desc .= $ff."<br>"; }
	$desc .= "</div>";
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

