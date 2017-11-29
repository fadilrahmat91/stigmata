<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');

if(isset($_POST['simpan_sub_kategori']))
{
		
	$id_kategori		= trim($_POST['id_kategori']);
	$nama_sub_kategori	= trim($_POST['nama_sub_kategori']);
	$desc_sub_kategori	= trim($_POST['desc_sub_kategori']);
			
			
			
			if($db->query("INSERT INTO tbl_sub_kategori SET							
							id_kategori			='$id_kategori',							
							nama_sub_kategori	='$nama_sub_kategori',							
							desc_sub_kategori	='$desc_sub_kategori'							
						"))
						{
							
							echo(1);
						}
				
	
	
}

if(isset($_POST['simpan_edit_sub_kategori']))
{
		
	$id_kategori		= trim($_POST['id_kategori']);
	$id_sub_kategori	= trim($_POST['id_sub_kategori']);
	$nama_sub_kategori	= trim($_POST['nama_sub_kategori']);
	$desc_sub_kategori	= trim($_POST['desc_sub_kategori']);
			
			
			
			if($db->query("UPDATE tbl_sub_kategori SET							
							id_kategori			='$id_kategori',							
							nama_sub_kategori	='$nama_sub_kategori',							
							desc_sub_kategori	='$desc_sub_kategori'		
							WHERE id_sub_kategori='$id_sub_kategori'
						"))
						{
							
							echo(1);
						}
				
	
	
}

?>	