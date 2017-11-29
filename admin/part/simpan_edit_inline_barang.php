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
		
		if(isset($_POST['edit_stok']))
		{
			$id_barang = $_POST['id_barang'];
			$stok_barang = $_POST['stok_barang'];
			
			if($db->query("UPDATE tbl_barang SET
							stok_barang	='$stok_barang'							
						WHERE id_barang	='$id_barang'
						
						")){
							
							echo(1);
						}
			
		}else if(isset($_POST['edit_harga']))
		{
			$id_barang = $_POST['id_barang'];
			$harga_barang = hanya_nomor($_POST['harga_barang']);
			
			if($db->query("UPDATE tbl_barang SET
							harga_barang	='$harga_barang'							
						WHERE id_barang	='$id_barang'
						
						")){
							
							echo($harga_barang);
						}
		}else if(isset($_POST['harga_member']))
		{
			$id_barang = $_POST['id_barang'];
			$harga_member = hanya_nomor($_POST['harga_member']);
			
			if($db->query("UPDATE tbl_barang SET
							harga_member	='$harga_member'							
						WHERE id_barang	='$id_barang'
						
						")){
							
							echo($harga_member);
						}
			
		}else if(isset($_POST['edit_harga_coret']))
		{
			$id_barang = $_POST['id_barang'];
			$harga_coret = hanya_nomor($_POST['harga_coret']);
			
			if($db->query("UPDATE tbl_barang SET
							harga_coret	='$harga_coret'							
						WHERE id_barang	='$id_barang'
						
						")){
							
							echo($harga_coret);
						}
			
		}
}

?>	