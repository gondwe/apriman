<?php 

require ("../../top/functions.php"); 

$yr = date("Y");
$sql= "insert into vote_student_leaders (student, post, year, sid) values ";
foreach($_POST["posts"] as $k=>$p){ $sqr[] = "('$p','".$_POST["students"][$k]."','$yr','$sid')";}



$sql .= implode(",",$sqr);
process("delete from vote_student_leaders where year = '$yr' and sid = '$sid'");
process($sql);


success("Save Successful. Previous leaders Records are in the student leaders page.");



