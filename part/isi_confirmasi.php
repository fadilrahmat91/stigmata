<?php
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');

if(isset($_GET['id_confirmasi']) && isset($_GET['cek_confirmasi']))
{
	include_once(dirname(__FILE__) . '/part_isi_confirmasi.php');
}else if(isset($_POST['nama_bank']) && isset($_POST['atas_nama_pengirim']))
{
	include_once(dirname(__FILE__) . '/go_confirmasi.php');
}

$limit_waktu = $db->query("SELECT hari FROM tbl_set_waktu_confirm")->fetch_object();
?>    	
 </div>
 <div class="main">
    <div class="content">
    	
    	<div class="section group">
				<div class="product_desc">	
					<div id="horizontalTab">
						<h2>KONFIRMASI PESANAN</h2>
						
						<div class="resp-tabs-container">
							<div class="product-desc " id="form_cek_kode_konfirmasi">
								<div class="alert alert-warning">
									<strong>Peringatan!</strong> Pemesanan dengan Bank Transfer akan otomatis dibatalkan oleh sistem kami jika pembayaran tidak diterima dalam waktu <?php echo $limit_waktu->hari?>x24 jam.
								</div>	
							<form id="konfirmasi_bukti_pesanan" >
								<input type="hidden" name="cek_confirmasi" value="cek_confirmasi">
								
								<div class="form-group">
								  <label class="control-label col-sm-2" for="id_confirmasi">Kode Pemesanan:</label>
								  <div class="col-sm-10">									
									<input type="text" class="form-control" id="id_confirmasi" name="id_confirmasi" REQUIRED placeholder="Masukkan Kode Pemesanan">
									<span class="help-block" id="kat_help">Didapatkan saat belanja di website ini.</span>
								  </div>
								</div>
								
								<div class="form-group">
								  <label class="control-label col-sm-2" for="id_confirmasi"></label>
								  <div class="col-sm-10">
									<input type="submit" class="btn btn-success" value="Cari" name="submit" >
									<span class="help-block" id="kat_help"> </span>
								  </div>
								</div>
								
								
								<!--
								
								<div class="form-group">
								  <label class="control-label col-sm-2" for="nama_bank">Bank Tujuan:</label>
								  <div class="col-sm-10">
									<select name="nama_bank" id="nama_bank" class="form-control">
									<option value="">Pilih Bank
									<?php
									$q = $db->query("SELECT * FROM tbl_bank");
									while($data = $q->fetch_object())
									{
										echo '<option value="">'.$data->nama_bank;
									}
									?>
									
									</select>
									<span class="help-block" id="kat_help">Bank kami yang anda gunakan.</span>
								  </div>
								</div>
								-->
								
							
							</form>
							
						
							
							

						<div id="content_login">
						</div>


						</div>
					
	
					</div>
					
					
					<div class="clear"></div>
					
				 </div>
			 </div>

 		</div>
 	</div>
    </div>
 </div>

 <script>
 $("#konfirmasi_bukti_pesanan").submit(function(){
	
	var target 	= "part/isi_confirmasi.php";
	var value	= $(this).serialize();
	
	$.get(target,value,function(e){
		//alert(e);
		$("#form_cek_kode_konfirmasi").slideUp().html(e).fadeIn();
	});
	
	
	return false;	
 });

 </script>