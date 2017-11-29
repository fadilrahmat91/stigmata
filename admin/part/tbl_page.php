<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');

if(isset($_GET['status']))
{
	$status  = $_GET['status'];
	$page_id = $_GET['page_id'];
	if($status == 1)
	{
		$action = 0;
		
	}else if($status ==0)
	{
		$action = 1;
	}
	
	$db->query("UPDATE tbl_page SET status='$action' WHERE page_id='$page_id'");
	die();
}
?>	
	<div class="container">
	<h1>DATA PAGE</h1>
	<button class="btn btn-primary" id="tambah_data">Tambah Page</button>
	<div id="t4_tambah_data" style="display:none"></div>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	<table id="tbl_pagenya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Judul Page </th>
							<th>Action</th>
							
				</tr>
			</thead>
			
			<?php
				$q = $db->query("SELECT * FROM tbl_page ORDER BY page_id DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					
					$page_id	= $data->page_id;
					$status		= $data->status;
					
				if($status ==0)
					{
						$class	= 'btn-danger btn-xs';
						$stat	= 'Off';
						
					}else if($status ==1)
					{
						$class='btn-success btn-xs';
						$stat	= 'On';
					}
					
					echo 	
					("
						<tr>
							<td>$no</td>
							<td class='page_judul'>$data->page_judul</td>
							<td>
								<a id='hapus_page' href='$page_id' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 							
								<a id='edit_page' href='$page_id'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
								<a id='action' href='$page_id' class='$status'><button class='btn $class'>$stat</button></a>
								
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

$('#tbl_pagenya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});

$("#tbl_pagenya ").on("click","tbody tr td #hapus_page",function(){
	
	var page_id = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/action_table.php?hapus_page",{page_id:page_id},function(e){
								
			$("#alertnya").show(0);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});

//edit
$("#tbl_pagenya ").on("click"," tbody tr td #edit_page",function(){

	loading_menu();
	var page_id = $(this).attr("href");
	$.get("part/form_edit_page.php",{page_id:page_id}, function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
});

//On off
$("#tbl_pagenya ").on("click"," tbody tr td #action",function(){
	
	var page_id = $(this).attr("href");
	var status  = $(this).attr("class");
	var target	= "part/tbl_page.php";
		$.get(target,{status:status,page_id:page_id},function(){
			load_menu_hash(target);
		});
	return false;		
});



$("#tambah_data").click(function(){
	loading_menu();
	
	$.get("part/form_page.php", function(e){
		
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