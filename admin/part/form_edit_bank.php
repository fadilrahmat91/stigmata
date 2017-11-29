<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');

$id_bank =  $_GET['id_bank'];
$data = $db->query("SELECT * FROM tbl_bank WHERE id_bank='$id_bank'")->fetch_object();

?>	
<div class="container">
	<h2>Edit <?php echo $data->nama_bank?></h2>	
	<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_Bank" action="part/simpan_tambah_bank.php">
	  <input type="hidden" class="form-control" name="id_bank" value="<?php echo $data->id_bank?>">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_bank">Nama Bank:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="Nama Bank" value="<?php echo $data->nama_bank?>" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nomor_rek">No Rek:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="nomor_rek" name="nomor_rek" placeholder="No Rek" value="<?php echo $data->nomor_rek?>" required>
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_rek">Nama Rek:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="nama_rek" name="nama_rek" placeholder="Nama Rek" value="<?php echo $data->nama_rek?>" required>
		  </div>
		</div>
	
		
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

$("#form_tambah_Bank").submit(function(){
	$("#alert_placeholder").hide();
	loading_menu();
	 var valuenya 	= $(this).serialize();
	 var targetnya	= $(this).attr("action");
	
	$.post(targetnya,valuenya,function(data){
	$("#alert_placeholder").show();	
			
			$("#t4_tambah_data").fadeOut();
			load_menu_hash("part/tbl_bank.php");
		
		loading_menu_hide();
	});
	
	return false;
});


</script>