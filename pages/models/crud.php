
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<link rel="stylesheet" href="assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css">
<?php



$aut = getlist("select id, lcase(names) from user_types where scode = '$sid'");

/* fix utypes onto crud */

$cu = array_diff($mods, getlist("select names from `crud`"));
foreach($cu  as $c) { process("insert into crud (names) values('$c')"); }

fix_uac();
$_mods = getlist("select id, names from crud");
$mods_ = getlist("select * from crud",0,1);

	
	$x = 1;
	table_open("p");
	echo "<thead>";
		echo "<th>Sno</th>";
		echo "<th>Module</th>";
		foreach($aut as $a=>$ut){ echo "<th>".rx(repdot($ut),1)."</th>"; }
		
	echo "</thead>";
	echo "<tbody>";
	foreach($_mods as $mo=>$ds){
		echo "<tr>";
		echo "<td>$x</td>";
		echo "<td>".rx($ds)."</td>";
		foreach($aut as $a=>$ut){ echo "<td>".bswitch($mods_[$mo][$ut],$mo,$ut)."</td>"; }
		echo "</tr>";
		$x++;
	}
	echo "<tbody>";
	table_close();
		
	
?>



<script src="assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
		
		