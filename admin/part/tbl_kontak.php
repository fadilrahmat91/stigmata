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
	<h1>DATA KONTAK</h1>

	<div id="t4_tambah_data" style="display:none"></div>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	<table id="tbl_kontaknya" class="table  table-striped "  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Nama </th>
							<th>Email </th>
							<th>Pesan </th>
							<th>Action</th>
							
				</tr>
			</thead>
			
			<?php
				$q = $db->query("SELECT * FROM tbl_kontak ORDER BY id_kontak DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					
					$id_kontak	= $data->id_kontak;
					
					if($data->status==0)
					{
						$class="class='info'";
					}else{
						$class="class=''";
					}
						
					
					echo 	
					("
						<tr $class>
							<td>$no</td>
							<td class='Name'>$data->Name</td>
							<td class='Email'>$data->Email</td>
							<td class='Email'>$data->Message</td>
							
							<td>
								<button type='button' class='btn btn-danger btn-xs' id='hapus_kontak' href='$data->id_kontak'><span class='glyphicon glyphicon-remove'></span> </button> 
								<button type='button' class='btn btn-info btn-xs' id='seen_kontak' href='$data->id_kontak'><span class='glyphicon glyphicon-eye-open'></span> </button>
								
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

$('#tbl_kontaknya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});

$("#tbl_kontaknya ").on("click","tbody tr td #hapus_kontak",function(){
	
	var id_kontak = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			
	
	if(deletenya)
	{
		$.get("part/action_table.php?hapus_kontak",{id_kontak:id_kontak},function(e){
								
			$("#alertnya").show(0);
			notif_function("t4_notif_kontak","hitNewKontak");
			
		});
		
		$(this).parent().parent().fadeOut();
		
	
	}
	
	return false;		
});


$("#tbl_kontaknya ").on("click"," tbody tr td #seen_kontak",function(){
	
	loading_menu();
	var id_kontak = $(this).attr("href");
	$.get("part/action_table.php?seen_kontak",{id_kontak:id_kontak}, function(e){
		$("#alertnya").show(0);
		$(this).parent().parent().removeClass("info");
		notif_function("t4_notif_kontak","hitNewKontak");
		loading_menu_hide();		
	});
	
	return false;		
});

$("#tambah_data").click(function(){
	loading_menu();
	
	$.get("part/form_kontak.php", function(e){
		
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