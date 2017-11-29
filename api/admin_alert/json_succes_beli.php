<?php
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
if(isset($_GET['jsoncallback']))
{
header('Content-type: application/json');

$dataowSet = $db->query("SELECT a.id_confirmasi, a.tgl_confirmasi, a.jam_confirmasi, a.code_uniq, a.ongkir, b.telp_pelanggan, b.nama_pelanggan, b.id_pelanggan,
							c.nama_bank, c.nomor_rek, c.nama_rek
							FROM tbl_confirmasi a 
							INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 						
							INNER JOIN tbl_bank c ON a.id_bank = c.id_bank 						
							WHERE a.status_confirmasi='0'
							GROUP BY a.id_confirmasi 
							ORDER BY id_uniq DESC LIMIT 5
						"); 

$data_confirmasi = array();						
						
while($data = $dataowSet->fetch_object()){
	$id_confirmasi = $data->id_confirmasi;	
	$q = $db->query("SELECT id_barang FROM tbl_confirmasi WHERE id_confirmasi='$id_confirmasi'");	
	$total =0;
	$tot_barang = mysqli_num_rows($q);
	while($get_id = $q->fetch_object()){
		$id_barang = $get_id->id_barang;
		$get_harga = $db->query("SELECT harga_barang FROM tbl_barang WHERE id_barang='$id_barang'")->fetch_object();
		$total += $get_harga->harga_barang;
	}
	$total = $total+$data->ongkir+$data->code_uniq;
	
	$data_confirmasi = array(
		"id_confirmasi" => $data->id_confirmasi,
		"Time" 			=> $data->tgl_confirmasi." ".$data->jam_confirmasi,
		"Total"		 	=> rupiah($total),
		"Qty" 			=> $tot_barang		
	
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
$jum = $db->query("SELECT (id_confirmasi) 
							FROM tbl_confirmasi					
							WHERE status_confirmasi='0'								
							GROUP BY id_confirmasi
				"); 
$num = mysqli_num_rows($jum);
echo $num;
}
?>



