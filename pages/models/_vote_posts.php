<style>
	#form-field-6 { margin:5px}
</style>
<?php 

$sql = "select vote_posts.id, vote_posts.post_title,  count(vote_candidates.id) as ctn
		from vote_posts left join vote_candidates on vote_candidates.post_id = vote_posts.id
		where vote_posts.scode = '$sid'
		group by vote_posts.id
		";
		
$vc = fetch("select count(id) from vote_candidates where vote_candidates.post_id in (select id from vote_posts where vote_posts.scode = '$sid')");
$vd = getlist("select vote_candidates.id, voters.adm_no, voters.names 
			from vote_candidates left join students as voters on voters.adm_no = vote_candidates.candidate_id 
			where vote_candidates.post_id not in (select id from vote_posts where vote_posts.scode = '$sid')");
$data = get($sql);

// spill($_SESSION);
echo "<h2>";echo "Vying Candidates : $vc";echo "</h2>";

if(!empty($data)){
	echo "<div class='col-sm-12' >";
	foreach($data as $j){
		echo "<div id='form-field-6' class='btn btn-green '>";
		echo $j["post_title"];
		echo "( ".$j['ctn']." )";
		echo "</div>";
	}
	echo "</div>";
}


?>

