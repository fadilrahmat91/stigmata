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


$q = $db->query("SELECT a . * , c.nama_brand, c.id_brand, e.nama_barang, e.stok_barang, e.harga_barang, e.id_kategori 
					FROM tbl_keranjang a
					INNER JOIN tbl_barang e ON a.id_barang = e.id_barang					
					LEFT JOIN tbl_brand c ON e.id_brand = c.id_brand					
					WHERE a.session_sementara ='$session_sementara'
					ORDER BY e.nama_barang, a.id_keranjang DESC
				");
				
$hit = mysqli_num_rows($q);
?>    	
 
 <div class="main">
    <div class="content">
    	
    	<div class="section group">
				<div class="product_desc">	
					<div id="horizontalTab">
						<div class="alert alert-info">Daftar Belanja :</div>
						
						<div class="resp-tabs-container">
							<div class="product-desc">
							<div class="product_descnya">
								<table class="table" id="tbl_keranjang">
									<tr>
										<td>No</td>
										<td>Nama Produk</td>
										<td>Gambar Produk</td>
										<td>Qty</td>
										<td style='text-align:right;'>@ Harga</td>
										<td style='text-align:right;'>Sub Total</td>
										<td width="100px;" style="text-align:right;">Action</td>
									</tr>
									
									<?php
									if($hit ===0)
									{
										echo "<h4>Keranjang belanja anda kosong!</h4>";
									}
										$no =0;
										$total = 0;
										while($data=$q->fetch_object())
										{
										
										
										
										#-------------------gambar array----------------------#
										$img = $obj->gambarArray($data->id_barang,1);
									
										
											$no ++;
											$total+=($data->harga_barang*$data->qty);
											$nama_kategori = ambil_nama_kat($db,$data->id_kategori);
											
											
											
											
											
											echo "
												<tr>
													<td>$no</td>												
													<td><a href='".link_detail($data->id_barang,$nama_kategori,$data->nama_barang)."'>$data->nama_barang</a></td>												
													<td><img src='".ambil_thumbs($img[0])."'></td>												
													<td>";
													?>
													<input type="hidden" id="id_barang" value="<?php echo $data->id_barang?>">																							
													<select id='qty' >
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
										}
										
									?>
									<tr>
										<td colspan="5" style="text-align:right;font-weight:bold">Total</td>
										
										<td  style="text-align:right;font-weight:bold">Rp.<?php echo rupiah($total)?></td>
										<td></td>
									</tr>
								</table>
						
						<div class="alert alert-warning">
								<table width="100%">
								<tr>
									<td>
										<a href="<?php echo $alamat?>" class="btn btn-info">&larr; Lanjut Belanja</a>
									</td>
									<td class="text-right">
										<a href="<?php echo $alamat?>kasir.php" id="lanjut_pembayaran" class="btn btn-success">Lanjut Pembayaran &rarr;</a>
									</td>
								</tr>
								</table>
								
						</div>	
						<br>
								

						<div id="content_login">
						</div>


						</div>
						</div>
					
	
					</div>
					
					
					<div class="clear"></div>
					<br><br>
					
				 </div>
			 </div>

 		</div>
 	</div>
    </div>
 

 <script>
 
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
				//location.reload();
				//alert(event);
				load_keranjang();
				 
			});
		
		});
	}
	
	
	loading_menu_hide();
	return false
	
 });

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

 
$("#lanjut_pembayaran").click(function(){
	loading_menu();
	var session_sementara = "<?php echo $session_sementara?>";
	$.get("<?php echo $alamat?>part/isi_login.php",{session_sementara:session_sementara},function(e){
		
		
		$("#content_login").hide().html(e).fadeIn();
		go_to("content_login");
		//alert(e);
		loading_menu_hide();
	});
	<?php
		if(!isset($_SESSION['id_pelanggan']))
			{
				echo "return false;";
			}
	
	?>
});

 </script>