<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting.php');
?>	
	<div class="container">
	<h1>DATA AKTIVITAS</h1>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	
	<table id="tbl_pesan" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>No</th>					
					<th>Nama</th>
					<th>Penerima</th>
					<th>Pesan</th>
					<th>Tgl_kirim</th>
					<th>Jam_kirim</th>
					<th>Tgl_baca</th>
					<th>Jam_baca</th>
					<th>Action</th>
				</tr>
			</thead>
	 <!--
			<tfoot>
				<tr>
					<th>No</th>					
					<th>Nama</th>
					<th>Penerima</th>
					<th>Pesan</th>
					<th>Tgl_kirim</th>
					<th>Jam_kirim</th>
					<th>Tgl_baca</th>
					<th>Jam_baca</th>
					<th>Action</th>
				</tr>
			</tfoot>
	 -->
			<tbody>
			
			<?php
				$q = $db->query("SELECT a.*, b.*, c.nama AS nama_penerima 
										FROM tbl_pesan a 
											INNER JOIN tbl_user b ON a.id_pengirim=b.id_user 
											INNER JOIN tbl_user c ON a.id_penerima=c.id_user 											
											ORDER BY a.id_pesan DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					$penerima	= $data->nama_penerima;
					$id_pesan	= $data->id_pesan;
					echo 
					("
						<tr>
							<td>$no</td>
							<td>$data->nama</td>
							<td>$penerima</td>
							<td>$data->isi_pesan</td>
							<td>$data->tgl_kirim</td>
							<td>$data->jam_kirim</td>
							<td>$data->tgl_baca</td>
							<td>$data->jam_baca</td>
							<td><a href='$id_pesan'>Hapus</a></td>
							
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


    $('#tbl_pesan').dataTable();
	
	$("#tbl_pesan tbody tr td a").click(function(){
		
		var id_pesan = $(this).attr("href");		

		var deletenya = confirm("Yakin menghapus data ini?");			

		if(deletenya)
		{
			$.get("part/action_table.php?hapus_pesan",{id_pesan:id_pesan},function(e){
									
				$("#alertnya").show(0);
				
			});
			
			$(this).parent().parent().fadeOut();
		
		}
		
		return false;		
	});
	
	

	
	
} );
</script>