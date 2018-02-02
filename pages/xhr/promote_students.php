<?php 

require ("../../top/functions.php"); 

$act = $_POST["action"];

switch($act){
	case 1 : promote(); break;
	case 2 : demote(); break;
}



function promote($adm=null){
	global $sid;
	if(process("update students set class = class + 1 where sid = '$sid'")){ success("Promotion Successful"); }
}
function demote($adm=null){
	global $sid;
	if(process("update students set class = class - 1 where sid = '$sid'")){ success("Demotion Successful"); }
}