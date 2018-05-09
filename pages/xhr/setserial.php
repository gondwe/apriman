<?php 

require ("../../top/functions.php"); 
// spill($_POST);
$serial = clean($_POST["newserial"]);

if(process("alter table finance_payments auto_increment = ".$serial))
{
	success("success");
}

?>

