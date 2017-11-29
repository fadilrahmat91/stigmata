<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');

$id_toko =  $_GET['id_toko'];
$data = $db->query("SELECT * FROM tbl_toko WHERE id_toko='$id_toko'")->fetch_object();

?>	
<div class="container">
	<h2>Edit Toko <?php echo $data->nama_toko?></h2>	
	<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_toko" action="part/simpan_tambah_toko.php">
	  <input type="hidden" class="form-control" name="id_toko" value="<?php echo $data->id_toko?>">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_toko">Nama Toko:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="nama_toko" name="nama_toko" placeholder="Nama Toko" value="<?php echo $data->nama_toko?>" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email_toko">Email Toko:</label>
		  <div class="col-sm-10">
			<input type="email" class="form-control" id="email_toko" name="email_toko" placeholder="email_toko" value="<?php echo $data->email_toko?>" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="telp_toko">Telp Toko:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="telp_toko" name="telp_toko" placeholder="telp_toko" value="<?php echo $data->telp_toko?>" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="no_rek_toko">Nomor Rekening Toko:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="no_rek_toko" name="no_rek_toko" placeholder="no_rek_toko" value="<?php echo $data->no_rek_toko?>" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="atas_nama_toko">Atas Nama Toko:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="atas_nama_toko" name="atas_nama_toko" placeholder="atas_nama_toko" value="<?php echo $data->atas_nama_toko?>" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="user_toko">Username:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="user_toko" name="user_toko" placeholder="user_toko" value="<?php echo $data->user_toko?>" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="pass_toko">Password:</label>
		  <div class="col-sm-10">
			<input type="password" class="form-control" id="pass_toko" name="pass_toko" placeholder="pass_toko" value="<?php echo $data->pass_toko?>" required>
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="ulangi_pass">Ulangi Password:</label>
		  <div class="col-sm-10">
			<input type="password" class="form-control" id="ulangi_pass" name="ulangi_pass" placeholder="ulangi_pass" value="<?php echo $data->pass_toko?>" required>
		  </div>
		</div>
		
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="alamat_toko">Alamat:</label>
		  <div class="col-sm-10">
			<textarea class="form-control" id="alamat_toko" name="alamat_toko" placeholder="alamat_toko" required><?php echo $data->alamat_toko?></textarea>
		  </div>
		</div>
		<!--
		<div class="form-group">
		  <label class="control-label col-sm-2" for="status_toko">Status Toko:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="status_toko" name="status_toko" placeholder="Status Toko" value="<?php echo $data->status_toko?>" required>
		  </div>
		</div>
		-->
		<div class="form-group">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">Submit</button>
		  </div>
		</div>
	  </form>
	  
</div>

<script>
$("#tutup_tambah_data").click(function(){
	$("#t4_tambah_data").fadeOut("slow");
});

$("#form_tambah_toko").submit(function(){
	$("#alert_placeholder").hide();
	loading_menu();
	 var valuenya 	= $(this).serialize();
	 var targetnya	= $(this).attr("action");
	
	$.post(targetnya,valuenya,function(data){
	$("#alert_placeholder").show();	
		if(data == 1){
			
			bootstrap_alert.warning('Nama Toko atau Username sudah terdaftar..');
			
		}else if(data == 2){
			
			bootstrap_alert.warning('Password harus minimal 8 karakter..');
		
		}else if(data == 3){
			
			bootstrap_alert.warning('Password dan Ulangi Password harus sama..');
			
		}else if(data ==4){
			
			$("#t4_tambah_data").fadeOut();
			load_menu_hash("part/tbl_toko.php");
			
		}
		
		loading_menu_hide();
	});
	
	return false;
});


</script>