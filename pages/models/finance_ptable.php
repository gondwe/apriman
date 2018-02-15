<?php 


	table_open("p");
	echo "<thead>";
		echo "<th>Sn</th>";
		echo "<th>Votehead</th>";
		foreach($pt as $t=>$tt){ echo "<th>".rx($tt)."</th>"; }
	echo "</thead>";
	echo "<tbody>";
	foreach($v as $r=>$rr){
		echo "<tr>";
		echo "<td>$r</td>";
		echo "<td>".rx(repdot($rr),1)."</td>";
		foreach($pt as $t=>$tt){
			echo "<td id='ta' >";
			echo  isset($x[$t][$rr])? $x[$t][$rr] : null;
			echo "</td>";
		}
	}
		
		echo "</tr>";
		echo "<tr  class='t' id='tb'>";
			echo "<td></td>";
			echo "<td id='te' >TOTAL</td>";
			foreach($pt as $t=>$tt){ echo "<td id='ta'>".@addcommas($paid[$t])."</td>";}
		echo "</tr>";
		echo "<tr id='tc' class='t'>";
			echo "<td></td>";
			echo "<td id='te' >BALANCE</td>";
			foreach($pt as $t=>$tt){ echo "<td id='ta'>".@addcommas($bal[$t] - $paid[$t])."</td>";}
		echo "</tr>";
		
	echo "</tbody>";
	echo "</table>";