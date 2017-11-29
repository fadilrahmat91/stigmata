<?php
include_once(dirname(__FILE__) . '/../config/config.php');
if(isset($_GET['id_confirmasi']))
{	
	$id_confirmasi = $_GET['id_confirmasi'];
	$db->query("UPDATE tbl_confirmasi SET sms_sent='1' WHERE id_confirmasi='$id_confirmasi'");
}

?>