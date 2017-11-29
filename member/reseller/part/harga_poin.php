<?php
session_start();
if(!isset($_SESSION['reseller']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

$class = new BlioniaClass($db);
$row = $class->HargaPoin();
$nilai_jual  = $row['nilai_jual'];
$nilai_tukar = $row['nilai_tukar'];



if(isset($_GET['update_harga_poin']))
{
	
	$nilai_jual  = hanya_nomor($_GET['edit_nilai_jual']);
	$nilai_tukar = hanya_nomor($_GET['edit_nilai_tukar']);
	$db->query("UPDATE tbl_harga_poin SET nilai_tukar='$nilai_tukar', nilai_jual='$nilai_jual'");
	
	die();
}
?>	
<div class="container">
	<h1>Harga Poin</h1>	
	
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nilai_jual">Nilai Jual</label>
		  <div class="col-sm-10">
			<span  class="form-control">Rp.<span id="nilai_jual"><?php echo rupiah($nilai_jual)?></span></span>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nilai_tukar">Nilai Tukar</label>
		  <div class="col-sm-10">			
			<span class="form-control">Rp.<span id="nilai_tukar" ><?php echo rupiah($nilai_tukar)?></span></span>
		  </div>
		</div>
		
		
</div>