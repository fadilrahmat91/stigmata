	
</div>	
</div>	

 
 <div style="clear:both;"></div>
 
 
 	<footer class="footer">
	<!--
	<div class="surbcribe_div">
	<div class="container">
		<div class="col-sm-4">
			Dapatkan info Promo kami:<br>
			<form id="email_surb">
				<div class="input-group">
					<input type="email" name="email_surbcribe" id="email_surbcribe" class="form-control" placeholder="Email Surbcribe" required>
					<span class="input-group-btn">
						<input type="submit" class="btn btn-default" id="btn_email_surbcribe" value="Go!">
					</span>
				</div>
				<div class="input-group" id="t4_respon">				
				</div>
			</form>
		</div>
		<div class="col-sm-4">
			
		</div>
		<div class="col-sm-4 text-right">
			<a href="" target="_blank"><img src="<?php echo $alamat?>img/logo_fb.png" class="sosmed_logo"></a>			
			<a href="" target="_blank"><img src="<?php echo $alamat?>img/logo_ig.png" class="sosmed_logo"></a>
				
		</div>
	</div>
 </div>
 -->
	
	
      <div class="container text-center">
        <p class="text-muted">Copyright &copy; 2016  <a href="<?php echo $alamat?>"><?php echo $alamat?></a> All Rights Reserved</p>
      </div>
    </footer>
</body>
</html>


<script>
$("#email_surb").submit(function(){
	//alert();
	$.post("<?php echo $alamat?>/part/go_surbcribe.php",$(this).serialize(),function(e){
		
		//alert(e);
		if(e==1)
		{
			$("#email_surbcribe, #btn_email_surbcribe").attr("disabled","disabled");
			$("#t4_respon").html("Terimakasih atas respon anda, pemberitahuan akan kami kirimkan.")
		}
	
	});	
	return false;
});
</script>