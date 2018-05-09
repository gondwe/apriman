<?php

require ("../../top/functions.php"); 

$dp = $_POST["dev"]==0? 'p' : 'd';

process("update vdata set vdat = '$dp' where vprop = 'appmode' and xdat = '$sid'");
