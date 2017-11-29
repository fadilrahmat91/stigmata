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
	<div id="judul_h1">
	<b>DATA PRODUCT</b>
	<br>
	<button class="btn btn-primary" id="tambah_data">Tambah Data</button>
	
		<div class="alert alert-success alert-dismissable" id="alertnya">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			 Anda berhasil !
        </div>
	<div id="alert_placeholder"></div>
	</div>
	
	<a href="#">All</a>
	<div id="t4_tambah_data" style="display:none"></div>
	
	<div id="t4_table">
	<table id="tbl_barangnya" class="table  table-bordered"  cellspacing="0" width="100%">
			<thead>
				<tr>
							
							
							<th>No</th>
							<th>Nama </th>
							<th>Stok</th>
						<!--<th>Kategori</th>-->
						<!--<th>Brand</th>    -->							
							<th>Harga Coret</th>							
							<th>Harga Normal</th>
							<th>Harga Member</th>
							<th>SKU Product</th>
						<!--<th>Berat Bersih</th>
							<th>Berat Kotor</th>
							<th>Ukuran Bersih</th>
							<th>Ukuran Kotor</th>	-->
							<th>Tanggal</th>
							<th>Status</th>
							<th>Promo</th>
							<th>Action</th>
							
				</tr>
			</thead>
		
			<?php
			if(isset($_GET['id_kategori']))
			{
				$id_kategori = $_GET['id_kategori'];
				
				
				$q = $db->query("SELECT a.*,	
										b.nama_kategori,
										c.id_images,
										c.url_images,		
										d.nama_brand										
									FROM tbl_barang a	
									INNER JOIN tbl_kategori b
										ON a.id_kategori = b.id_kategori
									LEFT JOIN tbl_images_barang c
										ON a.id_barang = c.id_barang
									INNER JOIN tbl_brand d
										ON a.id_brand = d.id_brand	
									WHERE a.id_kategori='$id_kategori'										
									GROUP BY a.id_barang
									ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC");
			}else if(isset($_GET['tbl_barang_new']))
			{
				
				$q = $db->query("SELECT a.*,	
										b.nama_kategori,
										c.id_images,
										c.url_images,		
										d.nama_brand										
									FROM tbl_barang a	
									LEFT JOIN tbl_kategori b
										ON a.id_kategori = b.id_kategori
									LEFT JOIN tbl_images_barang c
										ON a.id_barang = c.id_barang
									LEFT JOIN tbl_brand d
										ON a.id_brand = d.id_brand	
									WHERE a.admin_check='0'										
									GROUP BY a.id_barang
									ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC");
			}else if(isset($_GET['tbl_barang_featured']))
			{
				
				$q = $db->query("SELECT a.*,	
										b.nama_kategori,
										c.id_images,
										c.url_images,		
										d.nama_brand										
									FROM tbl_barang a	
									LEFT JOIN tbl_kategori b
										ON a.id_kategori = b.id_kategori
									LEFT JOIN tbl_images_barang c
										ON a.id_barang = c.id_barang
									LEFT JOIN tbl_brand d
										ON a.id_brand = d.id_brand														
									WHERE a.featured='1'
									GROUP BY a.id_barang
									ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC");
			}else{
				
				$q = $db->query("SELECT a.*,	
										b.nama_kategori,
										c.id_images,
										c.url_images,		
										d.nama_brand										
									FROM tbl_barang a	
									INNER JOIN tbl_kategori b
										ON a.id_kategori = b.id_kategori
									LEFT JOIN tbl_images_barang c
										ON a.id_barang = c.id_barang
									INNER JOIN tbl_brand d
										ON a.id_brand = d.id_brand														
									GROUP BY a.id_barang
									ORDER BY a.admin_check ASC, a.status_barang DESC, a.id_barang DESC");
			}
				
				$no = 0;
				while($data=$q->fetch_object())
				{
					$no++;
					$id_barang = $data->id_barang;
					
					if($data->status_barang == 1){
						$status_barang = "On - $data->status_barang";
						$class_status = "btn btn-success btn-xs non_aktifkan_barang";
						$link_product = "<a  href='#' target='_blank'>$data->nama_barang</a>";
					}else{
						$status_barang = "Off - $data->status_barang";
						$class_status = "btn btn-danger btn-xs aktifkan_barang ";
						$link_product = $data->nama_barang;
					}
					
					if($data->admin_check ==0)
					{
						$class_tr = "class='success'";
					}else{
						$class_tr = "";
					}
					
					if($data->featured =="1")
					{
						$info = "On";
						$class_featured = "btn btn-success btn-xs ";
					}else{
						$info = "Off";
						$class_featured = "btn btn-danger btn-xs  ";
					}
					
					$ar_id_kat = explode(",",$data->id_kategori);
					
					$form_edit_inline_stok = "<form action=\"#\" id=\"form_update_inline_stok\" method=\"post\">
												<input type=\"hidden\" value=\"$data->id_barang\" id=\"inline_id_barang\">
												<input type=\"number\" size=5 style=\"width:80px;\"value=\"$data->stok_barang\" id=\"inline_stok\" class=\"form-control \">
												<br>
												<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"btn btn-success btn-xs\">
												<input type=\"button\" name=\"submit\" value=\"Cancel\" id=\"Cancel\" class=\"btn btn-warning btn-xs\">
											</form>";
					
					echo 	
					("
						<tr $class_tr>
							<td>$no</td>
							<td ><div  id='popover_url_images' data-trigger='hover' rel='popover' data-content='<img src=".ambil_thumbs($data->url_images)." width=100%>' data-placement='top'>$link_product</div></td>													
							
					");
					
					
					echo 	
					("					
							<td id='td_stok'>								
									<div  id='td_stok_barang'>
										<a href='#' id='a_stok'>$data->stok_barang</a>
										
										$form_edit_inline_stok
										
									</div>																	
							</td>
							
							
					");
					
						echo '<!--<td >';
							foreach($ar_id_kat as $get_id){
								$q_kat = $db->query("SELECT id_kategori,nama_kategori FROM tbl_kategori WHERE id_kategori='$get_id'")->fetch_object();
									
									echo "<span class='btn btn-default btn-xs id_kategori' id='$get_id'>";
										echo $q_kat->nama_kategori;
									echo "</span>";
									
							}
						echo '</td>-->';
							
					echo ("
													
						
							<!--<td >$data->nama_brand</td>	-->
							
						  ");
							
							
					
				
					$form_edit_inline_harga_coret = "<form action=\"#\" id=\"form_update_inline_harga_coret\" method=\"post\">
													<input type=\"hidden\" value=\"$data->id_barang\" id=\"inline_id_barang\">
													<input type=\"text\"  style=\"width:120px;\" value=\"".rupiah($data->harga_coret)."\" id=\"inline_harga_coret\" class=\"form-control \">
													<br>
													<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"btn btn-success btn-xs\">
													<input type=\"button\" name=\"submit\" value=\"Cancel\" id=\"Cancel\" class=\"btn btn-warning btn-xs\">
												</form>";
					$harga_coret = rupiah($data->harga_coret);
						echo ("	
							<td align='right' id='td_harga_coret'>
									<div  id='td_harga_coret'>
										<a href='#' id='a_harga_coret'><s>$harga_coret</s></a>
										
										$form_edit_inline_harga_coret
										
									</div>																									
							</td>					
							");
						
						
					$form_edit_inline_harga = "<form action=\"#\" id=\"form_update_inline_harga\" method=\"post\">
													<input type=\"hidden\" value=\"$data->id_barang\" id=\"inline_id_barang\">
													<input type=\"text\"  style=\"width:120px;\" value=\"".rupiah($data->harga_barang)."\" id=\"inline_harga\" class=\"form-control \">
													<br>
													<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"btn btn-success btn-xs\">
													<input type=\"button\" name=\"submit\" value=\"Cancel\" id=\"Cancel\" class=\"btn btn-warning btn-xs\">
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
							
							
							
							
						
					$form_edit_inline_harga_member = "<form action=\"#\" id=\"form_update_inline_harga_member\" method=\"post\">
													<input type=\"hidden\" value=\"$data->id_barang\" id=\"inline_id_barang\">
													<input type=\"text\"  style=\"width:120px;\" value=\"".rupiah($data->harga_member)."\" id=\"inline_harga_member\" class=\"form-control \">
													<br>
													<input type=\"submit\" name=\"submit\" value=\"Update\" class=\"btn btn-success btn-xs\">
													<input type=\"button\" name=\"submit\" value=\"Cancel\" id=\"Cancel\" class=\"btn btn-warning btn-xs\">
												</form>";
					$harga_member = rupiah($data->harga_member);
						echo ("	
							<td align='right' id='td_harga_member'>
									<div  id='td_harga_member'>
										<a href='#' id='a_harga_member'>$harga_member</a>
										
										$form_edit_inline_harga_member
										
									</div>																									
							</td>					
							");
							
						
						
						
						
						
						
						
						
						
						
						echo "	
							

							<td >$data->sku_barang</td>	
							
					<!--	<td >$data->berat_bersih</td>							
							<td >$data->berat_kotor</td>							
							<td >$data->ukuran_besih</td>							
							<td >$data->ukuran_kotor</td>	-->
							
							<td >$data->tgl_details_update</td>							
							<td ><button class='$class_status' id='$id_barang'>$status_barang</button></td>							
							<td >";?>
									<input type="checkbox" title="<?php echo ($data->id_barang)?>" id="featured" name="featured" value="<?php echo ($data->featured)?>" <?php  if($data->featured =='1'){ echo 'checked'; }?>> Featured <br>
									<input type="checkbox" title="<?php echo ($data->id_barang)?>" id="new_arrival" name="new_arrival"  value="<?php echo ($data->new_arrival)?>" <?php  if($data->new_arrival=='1'){ echo 'checked';}?>> New Arrival <br>
									<input type="checkbox" title="<?php echo ($data->id_barang)?>" id="hot_deal" name="hot_deal" value="<?php echo ($data->hot_deal)?>" <?php if($data->hot_deal=='1'){ echo 'checked';}?>> Hot Deal <br>
						
						<?php
						echo "</td>
							<!--<td ><a id='featured' href='$id_barang' ><button class='$class_featured'>$info</button></a></td>-->
							<td>
								<a id='hapus_barang' href='$id_barang' title='Hapus'><img src='".$alamat."admin/img/delete.png'></a> 							
								<a id='edit_barang' href='$id_barang'><img src='".$alamat."admin/img/edit.png' title='Edit'></a>
								
								
								
							</td>
							
							
							
						</tr>
					";
					
				}
			?>
				
				
			</tbody>
		</table>
		
		
		
		
</div>

<script>
$("#alertnya,#edit_hide,#form_update_inline_stok,#form_update_inline_harga,#form_update_inline_harga_member,#form_update_inline_harga_coret").hide(0);

$("#tbl_barangnya tbody tr td #popover_url_images").popover({
	html: true
});


$(document).ready(function(){

$('#tbl_barangnya').dataTable();


$('#alertnya .close').click(function(){
  $(this).parent().hide();
});


//------------------------------------------------harga coret-------------------------------------------//
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

//cancel
$("#tbl_barangnya ").on("click","tbody tr #td_harga_coret #form_update_inline_harga_coret #Cancel",function(){	

	var harga_coret = $(this).parent().find("#inline_harga_coret").val();		
	$(this).parent().hide();
	$(this).parent().parent().find("#a_harga_coret").html(harga_coret).show();
	
	return false;		
});
//------------------------------------------------harga coret-------------------------------------------//






//------------------------------------------------harga-------------------------------------------//
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



//cancel
$("#tbl_barangnya ").on("click","tbody tr #td_harga #form_update_inline_harga #Cancel",function(){	
	var harga_barang = $(this).parent().find("#inline_harga").val();		
	$(this).parent().hide();
	$(this).parent().parent().find("#a_harga").html(harga_barang).show();
	
	return false;		
});
//------------------------------------------------harga-------------------------------------------//




//------------------------------------------------harga member-------------------------------------------//
//get inline harga
$("#tbl_barangnya ").on("click","tbody tr #td_harga_member #a_harga_member",function(){
	
	$(this).parent().find("#form_update_inline_harga_member").show();
	$(this).parent().find("#a_harga_member").hide();
		
	return false;		
});


$("#tbl_barangnya ").on("submit","tbody tr #td_harga_member #form_update_inline_harga_member",function(){
	
	var harga_member = $(this).find("#inline_harga_member").val();
	var id_barang = $(this).find("#inline_id_barang").val();
	var edit_harga_member = '';
	
		$.post("part/simpan_edit_inline_barang.php",{id_barang:id_barang,edit_harga_member:edit_harga_member,harga_member:harga_member},function(e){
								
			$("#alertnya").show(0);
			//alert(e);
			
		});
		
	
	$(this).hide();
	$(this).parent().find("#a_harga_member").html(harga_member).show();
	
	return false;		
});



//cancel
$("#tbl_barangnya ").on("click","tbody tr #td_harga_member #form_update_inline_harga_member #Cancel",function(){	

	var harga_member = $(this).parent().find("#inline_harga_member").val();		
	$(this).parent().hide();
	$(this).parent().parent().find("#a_harga_member").html(harga_member).show();
	
	return false;		
});
//------------------------------------------------harga member-------------------------------------------//





//------------------------------------------------stok-------------------------------------------//
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


$("#tbl_barangnya ").on("click","tbody tr #td_stok #form_update_inline_stok #Cancel",function(){
	var stok = $(this).parent().find("#inline_stok").val();
	$(this).parent().parent().find("#a_stok").html(stok).show();
	$(this).parent().hide();	
	
	return false;		
});
//------------------------------------------------stok-------------------------------------------//






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


//new_arrival
$("#tbl_barangnya tr td #new_arrival").change(function(){
		
	$(this).val(this.checked ? 1 : 0);
    var valnya = $(this).val();
    var id_barang = $(this).attr('title');
	var promo = $(this).attr('id');
	//alert(id_barang);		
		$.get("part/action_table.php",{promo:promo,valnya:valnya,id_barang:id_barang},function(e){
								
		});
		
});


//featured
$("#tbl_barangnya tr td #featured").change(function(){
		
	$(this).val(this.checked ? 1 : 0);
    var valnya = $(this).val();
    var id_barang = $(this).attr('title');
	var promo = $(this).attr('id');
	//alert(id_barang);		
		$.get("part/action_table.php",{promo:promo,valnya:valnya,id_barang:id_barang},function(e){
								
		});
		
});


//hot_deal
$("#tbl_barangnya tr td #hot_deal").change(function(){
		
	$(this).val(this.checked ? 1 : 0);
    var valnya = $(this).val();
    var id_barang = $(this).attr('title');
	var promo = $(this).attr('id');
	//alert(id_barang);		
		$.get("part/action_table.php",{promo:promo,valnya:valnya,id_barang:id_barang},function(e){
								
		});
		
});


//featured lama
/*
$("#tbl_barangnya ").on("click","tbody tr td #featured",function(){
	
	var id_barang = $(this).attr("href");		

	
		$.get("part/action_table.php?featured",{id_barang:id_barang},function(e){
								
			load_menu_hash("part/tbl_barang.php");
			//alert(e);
			
		});
		
		
	
	return false;		
});
*/

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