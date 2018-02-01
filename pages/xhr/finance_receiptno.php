<?php 

require ("../../top/functions.php"); 
$i = $_POST["dat"];
$i = explode("/",$i);
if(($i[1] !== '') && ($i[0] !== '')){ process("update finance_payments set rcno ='".$i[1]."' where id ='".$i[0]."'");success("Receipt No Saved "); }else{success("Receipt No NOT Saved ");	}