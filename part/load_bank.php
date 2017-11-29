<?php
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');

if(isset($_SESSION['session_sementara']))
{
	$session_sementara = $_SESSION['session_sementara'];
}else if(isset($_GET['session_sementara']))
{	

	$session_sementara = ($_GET['session_sementara']);
	
	
}

	if(isset($_GET['id_confirmasi']) && isset($_GET['total']))
	{
		$id_confirmasi 	= $_GET['id_confirmasi'];
		$total			= $_GET['total'];
		
	}
$limit_waktu = $db->query("SELECT hari FROM tbl_set_waktu_confirm")->fetch_object();
?>
<div class="main">
    <div class="content">
    	
    	<div class="section group">
				<div class="product_desc">	
					<div id="horizontalTab">
						<div class="alert alert-success">Selamat! Pesanan Anda akan dikirim!</div>
						
						<div class="resp-tabs-container">
							<div class="product-desc">
							<div class="product_descnya">
								
								<div class="clear"></div>


								<div id="div_left" class="col-xs-6" style="background-color:lavender;">
									<b>Simpan kode pemesanan:</b>
									<div class="label label-warning"><b><?php echo $id_confirmasi?></b></div>
									
									<span>Untuk cek order status</span>
								</div>	
									
								<div id="div_left" class="col-xs-6" style="background-color:lavenderblush;">
									<b>Transfer Dana Sebesar:</b>
									<div class="label label-info">RP.<b><?php echo rupiah($total)?></b></div>
									
								</div>	
								
							<div class="alert alert-danger">
								Kami telah menerima pemesanan anda.
								<strong>Peringatan!</strong> Pemesanan dengan Bank Transfer akan otomatis dibatalkan oleh sistem kami jika pembayaran tidak diterima dalam waktu <?php echo $limit_waktu->hari?>x24 jam.
							</div>
							
							<div class="alert alert-warning">								
								Jika anda menggunakan ATM non-tunai, e-banking atau m-banking, jangan lupa masukkan Kode Pesanan: <b><?php echo $id_confirmasi?></b> pada kolom berita.
							</div>
								
								<div class="clear"></div>
								<br><br>
							<div class="alert alert-warning text-center">
								<a href="<?php echo $alamat.menu_link("confirmasi")?>" class="btn btn-success">Konfirmasi &rarr;</a>
							</div>
								<br><br>
							</div>
							</div>
						
						
					
					</div>
					
				
					<div class="clear"></div>
					
				 </div>
			 </div>

 		</div>
 	</div>
    </div>
	
<style>
#div_left{
	padding-top:10px;
	height:150px;
	
}
</style>