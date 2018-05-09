<?php require ("../top/functions.php"); ?>
							
							<div class="page-header">
								<h1>Home <small>overview &amp; stats </small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<div class="row">
					
					<!-- our homepage stuff comes here -->
					
					</div>

<style>
	img { width:180px;}
	/* .rcnames {margin-top:40px} */
</style>
		<?php 
			
		
$me = $_SESSION[$ndk]["user"]["scode"];
$instdata = getlist("select * from settings where id = '$me'");


$rec = "";
$rec .=  "<div id='' style='dispaly:block; text-align:center; margin:15px auto;'>";
$rec .=  "<div id='rchead' class='col-sm-12' >";
$rec .=  "<div id='' class='col-sm-12' style='background-image: url(".getimage("settings/".($instdata["logo"])).");height: 350px;float: left;z-index: 0;opacity: 0.1;background-repeat: space;left: 2px;background-size: contain;' ></div>";
// $rec .=  "<div id='rclogo'  style='border-bottom:1px solid #ddd' ><img style='width:150px' src='".getimage("settings/".($instdata["logo"]))."' ></div>";
$rec .=  "<div class='rcnames col-sm-12' style='top: -250px;' >";
$rec .=  "<div id='name'><h1 style='font-size:48px'>".rx($instdata["name"])."</h1></div>";
$rec .=  "<div id='box'>P.O. Box ".$instdata["pobox"]."-".$instdata["postal_code"].", ".$instdata["location"]."</div>";
$rec .=  "<div id='tel'>Tel : +254 ".$instdata["pnumber"]."</div>";
$rec .=  "<div id='email'>e-mail : ".$instdata["email"]."</div>";
$rec .=  "</div>";
$rec .=  "</div>";
$rec .=  "</div>";

echo($rec);