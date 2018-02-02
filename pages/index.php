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
// $rec .=  "<div id='' style='dispaly:block; margin:15px auto;'>";
// $rec .=  "<div id='rchead' class='col-sm-12' >";
$rec .=  "<div id='rclogo' class='col-sm-4'><img src='".getimage("settings/".($instdata["logo"]))."' ></div>";
// $rec .=  "<div class='rcnames col-sm-8' >";
// $rec .=  "<div id='name'><h3>".rx($instdata["name"])."</h3></div>";
// $rec .=  "<div id='box'>P.O. Box ".$instdata["pobox"]."-".$instdata["postal_code"].", ".$instdata["location"]."</div>";
// $rec .=  "<div id='tel'>Tel : +254 ".$instdata["pnumber"]."</div>";
// $rec .=  "<div id='email'>e-mail : ".$instdata["email"]."</div>";
// $rec .=  "</div>";
// $rec .=  "</div>";
// $rec .=  "</div>";

echo($rec);