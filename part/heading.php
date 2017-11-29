<style>
.top-kosong{
	margin-top:60px;
}
</style>
  <div id="t4_keranjang" ></div>		
  <script>  
	load_keranjang();
  </script>
 

<div class="top-kosong"></div>



	<div class="container logo">	
		
		
		
		<div style="clear:both">
			<?php
				if($obj->banner()->	url_link_b4 =="")
				{
					echo '<img src="'.$obj->banner()->url_banner_b4.'"  class="gambar_banner_atas_slide">';
				}else{
					echo '<a href="'.$obj->banner()->url_link_b4.'"><img src="'.$obj->banner()->url_banner_b4.'"  class="gambar_banner_atas_slide"></a>';
				}
			?>
			</div>
		
					 

		
	</div>

<script>
$("#user_form").submit(function(){
	
	$.post("<?php echo $alamat?>part/isi_login.php",$(this).serialize(),function(e){		
			
			//alert(e);
			if(e=='success')
			{
				
				$("#info_login").html("<b>Berhasil!</b> Mohon tunggu sebentar...").fadeIn().delay(5000).fadeOut();				
				$('#myModal').modal('toggle');
				window.location = "<?php echo link_member()?>";
				
			}else{
				$("#info_login").html("<b>Gagal!</b> Email atau passowrd salah...").fadeIn().delay(5000).fadeOut();
			}


			
		});
	
return false;
});
$("#vip_form").submit(function(){
	
$.post("<?php echo $alamat?>part/isi_login.php",$(this).serialize(),function(e){		
			
			//alert(e);
			if(e=='success')
			{
				
				$("#info_login").html("<b>Berhasil!</b> Mohon tunggu sebentar...").fadeIn().delay(5000).fadeOut();				
				$('#myModal').modal('toggle');
				window.location = "<?php echo link_member()?>";
				
			}else{
				$("#info_login").html("<b>Gagal!</b> Code Uniq salah...").fadeIn().delay(5000).fadeOut();
			}


			
		});
	
return false;
});
</script>

