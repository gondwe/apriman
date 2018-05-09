<style>
	img {width:50px; margin-right:10px}
</style>
<?php 

require ("../../top/functions.php"); 



	
	if(isset($_SESSION[$ndk]["me"])){
	
	$post = $_POST["dat"];
	$_SESSION[$ndk]["dat"] = $post;
	$posts = getlist("select id, post_title from vote_posts where sid ='$sid'");
	echo "<h1>".$posts[$post]."</h1>";
	echo "<div id='list' class='two'>";
	$voted = get("select * from vote_elections 
					where p_id = '$post' and v_id = '".$_SESSION[$ndk]["me"]."'
					and  p_id in (select id from vote_posts where sid = '$sid')
					");
	if(empty($voted)){
	
	$c = get("select students.adm_no, students.names, vote_candidates.photo
				from vote_candidates 
				inner join students on students.adm_no = vote_candidates.candidate_id and vote_candidates.post_id = '$post'
				and  vote_candidates.post_id in (select id from vote_posts where sid = '$sid')
				"
			);
			

			
	if(count($c) >0 ){
		echo "<form name='selcan' method='post' id='savecan'>";
		foreach($c as $i=>$j){
			$img = getimage("vote_candidates/".$j["photo"]);
			echo "<img src='$img' id='img'>
			<input type='radio' name='mychoice' value='".$j['adm_no']."' >    ".$j["names"]."</input><br><hr>";
		}
		?>
		
		<a class='btn btn-success' href='javascript:void(0)'  onclick='vsavecan("savecan");' >SAVE</a>
		</form>
		
		<?php
		}else{
			echo "No Registered Candidates";
	}
	
}else{
	echo("<h4>you have voted a candidate for this position</h4>");
	echo("<h4>Thank You</h4>");
}

	}
	
	
	
	?>
