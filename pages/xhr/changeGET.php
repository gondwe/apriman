<?php 

require ("../../top/functions.php"); 



$r = $_POST["r"];
$_GET["t"] = $r;
$_SESSION[$ndk]["GET"]["t"] = $r;
$_SESSION[$ndk]['route'] = $r;
$_SESSION[$ndk]['alias'] = $r;

