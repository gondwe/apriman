
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<div class="page-header">
<?php $_SESSION[$ndk]["route"] = $route = $_GET['t']; $t = $_GET["t"] = 'vote_results'; ?>
<h1> <?=rx(mx($t))?> <small>statistics</small></h1>
</div>
</div>
</div>



<form name='clear' method='post' action=''>
	<input class='btn btn-red' type='submit' name='clear' value='Reset Results'>
	<a class='btn btn-blue' href='#new/voter_summary'  >Voter Summary</a>
	<a class='btn btn-blue' href='#new/result_summary'  >Results Summary</a>
</form>
<?php 

$d = get("select students.names, vote_posts.post_title as positions, count(vote_elections.v_id) as votes
			from vote_elections 
			left join students on students.adm_no = vote_elections.c_id
			left join vote_posts on vote_posts.id = vote_elections.p_id
			where students.sid = '$sid'
			group by vote_elections.c_id
			");


$allposts = array_column(get("select post_title from vote_posts where scode = '$sid'"),"post_title");
$e = array_diff($allposts, array_column($d, 'positions'));
$pop = fetch("select count(id) from students where sid = '$sid'");

$c = [];

foreach($allposts as $posts){
	foreach($d as $a){
		if($a["positions"] == $posts){
			$votes = $a["votes"]>1? ' votes.' : ' vote';
			$c[$posts][] = $a["names"].' = '.$a["votes"].$votes;
			$ck[$posts][] = $a['votes']; 
		}
	}
}



foreach ($c as $p=>$d){
	echo "<h2>Post : $p</h2>";
	echo "<ol>";
	$j = 0;
	$j = array_sum($ck[$p]);
	$k = $pop - $j;
	foreach($d as $v){echo "<li>$v</li>";}
	// spill($d);
	
	echo "<div class='btn btn-green btn-xs' style='margin-right:3px'><b>Voted : </b>$j</div>";		
	echo "<div class='btn btn-danger btn-xs'><b>Not Voted : </b>".$k."</div>";		
	echo "</ol>";
}

foreach($e as $p){
	echo "<h1>Post : $p</h1>";
	echo "<ol><li style='color:red'>No Contestants</li></ol>";
	
}
