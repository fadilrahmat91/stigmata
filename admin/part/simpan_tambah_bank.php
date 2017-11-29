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
		
	$nama_bank		= trim($_POST['nama_bank']);
	$nomor_rek		= trim($_POST['nomor_rek']);
	$nama_rek		= trim($_POST['nama_rek']);
	
		
		
		if(isset($_POST['id_bank']))
		{
			$id_bank = $_POST['id_bank'];
			
			if($db->query("UPDATE tbl_bank SET
							nama_bank		='$nama_bank',							
							nomor_rek		='$nomor_rek',							
							nama_rek		='$nama_rek'							
						WHERE id_bank	='$id_bank'
						
						")){
							
							echo(4);
						}
			
		}else if(isset($_POST['simpan_bank'])){
			
		
			$q = $db->query("SELECT * FROM tbl_bank WHERE nama_bank='$nama_bank'");
			if(mysqli_num_rows($q)>0){
			
			echo(1);
			die();
			}		
			
			
			if($db->query("INSERT INTO tbl_bank SET
							nama_bank		='$nama_bank',							
							nomor_rek		='$nomor_rek',							
							nama_rek		='$nama_rek'
						")){
							
							echo(4);
						}
				
	
		}	
}

?>	