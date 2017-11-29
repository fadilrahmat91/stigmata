<?php 
$alamat="http://localhost:8080/penjualan_baju/";
date_default_timezone_set("asia/Jakarta");
include_once(dirname(__FILE__) . '/function.php');

$obj = new BlioniaClass($db);
$kat = "";

function buat_ket($isinya){
 $isinya = strip_tags($isinya);
 $isinya = str_replace('&nbsp;',' ',$isinya);
 if(strlen($isinya) > 500) 
 $isinya = substr($isinya, 0, 500).'...';
 return $isinya;
}


foreach($obj->allKategori() as $nama_kat)
{
	$kat.=$nama_kat.',';
}
$kat = rtrim($kat, ', ');


$title="Belanja online $kat";
$description = "Belanja online $kat";
$type = "Website";


 if(isset($_GET['id_barang']))
 {	
	if($obj->detailsProduct($_GET['id_barang']) == "404")
	{
		header("location:".$alamat."404.php");
		
		die();
		//include ("404.php");
		//die("404");
	}else{			
		$details_product = $obj->detailsProduct($_GET['id_barang']);	
		$title = $details_product->nama_barang;
		$description = buat_ket($details_product->deskripsi_barang);
		$description = preg_replace('!\s+!', ' ', $description);
		$description = preg_replace( "/\s+/", " ", $description );
		$type = "Product";
		
			
			
		
	}
 }
 if(isset($_GET['id_brand']))
 {			
	$title = $obj->brand($_GET['id_brand'])->nama_brand;
	$description = $title;
	$type = "Product";
 }
 
 if(isset($_GET['id_kategori']))
 {			
	$title = $obj->kategori($_GET['id_kategori'])->nama_kategori;
	$description = $title;
	$type = "Product";
 }
 
 if(isset($_GET['page_id']))
 {		
	
	$page = $obj->page($_GET['page_id']);
	$title = $page->page_judul;
	$description = potong($page->page_isi,200);
	$type = "Website";
 }


 if(isset($_GET['id_sub_page']))
 {		
	
	$sub_page = $obj->sub_page($_GET['id_sub_page']);
	$title = $sub_page->nama_sub_page;
	$description = potong($sub_page->isi_sub_page,200);
	$type = "Website";
 }


?>