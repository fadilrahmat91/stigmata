<?php
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

$_xml ="";

header("Content-type: text/xml");

$_xml .='<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"      
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"    
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9            
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';     

$q = $db->query("SELECT a.id_barang,
						a.nama_barang,
						b.nama_kategori,
						c.nama_toko,
						d.nama_brand										
					FROM tbl_barang a
					INNER JOIN tbl_kategori b
						ON a.id_kategori = b.id_kategori
					INNER JOIN tbl_toko c
						ON a.id_toko = c.id_toko
					INNER JOIN tbl_brand d
						ON a.id_brand = d.id_brand
					WHERE a.status_barang='1'
					ORDER BY a.id_barang DESC LIMIT 150
				");

while($data = $q->fetch_object())
{
	$id_barang 		= htmlentities(strip_tags($data->id_barang), ENT_QUOTES);
	$nama_kategori 	= htmlentities(strip_tags($data->nama_kategori), ENT_QUOTES);
	$nama_barang	= htmlentities(strip_tags($data->nama_barang), ENT_QUOTES);
	
	$link = $alamat.link_detail($id_barang,$nama_kategori,$nama_barang);	
	$link = htmlentities(strip_tags($link), ENT_QUOTES);;	
	
	$_xml .="<url>\r\n";          
		$_xml .="<loc>".$link."</loc>\r\n";  
	$_xml .="</url>\r\n";
	
}
				
	


$_xml .="</urlset>";


echo $_xml;
