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
include_once(dirname(__FILE__) . '/part/isi_page.php');


include_once(dirname(__FILE__) . '/part/footer.php');
?>