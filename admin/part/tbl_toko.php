<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');
?>	
	<div class="container">
	<h1>DATA TOKO</h1>
	<button class="btn btn-primary" id="tambah_data">Tambah Data</button>
	<div id="t4_tambah_data" style="display:none"></div>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	<table id="tbl_tokonya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Nama Toko </th>
							<th>Username</th>
							<th>Password</th>
							<th>Alamat</th>
							<th>Email</th>
							<th>Telp</th>
							<th>No.rek</th>
							<th>Atas Nama</th>
							<th>Jum.Product</th>							
							<th>Status</th>							
							<th>Action</th>
							
				</tr>
			</thead>
			</tbody>
			<?php
				$q = $db->query("SELECT * FROM tbl_toko ORDER BY id_toko DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					
					$id_toko	= $data->id_toko;
					if($data->status_toko == 1){
						$status_toko = "Aktif";
						$class_status = "btn btn-success non_aktifkan";
					}else{
						$status_toko = "Non Aktif";
						$class_status = "btn btn-danger aktifkan";
					}
					$jum_on = $db->query("SELECT COUNT(id_barang) AS jum_on FROM tbl_barang WHERE id_toko='$id_toko' AND status_barang='1'")->fetch_object();
					$jum_off = $db->query("SELECT COUNT(id_barang) AS jum_off FROM tbl_barang WHERE id_toko='$id_toko' AND status_barang='0'")->fetch_object();
					$on = $jum_on->jum_on;
					$off= $jum_off->jum_off;
					$total = $on+$off;
					echo 	
					("
						<tr>
							<td>$no</td>
							<td class='nama_toko'>$data->nama_toko</td>
							<td class='user_toko'>$data->user_toko</td>
							<td class='pass_toko'>$data->pass_toko</td>
							<td class='alamat_toko'>$data->alamat_toko</td>
							<td class='email_toko'>$data->email_toko</td>
							<td class='telp_toko'>$data->telp_toko</td>
							<td class='no_rek_toko'>$data->no_rek_toko</td>
							<td class='atas_nama_toko'>$data->atas_nama_toko</td>
							<td ><a class='btn btn-default btn-xs' id='link_product' href='$id_toko' >On($on) Off($off)= $total</a></td>
							<td class='status_toko '><span class='$class_status btn-xs' id='$id_toko'>$status_toko</span></td>							
							<td>
								<a id='hapus_toko' href='$id_toko' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 							
								<a id='edit_toko' href='$id_toko'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
								
							</td>
							
							
						</tr>
					");
					
				}
			?>
				
				
			</tbody>
		</table>
</div>

<script>
$("#alertnya").hide(0);

	

$(document).ready(function(){

$('#tbl_tokonya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});

$("#tbl_tokonya ").on("click","tbody tr td #link_product",function(){
	
	var id_toko = $(this).attr("href");		

	load_menu_hash("part/tbl_barang.php?id_toko="+id_toko);
	
	return false;		
});

$("#tbl_tokonya ").on("click","tbody tr td #hapus_toko",function(){
	
	var id_toko = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/action_table.php?hapus_toko",{id_toko:id_toko},function(e){
								
			$("#alertnya").show(0);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});


$("#tbl_tokonya ").on("click"," tbody tr td .non_aktifkan",function(){
	
	var id_toko = $(this).attr("id");		

	var non_aktifkan = confirm("Yakin menonaktifkan toko ini?");			

	if(non_aktifkan)
	{
		$.get("part/action_table.php?non_aktifkan",{id_toko:id_toko},function(e){
								
			bootstrap_alert.success('Telah di non Aktifkan..');
			//alert(e);
			load_menu_hash("part/tbl_toko.php");
		});
		
		
	
	}
	
	return false;		
});


$("#tbl_tokonya ").on("click"," tbody tr td .aktifkan",function(){

	
	var id_toko = $(this).attr("id");		

	var aktifkan = confirm("Yakin mengaktifkan toko ini?");			

	if(aktifkan)
	{
		$.get("part/action_table.php?aktifkan",{id_toko:id_toko},function(e){
								
			bootstrap_alert.success('Telah di Aktifkan..');
			//alert(e);
			load_menu_hash("part/tbl_toko.php");
		});
		
		
	
	}
	
	return false;		
});

$("#tbl_tokonya ").on("click"," tbody tr td #edit_toko",function(){

	loading_menu();
	var id_toko = $(this).attr("href");
	$.get("part/form_edit_toko.php",{id_toko:id_toko}, function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
});

$("#tambah_data").click(function(){
	loading_menu();
	
	$.get("part/form_toko.php", function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
	
});

/*
var url = document.URL;
var hash = url.substring(url.indexOf('#')+1);
alert(hash);
*/
});

</script>