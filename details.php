<?php 
session_start();
include_once(dirname(__FILE__) . '/config/config.php');
include_once(dirname(__FILE__) . '/config/setting_front.php');
include_once(dirname(__FILE__) . '/config/function.php');
// setting//


//hits//
$id_barang = $_GET['id_barang'];
$db->query("UPDATE tbl_barang SET hits=hits+1 WHERE id_barang='$id_barang'");



//part of template//
include_once(dirname(__FILE__) . '/part/head.php');

$session_seen =  $_SESSION['session_sementara'];
$q_seen = $db->query("INSERT INTO tbl_session_seen SET session_sementara='$session_seen',id_barang='$id_barang'");



include_once(dirname(__FILE__) . '/part/heading.php');
include_once(dirname(__FILE__) . '/part/menu.php');
include_once(dirname(__FILE__) . '/part/isi_details.php');
include_once(dirname(__FILE__) . '/part/seen_product.php');
//include_once(dirname(__FILE__) . '/part/related_product.php');

//include_once(dirname(__FILE__) . '/part/new_product.php');
include_once(dirname(__FILE__) . '/part/footer.php');
?>