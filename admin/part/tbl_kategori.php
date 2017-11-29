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
	<h1>DATA KATEGORI</h1>
	<button class="btn btn-primary" id="tambah_data">Tambah Data</button>
	<div id="t4_tambah_data" style="display:none"></div>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	<table id="tbl_kategorinya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
					<th>No</th>
					<th>Nama Kategori </th>
					<th>Jum.Product </th>
					<th>Action</th>
							
				</tr>
			</thead>
			
			<tbody>
			
			<?php
				$q = $db->query("SELECT * FROM tbl_kategori	ORDER BY id_kategori DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					
					$id_kategori	= $data->id_kategori;
					$jum_on = $db->query("SELECT COUNT(id_barang) AS jum_on FROM tbl_barang WHERE FIND_IN_SET('$id_kategori',id_kategori) AND status_barang='1'")->fetch_object();
					$jum_off = $db->query("SELECT COUNT(id_barang) AS jum_off FROM tbl_barang WHERE FIND_IN_SET('$id_kategori',id_kategori) AND status_barang='0'")->fetch_object();
					$on = $jum_on->jum_on;
					$off= $jum_off->jum_off;
					$total = $on+$off;
					
					if($total<=0)
					{
						$link_action ="<a id='edit_kategori' href='$id_kategori'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
						<a id='hapus_kategori' href='$id_kategori' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 															
						";
						
					}else{
						
						$link_action ="<a id='edit_kategori' href='$id_kategori'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>";
						
					}
					
					
					echo 	
					("
						<tr>
							<td>$no</td>
							<td class='nama_kategori'>$data->nama_kategori</td>
							<td class='jum_Product'><a class='btn btn-default btn-xs' id='link_product' href='$id_kategori'>On($on) Off($off)= $total</a></td>
							<td>
								$link_action
								
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

$('#tbl_kategorinya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});


$("#tbl_kategorinya ").on("click","tbody tr td #link_product",function(){
	
	var id_kategori = $(this).attr("href");		

	load_menu_hash("part/tbl_barang.php?id_kategori="+id_kategori);
	
	return false;		
});


$("#tbl_kategorinya ").on("click","tbody tr td #hapus_kategori",function(){
	
	var id_kategori = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/action_table.php?hapus_kategori",{id_kategori:id_kategori},function(e){
								
			$("#alertnya").show(0);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});


$("#tbl_kategorinya ").on("click"," tbody tr td #edit_kategori",function(){

	loading_menu();
	var id_kategori = $(this).attr("href");
	$.get("part/form_edit_kategori.php",{id_kategori:id_kategori}, function(e){
		//alert(e);
		$("#t4_tambah_data").html(e);
			
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
});

$("#tambah_data").click(function(){
	loading_menu();
	
	$.get("part/form_kategori.php", function(e){
		
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