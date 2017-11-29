<?php
include_once(dirname(__FILE__) . '/../config/config.php');

function rupiah($nilai, $pecahan = 0) 
{
    return number_format($nilai, $pecahan, ',', '.');
}


$_xml="";
header("Content-type: text/xml");

$_xml .= '<?xml version="1.0" encoding="UTF-8"?>';

$_xml .= '<format_sms>';


$dataowSet = $db->query("SELECT a.id_confirmasi, a.code_uniq, a.ongkir, b.telp_pelanggan, b.nama_pelanggan, b.id_pelanggan,
							c.nama_bank, c.nomor_rek, c.nama_rek
							FROM tbl_confirmasi a 
							INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 						
							INNER JOIN tbl_bank c ON a.id_bank = c.id_bank 						
							WHERE a.sms_sent='0'
							GROUP BY a.id_confirmasi
						"); 
						
while($data = $dataowSet->fetch_object()){
	$id_confirmasi = $data->id_confirmasi;	
	$q = $db->query("SELECT id_barang FROM tbl_confirmasi WHERE id_confirmasi='$id_confirmasi'");	
	$total =0;
	while($get_id = $q->fetch_object()){
		$id_barang = $get_id->id_barang;
		$get_harga = $db->query("SELECT harga_barang FROM tbl_barang WHERE id_barang='$id_barang'")->fetch_object();
		$total += $get_harga->harga_barang;
	}
	$total = $total+$data->ongkir+$data->code_uniq;
	$_xml .="<data>";
		
	

		$tujuan 	= htmlentities(strip_tags($data->telp_pelanggan), ENT_QUOTES);

		$isi_pesan 	= "Yth.$data->nama_pelanggan Kode Pemesanan: $data->id_confirmasi Lakukan pembayaran Sebesar: Rp.".rupiah($total)." ke $data->nama_bank A/n. $data->nama_rek No.Rek: $data->nomor_rek Blionia.com";

		$id 		= ($data->id_confirmasi);

		

		$_xml .= "<tujuan>$tujuan</tujuan>";

		$_xml .= "<isi_pesan>$isi_pesan</isi_pesan>";

		$_xml .= "<id>$id</id>";



	$_xml .="</data>";

	

}





$_xml .= '</format_sms>';







//fwrite($file, $_xml);

//fclose($file);



//mysql_query("DELETE FROM gammu_server ");

echo $_xml;

//header("location:xml.xml");