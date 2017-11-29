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
	$isi_sub_page	= $_POST['isi_sub_page'];
	$nama_sub_page	= $_POST['nama_sub_page'];
	$id_page	= $_POST['id_page'];
	
	//echo "INSERT INTO tbl_sub_page SET isi_sub_page='$isi_sub_page', nama_sub_page='$nama_sub_page', page_time='$page_time'";
	if($db->query("INSERT INTO tbl_sub_page SET id_page='$id_page', isi_sub_page='$isi_sub_page', nama_sub_page='$nama_sub_page',status='1'"))
	{
		
		die();
	}
	
	die();
}

?>	
<script type="text/javascript" src="<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.js"></script>

<div class="container">
	<h2>Form Sub Page</h2>	
	
	<div id="form_lanjut_barang"></div>
	<!--<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>-->
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_sub_page" action="part/form_sub_page.php">
	  <input type="hidden" class="form-control" name="page_simpan">
	  	<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_kategori">Page Induk:</label>
		  <div class="col-sm-10">
			<select name="page_id" class="form-control" id="page_id">
				<option value="">---Pilih Page Induk---</option>
				<?php 
					$q = $db->query("SELECT * FROM tbl_page");
					while($data = $q->fetch_object())
					{
						echo '<option value="'.$data->page_id.'">'.$data->page_judul.'</option>';
					}
				?>
			</select>
		
			
		  </div>
		</div>
		<div id="toogle_main_form" style="display:none;">
					
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="nama_sub_page">Judul*</label>
					  <div class="col-sm-10">
						<!--auto compelete-->
						<input type="text" class="form-control  isi_sub_page" id="nama_sub_page" name="isi_sub_page" value="" required>			
						<span class="help-block" id="brand_help">Judul harus diisi.</span>
						 
						<!--auto compelete-->  
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="isi_sub_page">Isi Sub Page*</label>
					  <div class="col-sm-10">
						<!--auto editor-->
						<textarea class="form-control  isi_sub_page " id="isi_sub_page" name="isi_sub_page" value=""></textarea>
						<span class="help-block" id="deskripsi_help"><small>Isi Sub Page</small></span>
						 
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
$("#page_id").on("change",function(){
	$("#toogle_main_form").fadeIn();
});



//ckeditor
$( 'textarea#isi_sub_page' ).ckeditor({
	
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
$("#form_tambah_sub_page").submit(function(){
	
	loading_menu();
	var nama_sub_page  	= $("#nama_sub_page").val();
	var isi_sub_page  = $("#isi_sub_page").val();
	var 	id_page  = $("#page_id").val();
	 

	var page_simpan ='';
	
	$.post("part/form_sub_page.php",{page_simpan:page_simpan,	id_page:id_page,nama_sub_page:nama_sub_page,isi_sub_page:isi_sub_page},function(e){
		
		load_menu_hash("part/tbl_sub_page.php");
		//alert(e);
	});
	
		//alert(isi_sub_page);
		
	
	loading_menu_hide();
	return false;
});


</script>
</div>

