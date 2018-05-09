<?php 

require ("../../top/functions.php"); 
$reg = clean($_POST["dat"]);
$sql = "select students.names as names, classes.abbr as class, streams.abbr as stream from students 
			left join classes on classes.id = students.class
			left join streams on streams.id = students.stream
			where adm_no ='".$reg."' and sid = '$sid'";
$adm = getlist($sql);
if(!empty($adm)){
	success("RegNo ".$reg." - ".$adm['names']." ( ".rx($adm['class']." ".$adm['stream'])." )");
}else{
	error("Reg No. Not Found");
	// spill($sql);
}

?>

