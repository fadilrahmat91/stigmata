<?php
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
if(isset($_GET['jsoncallback']))
{
header('Content-type: application/json');

	$q = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi
							FROM tbl_pelanggan a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							WHERE a.admin_cek='0' ORDER BY a.id_pelanggan DESC LIMIT 5");
							
$num = mysqli_num_rows($q);							
$data_confirmasi = array();						
$data_confirmasi_all="";						
while($data = $q->fetch_object()){
	$id_pelanggan 	= $data->id_pelanggan;
		
	
	$data_confirmasi = array(
		"id_pelanggan" 		=> $data->id_pelanggan,
		"nama_pelanggan"	=> $data->nama_pelanggan,		
		"nama_provinsi"		=> $data->nama_provinsi,
		"tgl_daftar"		=> $data->tgl_daftar
		
				
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
$num = $db->query("SELECT COUNT(id_pelanggan) AS jum
					FROM tbl_pelanggan					
					WHERE admin_cek='0'
				")->fetch_object();
	echo $num->jum;
}
?>



