<?php
session_start();

include_once(dirname(__FILE__) . '/config/config.php');
include_once(dirname(__FILE__) . '/config/setting_front.php');
include_once(dirname(__FILE__) . '/config/function.php');
if(!isset($_SESSION['id_pelanggan']))
{
	header('Location: '.$alamat);
	die();
}


//part of template//
include_once(dirname(__FILE__) . '/part/head.php');
include_once(dirname(__FILE__) . '/part/heading.php');
include_once(dirname(__FILE__) . '/part/menu.php');

include_once(dirname(__FILE__) . '/part/isi_member.php');

include_once(dirname(__FILE__) . '/part/footer.php');
?>