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
	<div class="container" id="judul_h1">
		<h1>DATA VIP Member</h1>
		
			
			<div class="alert alert-success alert-dismissable" id="alertnya">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				 Anda berhasil !
			</div>
			
	</div>
	
	<div class="container" id="t4_tambah_data" style="display:none"></div>
	<div class="container" id="t4_table">
	<table id="tbl_pelanggannya" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID </th>					
					<th>Nama</th>
					<th>ALamat</th>
					<th>Email</th>
					<th>Pass</th>
					<th>Telp</th>							
					<th>Tgl Daftar</th>					
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
			
			<?php
				$q = $db->query("SELECT a.*, 
										b.id_prov, 
										b.nama AS nama_provinsi, 
										c.id_kab, 
										c.nama AS nama_kabupaten, 
										d.id_kec, 
										d.nama AS nama_kecamatan, 
										e.id_kel, 
										e.nama AS nama_kelurahan,
										f.code_uniq										
									FROM tbl_pelanggan a
									LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
									LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
									LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
									LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
									INNER JOIN tbl_vip_member f ON a.id_pelanggan = f.id_pelanggan
							WHERE a.vip_member='2' ORDER BY a.id_pelanggan DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
				
				if($data->status_pelanggan==1)
				{
					$status = "On";
					$idnya	= "nonaktifkan";
					$class	= "btn btn-success btn-xs";
				}else if($data->status_pelanggan==0)
				{
					$status = "Off";
					$idnya	= "aktifkan";
					$class	= "btn btn-danger btn-xs";
				}
				
				
				echo
					("
						<tr>
							<td>$no</td>
							<td>$data->nama_pelanggan</td>
							<td>$data->alamat_pelanggan , $data->nama_kelurahan , $data->nama_kecamatan , $data->nama_kabupaten , $data->nama_provinsi </td>
							<td>$data->email_pelanggan</td>
							<td>$data->pass_pelanggan</td>
							<td>$data->telp_pelanggan</td>							
							<td>$data->tgl_daftar</td>											
							<td><a href='$data->id_pelanggan' id='$idnya' class='$class'>$status</a></td>
							<td>
								<input type='text' class='form-control' name='code_uniq' id='code_uniq' value='$data->code_uniq'>
								<br>
								<a href='$data->id_pelanggan' id='out_reseller' class='btn btn-danger btn-xs'>Out</a>
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


$(document).ready(function() {

	$('#alertnya .close').click(function(){
	  $(this).parent().hide();
	});


	$('#tbl_pelanggannya').dataTable();
	
});


$("#tambah_data").click(function(){
	
	panggil_form("part/form_pelanggan.php");
	
	
});


$("#tbl_pelanggannya").on("click", "tbody tr td #aktifkan",function(){
	
	var id_pelanggan 	= $(this).attr("href");
	var aktifkan		='';
	//alert(id_pelanggan);
	
	
	$.get("part/simpan_tambah_pelanggan.php",{id_pelanggan:id_pelanggan,aktifkan:aktifkan},function(e){
		
		if(e==1)
		{
			load_menu_hash("part/tbl_vip_member.php");
		}
	});
	
	
	return false;
	
});

$("#tbl_pelanggannya").on("click", "tbody tr td #nonaktifkan",function(){
	
	var id_pelanggan 	= $(this).attr("href");
	var nonaktifkan		='';
	
	
	$.get("part/simpan_tambah_pelanggan.php",{id_pelanggan:id_pelanggan,nonaktifkan:nonaktifkan},function(e){
		
		if(e==1)
		{
			load_menu_hash("part/tbl_vip_member.php");
		}
	});
	
	
	return false;
	
});

$("#tbl_pelanggannya").on("click", "tbody tr td #out_reseller",function(){
	
	var id_pelanggan 	= $(this).attr("href");
	var out_reseller		='';
	if(confirm("Anda yakin mengeluarkan data dari member?"))
	{
		$.get("part/simpan_tambah_pelanggan.php",{id_pelanggan:id_pelanggan,out_reseller:out_reseller},function(e){
		
			if(e==1)
			{
				load_menu_hash("part/tbl_vip_member.php");
			}
		});
	
	
	}
		
	return false;
	
});
</script>