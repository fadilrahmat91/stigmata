<?php
	$id_brand = mysqli_real_escape_string($db,$_GET['id_brand']);	 
	$brand = $db->query("SELECT * FROM tbl_brand WHERE id_brand='$id_brand'")->fetch_object();
?>
			<!--
    		<div class="label label-info">
				<a href="<?php echo $alamat?>">Home</a> > <a href='<?php echo link_brand($brand->id_brand,$brand->nama_brand)?>'><?php echo $brand->nama_brand?></a> 
			</div>
    		-->
<?php 
$q = $db->query("SELECT a.*,
							b.nama_brand,										
							d.nama_brand										
						FROM tbl_barang a
						INNER JOIN tbl_brand b
							ON a.id_brand = b.id_brand									
						INNER JOIN tbl_brand d
							ON a.id_brand = d.id_brand
						WHERE a.id_brand='$id_brand' AND status_barang='1'				
						ORDER BY a.id_barang DESC LIMIT 4
						
					");
?>

	<div class="clear"></div>
	<div class='col-xs-3'>
		<img src='<?php echo $brand->url_image_brand?>'>
	</div>
	<div class='col-xs-9'>
		<h1><?php 	echo $brand->nama_brand?></h1>
		<p>			
			<?php 	echo $brand->desc_brand?>
		</p>
	</div>
	<div class="clear"></div>
	<div class="shape_button"><b>Product <?php echo $brand->nama_brand?></b></div>
	
	
	
	
    <div class="row container" id="grid_produk">
			<?php 
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
						<a href="'.link_detail($data->id_barang,$data->nama_brand,$data->nama_barang).'">
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
			<br>
			
				
		
		<!--load more product-->
		<br><br>
		<div class="row container" id="grid_produk">
			<div id="get_data_brand"></div>
		</div>
		<div style='clear:both;'></div>
		
<button id="show_more_brand" class="btn btn-block btn-primary">Show more..</button>

<script>


var current_page_brand = 2;
var fetch_page_brand = function() {  
	loading_menu();
    $.get('part/isi_brand_ajax.php', {page_index: current_page_brand, id_brand:'<?php echo $id_brand?>', page_size: 4}, function(data) {        
        current_page_brand += 1;
			
		if(data.length === 0)
		{			      
			$("#show_more_brand").fadeOut();
			loading_menu_hide();
		} else {
			$("#get_data_brand").append(data);
			
			loading_menu_hide();
			
		}
		
		
    });
}


$(function() {

    fetch_page_brand();

    // 2. on scroll to bottom
  
	
	$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
           //fetch_page_brand();
		}
	});

    // 3. on the `more` tag clicked.
    $('#show_more_brand').click(function(){
		 fetch_page_brand();
	});

});

</script>	
			
<script>
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
</script>
			
