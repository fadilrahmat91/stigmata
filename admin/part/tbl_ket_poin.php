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
$row = $class->infoHargaPoin();
$isi_ket_poin  = $row->isi_ket_poin;




if(isset($_GET['update_info_poin']))
{
	$isi_ket_poin = $_GET['isi_ket_poin'];
	$db->query("UPDATE tbl_ket_poin SET isi_ket_poin='$isi_ket_poin'");
	
	die();
}
?>	
<script type="text/javascript" src="<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.js"></script>
<div class="container">
	<h1>Harga Poin</h1>	
		<div id="keterangan_info" class="alert alert-success" ></div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="isi_ket_poin">Info</label>
		  <div class="col-sm-10">
			  <div class="col-sm-10">
						<!--auto editor-->
						<textarea class="form-control  isi_ket_poin " id="isi_ket_poin" name="isi_ket_poin" > <?php echo $isi_ket_poin ?></textarea>
						<span class="help-block" id="tbl_ket_poin_help"><small>Deskripsi singkat mengenai poin</small></span>
						 
						<!--auto editor-->  
					  </div>
		  </div>
		</div>
		
		
		<div class="form-group" id="t4_ubah_btn">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="button" id="save_btn" class="btn btn-danger">Update</button>
		  </div>
		</div>

	
</div>
<script>
$("#keterangan_info").hide();
$("#save_btn").click(function(){
	
	var isi_ket_poin 	= $("#isi_ket_poin").val();
	
	//alert(edit_nilai_tukar);
	$.get("part/tbl_ket_poin.php?update_info_poin",{
						isi_ket_poin:isi_ket_poin
								},function(e){
		//alert(e);	
			$("#keterangan_info").html("<span >Berhasil diupdate</span>").fadeIn();
			setTimeout(
			  function() 
			  {
					
				load_menu_hash("part/tbl_ket_poin.php");
				
			  }, 1000);			
		
	});
	
	return false;
});


//ckeditor
$( 'textarea#isi_ket_poin' ).ckeditor({
	
	filebrowserBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html?type=Flash',    
    filebrowserImageUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
	
});

//ckfinder
function BrowseServer()
{
	

	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '<?php echo $alamat?>admin/plugins/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = SetFileField;
	
	finder.popup();
	
	// It can also be done in a single line, calling the "static"
	// popup( basePath, width, height, selectFunction ) function:
	// CKFinder.popup( '../', null, null, SetFileField ) ;
	//
	// The "popup" function can also accept an object as the only argument.
	// CKFinder.popup( { basePath : '../', selectActionFunction : SetFileField } ) ;	
	
}

</script>