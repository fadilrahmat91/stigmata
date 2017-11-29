<?php
session_start();  
include_once(dirname(__FILE__) . '/config/config.php');
include_once(dirname(__FILE__) . '/config/setting_front.php');
include_once(dirname(__FILE__) . '/config/function.php');
// setting//

//part of template//
include_once(dirname(__FILE__) . '/part/head.php');
include_once(dirname(__FILE__) . '/part/heading.php');
include_once(dirname(__FILE__) . '/part/menu.php');
//include_once(dirname(__FILE__) . '/part/kategori_slide.php');
if(isset($_GET['id_brand']))
{
	include_once(dirname(__FILE__) . '/part/isi_brand.php');
}else{
	header ('location:'.$alamat);
}


//include_once(dirname(__FILE__) . '/part/new_product.php');
//include_once(dirname(__FILE__) . '/part/featured_product.php');
include_once(dirname(__FILE__) . '/part/footer.php');

?>


  
	

