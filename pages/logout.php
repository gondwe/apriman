

<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<?php require ("../top/functions.php");

backup_tables(dbserver, dbuser, dbpass, database);

 ?>
<?php unset($_SESSION[$ndk]);session_destroy();?>
<script>window.location.href='start.php';</script>



