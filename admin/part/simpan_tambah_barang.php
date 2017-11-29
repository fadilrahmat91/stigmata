<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');

if(isset($_POST))
{
		
		$id_kategori		= trim($_POST['id_kategori']);
	
		
		
		if(isset($_POST['edit_barang']))
		{
			$id_kategori = $_POST['id_kategori'];
			
			if($db->query("UPDATE tbl_kategori SET
							nama_barang		='$nama_barang'							
						WHERE id_kategori	='$id_kategori'
						
						")){
							
							echo(4);
						}
			
		}else if(isset($_POST['simpan_barang'])){
			
		
			echo $_POST['id_kategori'];
			
			//echo(1);
			die();
		}		
			
			
			
		
}

?>	