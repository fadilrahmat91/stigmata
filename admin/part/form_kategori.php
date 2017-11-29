<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
?>	
<script type="text/javascript" src="<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.js"></script>
<div class="container">
	<h2>Tambah Kategori</h2>	
	<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_kategori" action="part/simpan_tambah_kategori.php">
	  <input type="hidden" class="form-control" name="simpan_kategori">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_kategori">Nama Kategori:</label>
		  <div class="col-sm-10">
			
			<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Nama Kategori" required>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="desc_kategori">Desc Kategori:</label>
		  <div class="col-sm-10">
			<textarea class="form-control" id="desc_kategori" name="desc_kategori"  required></textarea>
		  </div>
		</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="url_images">Main Image*</label>
					  <div class="col-sm-10">
						<!--auto finder-->
						<input class="form-control  url_img_kategori" id="url_img_kategori" type="hidden" name="url_img_kategori" value="" required>
							<div id="main_img_show" data-toggle="modal" data-target="#modal_image"></div>	

									  <!-- Modal -->
									  <div class="modal fade" id="modal_image" role="dialog">
										<div class="modal-dialog">
										
										  <!-- Modal content-->
										  <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close" data-dismiss="modal">&times;</button>
											  <h4 class="modal-title" id="modal_image_header"></h4>
											</div>
											<div class="modal-body">
												<div id="modal_image_content"></div>
											</div>
											<div class="modal-footer">
											  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										  </div>
										  
										</div>
									  </div>
									  <!-- Modal -->

							
						<input type="button" value="Browse Server" class="btn btn-default" id="browse_gambar"/>
						<span class="help-block" id="deskripsi_help"><small>Gambar Utama tampak depan product</small></span>
						 
						<!--auto finder-->  
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



//ckfinder	
$("#browse_gambar").click(function(){
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '<?php echo $alamat?>admin/plugins/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = SetFileField;
	
	finder.popup();
	
});



function SetFileField( fileUrl )
{
	$( '#url_img_kategori' ).val(fileUrl);
	$( '#main_img_show' ).html("<img src='"+fileUrl+"' class='img-thumbnail' width='300px'>");
	$( '#modal_image_content' ).html("<img src='"+fileUrl+"' class='img-thumbnail' width='100%'>");
	$( '#modal_image_header' ).html(fileUrl);
	
}

$("#tutup_tambah_data").click(function(){
	$("#t4_tambah_data").fadeOut("slow");
});

$("#form_tambah_kategori").submit(function(){
	$("#alert_placeholder").hide();
	loading_menu();
	 var valuenya 	= $(this).serialize();
	 var targetnya	= $(this).attr("action");
	
	$.post(targetnya,valuenya,function(data){
	$("#alert_placeholder").show();	
		
			
			$("#t4_tambah_data").fadeOut();
			load_menu_hash("part/tbl_kategori.php");
			
		
		
		loading_menu_hide();
	});
	
	return false;
});


</script>