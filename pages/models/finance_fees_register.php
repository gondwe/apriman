
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> <?=rx(mx($t))?> <small>add New</small></h1>
</div>
</div>
</div>

<?php 

	include ("../nav.php");
	$terms = terms();
	
	$cl = isset($_SESSION[$ndk]["finance"]["fregister"]) ? $_SESSION[$ndk]["finance"]["fregister"]["class"] : null;
	$tm = isset($_SESSION[$ndk]["finance"]["fregister"]) ? $_SESSION[$ndk]["finance"]["fregister"]["term"] : null;
	$vh = isset($_SESSION[$ndk]["finance"]["fregister"]) ? $_SESSION[$ndk]["finance"]["fregister"]["votehead"] : null;
	
form_open("finance_feeregister");
echo "<div class='col-sm-3'>";form_cbo_("class",getlist("select id, abbr from classes where scode = '$sid'"), $cl);echo "</div>";
echo "<div class='col-sm-3'>";form_cbo_("term",$terms, $tm);echo "</div>";
echo "<div class='col-sm-3'>";form_cbo_("votehead", getvoteheads() ,$vh);echo "</div>";
echo "<div class='col-sm-3'>";form_button("LOAD");echo "</div>";
form_close(0);

if(isset($_SESSION[$ndk]["finance"]["fregister"])){
	$vh = fetch("select names from finance_votehead_names where id = '".$vh."'");
	$vh = fetch("select repdot2('$vh') as vh");
	
	$data = get("select st.adm_no, st.names, sum(fp.`$vh`) as votehead, fp.term from students as st left join finance_payments as fp on fp.adm_no = st.adm_no and fp.scode = st.sid and fp.arrid is null where st.class = '$cl' and st.sid = '$sid' group by st.adm_no, fp.term ");
				
	foreach($data as $d=>&$ata){
		$_data["votehead"] = is_null($ata["votehead"])? 0 : $ata["votehead"] ;
		if(!is_null($ata["term"])) { 
		$_data["term"] =  $ata["term"] ; 
		$data_[current($ata)][$ata["term"]] = $_data; }else{ $data_[current($ata)][] = $_data;}
		$data_[current($ata)]["names"] = $ata["names"];
		
	}
	
	
	$x = 1;
	echo "<div class='col-sm-11' style='margin-bottom:5%'>";
	table_open("p");
	echo "<thead>";
		echo "<th>Sn</th>";
		echo "<th>RegNo</th>";
		echo "<th>Names</th>";
		
		foreach($terms as $t=>$tt){ echo "<th>".rx($tt)."</th>"; }
		
	echo "</thead>";
	echo "<tbody>";
	foreach($data_ as $d=>$ata){
		echo "<tr>";
		echo "<td>$x</td>";
		echo "<td>$d</td>";
		echo "<td>".$ata["names"]."</td>";
		foreach($terms as $t=>$tt){ $val = isset($ata[$t])? $ata[$t]["votehead"] : 0; $trx[$t][] = $val; echo "<td>".addcommas($val)."</td>"; }
		echo "</tr>";
		$x++;
	}
		echo "<tr style='background:#aaa;font-weight:bold'>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>TOTAL</td>";
		foreach($terms as $t=>$tt){ $_tot[] = $tot = array_sum($trx[$t]); echo "<td>".addcommas($tot)."</td>"; }
		echo "</tr>";
		$x++;
		echo "<tr style='background:grey;font-weight:bold;border-bottom:2px solid grey;border-top:2px solid grey'>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>AGGR.SUM</td>";
		for($j=0; $j<count($terms)-1; $j++){ echo "<td></td>"; }
		echo "<td>".addcommas(array_sum($_tot))."</td>";
		echo "</tr>";
	echo "</tbody>";
	table_close();
	echo "</div>";

	
	
	
	
	
	}