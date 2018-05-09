<?php 

require ("../../top/functions.php"); 
$i = $_POST["dat"];
$i = explode("/",$i);

process("update finance_payments set rcpmode = '".$i[0]."' where id = '".$i[1]."'");
success("RCP Mode Changed");