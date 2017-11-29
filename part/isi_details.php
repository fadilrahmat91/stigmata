		<!--
		<div class="label label-info">    	
			<small><a href="<?php echo $alamat?>">Home</a> > <a href="<?php echo link_kategori($details_product->id_kategori,$details_product->nama_kategori)?>"><?php echo $details_product->nama_kategori?></a> > <a href="<?php echo link_brand($details_product->id_brand,$details_product->nama_brand)?>"><?php echo $details_product->nama_brand?></a> </small>    	    
    	</div>
		-->
		<div class="clear"></div>
			<div class="row">
				
			
				
				<div class="col-sm-6" id="zoom-left">
				<ul class="list-group list-group-flush text-center" id="list_harga">
					<li class="list-group-item"><i class="icon-ok text-success"></i>
						<h2><?php echo $details_product->nama_barang?></h2>
					</li>
					<li class="list-group-item"><i class="icon-ok text-success"></i>
						<?php echo $details_product->garansi_barang?>
					</li>					
					<li class="list-group-item "><i class="icon-ok text-success"></i>
						<?php
							if(($details_product->harga_coret > $details_product->harga_barang) && ($details_product->harga_coret !==0))
							{
								
								
						?>
								<span class="btn btn-danger"><?php echo diskon($details_product->harga_coret,$details_product->harga_barang)?></span>
								<p ><span><h2><s>Rp.<?php echo rupiah($details_product->harga_coret)?></s></h2></span></p>
								<p>Harga Spesial: <br>
										<h1>Rp.<?php echo rupiah($details_product->harga_barang)?></h1>
								</p>
						<?php
							}else{
						?>
						<h1>Rp.<?php echo rupiah($details_product->harga_barang)?></h1>
						<?php		
							}
						?>
						</li>
						<li class="list-group-item "><i class="icon-ok text-success"></i>
							<a class="btn btn-warning btn-block" href="" id="btn_beli_sekarang">Beli Sekarang &rarr;</a>
						</li>
				
				 <li class="list-group-item "><i class="icon-ok text-success"></i>
					<span id="stok_barang">Stok: <?php echo $details_product->stok_barang?> </span>
					</li>
				<li class="list-group-item "><i class="icon-ok text-success"></i>

				 Tag :
				 <?php
					$kat = explode(",",$details_product->id_kategori);
					$kategori ='';
					foreach($kat as $id_kategori)
					{
						$q = $db->query("SELECT * FROM tbl_kategori WHERE FIND_IN_SET($id_kategori,id_kategori)")->fetch_object();
						$kategori .="<a class='btn btn-info btn-xs' href='".link_kategori($q->id_kategori, $q->nama_kategori)."'>";
						$kategori .=$q->nama_kategori;						
						$kategori .="</a>";
						
						
						
					}
					
						$kategori .="<a class='btn btn-info btn-xs' href='".link_brand($details_product->id_brand, $details_product->nama_brand)."'>";
						$kategori .=$details_product->nama_brand;						
						$kategori .="</a>";
					
					echo $kategori;
				 ?>
				 	
				 </li>
			</div>
			
			
			<div class="col-sm-6 " >
					
					<?php
							#-------------------gambar array----------------------#
							$img = $obj->gambarArray($_GET['id_barang']);
							if (is_null($img[1])) 
							{
								$img_2 = no_image();
							}else{
								$img_2 = $img[1];
							}							
					
					?>
					
					
							<div id="myCarousel" class="carousel slide">
								<!-- main slider carousel items -->
								<div class="carousel-inner">
									<?php
										$i=0;
										foreach($img as $thumb)						
										{
											$act = $i==0 ? 'active':'';
											
											echo'	<div class="'.$act.' item" data-slide-number="'.$i.'">
														<img src="'.$thumb.'" class="img-responsive" id="img_large">
													</div>	
											';
											$i++;
										}
									
									?>
																	
									
								</div>
							</div>
				
					
					
							
							<ul class="list-inline text-center">
							<?php
								$i=0;
								foreach($img as $thumb)						
								{
									
									echo'	<li>
											 <a id="carousel-selector-'.$i.'">
												<img src="'.ambil_thumbs($thumb).'" class="img-thumbnail img-responsive thumb_details">
											 </a>
											</li>
									';
									$i++;
								}
							
							?>
							 </ul>
					 
					
					<!-- Trigger the modal with a button -->
						<!--<h6><a href="#" data-toggle="modal" data-target="#product_image" class="label label-danger ">Full Zoom (+)</a></h6>-->
					<!-- Trigger the modal with a button -->
							
						
						

							<!-- Modal -->
							<div id="product_image" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm" style="width:60%;min-height:100%;max-height:100%">
							
							<!-- Modal content-->
							<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><?php echo $details_product->nama_barang?></h4>
							</div>
							<div class="modal-body">
									
									
									<!--content-->
										<img src="" id="content_modalnya" alt="<?php echo $details_product->nama_barang?>" style="width:100%; height:auto" />
									<!-- content-->
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							</div>

							</div>
							</div>
							<!-- Modal -->
							
							
													
							<script>
							$('#myCarousel').carousel({
							interval: 4000
							});

							// handles the carousel thumbnails
							$('[id^=carousel-selector-]').click( function(){
							  var id_selector = $(this).attr("id");
							  var id = id_selector.substr(id_selector.length -1);
							  id = parseInt(id);
							  $('#myCarousel').carousel(id);
							  $('[id^=carousel-selector-]').removeClass('selected');
							  $(this).addClass('selected');
							});

							// when the carousel slides, auto update
							$('#myCarousel').on('slid', function (e) {
							  var id = $('.item.active').data('slide-number');
							  id = parseInt(id);
							  $('[id^=carousel-selector-]').removeClass('selected');
							  $('[id=carousel-selector-'+id+']').addClass('selected');
							});
							
							$('#myCarousel').bind('mousewheel', function(e){
								if(e.originalEvent.wheelDelta /120 > 0) {
									$(this).carousel('prev');
								}
								else{
								   $(this).carousel('next'); 
								}
							});
							
							
							$("#myCarousel #img_large").on("click",function(e){
								//alert($(this).attr("src"));
								$('#product_image').modal('show');
								$('#product_image #content_modalnya').attr('src',$(this).attr("src"));
							});
							
							
							</script>
							<style>						
							.carousel-control.left, .carousel-control.right {
								background-image: none
							}
							</style>						
													
													
							
							
							

				</div>
				
			
			</div>
			
			<div style="clear:both"></div>
		  <br>
		  <div class="panel panel-primary">
			
				 <div class="panel-heading">
					<h4>Detail produk "<?php echo $details_product->nama_barang?>"</h4>
				</div>
				
				
				<div class="panel-body">
					<div class="product-desc">
					<div class="product_descnya">
						<?php echo $details_product->deskripsi_barang?>
					</div>
					</div>
			
				
				
				
					<h3 class="alert alert-warning">Spesifikasi </h3>
				
				<div class="clear"></div>
				<table class="table">
					<tr>
						<td colspan="2"><b><?php echo $details_product->nama_barang?></b></td>
						
					</tr>
					<tr>
						<td>Ukuran (cm)</td>
						<td><?php echo $details_product->ukuran_kotor?></td>
					</tr>
					<tr>
						<td>Berat (kg)</td>
						<td><?php echo $details_product->berat_kotor?></td>
					</tr>
					<tr>
						<td>Harga (Rp)</td>
						<td><?php echo rupiah($details_product->harga_barang)?></td>
					</tr>
					<tr>
						<td>SKU</td>
						<td><?php echo $details_product->sku_barang?></td>
					</tr>
					<tr>
						<td>Brand</td>
						<td><?php echo $details_product->nama_brand?></td>
					</tr>
					
					<?php 
						if($details_product->in_paket !=='')
						{
							echo "<td>Paket</td>
								  <td>$details_product->in_paket</td>";
						}
					?>
					
				</table>
				<a class="btn btn-warning btn-block" href="" id="btn_beli_sekarang_bottom">Beli Sekarang &rarr;</a>
			</div>
	 </div>
	 
	 
	 
 
