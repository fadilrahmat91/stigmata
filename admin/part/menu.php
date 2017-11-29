<nav id="myNavbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<!--<nav id="myNavbar" class="navbar navbar-default" role="navigation">-->
        <!-- Brand and toggle get grouped for better mobile display -->
         <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $alamat?>admin"><?php echo $title?></a>                
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
			 
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
                <ul class="nav navbar-nav navbar-right">
                    
					<!--
                    <li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Toko <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#tbl_toko" id="tbl_toko">Data Toko</a></li>
							<li><a href="#form_toko" id="form_toko">Tambah Toko</a></li>
						</ul>
					</li>
					-->
					
					
					<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Member <span id="t4_notif_newkonsumen"></span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#tbl_pelanggan" id="tbl_pelanggan">Data Member <span id="t4_notif_in_newkonsumen"></a></li>
							<li><a href="#form_pelanggan" id="form_pelanggan">Tambah Member</a></li>
							
						</ul>
					</li>
					
					
					
                    <!--
					<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Reseller <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#tbl_vip_member" id="tbl_vip_member">Data Reseller</a></li>							
						</ul>
					</li>
					
                    
					<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Poin <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#tbl_harga_poin" id="tbl_harga_poin">Harga Poin</a></li>							
							<li><a href="#tbl_ket_poin" id="tbl_ket_poin">Info Poin</a></li>							
						</ul>
					</li>
					
					
					<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Laporan <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#tbl_grafik" id="tbl_grafik">Grafik Product</a></li>							
							<li><a href="#tbl_grafik_penjualan" id="tbl_grafik_penjualan">Grafik Penjualan</a></li>							
							<li><a href="#tbl_grafik_pelanggan" id="tbl_grafik_pelanggan">Grafik Konsumen</a></li>							
						</ul>
					</li>
					-->
                    
                    
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
						Product
						  <span id="t4_notif_newbarang"></span>										
						 <b class="caret"></b></a>
                        <ul class="dropdown-menu">                            
                            <li><a href="#tbl_barang_new" id="tbl_barang_new">New Product<span id="t4_i_notif_newbarang"></span></a></li>
                            <li><a href="#tbl_barang_featured" id="tbl_barang_featured">Featured Product</a></li>
                            <li><a href="#tbl_barang" id="tbl_barang">Data Product</a></li>
							<li class="divider"></li>
							<li><a href="#form_barang" id="form_barang">Tambah Product</a></li>
							<li><a href="#import_product" id="import_product">Import Product</a></li>
							
                        </ul>
                    </li>
					
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
						Kategori
						  <span id="t4_notif_newbarang"></span>										
						 <b class="caret"></b></a>
                        <ul class="dropdown-menu">                                                       
							<li><a href="#tbl_kategori" id="tbl_kategori">Data Kategori</a></li>
							<li><a href="#tbl_sub_kategori" id="tbl_sub_kategori">Sub Kategori</a></li>
							
                        </ul>
                    </li>
						
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
						Brand
						  <span id="t4_notif_newbarang"></span>										
						 <b class="caret"></b></a>
                        <ul class="dropdown-menu">                                                     
							<li><a href="#tbl_brand" id="tbl_brand">Data Brand</a></li>
							
                        </ul>
                    </li>
					
					<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Conf.Pesanan  <span id="t4_notif_newconfirmasi"></span><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                           
                           <li><a href="#tbl_confirmasi_new" id="tbl_confirmasi_new">Pemesanan New <span id="t4_notif_in_newconfirmasi"></span></a></li>							                           
                           <li><a href="#tbl_confirmasi_aproved" id="tbl_confirmasi_aproved">Pemesanan Approved</a></li>							
                           <li><a href="#tbl_confirmasi_rejected" id="tbl_confirmasi_rejected">Pemesanan Rejected</a></li>													   
						   <li class="divider"></li>
						   <li><a href="#tbl_confirmasi" id="tbl_confirmasi">Pemesanan All</a></li>							
						   
                        </ul>
                    </li>
					<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Conf.Bank  <span id="t4_notif_newbankconfrim"></span><b class="caret"></b></a>
                        <ul class="dropdown-menu">
