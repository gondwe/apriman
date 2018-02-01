<?php 

inmenu(["new/vote_results"]);

$dead = getlist("select adm_no, names from students where adm_no not in (select v_id from vote_elections)");
			

echo "<h3>Total Boycotts : ".count($dead)."</h3>";
echo "<ol>";
foreach($dead as $d=>$ed){
	echo "<li>Adm : $d ".strtoupper($ed)."</li>";
}
echo "</ol>";