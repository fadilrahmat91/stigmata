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
	<h2>Tambah Sub Kategori</h2>	
	<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_sub_kategori" action="part/simpan_tambah_sub_kategori.php">
	  <input type="hidden" class="form-control" value="tambah" name="simpan_sub_kategori">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_kategori">Kategori Induk:</label>
		  <div class="col-sm-10">
			<select name="id_kategori" class="form-control" id="id_kategori">
				<option value="">---Pilih Kategori Induk---</option>
				<?php 
					$q = $db->query("SELECT * FROM tbl_kategori");
					while($data = $q->fetch_object())
					{
						echo '<option value="'.$data->id_kategori.'">'.$data->nama_kategori.'</option>';
					}
				?>
			</select>
		
			
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="desc_kategori">Nama Sub Kategori</label>
		  <div class="col-sm-10">
				<input type="text" class="form-control" id="nama_sub_kategori" name="nama_sub_kategori" placeholder="Nama Sub Kategori" required>
		  </div>
		</div>
		
			
		<div class="form-group">
		  <label class="control-label col-sm-2" for="desc_kategori">Desc Kategori:</label>
		  <div class="col-sm-10">
			<textarea class="form-control" id="desc_sub_kategori" name="desc_sub_kategori"  required></textarea>
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

$("#form_tambah_sub_kategori").submit(function(){
	$("#alert_placeholder").hide();
	loading_menu();
	 var valuenya 	= $(this).serialize();
	 var targetnya	= $(this).attr("action");
	
	if($("#id_kategori").val() =="")
	{
		$("#id_kategori").css("border-color", "red").focus();
		
		loading_menu_hide();
		return false;
	}
	
	$.post(targetnya,valuenya,function(data){
	$("#alert_placeholder").show();	
		
			
			$("#t4_tambah_data").fadeOut();
			load_menu_hash("part/tbl_sub_kategori.php");
			
				
		loading_menu_hide();
	});
	
	return false;
});


</script>