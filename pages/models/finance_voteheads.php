
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<style>.alert {background:none; border-right:none; border-left:none}</style>
<div class="page-header">
<?php 
$t = $_GET["t"] = 'finance_voteheads';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
 ?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>


<?php




include("nav.php");
linkbutton( "views", $t, "View ".rx(mx($t)), $anchor);
include ("../top/tablo.php");

$d = new tablo($t);
include ("sets.php");




// $vdata = getfullvoteheads();
$fcv = getlist("select id, names from finance_feeclasses where scode = '$sid' order by id asc");
foreach($fcv as $fc=>$fcn):
	$vdata = feeclass_voteheads($fc);
	echo "<h3>$fcn</h3>";
	table_voteheads($vdata);
endforeach;




function table_voteheads($vdata){
	$vd = [];
	$vds = [];
	foreach($vdata as $v=>$d){
		$vd[$d["class"]][$d["term"]][$d["position"]] = rx($d["votehead"])." (".$d["amount"].")";
		$vds[$d["class"]][$d["term"]][$d["id"]] = $d["position"];
		ksort($vd[$d["class"]][$d["term"]]);
	}


	foreach(array_keys($vds) as $c){
		$vds_t = array_keys($vds[$c]);
		$ctr[$c] = [];
		foreach($vds_t as $t):
			foreach($vds[$c][$t] as $p):
				array_push($ctr[$c], $p);
			endforeach;
		endforeach;
		$dups[$c] = array();
		/* find duplicate positions */
		foreach(array_count_values($ctr[$c]) as $val => $j) if($j > 1) $dups[$c][] = $val;
	}
		




	// die();

	foreach($vd as $class=>$tx){
		echo "<div class='btn btn-teal' btn-large>".rx($class)."</div>";
		if(!empty($dups[$class])) error(" ( duplicates found ".implode(", ",$dups[$class])." )");
		echo "<div class='row ' style='margin-left:15px' >";

		foreach($tx as $t=>$x){
			echo "<div class='col-sm-4 style='margin-right:15px' >";
				echo "<h5 style='font-size:large;font-weight:bold;color:brown'>".rx($t)."</h5>";
				echo "<div class='alert alert-block '>";
				foreach($x as $a=>$b):
					echo("<p>".$a.". ".$b."</p>");
				endforeach;
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
		echo "</div>";
		echo "</div>";
	}
}
