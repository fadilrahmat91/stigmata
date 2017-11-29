<?php
	$id_sub_kategori = mysqli_real_escape_string($db,$_GET['id_sub_kategori']);	 
	$sub_kategori = $db->query("SELECT a.*,b.* FROM tbl_sub_kategori a INNER JOIN tbl_kategori b ON a.id_kategori=b.id_kategori WHERE id_sub_kategori='$id_sub_kategori'")->fetch_object();
?>

    		<div class="label label-info">
				<a href="<?php echo $alamat?>">Home</a> > 
					<a href='<?php echo link_kategori($sub_kategori->id_kategori,$sub_kategori->nama_kategori)?>'><?php echo $sub_kategori->nama_kategori?></a> >
					<a href='<?php echo link_sub_kategori($sub_kategori->id_sub_kategori,$sub_kategori->nama_sub_kategori)?>'><?php echo $sub_kategori->nama_sub_kategori?></a> 
			</div>
    		
<?php 
$q = $db->query("SELECT a.*,
							b.nama_sub_kategori,										
							c.nama_kategori,										
							d.nama_sub_kategori										
						FROM tbl_barang a
						INNER JOIN tbl_sub_kategori b
							ON a.id_sub_kategori = b.id_sub_kategori	
						INNER JOIN tbl_kategori c
							ON a.id_kategori = c.id_kategori									
						INNER JOIN tbl_sub_kategori d
							ON a.id_sub_kategori = d.id_sub_kategori
						WHERE a.id_sub_kategori='$id_sub_kategori' AND status_barang='1'				
						ORDER BY a.id_barang DESC LIMIT 4
						
					");
?>

	
<div class="judul_kat_besar alert alert-info text-center">
	<b><?php echo $sub_kategori->nama_sub_kategori?></b>
</div>
	<div class='col-xs-6 nopadding'>
		<img src='<?php echo $sub_kategori->url_img_kategori?>' width="100%">
	</div>
	<div class='col-xs-6'>
		<h1><?php 	echo $sub_kategori->nama_sub_kategori?></h1>
		<p>			
			<?php 	echo $sub_kategori->desc_sub_kategori?>
		</p>
	</div>
	<div class="clear"></div>
	<div class="alert alert-info "><b>Product <?php echo $sub_kategori->nama_sub_kategori?></b></div>
	
	
	
	
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
						<a href="'.link_detail($data->id_barang,$data->nama_sub_kategori,$data->nama_barang).'">
					  ';		
				
					
						echo'
							<div class="image">
								
									<input type="hidden" id="gbr2" value="'.$img_2.'">
									<input type="hidden" id="gbr1" value="'.$img[0].'">
									<center><img src="'.$img[0].'" alt="" class="gambar_product img-responsive" /></center>
								
							
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
			<div id="get_data_sub_kategori"></div>
		</div>
		<div style='clear:both;'></div>
		
<button id="show_more_sub_kategori" class="btn btn-block btn-primary">Show more..</button>

<script>


var current_page_sub_kategori = 2;
var fetch_page_sub_kategori = function() {  
	loading_menu();
    $.get('part/isi_sub_kategori_ajax.php', {page_index: current_page_sub_kategori, id_sub_kategori:'<?php echo $id_sub_kategori?>', page_size: 4}, function(data) {        
        current_page_sub_kategori += 1;
			
		if(data.length === 0)
		{			      
			$("#show_more_sub_kategori").fadeOut();
			loading_menu_hide();
		} else {
			$("#get_data_sub_kategori").append(data);
			
			loading_menu_hide();
			
		}
		
		
    });
}


$(function() {

    fetch_page_sub_kategori();

    // 2. on scroll to bottom
  
	
	$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
           //fetch_page_sub_kategori();
		}
	});

    // 3. on the `more` tag clicked.
    $('#show_more_sub_kategori').click(function(){
		 fetch_page_sub_kategori();
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
			
