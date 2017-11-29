
<nav id="myNavbar" class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="hal_reseller.php">Home</a>
                
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  
                    <li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Pemesanan <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#tbl_belanja" id="tbl_belanja">Data Belanja</a></li>
							<li><a href="#form_toko" id="form_toko">Tambah Toko</a></li>
						</ul>
					</li>
					
					
					<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Poin <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#tbl_poin" id="tbl_poin">Data Poin</a></li>
							<li><a href="#harga_poin" id="harga_poin">Harga Poin</a></li>
						</ul>
					</li>
					
					
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo $profilkonsumen->nama_pelanggan?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            
                            <li><a href="#details_pelanggan" id="details_pelanggan">Details</a></li>
                            <li class="divider"></li>
                            <li><a href="part/logout.php">LogOut</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
	
<script>
load_menu_hash("part/tbl_grafik_penjualan_home.php");
load_menu("tbl_belanja","part/tbl_belanja.php");
load_menu("harga_poin","part/harga_poin.php");
load_menu("tbl_poin","part/tbl_poin.php");
load_menu("details_pelanggan","part/details_pelanggan.php");

</script>