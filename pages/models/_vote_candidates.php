<?php 

/* clean up */
process("delete from vote_candidates where vote_candidates.post_id not in (select id from vote_posts where vote_posts.scode = '$sid')");
process("delete from vote_candidates where vote_candidates.candidate_id not in (select adm_no from students where sid = '$sid')");