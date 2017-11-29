<?php
if(isset($_SESSION['session_sementara']))
{
	$session_sementara = $_SESSION['session_sementara'];
}else if(isset($_GET['session_sementara']))
{	
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');
	$session_sementara = ($_GET['session_sementara']);
}


if(isset($_GET['multi_barang']) && isset($_GET['id_pelanggan']))
{
	//echo $_GET['id_pelanggan'];
	if(isset($_GET['multi_barang']))
	{
	
	//var_dump($_GET);
	
	
		//must be
		$session_sementara 	= $_GET['session_sementara'];
		$id_pelanggan 		= $_GET['id_pelanggan'];
		$multi_barang 		= $_GET['multi_barang'];
		$multi_qty	 		= $_GET['multi_qty'];
		$total		 		= $_GET['total'];
		
		//alamat_pengiriman
		$nama_pengiriman	= $_GET['nama_pengiriman'];		
		$email_pengiriman	= $_GET['email_pengiriman'];
		$id_confirmasi		= $_GET['id_confirmasi'];
		$telp_pengiriman	= $_GET['telp_pengiriman'];
		$alamat_pengiriman	= $_GET['alamat_pengiriman'];
		
		//tbl_confirmasi
		$tgl_confirmasi	= date("Y-m-d");
		$jam_confirmasi	= date("H:i");
		$code_uniq		= $_GET['code_uniq'];
		$ongkir			= $_GET['ongkir'];
		$id_bank		= $_GET['id_bank'];
		
		
		//alamat pengiriman
		$q = $db->query("SELECT * FROM tbl_pengiriman WHERE id_pelanggan='$id_pelanggan'");		
		
		if(mysqli_num_rows($q)>0)
		{
			$db->query("UPDATE tbl_pengiriman SET
								nama_pengiriman		='$nama_pengiriman',	
								id_confirmasi		='$id_confirmasi',								
								email_pengiriman	='$email_pengiriman',
								telp_pengiriman		='$telp_pengiriman',
								alamat_pengiriman	='$alamat_pengiriman'
							WHERE id_pelanggan='$id_pelanggan';								
						");
		}else{
			$db->query("INSERT INTO tbl_pengiriman SET
								nama_pengiriman		='$nama_pengiriman',	
								id_confirmasi		='$id_confirmasi',								
								email_pengiriman	='$email_pengiriman',
								telp_pengiriman		='$telp_pengiriman',
								alamat_pengiriman	='$alamat_pengiriman',
								id_pelanggan		='$id_pelanggan';								
						");
		}
		
		//product in array
		for($a=0;$a<sizeof($multi_barang);$a++)
		{
			
			if($multi_barang[$a] !='')
			{
					
				//echo "<u>$multi_barang[$a]</u><br>";
				
				$db->query("INSERT INTO tbl_confirmasi SET
											id_pelanggan	= '$id_pelanggan',
											id_barang		= '$multi_barang[$a]',
											qty				= '$multi_qty[$a]',
											id_confirmasi	= '$id_confirmasi',
											tgl_confirmasi	= '$tgl_confirmasi',
											jam_confirmasi	= '$jam_confirmasi',
											id_bank			= '$id_bank',
											ongkir			= '$ongkir',
											code_uniq		= '$code_uniq'
										");
				
				
			}
		}
		

		//hapus keranjang setelah pengiriman ke tbl_confirmasi
		$db->query("DELETE FROM tbl_keranjang WHERE session_sementara='$session_sementara'");
		
		echo '1';
	}
	
	die();
}

$id_pelanggan = $_SESSION['id_pelanggan'];


//tbl_barang
$q = $db->query("SELECT a . * , c.nama_brand, c.id_brand,  e.berat_kotor, e.nama_barang, e.stok_barang, e.harga_barang, e.id_kategori 
					FROM tbl_keranjang a
					INNER JOIN tbl_barang e ON a.id_barang = e.id_barang					
					LEFT JOIN tbl_brand c ON e.id_brand = c.id_brand					
					WHERE a.session_sementara ='$session_sementara'
					ORDER BY e.nama_barang, a.id_keranjang DESC
				");
$hit = mysqli_num_rows($q);				
				
//tbl_pelanggan
$pel = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
							FROM tbl_pelanggan a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
							LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
							LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
							WHERE a.id_pelanggan ='$id_pelanggan'
						 ")->fetch_object();
						 

//tbl_pengiriman						
$pengiriman = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
							FROM tbl_pengiriman a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
							LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
							LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
							WHERE a.id_pelanggan ='$id_pelanggan'
						 ");
$code_uniq = rand(999,3);						 
$cek_tbl_pengiriman = mysqli_num_rows($pengiriman);

if($cek_tbl_pengiriman >0){
	$q_kirim = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
							FROM tbl_pengiriman a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
							LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
							LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
							WHERE a.id_pelanggan ='$id_pelanggan'
						 ");
	
	$data = $q_kirim->fetch_object();
	$nama_pengiriman 	= $data->nama_pengiriman;
	$email_pengiriman 	= $data->email_pengiriman;
	$alamat_pengiriman 	= $data->alamat_pengiriman;
	$telp_pengiriman 	= $data->telp_pengiriman;
	$nama_provinsi	 	= $data->nama_provinsi;
	$id_prov		 	= $data->id_prov;
	$nama_kabupaten		= $data->nama_kabupaten;
	$id_kab		 		= $data->id_kab;
	$nama_kecamatan		= $data->nama_kecamatan;
	$id_kec		 		= $data->id_kec;
	$nama_kelurahan		= $data->nama_kelurahan;
	$id_kel				= $data->id_kel;
	
}else{
	$q_kirim = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
							FROM tbl_pelanggan a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
							LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
							LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
							WHERE a.id_pelanggan ='$id_pelanggan'
						 ");
	$data = $q_kirim->fetch_object();
	$nama_pengiriman 	= $data->nama_pelanggan;
	$email_pengiriman 	= $data->email_pelanggan;
	$alamat_pengiriman 	= $data->alamat_pelanggan;
	$telp_pengiriman 	= $data->telp_pelanggan;
	$nama_provinsi	 	= $data->nama_provinsi;
	$id_prov		 	= $data->id_prov;
	$nama_kabupaten		= $data->nama_kabupaten;
	$id_kab		 		= $data->id_kab;
	$nama_kecamatan		= $data->nama_kecamatan;
	$id_kec		 		= $data->id_kec;
	$nama_kelurahan		= $data->nama_kelurahan;
	$id_kel				= $data->id_kel;
	
}

				
?>    	
 
 <div class="main">
    <div class="content">
    	
    	<div class="section group">
				<div class="product_desc">	
					<div id="horizontalTab">
						
						<form method="get" id="form_pengiriman">
						<input type="hidden" name="id_pelanggan" value="<?php echo $_SESSION['id_pelanggan']?>">
						<input type="hidden" name="id_confirmasi" id="id_confirmasi" value="<?php echo id_confirmasi($_SESSION['id_pelanggan']);?>">
						<input type="hidden" name="code_uniq" id="code_uniq" value="<?php echo $code_uniq?>">
						<input type="hidden" name="session_sementara" value="<?php echo $_SESSION['session_sementara']?>">
						<div class="resp-tabs-container">
							<div class="product-desc">
							<div class="product_descnya">
							<br>
								<div class="list_step text-center">
									<span id="step_1_notif" class="badge badge-notify">1</span> 
										<span class="glyphicon glyphicon-chevron-right"></span>
									<span id="step_2_notif" class="badge badge-notify">2</span> 
										<span class="glyphicon glyphicon-chevron-right"></span>
									<span id="step_3_notif" class="badge badge-notify">3</span>
									
								</div>
								
								
								<!-----------------step 1--------------------->
								
								<div id="step_1">
								<div class="alert alert-info"><b>Daftar Belanja <?php echo $pel->nama_pelanggan?>:</b></div>
								<div style="background-color:lavender;">
								<table class="table" id="tbl_keranjang">
									
									<thead>
										<td>No</td>
										<td>Nama Produk</td>
										<td>Gambar Produk</td>
										<td>Qty</td>
										<td style='text-align:right;'>@ Harga</td>
										<td style='text-align:right;'>Sub Total</td>
										<td width="100px;" style="text-align:right;">Action</td>
									</thead>
									
									<?php
									if($hit ===0)
									{
										echo "<h4>Keranjang belanja anda kosong!</h4>";
									}
										
									
										$no =0;
										$total = 0;
										$total_berat = 0;
										
										$kg ="";
										
										while($data=$q->fetch_object())
										{
										
											$no ++;
											
											$nama_kategori = ambil_nama_kat($db,$data->id_kategori);
											$total_berat += ukuran($data->berat_kotor*$data->qty);
											$total+=($data->harga_barang*$data->qty);
											
											
											
												#-------------------gambar array----------------------#
											$img = $obj->gambarArray($data->id_barang,1);
									
										
											$no ++;
											
											$nama_kategori = ambil_nama_kat($db,$data->id_kategori);
											
											
											
											
											
											echo "
												<tr>
													<td>$no</td>												
													<td><a href='".link_detail($data->id_barang,$nama_kategori,$data->nama_barang)."'>$data->nama_barang</a></td>												
													<td><img src='".ambil_thumbs($img[0])."'></td>												
													<td>";
													?>
													<input type="hidden" id="id_barang"  name='multi_barang[]' value="<?php echo $data->id_barang?>">																							
													<select id='qty' name="multi_qty[]">
														<?php
															for($i=1;$i<= $data->stok_barang;$i++)
															{
																$selected = $data->qty == $i? 'selected="selected"':'';
																echo "<option value='$i' $selected>$i</option>";
															}
														?>
													</select>
													
											<?php		
											echo "	</td>												
													<td style='text-align:right;'>".rupiah($data->harga_barang)."</td>												
													<td style='text-align:right;'>".rupiah($data->harga_barang*$data->qty)."</td>												
													<td style='text-align:right;'><button id='hapus_keranjang' class='$data->id_keranjang btn btn-danger btn-cs'><span class='glyphicon glyphicon-remove'></span></button></td>												
												</tr>
											";
											
											
											$kg .= "($data->berat_kotor x $data->qty) = $total_berat + ";
										}
										
																 
										//harga ongkir
										$ongkir = $db->query("SELECT harga, free_limit FROM tbl_set_ongkir")->fetch_object();
										
										/*
										//jika berat barang lebih.. maka dikenakan biaya kirim //
										if($total_berat > $ongkir->free_limit)
										{
											
											$total_berat_a  = $total_berat-$ongkir->free_limit;
											$ongkos_kirim 	= $total_berat_a*$ongkir->harga;

											
											
											
											if($pel->id_kab == 1271){//gratis medan
												$ongkos_kirim = 0;
											}else{												
												$total_berat_a  = $total_berat-$ongkir->free_limit;
												$ongkos_kirim 	= $total_berat_a*$ongkir->harga;
											}
											
												
												
										}else{
											$ongkos_kirim = 0;
										}
										*/
										
										
										
										
									?>
									<tr>
										<td colspan="5" style="text-align:right;">Ongkir <?php echo rtrim((trim($kg)),"+") ."x ".$ongkir->harga?> = </td>
									<!--<td  style="text-align:right;"><?php echo rupiah($ongkir->harga)?>x<?php echo $total_berat?>=<?php echo rupiah($ongkir->harga)?></td>-->
										<td  style="text-align:right;"><?php echo rupiah($total_berat*$ongkir->harga)?></td>
										<input type="hidden" name="ongkir" id="ongkir" value="<?php echo $total_berat*$ongkir->harga?>">
										<td></td>
									</tr>
									<tr>
										<td colspan="5" style="text-align:right;">Uniq</td>
										<td  style="text-align:right;"><?php echo rupiah($code_uniq)?></td>
										<td></td>
									</tr>
									<tfoot>
										<th colspan="5" style="text-align:right;font-weight:bold">Total</td>
										<th  style="text-align:right;font-weight:bold">Rp.<?php echo rupiah($total+$code_uniq+($total_berat*$ongkir->harga))?></td>
										<input type="hidden" id="total" name="total" value="<?php echo ($total+$code_uniq+($total_berat*$ongkir->harga))?>">
										<th></th>
									</tfoot>
								</table>
								</div>

						
									<div class="alert alert-info" id="t4_go_step_2">
									

										<a href="<?php echo $alamat?>" style="width:45%;" class="btn btn-info">&larr; Lanjut Belanja</a>
									
										<div class="btn btn-warning" style="width:45%;float:right;" id="go_step_2">Step 2 &rarr;</div>
											
										
									</div>	



								</div>
						

						
						<!-----------------step 2--------------------->
						
						<div class="" id="step_2" style="display:none;">
						<div class="alert alert-warning"><strong>Alamat Pengiriman : </strong></div>
								
								<div style="background-color:lavenderblush;">
									
									
									<input type="hidden" name="code_uniq" value="<?php echo $code_uniq?>">
										
										Nama : 
											<input type="text" value="<?php echo $nama_pengiriman?>" name="nama_pengiriman" id="nama_pengiriman" class="form-control">
											
											Email : <input type="email" value="<?php echo $email_pengiriman?>" name="email_pengiriman" id="email_pengiriman" readonly="readonly" class="form-control">
											Telp : <input type="text" value="<?php echo $telp_pengiriman?>" name="telp_pengiriman" id="telp_pengiriman" class="form-control">
											Alamat :<textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="6" class="form-control"><?php echo $alamat_pengiriman?> <?php echo $nama_kelurahan?> <?php echo $nama_kecamatan?> <?php echo $nama_kabupaten?> <?php echo $nama_provinsi?></textarea>
										
									
									
									<br>
								</div>
								
														
										<div class="btn btn-warning" style="width:45%;float:right;" id="go_step_3">Step 3 &rarr;</div>
											
										
								</div>
								<div class="clear"></div>
									
									
									<!-----------------step 3--------------------->
									<div id="step_3" style="display:none;">
									<!--metode pembayaran-->
									<div class="alert alert-info"><a>Metode Pembayaran:</a></div>
										<div id="metode_pembayaran"	class="alert alert-warning" width="100%">
											
												
												<div class="btn btn-warning" id="select_method">
													 Bank Transfer &rarr;
												</div>
												
										<table class="table table-striped table-bordered table"  cellspacing="0" width="100%" id="tbl_list_bank" style="background:lavender;">
											<thead>											
												<th>BANK</th>
												<th>No.Rek</th>
												<th>A/n Rek</th>
												<th>Pilih</th>
											</thead>
											<?php
											$q = $db->query("SELECT * FROM tbl_bank");
											
											while($data = $q->fetch_object())
											{
												echo "
													<tr id='actif_click'>											
														<td>$data->nama_bank</td>
														<td>$data->nomor_rek</td>
														<td>$data->nama_rek</td>
														<td><input type='radio' name='id_bank' id='id_bank' value='$data->id_bank'></td>														
													</tr>";
											}
											
											?>
										</table>
												
										</div>
									<!--metode pembayaran-->
															
									<input type="submit" name="submit" id="submit_form_confirmasi" value="Finish &rarr;" class="btn btn-danger" style="float:right;width:50%;">
									</div>
								
								</form>
										
								<br><br>
								
						
						<div class="clear"></div>
						<br><br><br><br>
						

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
<style>
.step_1_notif_active,.step_2_notif_active,.step_3_notif_active{
background-color:red;
color:white;
cursor:pointer;
}
</style>
 <script>
 
 //--------------rubah stok----------------------//
 $("#tbl_keranjang").on("change","tr td #qty", function(){
	var id_barang = $(this).parent().find("#id_barang").val();	
	var qty = $(this).val();
	var update_to_keranjang = "update_to_keranjang";
	//alert(qty);
	var target="<?php echo $alamat?>kasir.php";
	$.get(target,{id_barang:id_barang,qty:qty,update_to_keranjang:update_to_keranjang},function(e){
			window.location = "<?php echo $alamat?>kasir.php";
	});
	
	return false
	
 });
 
 
 
 $("#submit_form_confirmasi, #tbl_list_bank").css({"display":"none"});
 $("#tbl_list_bank tr#actif_click").css({"cursor":"pointer"});
 
  $("#step_1_notif").addClass("step_1_notif_active");
  
 $("#go_step_2").on("click",function(e){
	 loading_menu();
	 var jumlah_keranjang = <?php echo $no?>;	
	if(jumlah_keranjang ==0)
	{
		alert("Keranjang anda kosong, silahkan berbelanja dulu..");
		loading_menu_hide();
		return false;
	}
	 $("#step_2_notif").addClass("step_2_notif_active");	
	 
	 $("#step_1").hide("slide", { direction: "left" }, 300);
	 setTimeout(
	  function() 
	  {
		$("#step_2").show("slide", { direction: "right" }, 500);
		loading_menu_hide();
	  }, 300);
	 
	 
	 
 });
 
 $("#go_step_3").on("click",function(e){	 
	 
	 $("#step_3_notif").addClass("step_3_notif_active");	 	 
	 $("#step_2").hide("slide", { direction: "left" }, 300);
	 setTimeout(
	  function() 
	  {
		$("#step_3").show("slide", { direction: "right" }, 500);
		loading_menu_hide();
	  }, 300);
	 
	 
 });
 
 //step badge
  $(".step_1_notif_active").on("click",function(){
	 $("#step_2,#step_3").hide("slide", { direction: "right" }, 300);
	 setTimeout(
	  function() 
	  {
		$("#step_1").show("slide", { direction: "left" }, 500);
		loading_menu_hide();
	  }, 300);
	 
	/*
	$("#step_1").slideDown();
	$("#step_2").slideUp();
	$("#step_3").slideUp();
	*/
 });
 
 $("#step_2_notif").on("click",function(){	
 
	 $("#step_1,#step_3").hide("slide", { direction: "right" }, 300);
	 setTimeout(
	  function() 
	  {
		$("#step_2").show("slide", { direction: "left" }, 500);
		loading_menu_hide();
	  }, 300);
 
	/*
	$("#step_2").slideDown();
	$("#step_1").slideUp();
	$("#step_3").slideUp();
	*/
 });
 
 $("#step_3_notif").on("click",function(){
	 
	 $("#step_1,#step_2").hide("slide", { direction: "left" }, 300);
	 setTimeout(
	  function() 
	  {
		$("#step_3").show("slide", { direction: "right" }, 500);
		loading_menu_hide();
	  }, 300);
	 
	 /*
	$("#step_3").slideDown();
	$("#step_2").slideUp();
	$("#step_1").slideUp();
	*/
 });
 
 
 $("#select_method").click(function(e){
	$("#tbl_list_bank").fadeIn();
	go_to("tbl_list_bank");
 });
 
 $("#tbl_list_bank").on("click","tr#actif_click",function(e){
	 //alert($(this).find("#id_bank").val());
	 $(this).find("#id_bank").prop("checked",true);	 
	 $("#submit_form_confirmasi").fadeIn();
	 go_to("submit_form_confirmasi");
 });
 
 $("#tbl_keranjang").on("click","tr td #hapus_keranjang", function(){
	var confirm_del = confirm("Apakah anda yakin menghapus list ini?");
	loading_menu();
		if(confirm_del){
			var id_keranjang = $(this).attr("class");
			var session_sementara	 = "<?php echo $session_sementara?>";
			var target="<?php echo $alamat?>kasir.php?id_keranjang="+id_keranjang+"&delete_from_keranjang";
			$.get(target,function(){
				$.get("<?php echo $alamat?>part/isi_kasir.php",{session_sementara:session_sementara},function(event){
					$(".main").hide().html(event).fadeIn();
					
					//alert(event);
					load_keranjang();
					location.reload();
				});
				
			});
		}
		loading_menu_hide();
		return false;
	
 });
 
 
 $("#form_pengiriman").submit(function(){
	loading_menu();
	var jumlah_keranjang = <?php echo $no?>;
	//alert(jumlah_keranjang);
	
	if(jumlah_keranjang ==0)
	{
		alert("Keranjang anda kosong, silahkan berbelanja dulu..");
		loading_menu_hide();
		return false;
	}
	
	var total 			= $("#total").val();
	var id_confirmasi 	= $("#id_confirmasi").val();
	
	//alert(total+id_confirmasi);
	
	$.get("<?php echo $alamat?>part/isi_kasir_login.php",$(this).serialize(),function(ambil_balik_id_confirmasi){
		
		$.get("<?php echo $alamat?>part/load_bank.php",{id_confirmasi:id_confirmasi,total:total},function(e){
			$(".main").hide().slideUp().html(e).fadeIn();
			//alert(e);
		});
		
		
	});
	
	$("#submit_form_confirmasi").addClass("disabled");
	loading_menu_hide();
	return false;
 });


 </script>
 
 <style>
 .tbl_alamat td{
	padding:5px;
}


.tbl_alamat td {
    vertical-align: top;
}
#hapus_keranjang{	
	cursor:pointer;
}
#submit_form_confirmasi, #tbl_list_bank{
	display:none;
}
 </style>