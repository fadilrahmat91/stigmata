<div id="loading" style="position:fixed; top:50%; left:45%; display:none;z-index:99999999;"><img src="<?php echo $alamat?>img/bigLoader.gif"></div>


<!--bootstrap-->		 
	<!--<nav id="myNavbar" class="navbar navbar-default navbar-pink  navbar-fixed-top" role="navigation">-->
		<!--<nav id="myNavbar" class="navbar navbar-default navbar-pink navbar-static-top" role="navigation">-->
		<div class="container" style="padding:0px">
		<nav id="myNavbar" class="navbar navbar-inverse  navbar-static-top" role="navigation">
       
		
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href='<?php echo $alamat?>' title="home"><span class="glyphicon glyphicon-home"></span></a>
			
            </div>
			
			
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse birunya" id="bs-example-navbar-collapse-1">
			
			
						
				
				
				
				<ul class="nav navbar-nav">
					<!--
                    <li class="dropdown" id="Categories_m">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">Categories <b class="caret"></b></a>
						<ul class="dropdown-menu">
						
						 <?php
							$q = $db->query("SELECT * FROM tbl_kategori WHERE nama_kategori<> ''");
							while($data = $q->fetch_object())
							{
								echo "<li><a href='".link_kategori($data->id_kategori,$data->nama_kategori)."'>$data->nama_kategori</a></li>";
								
							}
						
						?>
						</ul>
						
						
						
					</li>
					-->
					
					
					
					<li class="dropdown mega-dropdown " id="Categories">
						  
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Kategori
									<b class="caret"></b>
							</a>
						  
						  <ul class="dropdown-menu mega-dropdown-menu row ">
						  
							<?php
								$q = $db->query("SELECT * FROM tbl_kategori WHERE nama_kategori<> ''");
								$no=0;
								while($data = $q->fetch_object())
								{									
									$no++;
									echo '<li class="col-sm-3">
											  <ul>
												<li class="dropdown-header"><a href="'.link_kategori($data->id_kategori,$data->nama_kategori).'">'.$data->nama_kategori.' </a></li>';
													
												$qq = $db->query("SELECT * FROM tbl_sub_kategori WHERE id_kategori= '$data->id_kategori'");
												while($sub = $qq->fetch_object())
												{
													echo '<li><a href="'.link_sub_kategori($sub->id_sub_kategori,$sub->nama_sub_kategori).'">'.$sub->nama_sub_kategori.'</a></li>';
												
												}
												//echo'<a style="margin-left:20px;" href="'.link_kategori($data->id_kategori,$data->nama_kategori).'"><small>more &rarr;</small></a>';
												echo'<li class="divider"></li>';
									echo 	 '</ul>
											</li>';
									
									if($no %4==0)
									{
										echo"<div style='clear:both'></div>";
									}
									
								}
							
							?>
							
						  </ul>
						  
						</li>
					
					
						 
                   
				</ul>
				
				
						
				
                <ul class="nav navbar-nav">	
                   <?php
					/*#############################################################  drop down page #########################
					$q = $db->query("SELECT * FROM tbl_page WHERE status='1'");

					while($menu = $q->fetch_object())
					{
						
						if(isset($_GET['page_id']) && $_GET['page_id'] ==$menu->page_id)
						{
							$class_menu = 'active';
						}else{
							$class_menu = '';
						}
						
						$q_sub = $db->query("SELECT * FROM tbl_sub_page WHERE id_page='$menu->page_id' AND status='1'");
						if(mysqli_num_rows($q_sub)>0)
						{
							echo '<li class="dropdown">';							
									echo'<a href="#" data-toggle="dropdown" class="dropdown-toggle">'.$menu->page_judul.' <b class="caret"></b></a>';
										echo'<ul class="dropdown-menu">';
											echo '<li><a href="'.link_page($menu->page_id,$menu->page_judul).'">'.$menu->page_judul.'</a></li>';
											while($menu_sub = $q_sub->fetch_object())
											{
											
												echo "<li><a href='".link_sub_page($menu_sub->id_sub_page,$menu_sub->nama_sub_page)."'>$menu_sub->nama_sub_page</a></li>";
											
											}
										echo'</ul>';
							echo '</li>';
							
						}else{
							echo '<li class="'.$class_menu.'"><a href="'.link_page($menu->page_id,$menu->page_judul).'">'.$menu->page_judul.'</a></li>';
						}
						
						
						
						
						
					}
					#############################################################  drop down page #########################*/
					
					$q = $db->query("SELECT * FROM tbl_page WHERE status='1'");

					while($menu = $q->fetch_object())
					{
						
						
						echo '<li><a href="'.link_page($menu->page_id,$menu->page_judul).'">'.$menu->page_judul.'</a></li>';
						
						
					}
				
					
					?>
					
					
					<li class=""><a href="<?php echo $alamat.menu_link("kontak")?>">Contact</a></li>
					<li class=""><a href="<?php echo $alamat.menu_link("confirmasi")?>">Konfirmasi</a></li>					
					
					
                </ul>
				



					
				
            </div><!-- /.navbar-collapse -->
			
      
		
       
    </nav>
  </div>
        
	
	
