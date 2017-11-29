<div class="alert alert-warning">Promo</div>
<div class="container row" id="div_promo_land">
<?php 
$q_kat = $db->query("SELECT   a.nama_kategori,
							  a.id_kategori,
							  a.url_img_kategori
							FROM tbl_kategori a
							INNER JOIN tbl_barang b
								ON a.id_kategori = b.id_kategori
							WHERE a.url_img_kategori <>'' AND b.harga_coret > b.harga_barang AND b.harga_coret <>0
							GROUP BY a.nama_kategori DESC LIMIT 2
					");
					
	$y = 0;				
while($get_kat = $q_kat->fetch_object()){
	$y++;
	$id_kat = $get_kat->id_kategori;

	$q = $db->query("SELECT  
							  b.id_barang,
							  b.nama_barang,
							  b.harga_barang,
							  b.harga_coret,
							  b.url_images
						FROM tbl_barang b							
						WHERE b.id_kategori='$id_kat' AND b.harga_coret > b.harga_barang AND b.harga_coret <>0 LIMIT 2
					");

	if($y %2 ==0)
	{
		$warna = "#fff";
	}else{
		$warna = "#fff";
	}
   echo '<div class="header_grid">';	
   echo '<div class="col-sm-6 nopadding product_grid_khusus" style="background:'.$warna.'" id="land_promo">
   
			<a href="'.link_kategori($get_kat->id_kategori,$get_kat->nama_kategori).'"><img src="'.$get_kat->url_img_kategori.'" class="img-responsive"></a>
   
		 </div>';
   
   echo '<div class="col-sm-6  product_grid_khusus" style="background:'.$warna.'" id="item_land_promo">';
      
    		
		echo '<div class="row" id="grid_produk">';
			
			$i 	= 0;
			$a	= 0; 
			while($data = $q->fetch_object())
			{
				
				$a++;				
				//mobile kebawah
				if($a %2==0)
				{
					$div_clear =  '<div class="clearfix visible-xs" ></div>';	
					
					
				}else{
					$div_clear = "";
					
				}
				//4kebawah
				if($a %4==0)
				{					
					$div_clear =  "<div style='clear:both;'></div> ";					
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
					$harga  = 'Rp.'.rupiah($data->harga_barang);
				}
				
				
				echo '<div class="col-xs-6 col-sm-6 nopadding product_grid_khusus_colom ">						
						<a href="'.link_detail($data->id_barang,$get_kat->nama_kategori,$data->nama_barang).'">
							<div class="image" style="background:'.$warna.'">
								
									<center><img src="'.ambil_thumbs($data->url_images).'" alt="" class="gambar_product_khusus img-responsive" /></center>
								
							
							</div>	 

							
								'.$harga.$judulnya.'
							
							</li>
						</a>	
						
						
					</div>						
						 
						 '.$div_clear;
					
				
			}

	
	echo"</div>";
	echo"</div>";
	echo"</div> <div style='clear:both;'></div>";
	
	
	
} //kategori			
?>
			
</div>			
			<div style='clear:both;'></div>
			
			<br><br>
			
<script>

if(!isMobile)
{
	var item_land_promo_height = $("#item_land_promo").height();
	$("#div_promo_land #land_promo img").css({"height":item_land_promo_height});

}else{
$("#div_promo_land #land_promo img").css({"height":"70px"});
}
</script>