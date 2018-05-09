<?php

require_once('../../top/functions.php');

error_reporting(0);
ini_set('memory_limit','256M');
ini_set('max_execution_time',600);
// ob_start();

// spill($_SESSION);
// echo $html; 

if(isset($_SESSION[$ndk]["rcdata"])){
 
$html = '<style>.receipt {width:600px;display:auto;margin:0px auto;margin-bottom:2%;height:800px;/* background:pink; */font-family:century gothic;padding:10px;border:1px solid #ccc;border-radius:15px;}#rclogo {width:180px;float:left;}/* #rclogo img{width:120px;} */#rchead {width:100%;border-bottom:1px solid black;}.rcnames {width:410px;float:right;text-align:center;}#name{font-size:42px;}	#box {font-size:18px;}	#official {font-size:17px;}	#rcperson {padding-top:10px;}.rcperson {width:100%;margin-bottom:10px;	}.moneys {width:15%; text-align:center}#ctst{width:50px; text-align:center}#vh {padding-left:10px;}#shs {text-align:right; padding-right:10px;}#cts {text-align:center;}.tots {font-weight:bolder}.sum {font-weight:bold;margin-left:60%;padding-right:5px}.rcfooter {padding-left:20px;padding-right:20px;margin-top:5px;}.recno {border-bottom:1px solid black;width:60%}.balances {width:100%;}.rcbreakdown {border-right:1px solid black;border-bottom:2px solid black;}#bkd td {border-bottom:1px solid black;border-left:1px solid black;}		.bktitle th {border:1px solid black;}#mid {border:1px solid #aaa;border-radius:15px;padding:4px;margin-bottom:5px;}</style>';

$html .=$_SESSION[$ndk]["rcdata"];

// echo $html;
// die();


//==============================================================
//==============================================================
$title = 'receipt_'.$_SESSION[$ndk]["adm_search"]."_".$_SESSION[$ndk]["bkdownid"].".pdf";
include("../../mpdf/mpdf.php");

$mpdf=new mPDF('','A5','11','consolas',0,0,0,0,10,10); 
$mpdf->setTitle('Receipts');
//$mpdf->setHeader($header);
$mpdf->SetFooter($footer);
//$img="images/nyakach.png";
//$mpdf->SetWatermarkImage($img);
// $mpdf->showWatermarkImage=true;
$mpdf->WriteHTML($html);
$mpdf->Output($title,'I'); 

exit;
}

