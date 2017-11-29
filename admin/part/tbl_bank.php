<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
?>	
	<div class="container">
	<h1>DATA BANK</h1>
	<button class="btn btn-primary" id="tambah_data">Tambah Data</button>
	<div id="t4_tambah_data" style="display:none"></div>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	<table id="tbl_banknya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Nama Bank </th>
							<th>No Rek  </th>
							<th>Nama Rek </th>
							<th>Action</th>
							
				</tr>
			</thead>
			
			<?php
				$q = $db->query("SELECT * FROM tbl_bank ORDER BY id_bank DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					
					$id_bank	= $data->id_bank;
					
					echo 	
					("
						<tr>
							<td>$no</td>
							<td class='nama_bank'>$data->nama_bank</td>
							<td class='nomor_rek'>$data->nomor_rek</td>
							<td class='nomor_rek'>$data->nama_rek</td>
							
							<td>
								<a id='hapus_bank' href='$id_bank' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 							
								<a id='edit_bank' href='$id_bank'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
								
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
loading_menu_hide();
	

$(document).ready(function(){

$('#tbl_banknya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});

$("#tbl_banknya ").on("click","tbody tr td #hapus_bank",function(){
	
	var id_bank = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/action_table.php?hapus_bank",{id_bank:id_bank},function(e){
								
			$("#alertnya").show(0);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});


$("#tbl_banknya ").on("click"," tbody tr td #edit_bank",function(){

	loading_menu();
	var id_bank = $(this).attr("href");
	$.get("part/form_edit_bank.php",{id_bank:id_bank}, function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
});

$("#tambah_data").click(function(){
	loading_menu();
	
	$.get("part/form_bank.php", function(e){
		
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