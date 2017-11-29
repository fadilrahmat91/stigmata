<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');



include_once(dirname(__FILE__) . '/../plugins/php_excel/excel_reader.php');


if(isset($_GET['id_kategori']))
{
	//unset($_SESSION['session_var']);
	$_SESSION['id_kategori'] = $_GET['id_kategori'];
	
	die($_SESSION['id_kategori']);
}

if(isset($_GET['id_sub_kategori']))
{
	//unset($_SESSION['session_var']);
	$_SESSION['id_sub_kategori'] = $_GET['id_sub_kategori'];
	
	die($_SESSION['id_sub_kategori']);
}

if(isset($_GET['id_brand']))
{
	//unset($_SESSION['session_var']);
	$_SESSION['id_brand'] = $_GET['id_brand'];
	
	die($_SESSION['id_brand']);
}


if(isset($_FILES['userfile']['tmp_name']))
{
	
	//var_dump($_SESSION);
	$id_kategori 		= $_SESSION['id_kategori'];
	$id_sub_kategori 	= $_SESSION['id_sub_kategori'];
	$id_brand 			= $_SESSION['id_brand'];
	
	$status_barang		= "0";
	$tgl_details_update = date("Y-m-d H:i:s");
	
	
	$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);
	
		
	// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
	$sukses = 0;
	
	// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
	
	$get_data = "";
	for ($i=2; $i<=$baris; $i++)
	{
	  // membaca data id (kolom ke-1)
	  $sku_barang = $data->val($i, 1);
	  $nama_barang = $data->val($i, 2);
	  $stok_barang = $data->val($i, 3);
	  $harga_member = $data->val($i, 4);
	  $harga_barang = $data->val($i, 5);
	  $deskripsi_barang = $data->val($i, 6);
	  $berat_kotor = $data->val($i, 7);	  
	  $ukuran_kotor = $data->val($i, 8);
	  if($sku_barang !=="" || $berat_kotor !==""||  $ukuran_kotor !==""|| $deskripsi_barang !==""|| $nama_barang !==""|| $harga_barang !==""||$stok_barang !==""|| $harga_member !=="")
	  {
		$db->query("INSERT INTO tbl_barang SET										
										id_kategori		='$id_kategori',
										id_sub_kategori	='$id_sub_kategori',
										id_brand		='$id_brand',
										nama_barang		='$nama_barang',
										stok_barang		='$stok_barang',
										harga_member	='$harga_member',
										harga_barang	='$harga_barang',										
										sku_barang		='$sku_barang',
										deskripsi_barang='$deskripsi_barang',																				
										tgl_details_update ='$tgl_details_update',										
										berat_kotor		='$berat_kotor',										
										status_barang	='$status_barang',										
										ukuran_kotor	='$ukuran_kotor'																																						
					");
	  }
	 }
	
	// tampilan status sukses dan gagal
	
	echo "<div style='background-color:pink'>Data berhasil diimport!<br>";
	echo "</div>";
	
	die();
}



?>	


<div class="container">
	<h2>Import Product</h2>	
	<a href="part/format_import_product.xls">Download Template</a>
	<div class="info alert alert-info"></div>
	<form id="form_import_product">
	<div class="form-group">
	  <label class="control-label col-sm-2" for="nama_kategori">Pilih File*</label>
	  <div class="col-sm-10">
		<select  class="form-control" id="id_kategori" >
		<option value="">---Pilih Kategori Induk---</option>
		<?php 
			$q = $db->query("SELECT * FROM tbl_kategori");
			while($kat = $q->fetch_object())
			{				
				echo '<option value="'.$kat->id_kategori.'">'.$kat->nama_kategori.'</option>';
			}
		?>
		</select>	
		<span class="help-block" id="sub_kat_help">Kategori harus diisi.</span>
		</div>
	</div>
	
	
	<div id="t4_sub_kategori"></div>
	
	<div class="form-group" id="t4_brand" style="display:none;">
	  <label class="control-label col-sm-2" for="nama_brand">Brand*</label>
	  <div class="col-sm-10">
		<!--auto compelete-->
		<!--<input type="text" class="form-control  nama_brand" id="nama_brand_auto" name="nama_brand" value="" placeHolder="Pilih Brand" required>			-->
			
		<select name="id_brand" class="form-control" id="id_brand" >
		<option value="">---Pilih Brand---</option>
		<?php 
			$q = $db->query("SELECT * FROM tbl_brand");
			while($data = $q->fetch_object())
			{
				echo '<option value="'.$data->id_brand.'">'.$data->nama_brand.'</option>';
			}
		?>
		</select>
		
		<span class="help-block" id="brand_help">Brand harus diisi.</span>
		 
		<!--auto compelete-->  
	  </div>
	</div>
	
	
	
	<div class="form-group" id="t4_barang" style="display:none;">
	  <label class="control-label col-sm-2" for="nama_kategori">Import File Product*</label>
	  <div class="col-sm-10">
		<div id="form_upload" style="border:1px solid #aaa; padding:10px;">
			<input id="input_upload" class="button" type="file" />
		</div>
		<span class="help-block" id="brand_help">File harus sesuai dengan format yang ada.(xls)</span>
	 </div>
	</div>
	</form>
</div>

<script>
$(function(){
		
	new AjaxUpload('#input_upload', {
					action: 'part/import_product.php',
					onComplete: function(file, response){                   
						
						$(".info").html(response).fadeIn('slow').delay("5000").fadeOut();
						load_menu_hash("part/tbl_barang.php?tbl_barang_new");
					}
	});
	
});



$("#id_kategori").on("change",function(){
	var id_kategori = $(this).val();
	//alert(id_kategori);
	$.get("part/get_sub_kategori.php",{id_kategori:id_kategori},function(e){
		$("#t4_sub_kategori").html(e);
		
	})
	//set session
	$.get("part/import_product.php",{id_kategori:id_kategori},function(e){
		
		//alert(e);
	});
	
});


$("#t4_sub_kategori").on("change","#id_sub_kategori",function(){
	$("#t4_brand").fadeIn();
	//set session
	var id_sub_kategori = $(this).val();	
	$.get("part/import_product.php",{id_sub_kategori:id_sub_kategori},function(e){		
		//alert(e);
	});
});


$("#t4_brand").on("change","#id_brand",function(){
	$("#t4_barang").fadeIn();
	var id_brand = $(this).val();	
	$.get("part/import_product.php",{id_brand:id_brand},function(e){		
		
	});
});


</script>


