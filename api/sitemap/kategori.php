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

$q = $db->query("SELECT * FROM tbl_kategori WHERE nama_kategori<> '' ");

while($data = $q->fetch_object())
{
	$id_kategori 	= htmlentities(strip_tags($data->id_kategori), ENT_QUOTES);
	$nama_kategori 	= htmlentities(strip_tags($data->nama_kategori), ENT_QUOTES);
	
	
	$link = $alamat.link_kategori($id_kategori,$nama_kategori);
	$link = htmlentities(strip_tags($link), ENT_QUOTES);;	
	
	$_xml .="<url>\r\n";          
		$_xml .="<loc>".$link."</loc>\r\n";  
	$_xml .="</url>\r\n";
	
}
				
	


$_xml .="</urlset>";


echo $_xml;
