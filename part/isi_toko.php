<?php
	 $id_toko = mysqli_real_escape_string($db,$_GET['id_toko']);
	 
	$toko = $db->query("SELECT id_toko, nama_toko FROM tbl_toko WHERE id_toko='$id_toko'")->fetch_object();
?>

    		<div class="label label-info">
				<a href="<?php echo $alamat?>">Home</a> > <a href='<?php echo link_brand($toko->id_toko,$toko->nama_toko)?>'><?php echo $toko->nama_toko?></a> 
			</div>
    		
<?php 
$q = $db->query("SELECT a.*,
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
						WHERE a.id_toko='$id_toko' AND status_barang='1'
						ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC 
					");
?>
<div class="alert alert-warning"><b><?php echo $toko->nama_toko?></b></div>
    	
			<div class="row container" id="grid_produk">
			<?php 
			$i 	= 0;
			$a	= 0; 
			while($data = $q->fetch_object())
			{
				$i++;
				$a++;
					if($i %2==0)
				{
					//$style ="background-color:lavender;";
					$style ="";
				}
				else{
					//$style ="background-color:lavenderblush;";
					$style ="";
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
				
				echo '<div class="col-xs-6 col-sm-3 nopadding product_grid ">						
						<a href="'.link_detail($data->id_barang,$data->nama_kategori,$data->nama_barang).'">
							<div class="image">
								
									<center><img src="'.$data->url_images.'" alt="" class="gambar_product img-responsive" /></center>
								
							
							</div>	 

							
								'.$harga.$judulnya.'
								
								<div class="btn btn-warning block btn-xs text-center  btn_lihat_detail"><i class="icon-ok text-success"></i> 
									Lihat Detail &rarr;
								</div>
							
						</a>	
						
						
					</div>						
						 
						 '.$div_clear;
						
						
						
				
			}
			
			?>
			
	
			<div style='clear:both;'></div>
			</div>
			<br><br>	
			