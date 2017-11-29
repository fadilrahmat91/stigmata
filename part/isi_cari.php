<?php
$term = mysqli_real_escape_string($db,$_GET['term']);
?>
	<div class="label label-info">    		
    		<small><a href="<?php echo $alamat?>">Home</a> > <a href='<?php echo link_cari($term)?>'><?php echo anti_inject(buang_single_quote(mysqli_real_escape_string($db,$term)))?></a> </small>
    	    
    	</div>	     
		 
		 
		 

<?php
if($_GET['id_kategori_search']=='')
{
$q = $db->query("SELECT a.*,
							 b.nama_kategori,							 
							 c.nama_sub_kategori,							 
							 d.nama_brand										
						FROM tbl_barang a
						INNER JOIN tbl_kategori b
							ON a.id_kategori = b.id_kategori
						INNER JOIN tbl_brand d
							ON a.id_brand = d.id_brand
						INNER JOIN tbl_sub_kategori c
							ON a.id_sub_kategori = c.id_sub_kategori
						WHERE 
							a.nama_barang LIKE '%$term%' 
							OR
							a.harga_barang LIKE '%$term%' 
							OR
							b.nama_kategori LIKE '%$term%'							
							OR
							c.nama_sub_kategori LIKE '%$term%'
							OR
							d.nama_brand LIKE '%$term%'
							OR
							a.deskripsi_barang LIKE '%$term%'
						AND status_barang='1'
						ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC 

					");
}else{
$id_kategori = $_GET['id_kategori_search'];

$q = $db->query("SELECT a.*,
							 b.nama_kategori,							 
							 c.nama_sub_kategori,							 
							 d.nama_brand										
						FROM tbl_barang a
						INNER JOIN tbl_kategori b
							ON a.id_kategori = b.id_kategori
						INNER JOIN tbl_brand d
							ON a.id_brand = d.id_brand
						INNER JOIN tbl_sub_kategori c
							ON a.id_sub_kategori = c.id_sub_kategori
						WHERE 
							a.nama_barang LIKE '%$term%' AND a.id_kategori='$id_kategori'
							OR
							a.harga_barang LIKE '%$term%' AND a.id_kategori='$id_kategori'
							OR
							b.nama_kategori LIKE '%$term%'	AND a.id_kategori='$id_kategori'						
							OR
							c.nama_sub_kategori LIKE '%$term%' AND a.id_kategori='$id_kategori'
							OR
							d.nama_brand LIKE '%$term%' AND a.id_kategori='$id_kategori'
							OR
							a.deskripsi_barang LIKE '%$term%' AND a.id_kategori='$id_kategori'
						AND status_barang='1' 
						ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC 

					");
}					
				
	$hit_term = mysqli_num_rows($q);
	?>
	
	
	
	<div class="alert alert-info">Search result:<?php echo $hit_term?> </div>
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
						<a href="'.link_detail($data->id_barang,$data->nama_kategori,$data->nama_barang).'">
					  ';		
				
					
						echo'
							<div class="image">
								
									<input type="hidden" id="gbr2" value="'.$img_2.'">
									<input type="hidden" id="gbr1" value="'.$img[0].'">
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
			
	
			<div style='clear:both;'></div>
			
			</div>
			
			
			