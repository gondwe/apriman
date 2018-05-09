<?php 

require ("../../top/functions.php"); 
$id = $_POST["id"];

if($id){
	/* prepare registration */
	form_open("renew");form_input("names");form_input("key");form_close(1,"Register");
}else{
	/* prepare renewal */
	form_open("renew");form_input("key");form_close(1,"Renew");
}

?>

