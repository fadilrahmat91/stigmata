<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');


$id_barang = $_GET['id_barang'];
$data = $db->query("SELECT a.*,
										b.id_kategori,
										b.nama_kategori,
										c.id_images,
										c.url_images,		
										d.nama_brand										
									FROM tbl_barang a	
									LEFT JOIN tbl_kategori b
										ON a.id_kategori = b.id_kategori
									LEFT JOIN tbl_images_barang c
										ON a.id_barang = c.id_barang
									LEFT JOIN tbl_brand d
										ON a.id_brand = d.id_brand														
									WHERE a.id_barang='$id_barang'
									GROUP BY id_barang")->fetch_object();

							
//admin_check
$db->query("UPDATE tbl_barang SET admin_check='1' WHERE id_barang='$id_barang'");
														
/*
									
$q_toko 			= $db->query("SELECT * from tbl_toko ORDER BY id_toko ASC");
$get_data_toko 		= array();
while($data_toko 	= $q_toko->fetch_object()){
  $get_data_toko[] 	= $data_toko;
}

$cek 	= $db->query("SELECT id_toko FROM tbl_barang WHERE id_barang='$id_barang'")->fetch_object();
*/									
				
									
?>	
<script type="text/javascript" src="<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.js"></script>
<div >
	<h2>Edit Product</h2>	
	
	<div id="form_lanjut_barang"></div>
	<!--<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>-->
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_barang" action="">
	  <input type="hidden" class="form-control" name="id_barang" value="<?php echo $id_barang?>">

		<div id="toogle_main_form">
		<h3>Main Product:</h3>
					
					
					<input type="hidden" value="1" id="id_toko"  name="id_toko" >
					
					

					<div class="form-group">
					  <label class="control-label col-sm-2" for="nama_kategori">Kategori Product*</label>
					  <div class="col-sm-10">
						<select  class="form-control" id="id_kategori" disabled>
						<option value="">---Pilih Kategori Induk---</option>
						<?php 
							$q = $db->query("SELECT * FROM tbl_kategori");
							while($kat = $q->fetch_object())
							{
								$selected = $data->id_kategori == $kat->id_kategori ? ' selected="selected"' : '';
								echo '<option value="'.$kat->id_kategori.'" '.$selected.'>'.$kat->nama_kategori.'</option>';
							}
						?>
						</select>
						<input type="hidden" name="id_kategori" value="<?php echo $data->id_kategori?>">
						 </div>
					</div>
					
								
				<div class="form-group">
				  <label class="control-label col-sm-2" for="nama_kategori">Sub Kategori</label>
				  <div class="col-sm-10">
				
					<select name="" class="form-control" id="id_sub_kategori" disabled>
					<option value="">---Pilih Sub Kategori---</option>
					<?php 
						$q = $db->query("SELECT * FROM tbl_sub_kategori");
						while($sub_kat = $q->fetch_object())
						{
							$selected = $data->id_sub_kategori == $sub_kat->id_sub_kategori ? ' selected="selected"' : '';
							echo '<option value="'.$sub_kat->id_sub_kategori.'" '.$selected.'>'.$sub_kat->nama_sub_kategori.'</option>';
						}
						
						
					?>
					</select>
					<input type="hidden" name="id_sub_kategori" value="<?php echo $data->id_sub_kategori?>">
					<span class="help-block" id="sub_kat_help">Sub Kategori harus diisi.</span>
					
					<!--auto compelete-->  
				  </div>
				</div>
					
					
					<div class="form-group" id="t4_brand" >
					  <label class="control-label col-sm-2" for="nama_brand">Brand*</label>
					  <div class="col-sm-10">
						<!--auto compelete-->
						<!--<input type="text" class="form-control  nama_brand" id="nama_brand_auto" name="nama_brand" value="" placeHolder="Pilih Brand" required>			-->
							
						<select name="id_brand" class="form-control" id="id_brand" >
						<option value="">---Pilih Brand---</option>
						<?php 
							$q = $db->query("SELECT * FROM tbl_brand");
							while($brand = $q->fetch_object())
							{
								$selected = $data->id_brand == $brand->id_brand ? ' selected="selected"' : '';
								echo '<option value="'.$brand->id_brand.'" '.$selected.'>'.$brand->nama_brand.'</option>';
							}
						?>
						</select>
						
						<span class="help-block" id="brand_help">Brand harus diisi.</span>
						 
						<!--auto compelete-->  
					  </div>
					</div>
				
						
				<div id="hide_sementara">
				<h3 id="details_product">Details Product:</h3>
					<div class="form-group" id="div_nama_barang">
					  <label class="control-label col-sm-2" for="nama_barang">Nama Product*</label>
					  <div class="col-sm-10">			
						<input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $data->nama_barang?>" required>
						<span class="help-block" id="nama_help">
							Untuk kualitas yang lebih baik, Nama Product harus terdiri dari merek, warna, edisi, ciri khusus.
							<br>
							Contoh: <small>Nikon Wide Angle Camera 10 MP black</small>
						</span>
					  </div>
					</div>
					
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="deskripsi_barang">Deskripsi Produk*</label>
					  <div class="col-sm-10">
						<!--auto editor-->
						<textarea class="form-control  deskripsi_barang " id="deskripsi_barang" name="deskripsi_barang" ><?php echo $data->deskripsi_barang?></textarea>
						<span class="help-block" id="deskripsi_help"><small>Deskripsi singkat mengenai Produk/ Katalog produk. Berisi tentang keterangan lebih detail Product</small></span>
						 
						<!--auto editor-->  
					  </div>
					</div>
					
					
					<div class="alert alert-default">
						Main Image*<br>
						<span class="help-block" id="deskripsi_help"><small>Gambar Utama tampak depan product</small></span>
						<div id="t4_gambar_array" ></div>
						<div style="clear:both"></div>
						<a id="add_img" onclick="add_form_gambar()">add</a>
					</div>
					
					
				</div>
				
		</div>
		
		<div id="toogle_details_form">
			<h3 id="measurement_product">Measurement Product:</h3>
			<!--
			<div class="form-group">
			  <label class="control-label col-sm-2" for="berat_bersih">Berat bersih (kg)</label>
			  <div class="col-sm-10">				
				<input type="text" class="form-control  berat_bersih" id="berat_bersih" name="berat_bersih" value="<?php echo $data->berat_bersih?>" required>			
				<span class="help-block" id="berat_bersih_help"><small>Contoh : 10kg.</small></span>				 				
			  </div>
			</div>
			-->
			
			<div class="form-group">
			  <label class="control-label col-sm-2" for="berat_kotor">Berat  (kg)</label>
			  <div class="col-sm-10">
				
				<input type="text" class="form-control  berat_kotor" id="berat_kotor" name="berat_kotor" value="<?php echo $data->berat_kotor?>"  required>			
				<span class="help-block" id="berat_kotor_help">Berat paket (berat pengiriman)<small>Contoh : 12kg.</small></span>
				 				
			  </div>
			</div>
			
			<!--
			<div class="form-group">
			  <label class="control-label col-sm-2" for="ukuran_besih">Ukuran Bersih (cm)</label>
			  <div class="col-sm-10">
				
				<input type="text" class="form-control  ukuran_besih" id="ukuran_besih" name="ukuran_besih" value="<?php echo $data->ukuran_besih?>" required>			
				<span class="help-block" id="ukuran_besih_help">Panjang x Lebar x Tinggi<small>Contoh : 20x20x20</small></span>
				 				
			  </div>
			</div>
			-->
			
			<div class="form-group">
			  <label class="control-label col-sm-2" for="ukuran_kotor">Ukuran  (cm)</label>
			  <div class="col-sm-10">
				
				<input type="text" class="form-control  ukuran_kotor" id="ukuran_kotor" name="ukuran_kotor" value="<?php echo $data->ukuran_kotor?>" required>			
				<span class="help-block" id="ukuran_kotor_help">Ukuran paket (Ukuran pengiriman)<small>Contoh : 25x25x25</small></span>
				 				
			  </div>
			</div>
			
			
			
			
		</div>
				
		
		<div id="toogle_more_details_form">
		
		<h3>Pricing Product:</h3>
			<table class="table">
				<thead>
					<tr>
						<th>Seller SKU</th>
						<th width="100px">Quantity</th>
						<!--<th>Seller Price</th>-->
						<th>Retail Price</th>
						<th>Normal Price</th>
						<th>Member Price</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text"   	id="sku_barang" class="form-control" name="sku_barang" value="<?php echo $data->sku_barang?>" required></td>
						<td><input type="number" 	id="stok_barang" class="form-control" name="stok_barang" value="<?php echo $data->stok_barang?>"required></td>
						<!--<td><input type="text" 		id="harga_modal" class="form-control" name="harga_modal" value="<?php echo rupiah($data->harga_modal)?>" required></td>-->
						<td><input type="text" 		id="harga_coret" class="form-control" name="harga_coret" value="<?php echo rupiah($data->harga_coret)?>"></td>
						<td><input type="text" 		id="harga_barang" class="form-control" name="harga_barang" value="<?php echo rupiah($data->harga_barang)?>" required></td>
						<td><input type="text" 		id="harga_member" class="form-control" name="harga_member" value="<?php echo rupiah($data->harga_member)?>" required></td>						
					</tr>
				<tbody>
				
				<tfoot>
					<tr>
						<th>Kode uniq</th>
						<th>Stok</th>
						<!--<th>Harga Modal</th>-->
						<th>Harga Coret</th>
						<th>Harga Jual</th>
						<th>Harga Member</th>
					</tr>
				</tfoot>
			</table>
		</div>
		
		
		
			<div class="form-group alert alert-info">
			  <label class="control-label col-sm-2" for="deskripsi_barang">Kategori Promo Produk</label>
			  <div class="col-sm-10">
					<input type="checkbox" id="featured" name="featured" value="<?php echo ($data->featured)?>" <?php  if($data->featured =='1'){ echo 'checked'; }?>> Featured Product <br>
					<input type="checkbox" id="new_arrival" name="new_arrival" value="<?php echo ($data->new_arrival)?>" <?php  if($data->new_arrival=='1'){ echo 'checked';}?>> New Arrival <br>
					<input type="checkbox" id="hot_deal" name="hot_deal" value="<?php echo ($data->hot_deal)?>" <?php if($data->hot_deal=='1'){ echo 'checked';}?>> Hot Deal <br>
					
			  </div>
			</div>
			
		
		
		<div class="form-group" id="save_and_finish">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" id="simpan" class="btn btn-warning">Save And Finish</button>
		  </div>
		</div>
		

		
	  </form>
	  
</div>
<style>
.img_ready{
width:200px;
height:130px;
}
</style>
<script>

//gambar-------------------------------------------
<?php
$q = $db->query("SELECT * FROM tbl_images_barang WHERE url_images <>'' AND id_barang='".$data->id_barang."'");
while($g_url = $q->fetch_object())
{	
	echo 'add_form_gambar("'.$g_url->url_images.'");';
}

if(mysqli_num_rows($q)<4)
{
	$a = 4-mysqli_num_rows($q);
	for($i=0;$i<$a;$i++)
	{
		echo 'add_form_gambar();';
	}
}



?>


function add_form_gambar(url_gbrnya)
{
	if (url_gbrnya === undefined) {
		var formnya = '<div class="col-sm-3 alert alert-info text-center" style="height:200px;" id="form_gambar">'					  						
						+'<input class="url_images" id="url_images" type="hidden" name="url_images[]" value="" required>'
							+'<div id="main_img_show"></div>'							
						+'<input type="button" value="Browse Gambar" class="btn btn-xs btn-default" id="browse_gambar" />'						
						+'<input type="button" value="x" class="btn btn-xs btn-danger" id="del_gambar" />'						
					+'</div>';
	}else{
	
	var formnya = '<div class="col-sm-3 alert alert-success text-center" style="height:200px;" id="form_gambar">'					  						
						+'<input class="url_images" id="url_images" type="hidden" name="url_images[]" value="'+url_gbrnya+'" required>'
							+'<div id="main_img_show" data-toggle="modal" data-target="#modal_image">	'
							+'<img src='+url_gbrnya+' class="img_ready" ></div>	'
						+'<input type="button" value="Browse Gambar" class="btn btn-xs btn-default" id="browse_gambar" />'						
						+'<input type="button" value="x" class="btn btn-xs btn-danger" id="del_gambar" />'						
					+'</div>';
	}	
	
	$("#t4_gambar_array").append(formnya);
}


$("#t4_gambar_array").on("click","#form_gambar #browse_gambar",function(){

	
	var url_images = $(this).parent().find("#url_images");
	var main_img_show = $(this).parent().find("#main_img_show");
	
	//url_images.html("aaaa");
	BrowseServer(url_images,main_img_show);
	
	
});

//ckfinder
function BrowseServer(url_images,main_img_show)
{
	
	var get_t4 = $(this).html();
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '<?php echo $alamat?>admin/plugins/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
	//finder.selectActionFunction = SetFileField;
	finder.selectActionFunction = function(e){				
				url_images.val(e);
				main_img_show.html("<img src='"+e+"' class='img_ready'>");
				
			}
	finder.popup();
	
	// It can also be done in a single line, calling the "static"
	// popup( basePath, width, height, selectFunction ) function:
	// CKFinder.popup( '../', null, null, SetFileField ) ;
	//
	// The "popup" function can also accept an object as the only argument.
	// CKFinder.popup( { basePath : '../', selectActionFunction : SetFileField } ) ;	
	
}


$("#t4_gambar_array").on("click","#form_gambar #del_gambar",function(){
	if(confirm("Anda yakin menghapus data ini?"))
	{
		
		$(this).parent().remove();
	}
	
	return false;
});






$("#tutup_tambah_data").click(function(){
	$("#t4_tambah_data").fadeOut("slow");
});
$("#t4_table,#judul_h1").fadeOut();


$( 'textarea#deskripsi_barang' ).ckeditor({
	
	filebrowserBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : '<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : '<?php echo $alamat?>admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
    filebrowserWindowWidth : '1000',
    filebrowserWindowHeight : '700'
	
});

//$( '#main_img_show' ).html("<img src='<?php echo $data->url_images?>' class='img-thumbnail' width='300px'>");




//submit form
$("#form_tambah_barang").submit(function(){
	
	loading_menu();
		
	var targetnya	= 	"part/form_support_barang.php";
	//alert(id_toko);
	$.post(targetnya,$(this).serialize(),function(e){
						 						 
		//alert(e);
		if(e == 1)
		{
			
			load_menu_hash("part/tbl_barang.php");
			
		}else if(e ==0)
		{
			add_warning("Mohon maaf, ada kesalahan teknis. Pastikan form tidak diisi dengan karakter ilegal.","form_lanjut_barang");
		} 
		//	alert(e);
	});
	
	loading_menu_hide();
	return false;
});

//autocomplete kategori
$('#tokenfield').tokenfield({
  autocomplete: {
	source: [
		<?php 
			$q = $db->query("SELECT * FROM tbl_kategori");
			
			$str = '';
			while($data = $q->fetch_object()){
				$id_kategori = $data->id_kategori;
				$nama_kategori = $data->nama_kategori;
				
				$str .= '{ value:"'.$nama_kategori.'", label:"'.$nama_kategori.'" },'; 
				
			}
			echo rtrim($str,",");			
		?>
	
	],
	delay: 100
  },
   showAutocompleteOnFocus: true
   
});


//autocomplete tbl_brand
$(function() {
	var availableTags = [
	
	<?php 
		$brandnya ='';
		$q = $db->query("SELECT * FROM tbl_brand");
		while($data = $q->fetch_object()){
			
			$nama_brand = $data->nama_brand;
						
			$brandnya .= '{ value: "'.$nama_brand.'", label: "'.$nama_brand.'" },'; 
			
		}	
		echo rtrim($brandnya,",");
	?>
	
	];
	$( "#nama_brand_auto" ).autocomplete({
	source: availableTags
	});
});
</script>