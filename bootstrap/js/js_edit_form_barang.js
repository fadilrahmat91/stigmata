
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



//submit form
$("#form_tambah_barang").submit(function(){
	
	loading_menu();
	var id_kategori = $(".nama_kategori").val();
	var nama_barang = $("#nama_barang").val();
	var nama_brand  = $("#nama_brand_auto").val();
	var deskripsi_barang  = $("#deskripsi_barang").val();
	var id_toko = $(".id_toko").val();
	var berat_bersih = $("#berat_bersih").val();
	var berat_kotor = $("#berat_kotor").val();
	var ukuran_besih = $("#ukuran_besih").val();
	var ukuran_kotor = $("#ukuran_kotor").val();
	var garansi_barang = $("#garansi_barang").val();
	var stok_barang    = $("#stok_barang").val();
	var sku_barang	   = $("#sku_barang").val();
	var harga_barang   = $("#harga_barang").val();
	var harga_coret	   = $("#harga_coret").val();
	 
	 //alert(id_kategori);
	var simpan_edit_barang ='';
	var id_barang = <?php echo $id_barang?>';
	var targetnya	= 	"part/form_support_barang.php";
	//alert(id_toko);
	$.post(targetnya,{
						id_barang:id_barang,
						simpan_edit_barang:simpan_edit_barang,
						id_toko:id_toko,
						id_kategori:id_kategori,
						nama_barang:nama_barang,
						nama_brand:nama_brand,
						berat_bersih:berat_bersih,
						berat_kotor:berat_kotor,
						ukuran_besih:ukuran_besih,
						garansi_barang:garansi_barang,
						stok_barang:stok_barang,
						sku_barang:sku_barang,
						harga_barang:harga_barang,
						harga_coret:harga_coret,
						ukuran_kotor:ukuran_kotor,						
						deskripsi_barang:deskripsi_barang
					 
					 },function(e){
						 						 
		
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
				echo '{ value: "'.$id_kategori.'", label: "'.$nama_kategori.'" },'; 
				
			}														
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