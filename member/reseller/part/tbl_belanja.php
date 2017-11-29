<?php
session_start();
if(!isset($_SESSION['reseller']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');
$id_reseller = $_SESSION['reseller'];
?>	
	<div class="container" id="judul_h1">
		<h1>DATA BALANJA</h1>
	
	</div>
	
	<div id="t4_tambah_data" style="display:none"></div>
	
	<div class="container" id="t4_table">
	
<table id="tbl_confirmasinya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
			<tr >
				
				
				<th >Id Confirmasi</th>
				<th > Jumlah Item </th>
				<th > Tanggal Order</th>
				<th > Tanggal Confirm</th>
				<th >Status</th>
				<th  width="75px">&nbsp;&nbsp;&nbsp;Pilihan</th>
				
			</tr>
			</thead>
			
			<tbody>


	<?php 
	
     
     $rowSet = $db->query("SELECT a.*, b.nama_pelanggan, b.id_pelanggan FROM tbl_confirmasi a INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan WHERE a.id_pelanggan='$id_reseller' GROUP BY a.id_confirmasi ORDER BY a.status_confirmasi DESC, a.id_uniq DESC");  
	 $nourut =0;
     while($row = $rowSet->fetch_object()){ 
		$id_pelanggan = $row->id_pelanggan;
		$temp 	= $row->id_confirmasi;
		$hit 	= $db->query("SELECT COUNT(*) AS jumlah FROM tbl_confirmasi WHERE id_confirmasi = '$temp'");
		$jumlah = $hit->fetch_object();
	    $nourut++;
     
		 $aktif = $row->status_confirmasi;
		 if($aktif==0){ 				
				$link_conf 	= '<span class="btn btn-xs btn-default btn-warning" href="'.$temp.'" >Not checked</span>';
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
			$tgl_disetujui  = tanggalindo($row->tgl_disetujui)." ".$row->jam_confirmasi;
		}
		
		
	  
	  
	 
     
	 ?>
	 

			<tr id="tr_nya"<?php echo $class_tr?>>
				
				
				<td ><a href="view/view_deatil_confirm.php?id_confirm=<?php echo $row->id_confirmasi;?>&status=<?php echo $row->status_confirmasi;?>" title="REPORT BELANJA"  ><?php echo  $row->id_confirmasi;?></a></td>
				<td ><?php echo  $jumlah->jumlah;?></td>
				<td ><?php echo  tanggalindo($row->tgl_confirmasi)." ".$row->jam_confirmasi;?></td>
				<td ><?php echo  $tgl_disetujui;?></td>
				<td id="statusnya"><?php echo  $notif;?>
						
						
					</td>

				<td  id=""> <span id="link_conf"><?php echo $link_conf;?></span>
					
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
														<td class="data"style="text-align:right"><b>Total : &nbsp;&nbsp;&nbsp;</b></td>
														<td class="data" style="text-align:right"> <b>Rp.<?php echo rupiah($harga_total);?></b></td>
														
													</tr>
											
											
											</table>
											<?php
												
											$data_pelanggan = $db->query("SELECT a.*, b.nama_provinsi,c.nama_kota FROM tbl_pengiriman a 
																							INNER JOIN tbl_provinsi b ON a.id_provinsi=b.id_provinsi 
																							INNER JOIN tbl_kota c ON a.id_kota=c.id_kota
																					WHERE a.id_pelanggan='$id_pelanggan'")->fetch_object();
											
											echo ""
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
													<td class="data">Alamat </td>	<td class="data"><?php echo $data_pelanggan->alamat_pengiriman;?>, 
																									<?php echo $data_pelanggan->nama_kota;?>,
																									<?php echo $data_pelanggan->nama_provinsi;?>
													
													</td>
												</tr>
											
											</table>
											
											
											<a href="<?php echo $alamat;?>&print" id="hilang">Print</a>
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
			</tr>
			

		<?php 
			} 
		?>

		</tbody>
	</table>


	
</div>

<script>
$(document).ready(function(){

$('#tbl_confirmasinya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});


//get approve

$("#tbl_confirmasinya ").on("click","tbody tr td #link_conf",function(){
	
	
	$(this).parent().find("#setujui_confirm").attr("class","btn btn-xs btn-default btn-success");
	$(this).parent().find("#setujui_confirm").html("Approved");
	$(this).parent().parent().find("#statusnya").html("Telah Disetujui");
	$(this).parent().parent().removeClass("success");
	//alert($(this).parent().parent().find("#tr_nya").html());
	var id_confirmasi = $(this).parent().find("#setujui_confirm").attr("href");
		$.get("part/action_confirmasi.php",{id_confirmasi:id_confirmasi},function(e){
		
			setTimeout(
			  function() 
			  {
					
				load_menu_hash("part/tbl_confirmasi.php");
				
			  }, 1000);	
			  
		});
	
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