<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');

if(isset($_POST['page_simpan']))
{
	$page_isi	= $_POST['page_isi'];
	$page_judul	= $_POST['page_judul'];
	$page_time	= date('Y-m-d H:i:s');
	//echo "INSERT INTO tbl_page SET page_isi='$page_isi', page_judul='$page_judul', page_time='$page_time'";
	if($db->query("INSERT INTO tbl_page SET page_isi='$page_isi', page_judul='$page_judul', page_time='$page_time'"))
	{
		
		die();
	}
	
	die();
}

?>	
<script type="text/javascript" src="<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.js"></script>

<div class="container">
	<h2>Form Page</h2>	
	
	<div id="form_lanjut_barang"></div>
	<!--<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>-->
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_barang" action="part/form_page.php">
	  <input type="hidden" class="form-control" name="page_simpan">
	  	
		
		<div id="toogle_main_form">
					
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="page_judul">Judul*</label>
					  <div class="col-sm-10">
						<!--auto compelete-->
						<input type="text" class="form-control  page_isi" id="page_judul" name="page_isi" value="" required>			
						<span class="help-block" id="brand_help">Judul harus diisi.</span>
						 
						<!--auto compelete-->  
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="page_isi">Isi Page*</label>
					  <div class="col-sm-10">
						<!--auto editor-->
						<textarea class="form-control  page_isi " id="page_isi" name="page_isi" value=""></textarea>
						<span class="help-block" id="deskripsi_help"><small>Isi Page</small></span>
						 
						<!--auto editor-->  
					  </div>
					</div>
					
					
		
		
		
		
		
		<div class="form-group" id="save_and_finish">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" id="simpan" class="btn btn-warning">Save And Finish</button>
		  </div>
		</div>
		

		
	  </form>
	  
</div>

<script>

//ckeditor
$( 'textarea#page_isi' ).ckeditor({
	
	filebrowserBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
    filebrowserWindowWidth : '1000',
    filebrowserWindowHeight : '700'
	
});

//submit form
$("#form_tambah_barang").submit(function(){
	
	loading_menu();
	var page_judul  	= $("#page_judul").val();
	var page_isi  = $("#page_isi").val();
	 

	var page_simpan ='';
	
	$.post("part/form_page.php",{page_simpan:page_simpan,page_judul:page_judul,page_isi:page_isi},function(e){
		
		load_menu_hash("part/tbl_page.php");
		//alert(e);
	});
	
		//alert(page_isi);
		
	
	loading_menu_hide();
	return false;
});


</script>


