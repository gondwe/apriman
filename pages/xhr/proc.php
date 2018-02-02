<?php 
include("../../top/functions.php");


if(isset($_REQUEST["tcodes"])){
switch($_REQUEST["tcodes"]){
	case 1 : usr_alloc();
	break;
}
}


function usr_alloc(){



	$qut = "select id from user_types where names = 'admin'";
	
	$ut = fetch($qut);
	if($ut == null ){ process("insert into user_types (names) values ('admin')");}
	
	if(fetch("select count(id) from users where username = 'admin'") <> 1){
		process("delete from users where username = 'admin'");
		process("insert into users (username, password, names, usertype) values('admin','".md5('1234')."','ACE','$ut')");
	}
	
	$ut = fetch($qut);
	$uts = "select id from users where usertype = '$ut'";


	$au = getlist($uts);
	
	
	$default = ["id","names"];
	$f = array_column(getlist("describe menunames"),"Field");
	$f = array_diff($f,$default);
	$t = count($f);
	$default = getlist("select id from users");
	foreach($default as $s){$spin[] = "user_".$s;} 
	$f = array_diff($spin,$f);
	$d = count($f);
	
	
	
	foreach($f as $g){process("alter table menunames add `$g` int(1) not null default 0");}
	
	
	
	
	
	
	
	foreach($au as $a){
		$admin = 'user_'.$a;
		process("update menunames set `$admin`=1");		
	}
	
	echo "Usr Allocation Success( Resolved $d | Found $t )";
}
?>
