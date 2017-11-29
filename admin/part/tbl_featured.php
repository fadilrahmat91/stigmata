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
	<h1>DATA PRODUCT</h1>
	<button class="btn btn-primary" id="tambah_data">Tambah Data</button>
	
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	</div>
	
	<div id="t4_tambah_data" style="display:none"></div>
	
	<div class="container" id="t4_table">
	<table id="tbl_barangnya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Nama </th>
							<th>Stok</th>
							<th>Kategori</th>
							<th>Brand</th>    
							<th>Harga</th>
							<th>Harga Coret</th>
							<th>Toko</th>
							<th>SKU Product</th>
						<!--<th>Berat Bersih</th>
							<th>Berat Kotor</th>
							<th>Ukuran Bersih</th>
							<th>Ukuran Kotor</th>	-->
							<th>Tanggal</th>
							<th>Status</th>
							<th>Action</th>
							
				</tr>
			</thead>
		
			<?php
			if(isset($_GET['id_toko']))
			{
				$id_toko = $_GET['id_toko'];
				$q = $db->query("SELECT a.id_barang,
										a.nama_barang, 
										a.stok_barang,
										a.url_images,
										a.harga_barang,
										a.harga_coret,
										a.sku_barang,
										a.berat_bersih,
										a.berat_kotor,
										a.ukuran_besih,
										a.ukuran_kotor,
										a.tgl_details_update,														
										a.status_barang,														
										a.id_kategori,
										a.id_toko,
										a.admin_check,
										c.nama_toko,
										d.nama_brand										
									FROM tbl_barang a
									INNER JOIN tbl_toko c
										ON a.id_toko = c.id_toko
									INNER JOIN tbl_brand d
										ON a.id_brand = d.id_brand
									WHERE a.id_toko='$id_toko'
									ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC");
									
			}else if(isset($_GET['id_kategori']))
			{
				$id_kategori = $_GET['id_kategori'];
				
				
				$q = $db->query("SELECT a.id_barang,
										a.nama_barang, 
										a.stok_barang,
										a.url_images,
										a.harga_barang,
										a.harga_coret,
										a.sku_barang,
										a.berat_bersih,
										a.berat_kotor,
										a.ukuran_besih,
										a.ukuran_kotor,
										a.tgl_details_update,														
										a.status_barang,														
										a.id_kategori,
										a.id_toko,
										a.admin_check,
										c.nama_toko,
										d.nama_brand										
									FROM tbl_barang a
									INNER JOIN tbl_toko c
										ON a.id_toko = c.id_toko
									INNER JOIN tbl_brand d
										ON a.id_brand = d.id_brand
									WHERE FIND_IN_SET($id_kategori,a.id_kategori)
									ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC");
			}else{
				
				$q = $db->query("SELECT a.id_barang,
										a.nama_barang, 
										a.stok_barang,
										a.url_images,
										a.harga_barang,
										a.harga_coret,
										a.sku_barang,
										a.berat_bersih,
										a.berat_kotor,
										a.ukuran_besih,
										a.ukuran_kotor,
										a.tgl_details_update,														
										a.status_barang,														
										a.id_kategori,
										a.id_toko,
										a.admin_check,
										c.nama_toko,
										d.nama_brand										
									FROM tbl_barang a
									INNER JOIN tbl_toko c
										ON a.id_toko = c.id_toko
									INNER JOIN tbl_brand d
										ON a.id_brand = d.id_brand																				
									ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC");
			}
				
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					$id_barang = $data->id_barang;
					
					if($data->status_barang == 1){
						$status_barang = "On";
						$class_status = "btn btn-success btn-xs non_aktifkan_barang";
						$link_product = "<a  href='#' target='_blank'>$data->nama_barang</a>";
					}else{
						$status_barang = "Off";
						$class_status = "btn btn-danger btn-xs aktifkan_barang ";
						$link_product = $data->nama_barang;
					}
					
					if($data->admin_check ==0)
					{
						$class_tr = "class='success'";
					}else{
						$class_tr = "";
					}
					
					$ar_id_kat = explode(",",$data->id_kategori);
					
					$form_edit_inline_stok = "<form action=\"#\" id=\"form_update_inline_stok\" method=\"post\">
												<input type=\"hidden\" value=\"$data->id_barang\" id=\"inline_id_barang\">
												<input type=\"number\" size=5 style=\"width:80px;\"value=\"$data->stok_barang\" id=\"inline_stok\" class=\"form-control \">
												<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"btn btn-success btn-xs\">
											</form>";
					
					echo 	
					("
						<tr $class_tr>
							<td>$no</td>
							<td ><div  id='popover_url_images' data-trigger='hover' rel='popover' data-content='<img src=$data->url_images width=100%>' data-placement='top'>$link_product</div></td>													
							
					");
					
					
					echo 	
					("					
							<td id='td_stok'>								
									<div  id='td_stok_barang'>
										<a href='#' id='a_stok'>$data->stok_barang</a>
										
										$form_edit_inline_stok
										
									</div>																	
							</td>
							<td >
					");
					
					
							foreach($ar_id_kat as $get_id){
								$q_kat = $db->query("SELECT id_kategori,nama_kategori FROM tbl_kategori WHERE id_kategori='$get_id'")->fetch_object();
									
									echo "<span class='btn btn-default btn-xs id_kategori' id='$get_id'>";
										echo $q_kat->nama_kategori;
									echo "</span>";
									
							}
					echo ("
							</td>							
						
							<td >$data->nama_brand</td>	
							
						  ");
							
							
					
					$form_edit_inline_harga = "<form action=\"#\" id=\"form_update_inline_harga\" method=\"post\">
													<input type=\"hidden\" value=\"$data->id_barang\" id=\"inline_id_barang\">
													<input type=\"text\"  style=\"width:120px;\" value=\"".rupiah($data->harga_barang)."\" id=\"inline_harga\" class=\"form-control \">
													<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"btn btn-success btn-xs\">
												</form>";
					$harga_barang = rupiah($data->harga_barang);
						echo ("	
							<td align='right' id='td_harga'>
									<div  id='td_harga_barang'>
										<a href='#' id='a_harga'>$harga_barang</a>
										
										$form_edit_inline_harga
										
									</div>																									
							</td>					
							");
							
					$form_edit_inline_harga_coret = "<form action=\"#\" id=\"form_update_inline_harga_coret\" method=\"post\">
													<input type=\"hidden\" value=\"$data->id_barang\" id=\"inline_id_barang\">
													<input type=\"text\"  style=\"width:120px;\" value=\"".rupiah($data->harga_coret)."\" id=\"inline_harga_coret\" class=\"form-control \">
													<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"btn btn-success btn-xs\">
												</form>";
					$harga_coret = rupiah($data->harga_coret);
						echo ("	
							<td align='right' id='td_harga_coret'>
									<div  id='td_harga_coret'>
										<a href='#' id='a_harga_coret'>$harga_coret</a>
										
										$form_edit_inline_harga_coret
										
									</div>																									
							</td>					
							");
						
						echo ("	
							
							<td ><span class='btn btn-default btn-xs id_toko' id='$data->id_toko'>$data->nama_toko</span></td>							
							<td >$data->sku_barang</td>	
							
					<!--	<td >$data->berat_bersih</td>							
							<td >$data->berat_kotor</td>							
							<td >$data->ukuran_besih</td>							
							<td >$data->ukuran_kotor</td>	-->
							
							<td >$data->tgl_details_update</td>							
							<td ><button class='$class_status' id='$id_barang'>$status_barang</button></td>							
							<td>
								<a id='hapus_barang' href='$id_barang' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 							
								<a id='edit_barang' href='$id_barang'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
								
							</td>
							
							
						</tr>
					");
					
				}
			?>
				
				
			</tbody>
		</table>
		
		
		
		
</div>

<script>
$("#alertnya,#edit_hide,#form_update_inline_stok,#form_update_inline_harga,#form_update_inline_harga_coret").hide(0);

$("#tbl_barangnya tbody tr td #popover_url_images").popover({
	html: true
});


$(document).ready(function(){

$('#tbl_barangnya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});


//get inline harga coret
$("#tbl_barangnya ").on("click","tbody tr #td_harga_coret #a_harga_coret",function(){
	
	$(this).parent().find("#form_update_inline_harga_coret").show();
	$(this).parent().find("#a_harga_coret").hide();
		
	return false;		
});


$("#tbl_barangnya ").on("submit","tbody tr #td_harga_coret #form_update_inline_harga_coret",function(){
	
	var harga_coret = $(this).find("#inline_harga_coret").val();
	var id_barang = $(this).find("#inline_id_barang").val();
	var edit_harga_coret = '';
	
		$.post("part/simpan_edit_inline_barang.php",{id_barang:id_barang,edit_harga_coret:edit_harga_coret,harga_coret:harga_coret},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
	
	$(this).hide();
	$(this).parent().find("#a_harga_coret").html(harga_coret).show();
	
	return false;		
});

//get inline harga
$("#tbl_barangnya ").on("click","tbody tr #td_harga #a_harga",function(){
	
	$(this).parent().find("#form_update_inline_harga").show();
	$(this).parent().find("#a_harga").hide();
		
	return false;		
});


$("#tbl_barangnya ").on("submit","tbody tr #td_harga #form_update_inline_harga",function(){
	
	var harga_barang = $(this).find("#inline_harga").val();
	var id_barang = $(this).find("#inline_id_barang").val();
	var edit_harga = '';
	
		$.post("part/simpan_edit_inline_barang.php",{id_barang:id_barang,edit_harga:edit_harga,harga_barang:harga_barang},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
	
	$(this).hide();
	$(this).parent().find("#a_harga").html(harga_barang).show();
	
	return false;		
});


//get inline stok
$("#tbl_barangnya ").on("click","tbody tr #td_stok #a_stok",function(){
	
	$(this).parent().find("#form_update_inline_stok").show();
	$(this).parent().find("#a_stok").hide();
		
	return false;		
});


$("#tbl_barangnya ").on("submit","tbody tr #td_stok #form_update_inline_stok",function(){
	
	var stok_barang = $(this).find("#inline_stok").val();
	var id_barang = $(this).find("#inline_id_barang").val();
	var edit_stok = '';
	
		$.post("part/simpan_edit_inline_barang.php",{id_barang:id_barang,edit_stok:edit_stok,stok_barang:stok_barang},function(e){
								
			$("#alertnya").show(0);
			
			
		});
		
	
	$(this).hide();
	$(this).parent().find("#a_stok").html(stok_barang).show();
	
	return false;		
});


//get_by kategori
$("#tbl_barangnya ").on("click","tbody tr td .id_kategori",function(){
	
	var id_kategori = $(this).attr("id");		

	load_menu_hash("part/tbl_barang.php?id_kategori="+id_kategori);
	//alert(id_kategori);
	
	return false;		
});

//get_by toko
$("#tbl_barangnya ").on("click","tbody tr td .id_toko",function(){
	
	var id_toko = $(this).attr("id");		

	load_menu_hash("part/tbl_barang.php?id_toko="+id_toko);
	
	return false;		
});

//hapus
$("#tbl_barangnya ").on("click","tbody tr td #hapus_barang",function(){
	
	var id_barang = $(this).attr("href");		

	var deletenya = confirm("Yakin menghapus data ini?");			

	if(deletenya)
	{
		$.get("part/action_table.php?hapus_barang",{id_barang:id_barang},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
		$(this).parent().parent().fadeOut();
	
	}
	
	return false;		
});

//nonaktifkan
$("#tbl_barangnya ").on("click"," tbody tr td .non_aktifkan_barang",function(){
	
	var id_barang = $(this).attr("id");		

	var non_aktifkan_barang = confirm("Yakin menonaktifkan data ini?");			
	loading_menu();
	if(non_aktifkan_barang)
	{
		$.get("part/action_table.php?non_aktifkan_barang",{id_barang:id_barang},function(e){
								
			bootstrap_alert.success('Telah di non Aktifkan..');
			//alert(e);
			//load_menu_hash("part/tbl_barang.php");
			
		});
				
	$(this).attr("class","btn btn-danger btn-xs aktifkan_barang");
	$(this).html("Off");
	
	}
	loading_menu_hide();
	
	return false;		
});



//aktifkan
$("#tbl_barangnya ").on("click"," tbody tr td .aktifkan_barang",function(){

	
	var id_barang = $(this).attr("id");		

	var aktifkan_barang = confirm("Yakin mengaktifkan data ini?");			
	loading_menu();
	if(aktifkan_barang)
	{
		$.get("part/action_table.php?aktifkan_barang",{id_barang:id_barang},function(e){
								
			bootstrap_alert.success('Telah di Aktifkan..');
			//alert(e);
				
			//load_menu_hash("part/tbl_barang.php");
		});
		
	$(this).attr("class","btn btn-success btn-xs non_aktifkan_barang");
	$(this).html("On");	
	
	}
	loading_menu_hide();
	return false;		
});


//edit
$("#tbl_barangnya ").on("click"," tbody tr td #edit_barang",function(){

	loading_menu();	
	var id_barang = $(this).attr("href");
	$.get("part/form_edit_barang.php",{id_barang:id_barang}, function(e){
		
		//alert(e);
		
		if($("#t4_tambah_data").html(''))
		{
			if($("#t4_tambah_data").html(e))
			{
				$("#t4_tambah_data").fadeIn("slow");
			}
		}
		notif_function("t4_notif_newbarang","hitNewProduct");
		
		loading_menu_hide();
		
	});
	
	return false;		
});




//panggil form
$("#tambah_data").click(function(){
	
	tambah_barang();
	
});

/*
var url = document.URL;
var hash = url.substring(url.indexOf('#')+1);
alert(hash);
*/
});






</script>