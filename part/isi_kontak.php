

 
 <!-- content -->
 
 
	<br>
	
	<br>
<div class="container col-xs-10">
		
 <div class="panel panel-primary panel-transparent">
  <div class="panel-heading">
    
	<h2 class="panel-title">Contact Form</h2>
  </div>
  <div class="panel-body">
  
  
				
			 
			 <div id="toogle_main_form">
				
				  <div class="wrapper">
					
				  </div>
				  <div class="box1">
					<div class="wrapper">
					  <article class="col1">
					   
							
							<h3>Silahkan Hubungi Kami melalui Form Kontak dibawah ini.</h3>
						  <form id="ContactForm" action="part/go_kontak.php" method="post">
						  <div id="pemberitahuan"></div>
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="Name">Name*</label>
							  <div class="col-sm-10">
								<input type="text" class="form-control" name="Name" required> 
								<span class="help-block" id="name_help">Kategori harus diisi.</span>
							  </div>
							</div>
								
							<div class="form-group">
							  <label class="control-label col-sm-2" for="Email">Email*</label>
							  <div class="col-sm-10">
								<input type="email" class="form-control"name="Email" required> <span id="email_notif"></span>
								<span class="help-block" id="name_help">Email harus diisi.</span>
							  </div>
							</div>
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="Message">Message*</label>
							  <div class="col-sm-10">
								<textarea  class="form-control" id="textarea" name="Message" required></textarea> 
								<span class="help-block" id="name_help">Message harus diisi.</span>
							  </div>
							</div>
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="Sekurity">Sekurity*</label>
							  <div class="col-sm-10">
							  <span style="color:#808080;">
														<span style="font-size: 24px;">
													
															<span style="font-family: comic sans ms,cursive;">
																<strong>
																	<span style="background-color:#e6e6fa;" ><?php echo $_SESSION['randomnya'] ;?></span> 
																</strong>
															</span>
														</span>
													</span>
												
								
									<input name="captcha" type="text" class="form-control" size="10" id="captcha" required /> <span id="captcha_span"></span>
									<input name="captcha_dapat" type="hidden" value="<?php echo $_SESSION['randomnya'] ;?>" size="10"  /> 
							
								<span class="help-block" id="name_help">Sekurity harus diisi.</span>
							  </div>
							</div>
							
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="Message"></label>
							  <div class="col-sm-10">
								<input type="submit" name="submit" class="btn btn-success" value="Send"></span></span><span><span><input type="reset" name="reset" class="btn btn-danger" value="Clear">
								
							  </div>
							</div>
							
							 
						  </form>
					  </article>
					  
					  
					  
					</div>
				  </div>
				</div>
  
  
  
  </div>
</div>
 <br>
 <br>
 <br>
    <!-- content -->
</div>
<?php $url = $alamat.menu_link("kontak");?>
<script>

	$('#ContactForm').submit(function() {
		var urlnya = $(this).attr('action');
		var datanya = $(this).serialize();
		
		$("#captcha_span").hide(0);
		$("#pemberitahuan").hide(0);
		//alert('asas');
		
		$.ajax({
			type: 'POST',
			url: urlnya,
			data: datanya,
			success: function(e) {
			//alert(e);
			if(e ==1)
			{
				var notif = "<font color='red'>Captcha Salah..</font>";
				$("#captcha_span").fadeIn();
				$("#captcha_span").html("<b><font color=red><span class='glyphicon glyphicon-remove'></span></font></b>");
				
				
			}else if(e ==2)
			{
				var notif = "<font color='green'>Terimakasih.. atas kontak yang anda berikan, tim kami akan segera memproses. Terimakasih.</font>";
				setTimeout("document.location.href='<?php echo $url;?>'",5000);
				
			}else{
				
				var notif = e;
				
			}
			
				$("#pemberitahuan").fadeIn('1000');
				//$("#pemberitahuan_login").html(notif+"-"+e);
				$("#pemberitahuan").html(notif);
				
			}
		});
		
		return false;
	});	
</script>