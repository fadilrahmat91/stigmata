<!--brand kiri--------------------------------------------->
<!-------------------------------------style-------------------------------------------------------->
<div class="row container" id="land_kategori">
	<div class="col-sm-1 nopadding">
	<!--brand-->
			<?php
			$qb = $db->query("SELECT a.id_barang, 
										b.id_brand,
										b.nama_brand,
										b.url_image_brand
									FROM tbl_barang a
									INNER JOIN tbl_brand b
									ON a.id_brand=b.id_brand
									WHERE a.id_kategori='$id_kategori' ORDER BY rand() LIMIT 5");
			while($brand = $qb->fetch_object())
			{
				echo '<div class="col-xs-12" style="border-bottom:1px solid #ddd; background:red;padding:0px;margin:0px;">
						<a href="'.link_brand($brand->id_brand,$brand->nama_brand).'"><img src="'.$brand->url_image_brand.'" style="width:100%;"></a>
					</div>';
			
			}
			?>
	</div>		

	<div class="kat_gambarnya nopadding col-sm-6">
			<?php if($nama_kat->url_img_kategori !=""):?>
				<img src="<?php echo $nama_kat->url_img_kategori?>" >
			<?php else:?>
				<img src="<?php echo $alamat?>img/logo.png" >
			<?php endif;?>
			
			
			
			
			
	</div>
	
	
	<div class="div_height_kat col-sm-5" id="grid_produk">
			<?php
			
			
$q_2 = $db->query("SELECT a.*, 
							 b.nama_kategori,							
							 d.nama_brand										
						FROM tbl_barang a
						INNER JOIN tbl_kategori b
							ON a.id_kategori = b.id_kategori						
						INNER JOIN tbl_brand d
							ON a.id_brand = d.id_brand
						WHERE a.id_kategori='$id_kategori' AND status_barang='1' AND
						a.harga_coret > a.harga_barang AND a.harga_coret <>0 LIMIT 2
						
					");
$hit_q= mysqli_num_rows($q);
			
					$z 	= 0;
					$y	= 0; 
					while($data = $q_2->fetch_object())
					{
						
						$y++;
						
						
						if($y %2==0)
						{
							$div_clear =  '<div class="clearfix visible-xs" ></div>';	
							
						}else{
							$div_clear = "";
							
						}
						if($y %4==0)
						{					
							$div_clear =  "<div style='clear:both;'></div>";					
						}else{
							$div_clear = "";
							
						}
						
						if(($data->harga_coret > $data->harga_barang) && ($data->harga_coret !==0))
					{	
						
						$diskon = '<span class="btn btn-xs btn-danger" id="offernya"><small>'.diskon($data->harga_coret,$data->harga_barang).'</small></span><br>';
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
					
					echo '<div class="col-xs-6 col-sm-6 nopadding product_grid ">						
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
</div>	
<!-------------------------------------end style-------------------------------------------------------->

