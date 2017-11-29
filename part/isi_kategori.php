
<?php
	 $id_kategori = mysqli_real_escape_string($db,$_GET['id_kategori']);
	 $id_kategori = explode(",",$id_kategori);
	 $id_kategori = $id_kategori[0];
	 
	$nama_kat = $db->query("SELECT id_kategori, url_img_kategori, desc_kategori, nama_kategori FROM tbl_kategori WHERE id_kategori='$id_kategori'")->fetch_object();
?>
			<!--
    		<div class="label label-info">
				<a href="<?php echo $alamat?>">Home</a> > <a href='<?php echo link_kategori($nama_kat->id_kategori,$nama_kat->nama_kategori)?>'><?php echo $nama_kat->nama_kategori?></a>
			</div>
			-->
    		

<div class="judul_kat_besar alert alert-info text-center">
	<b><?php echo $nama_kat->nama_kategori?></b>
</div>


<?php
$random7 = rand(1,7);

//include ("kat_style_".$random7.".php");

//include ("kat_style_1.php");
include ("kat_style_2.php");
/*
include ("kat_style_3.php");
include ("kat_style_4.php");
include ("kat_style_5.php");
include ("kat_style_6.php");
include ("kat_style_7.php");
*/
?>





















<!--------------------------------------------------bawah grid kategori------------------------------------------>
<div class="shape_button"><?php echo $nama_kat->nama_kategori?></div>
<div style='clear:both'></div>
    	
			<div class="row container" id="grid_produk">
			<?php
			$q = $db->query("SELECT a.*, 
							 b.nama_kategori,							
							 d.nama_brand										
						FROM tbl_barang a
						INNER JOIN tbl_kategori b
							ON a.id_kategori = b.id_kategori						
						INNER JOIN tbl_brand d
							ON a.id_brand = d.id_brand
						WHERE a.id_kategori='$id_kategori' AND status_barang='1'
						ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC LIMIT 4
					");
			if($hit_q == 0){
				echo("<h3 class='text-center'>Maaf.. belum ada produk..</h2>");
			}
			
			$i 	= 0;
			$a	= 0; 
			while($data = $q->fetch_object())
			{
				
				$a++;
				
				
				if($a %2==0)
				{
					$div_clear =  '<div class="clearfix visible-xs" ></div>';	
					
				}else{
					$div_clear = "";
					
				}
				if($a %4==0)
				{					
					$div_clear =  "<div style='clear:both;'></div>";					
				}else{
					$div_clear = "";
					
				}
				
				if(($data->harga_coret > $data->harga_barang) && ($data->harga_coret !==0))
				{	
					
					$diskon = '<span class="btn btn-xs btn-warning" id="offernya"><small>'.diskon($data->harga_coret,$data->harga_barang).'</small></span><br>';
					$coret  =  '<span id="coretnya"><s>Rp.'.rupiah($data->harga_coret).'</s></span><br>';
					//$coret  =  '';
					$harga  = $diskon.$coret.'<span class="harganya_total">Rp.'.rupiah($data->harga_barang).'</span>';
					$judulnya  =  '<span class="judulnya">'.$data->nama_barang.'</span>';
				}else{
					$diskon = "";
					$coret = "";
					$harga  = '<span class="harganya_total">Rp.'.rupiah($data->harga_barang).'</span>';
					$judulnya = '<span class="judulnya">'.$data->nama_barang.'</span>';
				}
				
				
				#-------------------gambar array----------------------#
				$img = $obj->gambarArray($data->id_barang,2);
				if (is_null($img[1])) 
				{
					$img_2 = no_image();
				}else{
					$img_2 = $img[1];
				}
				
				echo '<div class="col-xs-6 col-sm-3 nopadding product_grid ">						
						<a href="'.link_detail($data->id_barang,$data->nama_kategori,$data->nama_barang).'">
					  ';		
				
					
						echo'
							<div class="image">
								
									<input type="hidden" id="gbr2" value="'.ambil_thumbs($img_2).'">
									<input type="hidden" id="gbr1" value="'.ambil_thumbs($img[0]).'">
									<center><img src="'.ambil_thumbs($img[0]).'" alt="" class="gambar_product img-responsive" /></center>
								
							
							</div>';

							
				echo $harga.$judulnya.'
								
								<div class="btn btn-warning block btn-xs text-center  btn_lihat_detail"><i class="icon-ok text-success"></i> 
									Lihat Detail &rarr;
								</div>
							
						</a>	
						
						
					</div>						
						 
						 '.$div_clear;
							
						
						
				
			}
			
			?>
			
			</div>
			<div style='clear:both;'></div>
		
			<br><br>	
			
				
		
		<!--load more product-->
		<br><br>
		<div class="row container" id="grid_produk">
			<div id="get_data_kategori"></div>
		</div>
		<div style='clear:both;'></div>
		
<button id="show_more_kategori" class="btn btn-block btn-primary">Show more..</button>
<script>

var current_page_kategori = 2;
var fetch_page_kategori = function() {  
	loading_menu();
    $.get('part/isi_kategori_ajax.php', {page_index: current_page_kategori, id_kategori:'<?php echo $id_kategori?>', page_size: 4}, function(data) {        
        current_page_kategori += 1;
			
		if(data.length === 0)
		{			      
			$("#show_more_kategori").fadeOut();
			loading_menu_hide();
		} else {
			$("#get_data_kategori").append(data);
			
			loading_menu_hide();
			
		}
		
		
    });
}


$(function() {

    fetch_page_kategori();

    // 2. on scroll to bottom
  
	
	$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
          // fetch_page_kategori();
		}
	});

    // 3. on the `more` tag clicked.
    $('#show_more_kategori').click(function(){
		 fetch_page_kategori();
	});

});

</script>	
			
			
<script>

if(!isMobile)
{
	
$(function() {
    $("#grid_produk .product_grid .gambar_product")
        .mouseover(function() {            
           var src2 = $(this).parent().parent().find("#gbr2").val();
		   //alert(src2);
           $(this).attr("src", src2);
			//alert(src);
        })
        .mouseout(function() {
            var src1 = $(this).parent().parent().find("#gbr1").val();
            $(this).attr("src", src1);
			//alert(src);
        });
});
}


</script>