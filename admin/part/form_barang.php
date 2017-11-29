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
	<h2>Tambah Product</h2>	
	
	<div id="form_lanjut_barang"></div>
	<!--<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>-->
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_barang" action="part/simpan_tambah_barang.php">
	  <input type="hidden" class="form-control" name="simpan_barang">
	  	
		
		<div id="toogle_main_form">
		<h3>Main Product:</h3>
					
					<!--
					<div class="form-group">
						<label class="control-label col-sm-2" for="id_toko">Pilih Toko*</label>
						  <div class="col-sm-10">
							  <select multiple class="form-control id_toko" id="id_toko" name="id_toko">
								<?php
									$q = $db->query("SELECT * from tbl_toko ORDER BY id_toko ASC");
									while($data = $q->fetch_object())
									{
										echo '<option value="'.$data->id_toko.'">'.$data->nama_toko.'</option>';
									}
								?>					
							  </select>
							  <span class="help-block" id="toko_help">Toko harus diisi.</span>
						  </div>
					</div>
					-->
					<input type="hidden" value="1" id="id_toko"  name="id_toko" >
					

					<div class="form-group">
					  <label class="control-label col-sm-2" for="nama_kategori">Kategori Product*</label>
					  <div class="col-sm-10">
						<!--auto compelete-->
						<!--
						<input type="text" class="form-control  nama_kategori " id="tokenfield" name="nama_kategori" value="" placeHolder="Pilih kategori" />			
						-->
						
						
						<select name="id_kategori" class="form-control" id="id_kategori" >
						<option value="">---Pilih Kategori Induk---</option>
						<?php 
							$q = $db->query("SELECT * FROM tbl_kategori");
							while($data = $q->fetch_object())
							{
								echo '<option value="'.$data->id_kategori.'">'.$data->nama_kategori.'</option>';
							}
						?>
						</select>
						<span class="help-block" id="kat_help">Kategori harus diisi.</span>
						
						<!--auto compelete-->  
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
				
				
						
				<div id="hide_sementara">				
				
					
				<h3 id="details_product">Details Product:</h3>
					<div class="form-group" id="div_nama_barang">
					  <label class="control-label col-sm-2" for="nama_barang">Nama Product*</label>
					  <div class="col-sm-10">			
						<input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Product" required>
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
						<textarea class="form-control  deskripsi_barang " id="deskripsi_barang" name="deskripsi_barang" value=""></textarea>
						<span class="help-block" id="deskripsi_help"><small>Deskripsi singkat mengenai Produk/ Katalog produk. Berisi tentang keterangan lebih detail Product</small></span>
						 
						<!--auto editor-->  
					  </div>
					</div>
					<div class="alert alert-default">
						Main Image*<br>
						<span class="help-block" id="deskripsi_help"><small>Gambar Utama tampak depan product ( Min: 800 x 750 px)</small></span>
						<div id="t4_gambar_array" ></div>
						<div style="clear:both"></div>
						<a id="add_img" onclick="add_form_gambar()">add</a>
					</div>
					
				</div>
				<div class="form-group">        
				  <div class="col-sm-offset-2 col-sm-10">
					<button type="button" id="kat_lanjut" class="btn btn-primary">Next &rarr;</button>
				  </div>
				</div>			
		</div>
		
		<div id="toogle_details_form">
			<h3 id="measurement_product">Measurement Product:</h3>
			<!--
			<div class="form-group">
			  <label class="control-label col-sm-2" for="berat_bersih">Berat bersih (kg)</label>
			  <div class="col-sm-10">
				
				<input type="text" class="form-control  berat_bersih" id="berat_bersih" name="berat_bersih" value="not_set" placeHolder="berat_bersih" required>			
				<span class="help-block" id="berat_bersih_help"><small>Contoh : 10kg.</small></span>
				 				
			  </div>
			</div>
			-->
			
			<div class="form-group">
			  <label class="control-label col-sm-2" for="berat_kotor">Berat (kg)</label>
			  <div class="col-sm-10">
				
				<input type="text" class="form-control  berat_kotor" id="berat_kotor" name="berat_kotor" value="" placeHolder="berat_kotor" required>			
				<span class="help-block" id="berat_kotor_help">Berat paket (berat pengiriman)<small>Contoh : 12kg.</small></span>
				 				
			  </div>
			</div>
			
			<!--
			<div class="form-group">
			  <label class="control-label col-sm-2" for="ukuran_besih">Ukuran Bersih (cm)</label>
			  <div class="col-sm-10">
				
				<input type="text" class="form-control  ukuran_besih" id="ukuran_besih" name="ukuran_besih" value="not_set" placeHolder="ukuran_besih" required>			
				<span class="help-block" id="ukuran_besih_help">Panjang x Lebar x Tinggi<small>Contoh : 20x20x20</small></span>
				 				
			  </div>
			</div>
			-->
			
			<div class="form-group">
			  <label class="control-label col-sm-2" for="ukuran_kotor">Ukuran (cm)</label>
			  <div class="col-sm-10">
				
				<input type="text" class="form-control  ukuran_kotor" id="ukuran_kotor" name="ukuran_kotor" value="" placeHolder="ukuran_kotor" required>			
				<span class="help-block" id="ukuran_kotor_help">Ukuran paket (Ukuran pengiriman)<small>Contoh : 25x25x25</small></span>
				 				
			  </div>
			</div>
			
			
			
			
		</div>
				<div class="form-group">        
				  <div class="col-sm-offset-3 col-sm-10">
					<button type="button" id="kat_lanjut1" class="btn btn-primary">Next&rarr;</button>
				  </div>
				</div>		
		
		
		
		<div id="toogle_more_details_form">
		<!--
		<h3 id="garansi_product">Garansi Product:</h3>
			<div class="form-group">
			  <label class="control-label col-sm-2" for="garansi_barang">Garansi Produk*</label>
			  <div class="col-sm-10">
				
				<textarea class="form-control  garansi_barang " id="garansi_barang" name="garansi_barang" value="" required></textarea>
				<span class="help-block" id="garansi_barang_help"><small>Contoh : Garansi Resmi 1 Tahun.</small></span>
				 				
			  </div>
			</div>
			
			<div class="form-group">
			  <label class="control-label col-sm-2" for="in_paket">Isi Paket*</label>
			  <div class="col-sm-10">
				
				<textarea class="form-control  in_paket " id="in_paket" name="in_paket" required></textarea>
				<span class="help-block" id="in_paket_help">Batasi dengan koma (,) <small>Contoh : Nikon Wide Angle Camera 10 MP black, Lensa standard, Kartu garansi, Buku panduan</small></span>
				 				
			  </div>
			</div>
		-->
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
						<td><input type="text"   	id="sku_barang" class="form-control" name="sku_barang" required></td>
						<td><input type="number" 	id="stok_barang" class="form-control" name="stok_barang" required></td>						
						<td><input type="text" 		id="harga_coret" class="form-control" name="harga_coret"></td>
						<td><input type="text" 		id="harga_barang" class="form-control" name="harga_barang" required></td>
						<td><input type="text" 		id="harga_member" class="form-control" name="harga_member" required></td>
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
			
			
			<div class="form-group alert alert-info">
			  <label class="control-label col-sm-2" for="deskripsi_barang">Kategori Promo Produk</label>
			  <div class="col-sm-10">
					<input type="checkbox" id="featured" name="featured" value="1"> Featured Product <br>
					<input type="checkbox" id="new_arrival" name="new_arrival" value="1" > New Arrival <br>
					<input type="checkbox" id="hot_deal" name="hot_deal" value="1"> Hot Deal <br>
					
			  </div>
			</div>
			
		</div>
			<div class="form-group">        
				  <div class="col-sm-offset-2 col-sm-10">
					<button type="button" id="kat_lanjut2" class="btn btn-primary">Next&rarr;</button>
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


