<div class="alert alert-info">All Item Discount</div>
<div class="row container" id="grid_produk">
<?php 
 $q = $db->query("SELECT    a.*,
							b.nama_kategori,
							c.nama_toko,
							d.nama_brand										
					FROM tbl_barang a
					INNER JOIN tbl_kategori b
						ON a.id_kategori = b.id_kategori
					INNER JOIN tbl_toko c
						ON a.id_toko = c.id_toko
					INNER JOIN tbl_brand d
						ON a.id_brand = d.id_brand
					WHERE harga_coret > harga_barang AND status_barang='1'
					ORDER BY a.id_barang DESC LIMIT 8
				");

if(isMobile()):	
	?>
		
					
		<div class=" swiper-container">
			<div class="swiper-wrapper">
			<?php 
			
			$i 	= 0;			
			while($data = $q->fetch_object())
			{
				
					
					if($i %2==0)
					{
						$swipe_open  = '<div class="swiper-slide">';
						$swipe_close = '';
						
					
						
					}else{
						
						$swipe_open  = '';
						$swipe_close = '</div>';
						
					}
					
				
				
					$diskon = '<span class="btn btn-xs btn-warning" id="offernya"><small>'.diskon($data->harga_coret,$data->harga_barang).'</small></span><br>';
					$coret  =  '<span id="coretnya"><s>Rp.'.rupiah($data->harga_coret).'</s></span><br>';					
					$harga  = $diskon.$coret.'<span class="harganya_total">Rp.'.rupiah($data->harga_barang).'</span>';
					$judulnya  =  '<span class="judulnya">'.$data->nama_barang.'</span>';
				
					echo $swipe_open;
				
					echo '<div class="col-xs-6 col-sm-3 nopadding product_grid">						
							<a href="'.link_detail($data->id_barang,$data->nama_kategori,$data->nama_barang).'">
								<div class="image">
									
									<center><img src="'.$data->url_images.'" alt="" class="gambar_product img-responsive" /></center>
									
								
								</div>	 

								
									'.$harga.$judulnya.'
									
									<div class="btn btn-warning block btn-xs text-center  btn_lihat_detail"><i class="icon-ok text-success"></i> 
										Lihat Detail &rarr;
									</div>
								
							</a>	
							
							
						</div>';
				
				echo $swipe_close;
				$i++;
				
			}			
			?>
			
			</div>
			<br>
			<br>
			<div class="swiper-pagination"></div>
		</div>
		<div style='clear:both;'></div>
		
		
		
		
		
 <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
</script>


<?php
else:

$i 	= 0;			
			while($data = $q->fetch_object())
			{
				
					$diskon = '<span class="btn btn-xs btn-warning" id="offernya"><small>'.diskon($data->harga_coret,$data->harga_barang).'</small></span><br>';
					$coret  =  '<span id="coretnya"><s>Rp.'.rupiah($data->harga_coret).'</s></span><br>';					
					$harga  = $diskon.$coret.'<span class="harganya_total">Rp.'.rupiah($data->harga_barang).'</span>';
					$judulnya  =  '<span class="judulnya">'.$data->nama_barang.'</span>';
				
				
				
					echo '<div class="col-xs-6 col-sm-3 nopadding product_grid">						
							<a href="'.link_detail($data->id_barang,$data->nama_kategori,$data->nama_barang).'">
								<div class="image">
									
									<center><img src="'.$data->url_images.'" alt="" class="gambar_product img-responsive" /></center>
									
								
								</div>	 

								
									'.$harga.$judulnya.'
									
									<div class="btn btn-warning block btn-xs text-center  btn_lihat_detail"><i class="icon-ok text-success"></i> 
										Lihat Detail &rarr;
									</div>
								
							</a>	
							
							
						</div>';
				
				
			}			
			?>
			
			</div>
			<br>
			<br>
			
		</div>
		<div style='clear:both;'></div>
		


<?php
endif;
?>	