<li><a href="#tbl_confirmasi_bank_new" id="tbl_confirmasi_bank_new">Data Confirmasi Bank New<span id="t4_notif_in_newbankconfrim"></span></a></li>													
						   <li><a href="#tbl_confirmasi_bank" id="tbl_confirmasi_bank">Data Confirmasi Bank All</span></a></li>							
						   
						   
                        </ul>
                    </li>
					<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"> Page Setting<span id="t4_notif_newconfirmasi"></span><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                           <li><a href="#tbl_page" id="tbl_page">Data Page</a></li>							
                           <li><a href="#tbl_sub_page" id="tbl_sub_page">Data Sub Page</a></li>							
							<li class="divider"></li>
                            <li><a href="#form_page" id="form_page">Tambah Page</a></li>							
                        </ul>
                    </li>
					
					<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"> Bank Setting<span id="t4_notif_newconfirmasi"></span><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                           <li><a href="#tbl_bank" id="tbl_bank">Data Bank</a></li>							
							<li class="divider"></li>
                            <li><a href="#form_bank" id="form_bank">Tambah Bank</a></li>							
                        </ul>
                    </li>

					<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"> Kontak<span id="t4_notif_kontak"></span><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                           <li><a href="#tbl_kontak" id="tbl_kontak">Data Kontak</a></li>							
								
                        </ul>
                    </li>
					
					<li class="dropdown">
						<a href="#tbl_banner" id="tbl_banner">Banner</a>						
					</li>
					
					
					 <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Admin <b class="caret"></b></a>
						<?php
							$id_admin = $_SESSION['id_admin'];
							$adm = $db->query("SELECT nama_admin FROM tbl_admin WHERE id_admin ='$id_admin'")->fetch_object();
						?>
                        <ul class="dropdown-menu">                            
                            <li><a href="#" id="ganti_pass"><?php echo $adm->nama_admin?></a></li>
                            <li class="divider"></li>
							<li><a href="<?php echo $alamat?>" target="_blank">Kunjungi Web</a></li>
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
load_menu("tbl_toko","part/tbl_toko.php");
load_menu("tbl_harga_poin","part/tbl_harga_poin.php");
load_menu("tbl_ket_poin","part/tbl_ket_poin.php");
load_menu("tbl_vip_member","part/tbl_vip_member.php");
load_menu("tbl_pelanggan","part/tbl_pelanggan.php");
load_menu("tbl_barang","part/tbl_barang.php");
load_menu("tbl_barang_new","part/tbl_barang.php?tbl_barang_new");
load_menu("tbl_barang_featured","part/tbl_barang.php?tbl_barang_featured");
load_menu("tbl_kategori","part/tbl_kategori.php");
load_menu("tbl_sub_kategori","part/tbl_sub_kategori.php");
load_menu("tbl_brand","part/tbl_brand.php");
load_menu("tbl_confirmasi","part/tbl_confirmasi.php");
load_menu("tbl_confirmasi_bank","part/tbl_confirmasi.php?tbl_confirmasi_bank");
load_menu("tbl_confirmasi_bank_new","part/tbl_confirmasi.php?tbl_confirmasi_bank_new");
load_menu("tbl_confirmasi_aproved","part/tbl_confirmasi.php?tbl_confirmasi_aproved");
load_menu("tbl_confirmasi_rejected","part/tbl_confirmasi.php?tbl_confirmasi_rejected");
load_menu("tbl_confirmasi_new","part/tbl_confirmasi.php?tbl_confirmasi_new");
load_menu("tbl_grafik","part/tbl_grafik.php");
load_menu("tbl_grafik_penjualan","part/tbl_grafik_penjualan.php");
load_menu("tbl_grafik_pelanggan","part/tbl_grafik_pelanggan.php");
load_menu("tbl_page","part/tbl_page.php");
load_menu("tbl_sub_page","part/tbl_sub_page.php");
load_menu("tbl_bank","part/tbl_bank.php");
load_menu("ganti_pass","part/ganti_pass.php");
load_menu("tbl_kontak","part/tbl_kontak.php");
load_menu("tbl_banner","part/tbl_banner.php");
load_menu("import_product","part/import_product.php");

load_menu("form_page","part/form_page.php");
load_menu("form_bank","part/form_bank.php");
load_menu("form_barang","part/form_barang.php");
load_menu("form_pelanggan","part/form_pelanggan.php");
load_menu("form_toko","part/form_toko.php");
notif_function("t4_notif_newbarang","hitNewProduct");
notif_function("t4_i_notif_newbarang","hitNewProduct");
notif_function("t4_notif_newconfirmasi","hitNewConfirmasi");
notif_function("t4_notif_in_newconfirmasi","hitNewConfirmasi");
notif_function("t4_notif_newkonsumen","hitNewKonsumen");
notif_function("t4_notif_in_newkonsumen","hitNewKonsumen");
notif_function("t4_notif_newbankconfrim","hitNewBankConfirmasi");
notif_function("t4_notif_in_newbankconfrim","hitNewBankConfirmasi");
notif_function("t4_notif_kontak","hitNewKontak");


$(document).on('click',function(){
$('.collapse').collapse('hide');
})
</script>