//gambar-------------------------------------------
add_form_gambar();
add_form_gambar();
add_form_gambar();
add_form_gambar();
function add_form_gambar()
{
	var formnya = '<div class="col-sm-3 alert alert-info text-center" style="height:200px;" id="form_gambar">'					  						
						+'<input class="url_images" id="url_images" type="hidden" name="url_images[]" value="" required>'
							+'<div id="main_img_show" data-toggle="modal" data-target="#modal_image"></div>	'
						+'<input type="button" value="Browse Gambar" class="btn btn-xs btn-default" id="browse_gambar" />'						
						+'<input type="button" value="x" class="btn btn-xs btn-danger" id="del_gambar" />'						
					+'</div>';
		
	$("#t4_gambar_array").append(formnya);
}


$("#t4_gambar_array").on("click","#form_gambar #browse_gambar",function(){

	
	var url_images = $(this).parent().find("#url_images");
	var main_img_show = $(this).parent().find("#main_img_show");
	
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
				main_img_show.html("<img src='"+e+"' class='img-thumbnail' style='width:130px; height:130px;'>");
				
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



$("#id_kategori").on("change",function(){
	var id_kategori = $(this).val();
	//alert(id_kategori);
	$.get("part/get_sub_kategori.php",{id_kategori:id_kategori},function(e){
		$("#t4_sub_kategori").html(e);
	})
	
	
});


$("#tutup_tambah_data").click(function(){
	$("#t4_tambah_data").fadeOut("slow");
});

/*
//ckeditor
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

*/





//ckeditor
if ( !CKEDITOR.env.ie || CKEDITOR.env.version > 7 )
					CKEDITOR.env.isCompatible = true;


$(function(){         
	// 1. Create your own toolbar         
	var myToolbar = [    
		[ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Table'],        
		['Styles'],		
		[ 'Link','Unlink','Anchor' ],
		[ 'Image' ],
		[ 'Iframe' ],
		[ 'NumberedList','BulletedList'],		
		['SelectAll']    
	];                                    
	// 2. Create a config var to hold your toolbar    
	var config =   {
		toolbar_mySimpleToolbar: myToolbar,   
		toolbar: 'mySimpleToolbar'            
	};     
	// 3. change the textarea into an editor using your config and toolbar      
	$( 'textarea#deskripsi_barang' ).ckeditor(config);
});








$("#alert_placeholder, #save_and_finish, #hide_sementara, #kat_lanjut, #kat_lanjut1,#kat_lanjut2,#toogle_details_form,#toogle_more_details_form").hide();

//setelah kategori terisi
$("#kat_lanjut").click(function(){
	
	kat_lanjut();
});



$("#t4_sub_kategori").on("change #id_sub_kategori",function(){
	$("#t4_brand").fadeIn();
});



$("#t4_brand").on("change",function(){
	kat_lanjut();
});



function kat_lanjut()
{

	loading_menu();
	var cek_id_kategori = $("#id_kategori").val();
	var t4_sub_kategori = $("#t4_sub_kategori").find("#id_sub_kategori").val();
	
	if(cek_id_kategori =='')
	 {
		$("#kat_help").css({"color":"red",});
		loading_menu_hide();
		return false;
	 }else if(t4_sub_kategori ==''){
	 
		$("#sub_kat_help").css({"color":"red",});
		loading_menu_hide();
		return false;
	 
	 }else{
		 
		 $("#sub_kat_help,#kat_help").fadeOut();
		 $(this).hide();
	 }
		
	//alert(cek_id_toko);	
	$("#hide_sementara,#kat_lanjut1").fadeIn(function(){
		
		go_to("details_product");
		
	});
		
	loading_menu_hide();
	return false;
}


$("#kat_lanjut1").click(function(){
	
	loading_menu();
	var cek_nama_brand_auto = $("#nama_brand_auto").val();
	var cek_nama_barang 	= $("#nama_barang").val();
	var deskripsi_barang  = $("#deskripsi_barang").val();
	if(cek_nama_brand_auto=='')
	{
		
		$("#brand_help").css({"color":"red",});
		
	}else if(cek_nama_barang=='')
	{
		
		$("#nama_help").css({"color":"red",});
	
	}else if(deskripsi_barang=='')
	{
		
		$("#deskripsi_help").css({"color":"red",});
		
	}else{
		$("#brand_help,#nama_help").fadeOut();
		$(this).hide();
		$("#kat_lanjut2,#toogle_details_form").fadeIn(function(){
			
			go_to("measurement_product");
			
		});
	}
		
	loading_menu_hide();
	return false;
});

$("#kat_lanjut2").click(function(){
	
	loading_menu();
	var berat_bersih 	= $("#berat_bersih").val();
	var berat_kotor 	= $("#berat_kotor").val();
	var ukuran_besih 	= $("#ukuran_besih").val();
	var ukuran_kotor 	= $("#ukuran_kotor").val();
	
	
	if(berat_bersih=='')
	{
		
		$("#berat_bersih_help").css({"color":"red",});
		
	}else if(berat_kotor=='')
	{
		
		$("#berat_kotor_help").css({"color":"red",});
		
	
	}else if(ukuran_besih=='')
	{
		
		$("#ukuran_besih_help").css({"color":"red",});
		
	
	}else if(ukuran_kotor=='')
	{
		
		$("#ukuran_kotor_help").css({"color":"red",});
		
	}else{
		$("#brand_help,#nama_help").fadeOut();
		$(this).hide();
		$("#toogle_more_details_form,#save_and_finish").fadeIn(function(){
			
			go_to("garansi_product");
			
		});
	}
		
	loading_menu_hide();
	return false;
});


//submit form
$("#form_tambah_barang").submit(function(){
	
	loading_menu();
	/*
	var nama_kategori 	= $(".nama_kategori").val();
	var nama_barang 	= $("#nama_barang").val();
	var nama_brand  	= $("#nama_brand_auto").val();
	var deskripsi_barang  = $("#deskripsi_barang").val();
	var id_toko 		= $(".id_toko").val();
	var berat_bersih 	= $("#berat_bersih").val();
	var berat_kotor 	= $("#berat_kotor").val();
	var ukuran_besih 	= $("#ukuran_besih").val();
	var ukuran_kotor 	= $("#ukuran_kotor").val();
	var garansi_barang = $("#garansi_barang").val();
	var stok_barang    = $("#stok_barang").val();
	var sku_barang	   = $("#sku_barang").val();
	var harga_modal	   = $("#harga_modal").val();
	var harga_barang   = $("#harga_barang").val();
	var harga_coret	   = $("#harga_coret").val();
	var url_images	   = $("#url_images").val();
	var in_paket	   = $("#in_paket").val();
	 
	 //alert(nama_kategori);
	var simpan_barang ='';
	*/
	
	//alert(id_toko);
	
	/*
	{
						simpan_barang:simpan_barang,
						id_toko:id_toko,
						nama_kategori:nama_kategori,
						nama_barang:nama_barang,
						nama_brand:nama_brand,
						berat_bersih:berat_bersih,
						berat_kotor:berat_kotor,
						ukuran_besih:ukuran_besih,
						garansi_barang:garansi_barang,
						stok_barang:stok_barang,
						sku_barang:sku_barang,
						harga_modal:harga_modal,
						harga_barang:harga_barang,
						harga_coret:harga_coret,
						ukuran_kotor:ukuran_kotor,						
						deskripsi_barang:deskripsi_barang,
						in_paket:in_paket,
						url_images:url_images
					 
					 }
					 */
	var targetnya	= 	"part/form_support_barang.php";				 
	$.post(targetnya,$(this).serialize(),function(e){
						 						 
//		alert(e);
		if(e == 1)
		{
			
			load_menu_hash("part/tbl_barang.php");
			
		}else if(e ==0)
		{
			add_warning("Mohon maaf, ada kesalahan teknis. Pastikan form tidak diisi dengan karakter ilegal.","form_lanjut_barang");
		} 
		
		
		
		
	});
	
	
	loading_menu_hide();
	return false;
});

/*
//autocomplete kategori
$('#tokenfield').tokenfield({
  autocomplete: {
	source: [
		<?php 
			$q = $db->query("SELECT * FROM tbl_kategori");
			while($data = $q->fetch_object()){
				$id_kategori = $data->id_kategori;
				$nama_kategori = $data->nama_kategori;
				
				//echo "'".$data->nama_kategori."',";
				echo '{ value: "'.$nama_kategori.'", label: "'.$nama_kategori.'" },'; 
				
			}														
		?>
	
	],
	delay: 100
  },
   showAutocompleteOnFocus: true
   
});
*/
/*
//autocomplete tbl_brand
$(function() {
	var availableTags = [
	
	<?php 
		$q = $db->query("SELECT * FROM tbl_brand");
		while($data = $q->fetch_object()){
			
			$nama_brand = $data->nama_brand;
						
			echo '{ value: "'.$nama_brand.'", label: "'.$nama_brand.'" },'; 
			
		}														
	?>
	
	];
	$( "#nama_brand_auto" ).autocomplete({
	source: availableTags
	});
});
*/
</script>