<script>

$("#btn_beli_sekarang,#btn_beli_sekarang_bottom").click(function(){
	loading_menu();
	var target="<?php echo link_kasir($details_product->id_barang,$details_product->harga_barang,$details_product->stok_barang)?>";
	var session_sementara = "<?php echo ($_SESSION['session_sementara'])?>";
	$.get(target,function(e){
		//alert(e);
		
		if(e == "minus_stok")
		{
			$("#stok_barang").fadeOut().fadeIn().fadeOut().fadeIn().css({"font-weight":"bold","color":"red"});
			go_to("btn_beli_sekarang");
			alert("Maaf, stok terbatas..("+$("#stok_barang").html()+")");			
			loading_menu_hide();	
			return false;
		}else{
				
			<?php 
				if(isset($_SESSION['id_pelanggan']))
				{
			?>
					window.location = "<?php echo $alamat?>kasir.php";
			<?php			
				}else{
			?>
				
					$.get("part/isi_kasir.php",{session_sementara:session_sementara},function(event){
						$("#t4_load_js").hide().html(event).fadeIn('2000');
						//alert(event);
					});
					
					window.location = "<?php echo $alamat?>kasir.php";
					
			<?php
				}
			?>	
			
		}
		
	
	});
	
	
	return false;
});


/*
$(function(){
      
      $('#gambar_content').okzoom({
        width: 300,
        height: 300,
        border: "1px solid black",
        shadow: "0 0 5px #000"
		
      });


});
*/

//set ukuran #gambar_content
//var tinggi_list_harga = $("#list_harga").height();
//$("#gambar_content").css({"height":tinggi_list_harga}).addClass("img-responsive img-thumbnail");

</script>

<style>

</style>