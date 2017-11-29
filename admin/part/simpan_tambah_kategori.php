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
		
	$nama_kategori		= trim($_POST['nama_kategori']);
	$url_img_kategori	= trim($_POST['url_img_kategori']);
	$desc_kategori		= trim($_POST['desc_kategori']);
	
		
		
		if(isset($_POST['id_kategori']))
		{
			$id_kategori = $_POST['id_kategori'];
			
			if($db->query("UPDATE tbl_kategori SET
							nama_kategori		='$nama_kategori',							
							desc_kategori		='$desc_kategori',							
							url_img_kategori	='$url_img_kategori'							
						WHERE id_kategori	='$id_kategori'
						
						")){
							
							echo(4);
						}
			
		}else if(isset($_POST['simpan_kategori'])){
			
		
			$q = $db->query("SELECT * FROM tbl_kategori WHERE nama_kategori='$nama_kategori'");
			if(mysqli_num_rows($q)>0){
			
			echo(1);
			die();
			}		
			
			
			if($db->query("INSERT INTO tbl_kategori SET							
							nama_kategori		='$nama_kategori',							
							desc_kategori		='$desc_kategori',							
							url_img_kategori	='$url_img_kategori'							
						")){
							
							echo(4);
						}
				
	
	}	
}

?>	