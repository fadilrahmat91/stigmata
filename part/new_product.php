<?php 
 $q = $db->query("SELECT    a.*,
							b.nama_kategori,							
							d.nama_brand										
						FROM tbl_barang a
						INNER JOIN tbl_kategori b
							ON a.id_kategori = b.id_kategori						
						INNER JOIN tbl_brand d
							ON a.id_brand = d.id_brand
						WHERE status_barang='1'
						ORDER BY a.id_barang DESC LIMIT 8
					");
?>

    	
    	
    		<div class="alert alert-info">New Product</div>
			
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
				
				echo '<div class="col-xs-6 col-sm-3 nopadding product_grid ">						
						<a href="'.link_detail($data->id_barang,$data->nama_kategori,$data->nama_barang).'">
							<div class="image">
								
									<center><img src="'.ambil_thumbs($data->url_images).'" alt="" class="gambar_product img-responsive" /></center>
								
							
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
			
			</div>
			<div style='clear:both;'></div>
			
		
		<!--load more product-->
		<br><br>
		<div class="row container" id="grid_produk">
			<div id="get_data"></div>
		</div>
		<div style='clear:both;'></div>
		
<button id="show_more" class="btn btn-block btn-primary">Show more..</button>
<script>

var current_page = 3;
var fetch_lock = false;
var fetch_page = function() {  
	loading_menu();
    $.get('part/new_product_ajax.php', {page_index: current_page, page_size: 4}, function(data) {        
        current_page += 1;
			
		if(data.length === 0)
		{			      
			$("#show_more").fadeOut();
			loading_menu_hide();
		} else {
			$("#get_data").append(data);
			
			loading_menu_hide();
			
		}
		
		
    });
}


$(function() {

    fetch_page();

    // 2. on scroll to bottom
  
	
	$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
           fetch_page();
		}
	});

    // 3. on the `more` tag clicked.
    $('#show_more').click(function(){
		 fetch_page();
	});

});

</script>