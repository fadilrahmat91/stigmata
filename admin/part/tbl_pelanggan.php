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
		<h1>DATA PELANGGAN</h1>
		
			<button class="btn btn-primary" id="tambah_data">Tambah Data</button>
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
					<th>No</th>					
					<th>Nama</th>
					<th>ALamat</th>
					<th>Email</th>
					<th>Pass</th>
					<th>Telp</th>					
					<th>Tgl Daftar</th>					
					<th>Status</th>
					
				</tr>
			</thead>

			<tbody>
			
			<?php
				$q = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
							FROM tbl_pelanggan a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
							LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
							LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
							WHERE a.vip_member='1' ORDER BY a.id_pelanggan DESC");
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
				
				if($data->admin_cek =='0')
				{
					$class_tr 	= "class='warning'";
				}else{
					$class_tr 	= "class=''";
				}
				
				echo
					("
						<tr $class_tr>
							<td>$no</td>
							<td>$data->nama_pelanggan</td>
							<td>$data->alamat_pelanggan , $data->nama_kelurahan , $data->nama_kecamatan , $data->nama_kabupaten , $data->nama_provinsi </td>
							<td>$data->email_pelanggan</td>
							<td>$data->pass_pelanggan</td>
							<td>$data->telp_pelanggan</td>							
							<td>$data->tgl_daftar</td>											
							<td><a href='$data->id_pelanggan' id='$idnya' class='$class'>$status</a></td>
						
							
						</tr>
					");
					
				}
				
				$db->query("UPDATE tbl_pelanggan SET admin_cek='1' WHERE admin_cek='0'");
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
			load_menu_hash("part/tbl_pelanggan.php");
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
			load_menu_hash("part/tbl_pelanggan.php");
		}
	});
	
	
	return false;
	
});

$("#tbl_pelanggannya").on("click", "tbody tr td #set_reseller",function(){
	
	var id_pelanggan 	= $(this).attr("href");
	var set_reseller		='';
	
	var code_uniq 		= $(this).parent().find("#code_uniq").val();
	//alert(code_uniq)
	if(code_uniq =="")
	{
		alert("Code Uniq Harus diisi..!!")
		return false;
	}
	
	
	
	$.get("part/simpan_tambah_pelanggan.php",{code_uniq:code_uniq,id_pelanggan:id_pelanggan,set_reseller:set_reseller},function(e){
		//alert(e);
		//$("body").html(e);
		if(e==1)
		{
			load_menu_hash("part/tbl_pelanggan.php");
		}
	});
	
	
	return false;
	
});
</script>