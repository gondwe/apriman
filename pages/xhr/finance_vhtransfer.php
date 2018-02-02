<?php 

require ("../../top/functions.php"); 

$yr = $_POST["dat"];

$vh = "insert into finance_voteheads (votehead, amount, position, term, account, class, feeclass, scode, vhyear) 
		select votehead, amount, position, term, account, class, feeclass, scode, year(current_timestamp) as vhyear
		from finance_voteheads where vhyear = '$yr'";
if(process($vh)){
	success("Import Successful");
}
// spill($vh);
