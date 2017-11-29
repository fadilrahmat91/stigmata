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
	
/*
KETERANGAN STATUS
1	= nama_toko atau user_toko sudah terdaftar
2	= pass_toko <=7
3	= pass_toko tidaksama dengan ulangi_pass

*/	
	$nama_toko		= trim($_POST['nama_toko']);
	$email_toko		= trim($_POST['email_toko']);
	$telp_toko		= trim($_POST['telp_toko']);
	$no_rek_toko	= trim($_POST['no_rek_toko']);
	$atas_nama_toko	= trim($_POST['atas_nama_toko']);
	$user_toko		= trim($_POST['user_toko']);
	$pass_toko		= trim($_POST['pass_toko']);
	$ulangi_pass	= trim($_POST['ulangi_pass']);
	$alamat_toko	= trim($_POST['alamat_toko']);
	$tgl_bergabung	= date("Y-m-d");

		
	if(strlen($pass_toko)<=7){
		
		echo(2);
		die();
		
		
	}else if($pass_toko !== $ulangi_pass){
		
		echo(3);
		die();
			
	}else{
		
		
		if(isset($_POST['id_toko']))
		{
			$id_toko = $_POST['id_toko'];
			
			if($db->query("UPDATE tbl_toko SET
							nama_toko		='$nama_toko',
							email_toko		='$email_toko',
							telp_toko		='$telp_toko',
							no_rek_toko		='$no_rek_toko',
							atas_nama_toko	='$atas_nama_toko',
							user_toko		='$user_toko',
							pass_toko		='$pass_toko',
							alamat_toko		='$alamat_toko',
							tgl_bergabung	='$tgl_bergabung'							
						WHERE id_toko	='$id_toko'
						
						")){
							
							echo(4);
						}
			
		}else if(isset($_POST['simpan_toko'])){
			
		
			$q = $db->query("SELECT * FROM tbl_toko WHERE nama_toko='$nama_toko' OR user_toko='$user_toko'");
			if(mysqli_num_rows($q)>0){
			
			echo(1);
			die();
			}		
			
			
			if($db->query("INSERT INTO tbl_toko SET
							nama_toko		='$nama_toko',
							email_toko		='$email_toko',
							telp_toko		='$telp_toko',
							no_rek_toko		='$no_rek_toko',
							atas_nama_toko	='$atas_nama_toko',
							user_toko		='$user_toko',
							pass_toko		='$pass_toko',
							alamat_toko		='$alamat_toko',
							tgl_bergabung	= '$tgl_bergabung',
							status_toko 	= 1				
						
						")){
							
							echo(4);
						}
				
		}
		
		
		

	}	
}

?>	