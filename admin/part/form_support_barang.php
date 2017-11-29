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

//var_dump($_POST);

//die();
		
	//$id_kategori 		= trim($_POST['id_kategori']);
	$nama_barang 		= buang_single_quote(trim($_POST['nama_barang']));
	
	$deskripsi_barang 	= $_POST['deskripsi_barang'];
	$ukuran_besih 		= "";
	$ukuran_kotor 		= buang_single_quote($_POST['ukuran_kotor']);	
	$berat_bersih 		= "";
	$berat_kotor 		= ($_POST['berat_kotor']);
	
	$stok_barang		= $_POST['stok_barang'];	
	$harga_member		= hanya_nomor($_POST['harga_member']);
	$harga_barang		= hanya_nomor($_POST['harga_barang']);
	$harga_coret		= hanya_nomor($_POST['harga_coret']);
	$sku_barang			= buang_single_quote($_POST['sku_barang']);
	$tgl_update_barang	= date("Y-m-d");
	$tgl_details_update	= date("Y-m-d H:i:s");	
	$url_images	 		= $_POST['url_images'];
	$id_kategori	 	= $_POST['id_kategori'];
	$id_sub_kategori	= $_POST['id_sub_kategori'];
	$id_brand	 		= buang_single_quote(trim($_POST['id_brand']));	
	
	function checkbox_value($name) {
		return (isset($_POST[$name]) ? 1 : 0);
	}
	
	$featured			= checkbox_value('featured');
	$new_arrival		= checkbox_value('new_arrival');
	$hot_deal			= checkbox_value('hot_deal');

	
	
	//$nama_brand	 		= buang_single_quote(trim($_POST['nama_brand']));	
	//$in_paket	 		= $_POST['in_paket'];
	//$garansi_barang		= buang_single_quote($_POST['garansi_barang']);
	
			/*
			#kategori
			$post_id = trim($_POST['id_kategori']);
			$id_kat = explode(', ',$post_id);
			$id_kategori 	= array();
			$get_id			= array();
			foreach($id_kat as $data_kat)
			{
				 if (is_numeric($data_kat)) 
				 {
					 
					$id_kategori[]=$data_kat;
					
				 }
				 
				 if(!is_numeric($data_kat))
				 {					 				
					
					
					$q = $db->query("SELECT id_kategori FROM tbl_kategori WHERE nama_kategori='$data_kat'");
					if(mysqli_num_rows($q)>0)
					{
												
						$qq = $q->fetch_object();						
						
						
					}else{
						
						if($db->query("INSERT INTO tbl_kategori SET nama_kategori='$data_kat'"))
						{
								
							$q = $db->query("SELECT id_kategori FROM tbl_kategori WHERE nama_kategori='$data_kat'");
							$qq = $q->fetch_object();								
								
						}
											
					}
					 					 
					array_push($id_kategori,$qq->id_kategori);				 	 
				 }				 				
				
			}
			
			
			$id_kat_save = (array_unique($id_kategori));						
			
			$new_id_kat = implode(",",$id_kat_save);
			
			*/
			/*
			#kategori
			$post_nama_kategori = trim($_POST['nama_kategori']);
			$arr_kategori = explode(',',$post_nama_kategori);
			$id_kategori 	= array();
			
			foreach($arr_kategori as $nama_kategori)
			{
							 
					$nama_kategori = trim($nama_kategori);
					$q = $db->query("SELECT id_kategori FROM tbl_kategori WHERE nama_kategori='$nama_kategori'");
					if(mysqli_num_rows($q)>0)
					{
												
						$qq = $q->fetch_object();						
						$id_kategori[]=$qq->id_kategori;	
						
					}else if(mysqli_num_rows($q)<=0){
						
						if($db->query("INSERT INTO tbl_kategori SET nama_kategori='$nama_kategori'"))
						{
								
							$q = $db->query("SELECT id_kategori FROM tbl_kategori WHERE nama_kategori='$nama_kategori'");
							$qq = $q->fetch_object();								
							$id_kategori[]=$qq->id_kategori;	 	 	
						}
						
					
											
					}
					
					
			}
			
			$id_kat_save = (array_unique($id_kategori));						
			
			$new_id_kat = implode(",",$id_kat_save);
			
			
			
			#brand			
			$qb = $db->query("SELECT id_brand FROM tbl_brand WHERE nama_brand='$nama_brand'");
			if(mysqli_num_rows($qb)>0)
			{
										
				$data = $qb->fetch_object();						
				$id_brand	= $data->id_brand;
				
			}else{
				
				if($db->query("INSERT INTO tbl_brand SET nama_brand='$nama_brand'"))
				{
						
					$qb = $db->query("SELECT id_brand FROM tbl_brand WHERE nama_brand='$nama_brand'");
					$data = $qb->fetch_object();						
					$id_brand	= $data->id_brand;								
						
				}
				
			}
			
			*/
			
		if(isset($_POST['simpan_barang']))
		{
			if($db->query("INSERT INTO tbl_barang SET										
										id_kategori		='$id_kategori',
										id_sub_kategori	='$id_sub_kategori',
										id_brand		='$id_brand',
										nama_barang		='$nama_barang',
										stok_barang		='$stok_barang',
										harga_member	='$harga_member',
										harga_barang	='$harga_barang',
										harga_coret		='$harga_coret',
										sku_barang		='$sku_barang',
										deskripsi_barang='$deskripsi_barang',										
										berat_bersih	='$berat_bersih',
										berat_kotor		='$berat_kotor',
										ukuran_besih	='$ukuran_besih',
										ukuran_kotor	='$ukuran_kotor',										
										featured		='$featured',										
										new_arrival		='$new_arrival',										
										hot_deal		='$hot_deal',										
										tgl_update_barang	='$tgl_update_barang',										
										tgl_details_update	='$tgl_details_update'
										
					")=== TRUE){ 
							
							$last_id = $db->insert_id;
							foreach($url_images as $url)
							{
								if($url !=="")
								{
									$db->query("INSERT INTO tbl_images_barang SET url_images='$url', id_barang='$last_id'");
								}
									
							}
							
							//echo($last_id); 
							echo(1); 
							
						}else{
							echo(0);							
						}
		
		}else if(isset($_POST['id_barang'])){
			$id_barang = $_POST['id_barang'];
			
			if($db->query("UPDATE tbl_barang SET
										id_kategori		='$id_kategori',
										id_sub_kategori	='$id_sub_kategori',
										id_brand		='$id_brand',
										nama_barang		='$nama_barang',
										stok_barang		='$stok_barang',
										harga_member	='$harga_member',
										harga_barang	='$harga_barang',
										harga_coret		='$harga_coret',
										sku_barang		='$sku_barang',
										deskripsi_barang='$deskripsi_barang',										
										berat_bersih	='$berat_bersih',
										berat_kotor		='$berat_kotor',
										ukuran_besih	='$ukuran_besih',
										ukuran_kotor	='$ukuran_kotor',										
										featured		='$featured',										
										new_arrival		='$new_arrival',										
										hot_deal		='$hot_deal',										
										tgl_update_barang	='$tgl_update_barang',										
										tgl_details_update	='$tgl_details_update'
							WHERE id_barang ='$id_barang'			
					")==-TRUE){ 
					
							if($db->query("DELETE FROM tbl_images_barang WHERE id_barang='$id_barang'"))
							{
							
								foreach($url_images as $url)
								{
									if($url !=="")
									{
										$db->query("INSERT INTO tbl_images_barang SET url_images='$url', id_barang='$id_barang'");
									}
										
								}
							
							}
							echo(1); 
							
							
						}else{
							echo(0);							
						}
			
		}
			
			die();
	
			
		
}

?>	