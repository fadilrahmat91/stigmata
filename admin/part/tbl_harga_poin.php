<?php
session_start();
if(!isset($_SESSION['id_admin']))
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
		
		<div class="form-group" id="t4_ubah_btn">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="button" id="ubah_btn" class="btn btn-danger">Edit</button>
		  </div>
		</div>
		
		<div class="form-group" id="t4_save_btn">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="button" id="save_btn" class="btn btn-success">Save</button>
			<button type="button" id="cancel_btn" class="btn btn-warning">Cancel</button>
		  </div>
		</div>
	
</div>
<script>
$("#t4_save_btn").hide();
$("#ubah_btn").click(function(){
	var nilai_jual  = $("#nilai_jual").text();
	var nilai_tukar = $("#nilai_tukar").html();
	
	$("#nilai_jual").html("<input type='text' id='input_nilai_jual' value='"+nilai_jual+"'>");
	$("#nilai_tukar").html("<input type='text' id='input_nilai_tukar' value='"+nilai_tukar+"'>");
	$("#input_nilai_jual").focus();
	$(this).hide();
	$("#t4_save_btn").show();
	
	return false;
});

$("#save_btn").click(function(){
	
	var edit_nilai_jual 	= $("#input_nilai_jual").val();
	var edit_nilai_tukar 	= $("#input_nilai_tukar").val();	
	//alert(edit_nilai_tukar);
	$.get("part/tbl_harga_poin.php?update_harga_poin",{						
						edit_nilai_jual:edit_nilai_jual,
						edit_nilai_tukar:edit_nilai_tukar
								},function(e){
		//alert(e);		
		load_menu_hash("part/tbl_harga_poin.php");
	});
	
	return false;
});

$("#cancel_btn").click(function(){
	
	load_menu_hash("part/tbl_harga_poin.php");
	
	
	return false;
});




</script>