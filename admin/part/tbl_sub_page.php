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
	$id_sub_page = $_GET['id_sub_page'];
	if($status == 1)
	{
		$action = 0;
		
	}else if($status ==0)
	{
		$action = 1;
	}
	
	$db->query("UPDATE tbl_sub_page SET status='$action' WHERE id_sub_page='$id_sub_page'");
	die();
}

if(isset($_GET['del_tbl_sub_page']))
{
	$id_sub_page = $_GET['id_sub_page'];
	$db->query("DELETE FROM tbl_sub_page WHERE id_sub_page='$id_sub_page'");
	die();
}
?>	
	<div class="container">
	<h1>DATA SUB PAGE</h1>
	<button class="btn btn-primary" id="tambah_data">Tambah Sub Page</button>
	<div id="t4_tambah_data" style="display:none"></div>
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	<table id="tbl_sub_pagenya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Judul Page </th>
							<th>Judul Sub Page </th>
							<th>Action</th>
							
				</tr>
			</thead>
			
			<?php
				$q = $db->query("SELECT a.*,b.page_judul  
												FROM tbl_sub_page a
												LEFT JOIN tbl_page b
												ON a.id_page=b.page_id
											ORDER BY id_sub_page DESC");
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					
					$id_sub_page	= $data->id_sub_page;
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
							<td class='nama_sub_page'>$data->page_judul</td>
							<td class='nama_sub_page'>$data->nama_sub_page</td>
							<td>
								<a id='hapus_sub_page' href='$id_sub_page' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 							
								<a id='edit_sub_page' href='$id_sub_page'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
								<a id='action' href='$id_sub_page' class='$status'><button class='btn $class'>$stat</button></a>
								
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

$('#tbl_sub_pagenya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});

$("#tbl_sub_pagenya ").on("click","tbody tr td #hapus_sub_page",function(){
	
	var id_sub_page = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/tbl_sub_page.php",{del_tbl_sub_page:'del_tbl_sub_page',id_sub_page:id_sub_page},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});

//edit
$("#tbl_sub_pagenya ").on("click"," tbody tr td #edit_sub_page",function(){

	loading_menu();
	var id_sub_page = $(this).attr("href");
	//alert(id_sub_page);
	$.get("part/form_edit_sub_page.php",{id_sub_page:id_sub_page}, function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
});

//On off
$("#tbl_sub_pagenya ").on("click"," tbody tr td #action",function(){
	
	var id_sub_page = $(this).attr("href");
	var status  = $(this).attr("class");
	var target	= "part/tbl_sub_page.php";
		$.get(target,{status:status,id_sub_page:id_sub_page},function(){
			load_menu_hash(target);
		});
	return false;		
});



$("#tambah_data").click(function(){
	loading_menu();
	
	$.get("part/form_sub_page.php", function(e){
		
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