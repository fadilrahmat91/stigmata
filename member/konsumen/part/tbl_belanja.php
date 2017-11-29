<?php
session_start();
if(!isset($_SESSION['id_pelanggan']))
{
	header ('location: login.php');
}

include_once(dirname(__FILE__) . '/../../setting.php');

$id_pelanggan = $_SESSION['id_pelanggan'];

?>	
	<div class="container" id="judul_h1">
		<h1>DATA BELANJA</h1>
		
	</div>
	
	<div id="t4_tambah_data" style="display:none"></div>
	
	<div class="container" id="t4_table">
	
<table id="tbl_confirmasinya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
			<tr >
								
				<th >Kode Pemesanan</th>
				<th > Qty </th>
				<th > Ord.Date</th>
				<th > Conf.Date</th>
				<th > Bank Conf.</th>
				<th >Status</th>
				<th  width="75px">Action</th>
				<th>Total</th>
				
			</tr>
			</thead>
			
			<tbody>


	<?php 
	
     if(isset($_GET['tbl_confirmasi_bank']))
	 {
		$rowSet = $db->query("SELECT a.id_confirmasi, b.nama_pelanggan, b.id_pelanggan, c.* 
								FROM tbl_bukti_transfer a 
								INNER JOIN tbl_confirmasi c ON a.id_confirmasi = c.id_confirmasi 
								INNER JOIN tbl_pelanggan b ON c.id_pelanggan = b.id_pelanggan 
								WHERE c.id_pelanggan='$id_pelanggan'
								GROUP BY a.id_confirmasi 
								ORDER BY c.status_confirmasi ASC, c.id_uniq DESC");  
	 }else if(isset($_GET['tbl_data_belanja_aproved'])){
		 
		$rowSet = $db->query("SELECT a.*, b.nama_pelanggan, b.id_pelanggan 
								FROM tbl_confirmasi a 
								INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 
								WHERE a.id_pelanggan='$id_pelanggan' AND a.status_confirmasi='1'
								GROUP BY a.id_confirmasi 
								ORDER BY a.status_confirmasi ASC, a.id_uniq DESC");  	 		 
	 }else{
		 $rowSet = $db->query("SELECT a.*, b.nama_pelanggan, b.id_pelanggan 
								FROM tbl_confirmasi a 
								INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 
								WHERE a.id_pelanggan='$id_pelanggan' 
								GROUP BY a.id_confirmasi 
								ORDER BY a.status_confirmasi ASC, a.id_uniq DESC");  	
	 }							
								
     $nourut =0;
     while($row = $rowSet->fetch_object()){

		
		$id_pelanggan = $row->id_pelanggan;
		$temp 	= $row->id_confirmasi;
		$hit 	= $db->query("SELECT COUNT(*) AS jumlah FROM tbl_confirmasi WHERE id_confirmasi = '$temp'");
		$jumlah = $hit->fetch_object();
	    $nourut++;
     
		 $aktif = $row->status_confirmasi;
		 if($aktif==0){ 				
				$link_conf 	= '<span class="btn btn-xs btn-default btn-warning" href="'.$temp.'" id="setujui_confirm">Not checked</span>';
				$notif 		= "<b><font color=red>Belum Disetujui</font></b>";
				$class_tr 	= "class='success'";
		 
			}else if($aktif==1)
			{				
				$link_conf 	= '<span class="btn btn-xs btn-default btn-success" href="'.$temp.'">Approved</span>';
				$notif 		= "Telah Disetujui";
				$class_tr 	= "";
			}else if($aktif==2)
			{
				$link_conf 	= '<span class="btn btn-xs btn-default btn-danger" href="'.$temp.'">Rejected</span>';
				$notif 		= "Rejected";
				$class_tr 	= "class='danger'";
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
										INNER JOIN tbl_bank b
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
			
			//setting auto off pesanan
			if($aktif ==0)
			{
				//-----set waktu auto reject---
				$get = $db->query("SELECT hari FROM tbl_set_waktu_confirm")->fetch_object();
				$hari = $get->hari;
				
				if(hit_hari($row->tgl_confirmasi) >= $hari)
				{
					$db->query("UPDATE tbl_confirmasi SET status_confirmasi='2' WHERE id_confirmasi='$temp'");
				}
				
				
			}
			//setting auto off pesanan
			
			
			
		}
     
	 ?>
	 

			<tr id="tr_nya"<?php echo $class_tr?>>
				
				
				<td ><a href="print.php?id_confirmasi=<?php echo $row->id_confirmasi;?>&status=<?php echo $row->status_confirmasi;?>&go_print=0" target="_blank"title="REPORT BELANJA"  ><?php echo  $row->id_confirmasi;?></a></td>
				<td ><?php echo  $jumlah->jumlah;?></td>
				<td ><?php echo  tanggalindo($row->tgl_confirmasi)." ".$row->jam_confirmasi;?> 
						<br>
					(<?php if(hit_hari($row->tgl_confirmasi)==0){$hari = "hari ini";}else{ $hari=hit_hari($row->tgl_confirmasi)." hari yg lalu";}echo "<small>".$hari."</small>";?>)
				</td>

				<td ><?php echo  $tgl_disetujui;?></td>
				<td id="bank_image" >
					<input type="hidden" value="<?php echo $row->id_confirmasi?>">
					<?php echo $modals;?>
				</td>
				
				<td id="statusnya"><?php echo  $notif;?></td>

				<td  id=""> <span id="link_conf"><!--<?php echo $link_conf;?>--></span>
					
					    <!-- Trigger the modal with a button -->
							<button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#<?php echo $row->id_confirmasi?>">Details</button>
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
														<th class="data" width="30px">No</th>
														<th class="data">Nama Barang</th>
														
														<th class="data">Harga Per Item</th>
														
														
													</tr>

											<?php
												$harga_total = 0;
												$q = $db->query("SELECT a.*, b.nama_barang,b.harga_barang FROM tbl_confirmasi a INNER JOIN tbl_barang b ON a.id_barang = b.id_barang WHERE a.id_confirmasi ='$row->id_confirmasi'");
												$no =0;
												while($data = $q->fetch_object()){
												$no++;
												$harga_total+=$data->harga_barang;
												$code_uniq = $data->code_uniq;
												$ongkir = $data->ongkir;
											?>
												
												<tr class="data">
														<td class="data" width="30px" valign="top"><?php echo $no;?></td>
														<td class="data" width="230px" valign="top"><?php echo $data->nama_barang;?></td>
														
														<td class="data" style="text-align:right" valign="top"><?php echo rupiah($data->harga_barang);?></td>
														
														
													
													</tr>
												
												<?php
												}
												?>
											
													<tr class="data">
														<td></td>
														<td class="data"style="text-align:right"><b>Uniq : &nbsp;&nbsp;&nbsp;</b></td>
														<td class="data" style="text-align:right"> <b>Rp.<?php echo $code_uniq;?></b></td>
														
													</tr>
													<tr class="data">
														<td></td>
														<td class="data"style="text-align:right"><b>Ongkir : &nbsp;&nbsp;&nbsp;</b></td>
														<td class="data" style="text-align:right"> <b>Rp.<?php echo rupiah($ongkir);?></b></td>
														
													</tr>
											
													<tr class="data">
														<td></td>
														<td class="data"style="text-align:right"><b>Total : &nbsp;&nbsp;&nbsp;</b></td>
														<td class="data" style="text-align:right"> <b>Rp.<?php echo rupiah($harga_total+$code_uniq+$ongkir);?></b></td>
														
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
											
											
											<a href="print.php?id_confirmasi=<?php echo $id_confirmasi?>&go_print=1" target="blank" class="btn btn-xs"><span class="glyphicon glyphicon-print" ></span> Print</a>
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
				<td><b>Rp.<?php echo rupiah($harga_total+$code_uniq+$ongkir);?></b></td>
			</tr>
			

		<?php 
			} 
		?>
	
		</tbody>
	</table>



<?php
//set hari
include_once(dirname(__FILE__) . '/set_waktu_confirm.php');
?>
	
</div>

<script>
$(document).ready(function(){

$('#tbl_confirmasinya').dataTable({
        "order": [[ 4, "desc" ]]
    });


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});
//bukti bank gambar
$("#tbl_confirmasinya tbody tr #bank_image #popover_url_images").popover({
	html: true
});


//get approve
$("#tbl_confirmasinya ").on("click","tbody tr td #link_conf",function(){
	var setujui_pembelian = confirm("Apakah anda yakin menyetujui Pemesanan ini?");
	if(setujui_pembelian)
	{
		
		$(this).parent().find("#setujui_confirm").attr("class","btn btn-xs btn-default btn-success");
		$(this).parent().find("#setujui_confirm").html("Approved");
		$(this).parent().parent().find("#statusnya").html("Telah Disetujui");
		$(this).parent().parent().removeClass("success");
		//alert($(this).parent().parent().find("#tr_nya").html());
		var id_confirmasi = $(this).parent().find("#setujui_confirm").attr("href");
		var setujui_confirm = 'setujui_confirm';
			$.get("part/action_confirmasi.php",{id_confirmasi:id_confirmasi,setujui_confirm:setujui_confirm},function(e){
			
					load_menu_hash("part/tbl_confirmasi.php");
					//alert(e);
			});
		
	}else{
		return false;
	}
	return false;		
});






$("#tbl_confirmasinya ").on("submit","tbody tr #td_harga_coret #form_update_inline_harga_coret",function(){
	
	var harga_coret = $(this).find("#inline_harga_coret").val();
	var id_barang = $(this).find("#inline_id_barang").val();
	var edit_harga_coret = '';
	
		$.post("part/simpan_edit_inline_barang.php",{id_barang:id_barang,edit_harga_coret:edit_harga_coret,harga_coret:harga_coret},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
	
	$(this).hide();
	$(this).parent().find("#a_harga_coret").html(harga_coret).show();
	
	return false;		
});




//get inline harga
$("#tbl_confirmasinya ").on("click","tbody tr #td_harga #a_harga",function(){
	
	$(this).parent().find("#form_update_inline_harga").show();
	$(this).parent().find("#a_harga").hide();
		
	return false;		
});

//set_bank_admin_status = 0
$("#tbl_confirmasinya ").on("click","tbody tr #bank_image",function(){
	
	var id_confirmasi 			= $(this).find("input").attr("value");
	var set_bank_admin_status 	= "set_bank_admin_status";
	$.get("part/action_confirmasi.php",{set_bank_admin_status:set_bank_admin_status,id_confirmasi:id_confirmasi},function(e){
		
	});		
	//return false;		
});


$("#tbl_confirmasinya ").on("submit","tbody tr #td_harga #form_update_inline_harga",function(){
	
	var harga_barang = $(this).find("#inline_harga").val();
	var id_barang = $(this).find("#inline_id_barang").val();
	var edit_harga = '';
	
		$.post("part/simpan_edit_inline_barang.php",{id_barang:id_barang,edit_harga:edit_harga,harga_barang:harga_barang},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
	
	$(this).hide();
	$(this).parent().find("#a_harga").html(harga_barang).show();
	
	return false;		
});


//get inline stok
$("#tbl_confirmasinya ").on("click","tbody tr #td_stok #a_stok",function(){
	
	$(this).parent().find("#form_update_inline_stok").show();
	$(this).parent().find("#a_stok").hide();
		
	return false;		
});


$("#tbl_confirmasinya ").on("submit","tbody tr #td_stok #form_update_inline_stok",function(){
	
	var stok_barang = $(this).find("#inline_stok").val();
	var id_barang = $(this).find("#inline_id_barang").val();
	var edit_stok = '';
	
		$.post("part/simpan_edit_inline_barang.php",{id_barang:id_barang,edit_stok:edit_stok,stok_barang:stok_barang},function(e){
								
			$("#alertnya").show(0);
			
			
		});
		
	
	$(this).hide();
	$(this).parent().find("#a_stok").html(stok_barang).show();
	
	return false;		
});


//get_by kategori
$("#tbl_confirmasinya ").on("click","tbody tr td .id_kategori",function(){
	
	var id_kategori = $(this).attr("id");		

	load_menu_hash("part/tbl_barang.php?id_kategori="+id_kategori);
	//alert(id_kategori);
	
	return false;		
});

//get_by toko
$("#tbl_confirmasinya ").on("click","tbody tr td .id_toko",function(){
	
	var id_toko = $(this).attr("id");		

	load_menu_hash("part/tbl_barang.php?id_toko="+id_toko);
	
	return false;		
});

//hapus
$("#tbl_confirmasinya ").on("click","tbody tr td #hapus_barang",function(){
	
	var id_barang = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/action_table.php?hapus_barang",{id_barang:id_barang},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});

//nonaktifkan
$("#tbl_confirmasinya ").on("click"," tbody tr td .non_aktifkan_barang",function(){
	
	var id_barang = $(this).attr("id");		

	var non_aktifkan_barang = confirm("Yakin menonaktifkan data ini?");			
	loading_menu();
	if(non_aktifkan_barang)
	{
		$.get("part/action_table.php?non_aktifkan_barang",{id_barang:id_barang},function(e){
								
			bootstrap_alert.success('Telah di non Aktifkan..');
			//alert(e);
			//load_menu_hash("part/tbl_barang.php");
			
		});
				
	$(this).attr("class","btn btn-danger btn-xs aktifkan_barang");
	$(this).html("Off");
	
	}
	loading_menu_hide();
	
	return false;		
});



//aktifkan
$("#tbl_confirmasinya ").on("click"," tbody tr td .aktifkan_barang",function(){

	
	var id_barang = $(this).attr("id");		

	var aktifkan_barang = confirm("Yakin mengaktifkan data ini?");			
	loading_menu();
	if(aktifkan_barang)
	{
		$.get("part/action_table.php?aktifkan_barang",{id_barang:id_barang},function(e){
								
			bootstrap_alert.success('Telah di Aktifkan..');
			//alert(e);
				
			//load_menu_hash("part/tbl_barang.php");
		});
		
	$(this).attr("class","btn btn-success btn-xs non_aktifkan_barang");
	$(this).html("On");	
	
	}
	loading_menu_hide();
	return false;		
});


//edit
$("#tbl_confirmasinya ").on("click"," tbody tr td #edit_barang",function(){

	loading_menu();	
	var id_barang = $(this).attr("href");
	$.get("part/form_edit_barang.php",{id_barang:id_barang}, function(e){
		
		//alert(e);
		
		if($("#t4_tambah_data").html(''))
		{
			if($("#t4_tambah_data").html(e))
			{
				$("#t4_tambah_data").fadeIn("slow");
			}
		}
		notif_function("t4_notif_newbarang","hitNewProduct");
		
		loading_menu_hide();
		
	});
	
	return false;		
});




//panggil form
$("#tambah_data").click(function(){
	
	tambah_barang();
	
});

/*
var url = document.URL;
var hash = url.substring(url.indexOf('#')+1);
alert(hash);
*/
});

</script>