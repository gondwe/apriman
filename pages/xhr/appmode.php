<?php 

require ("../../top/functions.php"); 
$reg = $_POST["dat"];
$where  = " where vprop = 'appmode' and xdat = '$sid'";
$m = $appmode == 'p' ? 'd' : 'p';
process ("update vdata set vdat = '$m' $where");
success("Appmode Change > ".rx($m=='p'? "production" : "development"));

?>

