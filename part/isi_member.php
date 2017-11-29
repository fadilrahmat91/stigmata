

	<div class="container" id="judul_h1">
		<h2>Welcome, <a><?php echo strtoupper($obj->member($_SESSION['id_pelanggan'])->nama_pelanggan)?></a>  </h2>
		
	</div>


	
	<!------------------------------------------------menu member-------------------------------------------->
	<div class="container">
  
	  <ul class="nav nav-pills">
		<li class="active"><a data-toggle="pill" href="#home">Transaksi</a></li>
		<li><a data-toggle="pill" href="#profil">Profil</a></li>
		<li><a href="<?php echo $alamat?>part/logout.php">LogOut</a></li>
		
	  </ul>
	  
		
	</div>
	
	
	<!------------------------------------------------menu member-------------------------------------------->
	
	
	
	
	
	
	
	
	

<div class="tab-content">
<div id="home" class="tab-pane fade in active">

 <h3>Transaksi</h3>

<div class="container" id="t4_table">
	
<table id="tbl_confirmasinya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
			<tr >
				
				
				<th >Id Conf.</th>
				<th > Qty </th>
				<th > Ord.Date</th>
				<th > Conf.Date</th>
				<!--<th > Bank Conf.</th>-->
				<th >Status</th>
				<th  width="75px">Action</th>
				<th>Total</th>
				
			</tr>
			</thead>
			
			<tbody>


	<?php 
	foreach($obj->member_confirm($_SESSION['id_pelanggan']) as $row)							
	{
     $nourut =0;
     

		
		$id_pelanggan = $row->id_pelanggan;
		$temp 	= $row->id_confirmasi;
		$hit 	= $db->query("SELECT COUNT(*) AS jumlah FROM tbl_confirmasi WHERE id_confirmasi = '$temp'");
		$jumlah = $hit->fetch_object();
	    $nourut++;
     
		 $aktif = $row->status_confirmasi;		 
		 if($aktif==0){ 				
				$link_conf 	= '';
				$go_Reject	= '	';
				$notif 		= "<b><font color=red id='ket_notif'><span class='glyphicon glyphicon-refresh'></span> Menunggu</font></b>";
				$class_tr 	= "class='success'";
		 
			}else if($aktif==1)
			{				
				$link_conf 	= '';
				$notif 		= "<font color=green><span class='glyphicon glyphicon-ok'></span> Sent<br>(<b>$row->nama_shipping</b>-$row->resi_shipping</font>)";
				$class_tr 	= "";
				$go_Reject	= "";
			}else if($aktif==2)
			{
				$link_conf 	= '';
				$notif 		= "<font color=red><span class='glyphicon glyphicon-remove'></span> Rejected</font>";
				$class_tr 	= "class='danger'";
				$go_Reject	= "";
			}
		
		$id_confirmasi 	= $row->id_confirmasi;
		if($row->tgl_disetujui =='0000-00-00'){
			$tgl_disetujui  = '-';
		}else{
			$tgl_disetujui  = tanggalindo($row->tgl_disetujui)." ".$row->jam_disetujui;
		}
		
		//bukti_bank
		$q_bank_conf = $db->query("SELECT a.*,b.nama_bank, b.nomor_rek,b.nama_rek 
										FROM tbl_bukti_transfer a
										LEFT JOIN tbl_bank b
										ON a.id_bank = b.id_bank
										WHERE a.id_confirmasi ='$id_confirmasi'");
		$hit_bank = mysqli_num_rows($q_bank_conf);
		$data = $q_bank_conf->fetch_object();
		
		
		if($hit_bank ==1)
		{	
			if($data->admin_cek ==1){
				$btn_class	= "btn-disabled";
				$class_tr 	= "";
			}else{
				$class_tr 	= "class='warning'";
				$btn_class	= "btn-info";
			}
			
			
			$url_img	= "<div  id='popover_url_images' data-trigger='hover' rel='popover' data-content='<img src=$alamat/user_image/bukti_transfer/$data->url_image width=100%>' data-placement='top'>$data->waktu</div>";
			$modals		= '
						<!-- Trigger the modal with a button -->
							<button type="button" class="btn '.$btn_class.' btn-xs" data-toggle="modal" data-target="#bank_'.$data->id_confirmasi.'">'.$url_img.'</button>
						<!-- Trigger the modal with a button -->
						

							<!-- Modal -->
							<div id="bank_'.$data->id_confirmasi.'" class="modal fade" role="dialog">
							<div class="modal-dialog">
							
							<!-- Modal content-->
							<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Slip Transfer: '.$data->id_confirmasi.'</h4>
							</div>
							<div class="modal-body">
									
									
									<!--content-->
										<table class="alert alert-danger">
											<tr>
												<td>Kode Pesanan</td><td>: '.$data->id_confirmasi.'</td>
											</tr>
											<tr>
												<td>Nama Pengirim</td><td>: '.$data->atas_nama_pengirim.'</td>
											</tr>
											<tr>
												<td>Jumlah dana</td><td>: Rp.'.rupiah($data->jumlah_transfer).'</td>
											</tr>
											<tr>
												<td>Waktu Conf.</td><td>: '.$data->waktu.'</td>
											</tr>
											<tr>
												<td valign="top">Struk Conf.</td><td valign="top">: <a href="'.$alamat.'user_image/bukti_transfer/'.$data->url_image.'" target="_blank"><img class="img-thumbnail" src="'.$alamat.'user_image/bukti_transfer/'.$data->url_image.'" width="200px"></a></td>
											</tr>
										</table>
										
										
										<h4>Bank Tujuan:</h4>
										<table class="alert alert-success">
											<tr>
												<td>Bank</td><td>'.$data->nama_bank.'</td>
											</tr>
											<tr>
												<td>No.Rek</td><td>'.$data->nomor_rek.'</td>
											</tr>
											<tr>
												<td>Nama.Rek</td><td>'.$data->nama_rek.'</td>
											</tr>
											
										</table>
											
									<!-- content-->
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							</div>

							</div>
							</div>
							<!-- Modal -->';
			
			
		}else{
			$class_tr 	= "";
			$url_img	= "-";
			$modals		= "";
			
			//setting auto reject pesanan
			if($aktif ==0)
			{
				//-----set waktu auto reject---
				$get = $db->query("SELECT hari FROM tbl_set_waktu_confirm")->fetch_object();
				$hari = $get->hari;
				
				if(hit_hari($row->tgl_confirmasi) >= $hari)
				{
					$db->query("UPDATE tbl_confirmasi SET status_confirmasi='2' WHERE id_confirmasi='$temp'");
					$db->query("INSERT INTO tbl_reject_reason SET id_confirmasi='$temp', reason='System Auto reject Member.'");
				}
				
				
			}
			//setting auto reject pesanan
			
			
			
		}
     
	 ?>
	 

			<tr id="tr_nya"<?php echo $class_tr?>>
				
				
				<!--<td ><a href="print.php?id_confirmasi=<?php echo $row->id_confirmasi;?>&status=<?php echo $row->status_confirmasi;?>&go_print=0" target="_blank"title="REPORT BELANJA"  ><?php echo  $row->id_confirmasi;?></a></td>-->
				<td ><?php echo  $row->id_confirmasi;?></td>
				<td ><input type="hidden" value="<?php echo $jumlah->jumlah?>" id="quantity"><?php echo  $jumlah->jumlah;?></td>
				<td ><?php echo  tanggalindo($row->tgl_confirmasi)." ".$row->jam_confirmasi;?> 
						<br>
					(<?php if(hit_hari($row->tgl_confirmasi)==0){$hari = "hari ini";}else{ $hari=hit_hari($row->tgl_confirmasi)." hari yg lalu";}echo "<small>".$hari."</small>";?>)
				</td>
				<td ><?php echo  $tgl_disetujui;?></td>
				<!--<td id="bank_image" >
					<input type="hidden" value="<?php echo $row->id_confirmasi?>">
					<?php //echo $modals;?>
				</td>-->
				<td id="statusnya"><?php echo  $notif.$go_Reject;?></td>
				<td  id=""> <span id="link_conf"><?php echo $link_conf;?></span>
					
					    <!-- Trigger the modal with a button -->
							<button type="button" class="btn btn-info btn-lg btn-xs btn-block" data-toggle="modal" data-target="#<?php echo $row->id_confirmasi?>">Details</button>
						<!-- Trigger the modal with a button -->
						

							<!-- Modal -->
							<div id="<?php echo $row->id_confirmasi?>" class="modal fade" role="dialog">
							<div class="modal-dialog">
							
							<!-- Modal content-->
							<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Faktur: <?php echo $row->id_confirmasi?></h4>
							</div>
							<div class="modal-body">
									
									
									<!--content-->
										
										<div id="report_area">

										<table class="data">
										<tr class="data">
											<td class="data">ID BELANJA</td>
											
											<td class="data">: <b><?php echo $row->id_confirmasi?></b> </td>
										</tr>

										<tr class="data">
											<td class="data">STATUS</td>
											
											<td class="data">: <b><?php echo $notif ?></b></td>
										</tr>
										<tr class="data">
											<td class="data">TGL ORDER</td>
											
											<td class="data">: <b><?php echo tanggalindo($row->tgl_confirmasi)." ".$row->jam_confirmasi ?></b></td>
										</tr>
										<tr class="data">
											<td class="data">TGL APPROVE</td>
											
											<td class="data">: <b><?php echo $tgl_disetujui ?></b></td>
										</tr>
										</table>
											
											
											<table class="data">
													<tr class="data">
														<th  width="30px">No</th>
														<th >Nama Produk</th>														
														<th >Qty</th>
														
														<th class="data text-right">@ Harga</th>
														<th class="data text-right">Sub Total</th>
														
														
													</tr>

										<?php
												$harga_total = 0;
												$q = $db->query("SELECT a.*, b.nama_barang,b.harga_barang FROM tbl_confirmasi a INNER JOIN tbl_barang b ON a.id_barang = b.id_barang WHERE a.id_confirmasi ='$row->id_confirmasi'");
												$no =0;
												while($data = $q->fetch_object()){
												$no++;
												$harga_total+=($data->harga_barang*$data->qty);
												$code_uniq = $data->code_uniq;
												$ongkir = $data->ongkir;
											?>
												
												<tr >
														<td  width="30px" valign="top"><?php echo $no;?></td>
														<td  width="230px" valign="top"><?php echo $data->nama_barang;?></td>
														<td  width="230px" valign="top"><?php echo $data->qty;?></td>
														<td  style="text-align:right" valign="top"><?php echo rupiah($data->harga_barang);?></td>
														
														
														<td  style="text-align:right" valign="top"><?php echo rupiah($data->harga_barang*$data->qty);?></td>
														
													
													</tr>
												
												<?php
												}
												?>
											
													<tr >
														
														<td colspan="4" style="text-align:right"><b>Uniq : &nbsp;&nbsp;&nbsp;</b></td>
														<td  style="text-align:right"> <b><?php echo $code_uniq;?></b></td>
														
													</tr>
													<tr >
														
														<td  colspan="4" style="text-align:right"><b>Ongkir : &nbsp;&nbsp;&nbsp;</b></td>
														<td   style="text-align:right"> <b><?php echo rupiah($ongkir);?></b></td>
														
													</tr>
											
													<tr >
														
														<td  colspan="4" style="text-align:right"><b>Total : &nbsp;&nbsp;&nbsp;</b></td>
														<td   style="text-align:right"> <b>Rp.<?php echo rupiah($harga_total+$code_uniq+$ongkir);?></b></td>
														
													</tr>
											
											
											</table>
											
										<?php
														
											$data_pelanggan = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
																		FROM tbl_pengiriman a
																		LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
																		LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
																		LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
																		LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
																		WHERE a.id_pelanggan='$id_pelanggan'")->fetch_object();

											?>
											Alamat Pengiriman:
											<table class="data">
												<tr class="data">
													<td class="data">Nama </td>	<td class="data"><?php echo $data_pelanggan->nama_pengiriman;?></td>
												</tr>
												<tr class="data">
													<td class="data">Telepon </td>	<td class="data"><?php echo $data_pelanggan->telp_pengiriman;?></td>
												</tr >
												<tr class="data">
													<td class="data">Email </td>	<td class="data"><?php echo $data_pelanggan->email_pengiriman;?></td>
												</tr>
												<tr class="data">
													<td class="data">Alamat </td>	<td class="data"><?php echo $data_pelanggan->alamat_pengiriman;?>
																								<!--	<?php echo $data_pelanggan->nama_kelurahan;?>,
																									<?php echo $data_pelanggan->nama_kecamatan;?>,
																									<?php echo $data_pelanggan->nama_kabupaten;?>,
																									<?php echo $data_pelanggan->nama_provinsi;?>
																									-->
													
													</td>
												</tr>
											
											</table>
											
											
										<!--	<a href="print.php?id_confirmasi=<?php echo $id_confirmasi?>&go_print=1" target="blank" class="btn btn-xs"><span class="glyphicon glyphicon-print" ></span> Print</a>-->
											</div>
											
									<!-- content-->
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							</div>

							</div>
							</div>
							<!-- Modal -->
				
				</td>
				<td><input type="hidden" value="<?php echo $harga_total+$code_uniq+$ongkir?>" id="total_dana_belanja">Rp.<?php echo rupiah($harga_total+$code_uniq+$ongkir)?></td>
				
			</tr>
			
				
			
			

		<?php 
			} 
		?>
	
		</tbody>
	</table>


	
</div>
</div>

	<div id="profil" class="tab-pane fade">
	<hr style="border:1px solid #ddd">
		<?php
		$id_pelanggan = $_SESSION['id_pelanggan'];
		$q_profil = $db->query("SELECT * FROM tbl_pelanggan WHERE id_pelanggan='$id_pelanggan'")->fetch_object();
		
		?>
		<div class="col-xs-3">
			Nama
		</div>
		<div class="col-xs-9">
			: <?php echo $q_profil->nama_pelanggan?>
		</div>
		
		
		<div class="col-xs-3">
			Email
		</div>
		
		<div class="col-xs-9">
			: <?php echo $q_profil->email_pelanggan?>
		</div>
		
		<br>
		<hr style="border:1px solid #ddd">
		
      <h3>Ganti Password</h3>
      <p>
		<div class="alert alert-danger" id="t4_return_pass" style="display:none;"></div>
		<form id="ganti_password">
		<div class="col-xs-3">
			Password
		</div>
		
		
		<div class="col-xs-9">
			<input type="password" class="form-control" name="pass1" placeholder="Password" required>
		</div>
		
		
		<div class="col-xs-3">
			Confrim Password
		</div>
		
		
		<div class="col-xs-9">
			<input type="password" class="form-control" name="pass2" placeholder="Confirm Password" required>
		</div>
		
		
		<div class="col-xs-3">
			
		</div>
		
		
		<div class="col-xs-9">
			<input type="submit" class="btn btn-info btn-block" value="Ganti password">
		</div>
		</form>
		
		
	  
	  </p>
    </div>
    
	
	
	
	
	
	
	
	
</div>
<script>
$("#ganti_password").submit(function(){
	
	$.post("<?php echo $alamat?>part/ganti_pass.php",$(this).serialize(),function(e){
		//alert(e);
		if(e==0)
		{
			$("#t4_return_pass").hide().html("<b>Info!!</b> Password dan Confirm Password tidak sama").fadeIn();
		}else if(e==1)
		{
			$("#t4_return_pass").hide().html("<b>Info!!</b> Password harus lebih dari 6 karakter").fadeIn();
		}else if(e==2)
		{		
			$("#t4_return_pass").hide().html("<b>Info!!</b> Berhasil ganti password. Mohon tunggu sebentar").fadeIn();	
			window.location = "<?php echo $alamat?>/part/logout.php";
		}
	});
	return false;
})
</script>