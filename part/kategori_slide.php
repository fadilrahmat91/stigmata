

	
<div class="col-sm-6 col-lg-3 col-xs-6 banner_right">
	
		
		<?php
			if($obj->banner()->	url_link_b2 =="")
			{
				echo '<img src="'.$obj->banner()->url_banner_b2.'">';
			}else{
				echo '<a href="'.$obj->banner()->url_link_b2.'"><img src="'.$obj->banner()->url_banner_b2.'"></a>';
			}
		?>

		
		<?php
			if($obj->banner()->	url_link_b3 =="")
			{
				echo '<img src="'.$obj->banner()->url_banner_b3.'">';
			}else{
				echo '<a href="'.$obj->banner()->url_link_b3.'"><img src="'.$obj->banner()->url_banner_b3.'"></a>';
			}
		?>

		
			
</div>															
						
		

<div class="col-sm-6 col-lg-3 col-xs-6 banner_center" >
	<?php
		if($obj->banner()->	url_link_b1 =="")
		{
			echo '<img src="'.$obj->banner()->url_banner_b1.'">';
		}else{
			echo '<a href="'.$obj->banner()->url_link_b1.'"><img src="'.$obj->banner()->url_banner_b1.'"></a>';
		}
	?>

</div>		


<div class="col-sm-12 col-lg-6 col-xs-12" id="slidenya" >

	<div width="100%">
		<?php 
			 $q = $db->query("SELECT a.*,
										b.nama_kategori,										
										d.nama_brand										
									FROM tbl_barang a
									INNER JOIN tbl_kategori b
										ON a.id_kategori = b.id_kategori									
									INNER JOIN tbl_brand d
										ON a.id_brand = d.id_brand
									WHERE status_barang='1' AND featured='1'						
									ORDER BY a.id_barang DESC LIMIT 5
								");
				$hit_q = mysqli_num_rows($q);
			?>
							 
					
										  
						   <div id="myCarousel" class="carousel slide" data-ride="carousel">
							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php		 
			 
									 $no = -1;
									 
									 for($i=0; $i<$hit_q; $i++)
									 {
										$no++;
										 if($no ==0)
										{
											$active = 'active';
										}else{
											$active = '';
										}
											echo '<li data-target="#myCarousel" data-slide-to="'.$no.'" class="'.$active.'"></li>
											';
										 
									 }
								?>
							</ol>

							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox" id="slide_div">
							  
							 <?php
								$no = -1;	
								while($row = $q->fetch_object())
								{
									$no++;
									if($no ==0)
									{
										$active = 'active';
									}else{
										$active = '';
									}
									if(($row->harga_coret > $row->harga_barang) && ($row->harga_coret !==0))
									{
										$diskon = '<span id="offernya">Off '.diskon($row->harga_coret,$row->harga_barang).'</span><br>';
										$coret  =  '<span class="btn btn-xs btn-danger" id="coretnya"><s>Rp. '.rupiah($row->harga_coret).'</s></span><br>';
									}else{
										$diskon = "";
										$coret = "";
									}
									
											$gmr = $db->query("SELECT url_images FROM tbl_images_barang WHERE id_barang='$row->id_barang' AND url_images<>'' LIMIT 1")->fetch_object();
											
											echo
											'<div class="item '.$active.'">
													
													<img id="gambar_slide" class="gambar_slide" src="'.$gmr->url_images.'" alt="'.$row->nama_barang.'" >
													
													<div class="carousel-caption">
														<div class="judulcarousel"><a href="'.link_detail($row->id_barang,$row->nama_kategori,$row->nama_barang).'">'.potong($row->nama_barang,50).'</a></div>  
													  
													  '.$diskon.'
													  '.$coret .'
													  <a id="harga_div" class="btn btn-info" href="'.link_detail($row->id_barang,$row->nama_kategori,$row->nama_barang).'">Rp.'.rupiah($row->harga_barang).'</a>
													
													</div>
											  </div>'
											  ;
											
								}
								
							 ?>
							  

							</div>

							<!-- Left and right controls -->
							<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							  <span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							  <span class="sr-only">Next</span>
							</a>
						  </div>
						</div>
												 
</div>						
				
<!--
<div class="col-sm-3"  id="list_kategori">
	
	 <?php
		$q = $db->query("SELECT a.id_kategori, a.nama_kategori, a.desc_kategori, a.url_img_kategori FROM tbl_kategori a WHERE a.nama_kategori<> '' ORDER BY rand()");
		$jum_row = mysqli_num_rows($q);
		while($data = $q->fetch_object())
		{
			echo "<li class='' title='".$data->url_img_kategori."' id='".$data->desc_kategori."'><a href='".link_kategori($data->id_kategori,$data->nama_kategori)."' class='block'>$data->nama_kategori</a><input type='hidden'  value='".$data->nama_kategori."'></li>";
		}	
	?>
	
	<button id="loadMore" class="btn btn-warning btn-xs">Show More </button>
</div>


<div class="col-sm-3"  id="landing_kategori">
	
</div>						 
-->

								
						
						
<div class="clear bawah_slider"></div>

<script>
/*
$(document).ready(function(){
		
		if(!isMobile)
		{
		setTimeout(
		  function() 
		  {
		   var div_height = $("#slidenya").height();	
			$(".banner_center img").height(div_height);
			$(".banner_right img").height(div_height/2);
			
			$(".banner_center img").width($(".banner_center").width());
			$(".banner_right img").width($(".banner_right").width());
		  }, 2);
		}
});
*/
</script>