<div class="container body_container"><!-- sampai footer-->



	<div class="container row">
		
		<div  class="col-xs-12 col-sm-8 col-lg-8 div_form_cari nopadding" >
			
			<div class="form_cari" >

				<form class="" role="search" action="<?php echo $alamat?>cari.php" id="form_cari">
				
				
					
					
					<div class="col-xs-12 col-lg-12 nopadding" >						
					
					 <div class="input-group cari-group"> 

							<input type="text" class="form-control" placeholder="Search" required name="term" id="srch-term">
						
							<select name="id_kategori_search" class="form-control" data-live-search="true" title="--Kategori--" >
								<option value="">--Kategori--</option>
								<?php 
									$q = $db->query("SELECT * FROM tbl_kategori");
									while($data = $q->fetch_object())
									{
										echo '<option value="'.$data->id_kategori.'">'.$data->nama_kategori.'</option>';
									}
								?>
								</select>
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</span>

						</div>
						<!-- /input-group -->
					
					</div>
					
				
				</form>
			</div>
		</div>
		
		<div  class="col-xs-12 col-sm-3 col-lg-4  text-right div_acount">
			<br>
			
			<?php 
				if(isset($_SESSION['id_pelanggan']))
				{
					echo '<a href="'.link_member().'"><span class="	glyphicon glyphicon-user"></span> '.strtoupper($obj->member($_SESSION['id_pelanggan'])->nama_pelanggan).'</a>';
				}else{
					echo '<a href="#login" id="login_member" data-toggle="modal" data-target="#myModal"><span class="	glyphicon glyphicon-user"></span> Member Login</a>';
				}
				
			
			?>
			
			
		</div>
		
		
			  <!-- Modal -->
			  <div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog modal-sm">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Login Member</h4>
					</div>
					<div class="modal-body">
						<div id="free" class="tab-pane fade in active">
								<h3>Member</h3>
								
								  <form class="form-horizontal" role="form" method="post" id="user_form" action="part/simpan_tambah_bank.php">
								  <input type="hidden" class="form-control" name="login" value="login">
									<div class="form-group">
									  <label class="control-label col-sm-2" for="email_pelanggan">Email:</label>
									  <div class="col-sm-10">
										<input type="email" class="form-control" id="email_pelanggan" name="email_pelanggan" placeholder="Email" required>
									  </div>
									</div>
									
									<div class="form-group">
									  <label class="control-label col-sm-2" for="pass_pelanggan">Pass:</label>
									  <div class="col-sm-10">
										<input type="password" class="form-control" id="pass_pelanggan" name="pass_pelanggan" placeholder="Password"  required>
									  </div>
									</div>
									
									<div class="form-group">        
									  <div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-primary btn-xs">Login</button>
									  </div>
									</div>
								  </form>
						</div>	
							
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
		</div><!--row-->	
		<hr>
	<div style="clear:both;"></div>


<script>
$("#form_cari").submit(function(){
	loading_menu();
	if($("#srch-term").val() ==""){
		$("#srch-term").focus();
		
		loading_menu_hide();
		return false;
	}
		
});

</script>

						
	<div id="t4_load_js"><!--sampe footer-->
	