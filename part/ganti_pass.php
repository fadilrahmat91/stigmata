<?php 
session_start();
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');
if(!isset($_SESSION['id_pelanggan']))
{
	header('Location: '.$alamat);
	die();
}

if($_POST):
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$id_pelanggan = $_SESSION['id_pelanggan'];
	
	if($pass1 !== $pass2)
	{
		die("0");
	}
	
	
	if(strlen($pass1)<6 )
	{
		die("1");
	}
	
	if($db->query("UPDATE tbl_pelanggan SET pass_pelanggan='$pass1' WHERE id_pelanggan='$id_pelanggan'")===TRUE)
	{		
		die("2");
	}
	
	
endif;	
?>
			
		
			