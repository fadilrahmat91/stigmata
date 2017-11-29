<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

if(isset($_POST))
{
	
	if(isset($_POST['simpan_pelanggan']))
	{
		$nama_pelanggan 	= $_POST['nama_pelanggan'];
		$alamat_pelanggan 	= $_POST['alamat_pelanggan'];
		$email_pelanggan	= $_POST['email_pelanggan'];
		$telp_pelanggan		= $_POST['telp_pelanggan'];
		$user_pelanggan		= $_POST['user_pelanggan'];
		$pass_pelanggan		= $_POST['pass_pelanggan'];
		$id_provinsi		= $_POST['id_provinsi'];
		$id_kota			= $_POST['id_kota'];
		$tgl_daftar			= date('Y-m-d H:i:s');
		
		$cek_user  = $db->query("SELECT user_pelanggan FROM tbl_pelanggan WHERE user_pelanggan='$user_pelanggan'");
		$cek_email = $db->query("SELECT email_pelanggan FROM tbl_pelanggan WHERE email_pelanggan='$email_pelanggan'");
		
		if(mysqli_num_rows($cek_user)>0)
		{
			die("Maaf Username : $user_pelanggan Sudah terdaftar..!!");
		}
		else if(mysqli_num_rows($cek_email)>0)
		{
			die("Maaf Email : $email_pelanggan Sudah terdaftar..!!");
		}
		
		
		
		if($db->query("INSERT INTO tbl_pelanggan SET 
										nama_pelanggan		='$nama_pelanggan',
										alamat_pelanggan	='$alamat_pelanggan',
										email_pelanggan		='$email_pelanggan',
										telp_pelanggan		='$telp_pelanggan',
										user_pelanggan		='$user_pelanggan',
										pass_pelanggan		='$pass_pelanggan',
										id_provinsi			='$id_provinsi',
										id_kota				='$id_kota',
										tgl_daftar			='$tgl_daftar',
										status_pelanggan	='1',
										vip_member			='1'
		
		"))
		{
			echo(1);
		}
		
		
		
	}
			
}




//aktifasi

	if(isset($_GET['aktifkan']))
	{
		$id_pelanggan = $_GET['id_pelanggan'];
		
		if($db->query("UPDATE tbl_pelanggan SET status_pelanggan='1' WHERE id_pelanggan='$id_pelanggan'"))
		{
			echo(1);
		}
		
	}
	
	if(isset($_GET['nonaktifkan']))
	{
		$id_pelanggan = $_GET['id_pelanggan'];
		
		if($db->query("UPDATE tbl_pelanggan SET status_pelanggan='0' WHERE id_pelanggan='$id_pelanggan'"))
		{
			echo(1);
		}
		
	}
	
	if(isset($_GET['set_reseller']))
	{
		$id_pelanggan 	= $_GET['id_pelanggan'];
		$code_uniq 		= $_GET['code_uniq'];
		//echo $code_uniq;
		//die();
		if($db->query("UPDATE tbl_pelanggan SET vip_member='2' WHERE id_pelanggan='$id_pelanggan'"))
		{
			$db->query("INSERT INTO tbl_vip_member SET code_uniq='$code_uniq', id_reseller='$id_pelanggan', id_pelanggan='$id_pelanggan'");
			
				echo(1);
			
		}
		
	}
	
	if(isset($_GET['out_reseller']))
	{
		$id_pelanggan = $_GET['id_pelanggan'];
		
		if($db->query("UPDATE tbl_pelanggan SET vip_member='1' WHERE id_pelanggan='$id_pelanggan'"))
		{
			$db->query("DELETE FROM tbl_vip_member WHERE id_pelanggan='$id_pelanggan'");
			echo(1);
		}
		
	}
	


?>	