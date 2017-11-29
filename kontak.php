<?php 
session_start();

include_once(dirname(__FILE__) . '/config/config.php');
include_once(dirname(__FILE__) . '/config/setting_front.php');
include_once(dirname(__FILE__) . '/config/function.php');
// setting//

//part of template//
$_SESSION['randomnya'] = randomnya(5);
include_once(dirname(__FILE__) . '/part/head.php');
include_once(dirname(__FILE__) . '/part/heading.php');
include_once(dirname(__FILE__) . '/part/menu.php');
//include_once(dirname(__FILE__) . '/part/kategori_slide.php');
include_once(dirname(__FILE__) . '/part/isi_kontak.php');
//include_once(dirname(__FILE__) . '/part/new_product.php');
//include_once(dirname(__FILE__) . '/part/featured_product.php');
include_once(dirname(__FILE__) . '/part/footer.php');

?>


  
	

