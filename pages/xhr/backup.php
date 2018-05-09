<?php 

require ("../../top/functions.php"); 

backup_tables(dbserver, dbuser, dbpass, database, "../../pages/");


echo "Backup Successful";