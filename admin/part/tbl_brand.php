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
	<h1>DATA BRAND</h1>
	<button class="btn btn-primary" id="tambah_data">Tambah Data</button>
	<br>
		<a href="../img/brand_155x85.psd">Download template</a>
	<div id="t4_tambah_data" style="display:none"></div>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	<table id="tbl_brandnya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Nama brand </th>
							<th>Logo </th>
							<th>Action</th>
							
				</tr>
			</thead>
			
			<?php
				$q = $db->query("SELECT * FROM tbl_brand ORDER BY id_brand DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					
					$id_brand	= $data->id_brand;
					
					echo 	
					("
						<tr>
							<td>$no</td>
							<td class='nama_brand'>$data->nama_brand</td>
							<td class='logo'><img src='$data->url_image_brand' width='70px'></td>
							<td>
								<a id='hapus_brand' href='$id_brand' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 							
								<a id='edit_brand' href='$id_brand'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
								
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

$('#tbl_brandnya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});

$("#tbl_brandnya ").on("click","tbody tr td #hapus_brand",function(){
	
	var id_brand = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/action_table.php?hapus_brand",{id_brand:id_brand},function(e){
								
			$("#alertnya").show(0);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});


$("#tbl_brandnya ").on("click"," tbody tr td #edit_brand",function(){

	loading_menu();
	var id_brand = $(this).attr("href");
	$.get("part/form_edit_brand.php",{id_brand:id_brand}, function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
});

$("#tambah_data").click(function(){
	loading_menu();
	
	$.get("part/form_brand.php", function(e){
		
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