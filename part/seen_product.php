<?php 
 $id_kategori 	= $details_product->id_kategori;
 
 $id_barang		= $details_product->id_barang;
 $session_seen = $_SESSION['session_sementara'];
 $q = $db->query("SELECT a.id_barang,b.*,
							c.nama_kategori,							
							e.nama_brand	
							FROM tbl_session_seen a
							INNER JOIN tbl_barang b
							ON a.id_barang=b.id_barang
								INNER JOIN tbl_kategori c
								ON b.id_kategori = c.id_kategori							
								INNER JOIN tbl_brand e
									ON b.id_brand = e.id_brand
							WHERE a.session_sementara='$session_seen' AND a.id_barang <> '$id_barang' AND status_barang='1'
							GROUP BY a.id_barang 
							ORDER BY a.id_seen DESC
							LIMIT 4
							");
?>

    	
   
		
		    		<div class="shape_button">Produk yang sudah dilihat</div>
        		
    	
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