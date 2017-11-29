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
		
	$nama_brand		= trim($_POST['nama_brand']);
	$desc_brand		= trim($_POST['desc_brand']);
	$url_image_brand		= trim($_POST['url_image_brand']);
	
		
		
		if(isset($_POST['id_brand']))
		{
			$id_brand = $_POST['id_brand'];
			
			if($db->query("UPDATE tbl_brand SET
							nama_brand		='$nama_brand',
							desc_brand		='$desc_brand',
							url_image_brand		='$url_image_brand'						
						WHERE id_brand	='$id_brand'
						
						")){
							
							echo(1);
						}
			
		}else if(isset($_POST['simpan_brand'])){
					
			
			if($db->query("INSERT INTO tbl_brand SET
							nama_brand		='$nama_brand',
							desc_brand		='$desc_brand',
							url_image_brand		='$url_image_brand'
						")){
							
							echo(1);
						}
				
	
		}	
}

?>	