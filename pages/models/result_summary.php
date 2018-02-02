<div class="page-header">
<h1> <?=rx(mx('result_summary'))?> <small>stats</small></h1>


</div>
<!-- end: PAGE TITLE & BREADCRUMB -->
</div>
</div>
<?php 

inmenu(["new/vote_results","new/student_leaders"]);

?>



<h2 style='color:green'>Student Leaders <?=date("Y")?></h2>
<?php 
$yr = date("Y");
$d = get("select students.adm_no, students.names, vote_posts.post_title as positions, count(vote_elections.v_id) as votes
			from vote_elections 
			left join students on students.adm_no = vote_elections.c_id
			left join vote_posts on vote_posts.id = vote_elections.p_id
			where students.sid = '$sid' and year(vote_elections.date) = '$yr'
			group by vote_elections.c_id
			");


			
			
$allposts = getlist("select post_title from vote_posts where scode = '$sid'");



$c = [];
$j = [];

foreach($allposts as $posts){
	foreach($d as $a){
		if($a["positions"] == $posts){
			$c[$posts][$a["names"]] = $a["votes"];
		}
	}
}


foreach($c as $f=>$g){
	$h = max($g);
	$i = array_search($h,$g);
	$j[$f]= strtoupper($i);
}



echo "<form id='saveleaders'>";
echo "<ol>";
foreach ($j as $p=>$d){
	echo "<li>$p : $d</li>";
	echo "<input type='hidden' name='posts[]' value='$p'>";
	echo "<input type='hidden' name='students[]' value='$d'>";
}
	?><a href='javascript:void(0)' class='btn btn-success' onclick='vsavel("saveleaders")'>SAVE DATA</a><?php
echo "</ol>";
echo "</form>";




