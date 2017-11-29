<?php
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
if(isset($_GET['jsoncallback']))
{
header('Content-type: application/json');


$rowSet = $db->query("SELECT a.id_confirmasi, b.nama_pelanggan, b.id_pelanggan, c.* 
								FROM tbl_bukti_transfer a 
								INNER JOIN tbl_confirmasi c ON a.id_confirmasi = c.id_confirmasi 
								INNER JOIN tbl_pelanggan b ON c.id_pelanggan = b.id_pelanggan
								WHERE a.admin_cek='0'
								GROUP BY a.id_confirmasi 
								ORDER BY c.status_confirmasi ASC, c.id_uniq DESC LIMIT 5");  
$num = mysqli_num_rows($rowSet);	
$data_confirmasi = array();		
				
$data_confirmasi_all="";						
while($data = $rowSet->fetch_object()){
	$id_confirmasi 	= $data->id_confirmasi;
		$q_bank_conf = $db->query("SELECT a.*,b.nama_bank, b.nomor_rek,b.nama_rek 
										FROM tbl_bukti_transfer a
										LEFT JOIN tbl_bank b
										ON a.id_bank = b.id_bank
										WHERE a.id_confirmasi ='$id_confirmasi'");
		$hit_bank = mysqli_num_rows($q_bank_conf);
		$row = $q_bank_conf->fetch_object();
		
	
	$data_confirmasi = array(
		"id_confirmasi" => $row->id_confirmasi,
		"Time" 			=> $row->waktu,
		"DanaConf"	 	=> rupiah($row->jumlah_transfer),
		"Img"		 	=> $alamat.'user_image/bukti_transfer/'.$row->url_image
				
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
	
$q = $db->query("SELECT id_confirmasi
								FROM tbl_bukti_transfer 
								WHERE admin_cek='0'
								GROUP BY id_confirmasi
				 ");
	$num = mysqli_num_rows($q);
	
	echo $num;
}
?>



