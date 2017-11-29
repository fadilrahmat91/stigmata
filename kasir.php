<?php
session_start();
include_once(dirname(__FILE__) . '/config/config.php');
include_once(dirname(__FILE__) . '/config/setting_front.php');
include_once(dirname(__FILE__) . '/config/function.php');
// setting//

if(isset($_GET['save_to_keranjang']))
{
$session_sementara 	= $_SESSION['session_sementara'];
$id_barang 			= hanya_nomor($_GET['by_produk_id']);
$harga_per_item 	= hanya_nomor($_GET['harga_barang']);
$stok_barang		= hanya_nomor($_GET['stok_barang']);

$q_cek = $db->query("SELECT id_barang,qty FROM tbl_keranjang WHERE session_sementara='$session_sementara' AND id_barang = '$id_barang' ");
$cek_barang	= mysqli_num_rows($q_cek);
	
	$data_cek = $q_cek->fetch_object();
	if($stok_barang > $data_cek->qty)
	{
		if($cek_barang>0)
		{
		
			$db->query("UPDATE tbl_keranjang SET qty=qty+1 WHERE id_barang='$id_barang' AND session_sementara='$session_sementara'");
			die("Update");
			
		}else{
			
			$db->query("INSERT INTO tbl_keranjang SET id_barang='$id_barang', qty=qty+1, harga_per_item='$harga_per_item', session_sementara='$session_sementara'");
			die("Insert");
			
		}
		
		
	}else{
		die("minus_stok");
	}
}

if(isset($_GET['update_to_keranjang']))
{
$session_sementara 	= $_SESSION['session_sementara'];
$qty			= hanya_nomor($_GET['qty']);
$id_barang		= hanya_nomor($_GET['id_barang']);

$db->query("UPDATE tbl_keranjang SET qty='$qty' WHERE id_barang='$id_barang' AND session_sementara='$session_sementara'");
die("Update");
	
}



if(isset($_GET['delete_from_keranjang']))
{
	$id_keranjang = $_GET['id_keranjang'];
	$db->query("DELETE FROM tbl_keranjang WHERE id_keranjang='$id_keranjang'");
	die();
}

//part of template//
include_once(dirname(__FILE__) . '/part/head.php');
include_once(dirname(__FILE__) . '/part/heading.php');
include_once(dirname(__FILE__) . '/part/menu.php');

if(isset($_SESSION['id_pelanggan']))
{
	include_once(dirname(__FILE__) . '/part/isi_kasir_login.php');
}else{
	include_once(dirname(__FILE__) . '/part/isi_kasir.php');
}



include_once(dirname(__FILE__) . '/part/footer.php');
?>