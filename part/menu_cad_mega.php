<div id="loading" style="position:fixed; top:50%; left:45%; display:none;z-index:99999999;"><img src="<?php echo $alamat?>img/bigLoader.gif"></div>


	<div class="container">	
		<a href="<?php echo $alamat?>"><img style="height:60px; margin-top:-40px;"  src="<?php echo $alamat?>img/logo_homesmart.png" alt="" /></a>	
	</div>



<!--bootstrap-->		 
	<!--<nav id="myNavbar" class="navbar navbar-default navbar-pink  navbar-fixed-top" role="navigation">-->
		<nav id="myNavbar" class="navbar navbar-default navbar-pink" role="navigation">
       
		
		<div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
			
            </div>
			
			
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse birunya" id="bs-example-navbar-collapse-1">
			
			
				
			
						
				
				
				
				<ul class="nav navbar-nav">
				
                    <li class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">Kategori <b class="caret"></b></a>
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
					
                   
				</ul>
				
				
                <ul class="nav navbar-nav">	
                   <?php
				
					$q = $db->query("SELECT * FROM tbl_page WHERE status='1'");

					while($menu = $q->fetch_object())
					{
						
						if(isset($_GET['page_id']) && $_GET['page_id'] ==$menu->page_id)
						{
							$class_menu = 'active';
						}else{
							$class_menu = '';
						}
						echo '<li class="'.$class_menu.'"><a href="'.link_page($menu->page_id,$menu->page_judul).'">'.$menu->page_judul.'</a></li>';
					}
					
					?>
					
                </ul>
				
				
				 <ul class="nav navbar-nav navbar-right">
					<li class=""><a href="<?php echo $alamat.menu_link("confirmasi")?>">Konfirmasi</a></li>
					
				 </ul>
				
					




				<div class="collapse navbar-collapse js-navbar-collapse">
				  <ul class="nav navbar-nav">
					<li class="dropdown mega-dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Collection  <b class="caret"></b></a>

					  <ul class="dropdown-menu mega-dropdown-menu row">
						<li class="col-sm-3">
						  <ul>
							<li class="dropdown-header">New in Stores</li>
							<div id="myCarousel" class="carousel slide" data-ride="carousel">
							  <div class="carousel-inner">
								<div class="item active">
								  <a href="#"><img src="http://placehold.it/254x150/3498db/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 1"></a>
								  <h4><small>Summer dress floral prints</small></h4>
								  <button class="btn btn-primary" type="button">49,99 €</button>
								  <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
								</div>
								<!-- End Item -->
								<div class="item">
								  <a href="#"><img src="http://placehold.it/254x150/ef5e55/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 2"></a>
								  <h4><small>Gold sandals with shiny touch</small></h4>
								  <button class="btn btn-primary" type="button">9,99 €</button>
								  <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
								</div>
								<!-- End Item -->
								<div class="item">
								  <a href="#"><img src="http://placehold.it/254x150/2ecc71/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 3"></a>
								  <h4><small>Denin jacket stamped</small></h4>
								  <button class="btn btn-primary" type="button">49,99 €</button>
								  <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
								</div>
								<!-- End Item -->
							  </div>
							  <!-- End Carousel Inner -->
							</div>
							<!-- /.carousel -->
							<li class="divider"></li>
							<li><a href="#">View all Collection <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
						  </ul>
						</li>
						<li class="col-sm-3">
						  <ul>
							<li class="dropdown-header">Dresses</li>
							<li><a href="#">Unique Features</a></li>
							<li><a href="#">Image Responsive</a></li>
							<li><a href="#">Auto Carousel</a></li>
							<li><a href="#">Newsletter Form</a></li>
							<li><a href="#">Four columns</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Tops</li>
							<li><a href="#">Good Typography</a></li>
						  </ul>
						</li>
						<li class="col-sm-3">
						  <ul>
							<li class="dropdown-header">Jackets</li>
							<li><a href="#">Easy to customize</a></li>
							<li><a href="#">Glyphicons</a></li>
							<li><a href="#">Pull Right Elements</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Pants</li>
							<li><a href="#">Coloured Headers</a></li>
							<li><a href="#">Primary Buttons & Default</a></li>
							<li><a href="#">Calls to action</a></li>
						  </ul>
						</li>
						<li class="col-sm-3">
						  <ul>
							<li class="dropdown-header">Accessories</li>
							<li><a href="#">Default Navbar</a></li>
							<li><a href="#">Lovely Fonts</a></li>
							<li><a href="#">Responsive Dropdown </a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Newsletter</li>
							<form class="form" role="form">
							  <div class="form-group">
								<label class="sr-only" for="email">Email address</label>
								<input type="email" class="form-control" id="email" placeholder="Enter email">
							  </div>
							  <button type="submit" class="btn btn-primary btn-block">Sign in</button>
							</form>
						  </ul>
						</li>
					  </ul>

					</li>
				  </ul>

				</div>
					









					
				
            </div><!-- /.navbar-collapse -->
			
			
			
			
			
			
			
			
			
        </div>
        
		
		
		
		
		
		
		
		
		
		
		
		
		
		
       
    </nav>

<div class="container"><!-- sampai footer-->


						<div class="form_cari">
		
							<form class="" role="search" action="<?php echo $alamat?>cari.php" id="form_cari">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search" required name="term" id="srch-term">
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
							</form>
						</div>
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
	