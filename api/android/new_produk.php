<?php
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
if(isset($_GET['jsoncallback']))
{
header('Content-type: application/json');
$q = $db->query("SELECT a.id_barang,
										a.nama_barang, 
										a.stok_barang,
										a.url_images,
										a.harga_barang,
										a.harga_coret,
										a.sku_barang,
										a.berat_bersih,
										a.berat_kotor,
										a.ukuran_besih,
										a.ukuran_kotor,
										a.tgl_details_update,														
										a.status_barang,														
										a.id_kategori,
										a.id_toko,
										a.admin_check,
										a.featured,
										c.nama_toko,
										d.nama_brand										
									FROM tbl_barang a
									INNER JOIN tbl_toko c
										ON a.id_toko = c.id_toko
									INNER JOIN tbl_brand d
										ON a.id_brand = d.id_brand
									
									ORDER BY rand() LIMIT 5");
$num = mysqli_num_rows($q);
$data_confirmasi = array();						
$data_confirmasi_all="";						
while($data = $q->fetch_object()){

	
	$data_confirmasi = array(
		"id_barang" 		=> $data->id_barang,
		"nama_barang" 		=> $data->nama_barang,
		"sku_barang" 		=> $data->sku_barang,
		"harga_barang"		=> rupiah($data->harga_barang),		
		"nama_brand"		=> ($data->nama_brand),		
		"url_images"		=> $data->url_images,
		"tgl_details_update"		=> $data->tgl_details_update
		
				
	);
	
	/*
	$data_confirmasi = array(
		"id_confirmasi" 	=> $data->id_confirmasi,		
		"total"		 		=> rupiah($total)
		
	
	);
	*/
	$data_confirmasi_all[] = $data_confirmasi;
}

	echo $_GET['jsoncallback'] ."(".json_encode($data_confirmasi_all).");";
}
if(isset($_GET['notif']))
{
	$num = $db->query("SELECT COUNT(id_barang)	AS jum									
									FROM tbl_barang
							WHERE admin_check ='0'
					")->fetch_object();
	echo $num->jum;
}
?>



