<?php 
session_start();
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

if(isset($_GET['form_harga_ongkir']) && isset($_GET['harga']) && isset($_GET['free_limit'])){
		
	$harga 		= hanya_nomor($_GET['harga']);
	$free_limit = hanya_nomor($_GET['free_limit']);
	
	if($db->query("UPDATE tbl_set_ongkir SET harga='$harga', free_limit='$free_limit'"))
	{
		$back = array("harga" => rupiah($harga),"free_limit" => $free_limit);	
		
		echo implode("-",$back);
	}
	
}

if(isset($_GET['hapus_toko'])){
		
	$id_toko = $_GET['id_toko'];
	$db->query("DELETE FROM tbl_toko WHERE id_toko ='$id_toko'");
	
}

if(isset($_GET['hapus_barang'])){
		
	$id_barang = $_GET['id_barang'];
	$db->query("DELETE FROM tbl_barang WHERE id_barang ='$id_barang'");
	
}


if(isset($_GET['non_aktifkan'])){
	
	$id_toko = $_GET['id_toko'];
	$db->query("UPDATE tbl_toko SET status_toko='0' WHERE id_toko='$id_toko'");
	$db->query("UPDATE tbl_barang SET status_barang='0' WHERE id_toko='$id_toko'");
	
	
	
}
if(isset($_GET['aktifkan'])){
	
	$id_toko = $_GET['id_toko'];
	$db->query("UPDATE tbl_toko SET status_toko='1' WHERE id_toko='$id_toko'");
	
	
	
}

if(isset($_GET['non_aktifkan_barang'])){
	
	$id_barang = $_GET['id_barang'];
	$db->query("UPDATE tbl_barang SET status_barang='0' WHERE id_barang='$id_barang'");
	
	
	
}
if(isset($_GET['aktifkan_barang'])){
	
	$id_barang = $_GET['id_barang'];
	$db->query("UPDATE tbl_barang SET status_barang='1' WHERE id_barang='$id_barang'");
	
	
	
}

if(isset($_GET['hapus_kategori'])){
	
	$id_kategori = $_GET['id_kategori'];
	$db->query("DELETE FROM tbl_kategori WHERE id_kategori='$id_kategori'");
	
	
	
}

if(isset($_GET['hapus_kontak'])){
	
	$id_kontak = $_GET['id_kontak'];
	$db->query("DELETE FROM tbl_kontak WHERE id_kontak='$id_kontak'");
	
	
}

if(isset($_GET['seen_kontak'])){
	
	$id_kontak = $_GET['id_kontak'];
	$db->query("UPDATE tbl_kontak SET status='1' WHERE id_kontak='$id_kontak'");

	
}

if(isset($_GET['hapus_sub_kategori'])){
	
	$id_sub_kategori = $_GET['id_sub_kategori'];
	$db->query("DELETE FROM tbl_sub_kategori WHERE id_sub_kategori='$id_sub_kategori'");
	
	
	
}

if(isset($_GET['hapus_brand'])){
	
	$id_brand = $_GET['id_brand'];
	$db->query("DELETE FROM tbl_brand WHERE id_brand='$id_brand'");
	
	
	
}

if(isset($_GET['hapus_page'])){
	
	$page_id = $_GET['page_id'];
	$db->query("DELETE FROM tbl_page WHERE page_id='$page_id'");
	
	
	
}

if(isset($_GET['hapus_bank'])){
	
	$id_bank = $_GET['id_bank'];
	$db->query("DELETE FROM tbl_bank WHERE id_bank='$id_bank'");
	
	
	
}

if(isset($_GET['promo'])){
	$promo = $_GET['promo'];
	$id_barang = $_GET['id_barang'];
	$valnya = $_GET['valnya'];
	
	$db->query("UPDATE tbl_barang SET $promo='$valnya' WHERE id_barang='$id_barang'");
	
	
	/*
	$q = $db->query("SELECT '$promo' FROM tbl_barang WHERE id_barang='$id_barang'")->fetch_array();
	
	if($q["$promo"] ==0)
	{
		$db->query("UPDATE tbl_barang SET '$promo'='1' WHERE id_barang='$id_barang'");
	}else{
		$db->query("UPDATE tbl_barang SET '$promo'='0' WHERE id_barang='$id_barang'");
	}
	*/
	
	
	
	
}
