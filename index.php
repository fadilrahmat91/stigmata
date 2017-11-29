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
include_once(dirname(__FILE__) . '/part/kategori_slide.php');
//include_once(dirname(__FILE__) . '/part/promo_by_kategori.php');

include_once(dirname(__FILE__) . '/part/featured_product.php');
include_once(dirname(__FILE__) . '/part/hot_deals.php');
include_once(dirname(__FILE__) . '/part/new_arrival.php');
//include_once(dirname(__FILE__) . '/part/new_product.php');
//include_once(dirname(__FILE__) . '/part/swipper.php');
include_once(dirname(__FILE__) . '/part/footer.php');

?>


  
	

