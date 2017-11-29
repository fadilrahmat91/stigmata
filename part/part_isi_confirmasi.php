<?php
$id_confirmasi = mysqli_real_escape_string($db,trim($_GET['id_confirmasi']));
	
	$cari = $db->query("SELECT 	a.*, 
								b.nama_pelanggan, 
								b.id_pelanggan ,
								c.status_shipping, 
								c.resi_shipping,
								c.id_shipping,
								c.status_shipping,
								d.nama_shipping,
								e.reason
								FROM tbl_confirmasi a 
								INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 
								LEFT JOIN tbl_final_confirmasi c ON a.id_confirmasi=c.id_confirmasi
								LEFT JOIN tbl_shipping d ON c.id_shipping=d.id_shipping
								LEFT JOIN tbl_reject_reason e ON a.id_confirmasi=e.id_confirmasi
							WHERE a.id_confirmasi='$id_confirmasi'
								GROUP BY a.id_confirmasi 
								ORDER BY a.status_confirmasi ASC, a.id_uniq DESC");  
									
	if(mysqli_num_rows($cari)>0)
	{
		$data 	= $cari->fetch_object();
		$status	= $data->status_confirmasi;
		if($status == 1)
		{
			echo "<div class='alert alert-success'><strong>Selamat!</strong> Kode Pesanan : <b>".htmlentities($id_confirmasi)."</b> Atas nama : <b>$data->nama_pelanggan</b> telah kami proses.. <br> Terimakasih atas kepercayaan anda kepada <b>homesmart.co.id</b></div>";
            if($data->resi_shipping =="" || $data->resi_shipping == "NULL")			
			{
				echo "<div class='alert alert-warning'>
						Status: <b>On shipping Progress..</b>
					 </div>";
			}else{
				echo "<div class='alert alert-info'>
				<b>On shipping Progress..</b>
						<table>
							<tr>
								<td>Ekspedisi </td><td> :<strong> $data->nama_shipping</strong></td>
							</tr>
							<tr>
								<td>No Resi</td><td>: <b>".$data->resi_shipping."</b></td>
							</tr>
						</table>	
					 </div>";
			}
			
		}else if($status == 2)
		{
			echo "<div class='alert alert-danger'><strong>Maaf</strong> Kode Pesanan : <b>".htmlentities($id_confirmasi)."</b> telah kami tolak dengan alasan ketentuan kami, Terimakasih..</div>";
			if(!empty($data->reason))
			{
				echo "<div class='alert alert-info'>
						<table>
							<tr>
								<td>Kode Pesanan </td><td> :<strong> ".htmlentities($id_confirmasi)."</strong></td>
							</tr>
							<tr>
								<td>Reject reason</td><td>: <b>".$data->reason."</b></td>
							</tr>
						</table>	
					  </div>";
			}
			
		}else if($status == 0)
		{
			echo "<div class='alert alert-info'><strong>Peringatan!</strong> <br>Kode Pesanan : <b>".htmlentities($id_confirmasi)."</b> Atas nama : <b>$data->nama_pelanggan</b> belum kami proses.. Silahkan lakukan Konfirmasi dibawah ini. <br> Terimakasih atas kepercayaan anda kepada <b>homesmart.co.id</b></div>";
			?>
				<div class="alert alert-warning">
				<form id="go_confirm_bank" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="id_confirmasi" value="<?php echo $data->id_confirmasi;?>" id="id_confirmasi" required>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="nama_bank">Bank Tujuan:</label>
					  <div class="col-sm-10">
						<select name="nama_bank" id="nama_bank" class="form-control">
						<option value="">Pilih Bank
						<?php
						$q = $db->query("SELECT * FROM tbl_bank");
						while($data = $q->fetch_object())
						{
							echo '<option value="'.$data->id_bank.'">'.$data->nama_bank;
						}
						?>
						
						</select>
						<span class="help-block" id="kat_help">Bank kami yang anda gunakan.</span>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="nama_bank">Atas nama pengirim:</label>
					  <div class="col-sm-10">
					  <input type="text" name="atas_nama_pengirim" class="form-control" id="atas_nama_pengirim" required>
						<span class="help-block" id="kat_help">Atas nama rekening pengirim. (Atas nama bank pengirim). </span>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="jumlah_transfer">Jumlah dana:</label>
					  <div class="col-sm-10">
					  <input type="text" name="jumlah_transfer" class="form-control" id="jumlah_transfer" required>
						<span class="help-block" id="kat_help">Jumlah dana yang di transfer. </span>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="file_bukti_transfer">Upload bukti Transfer:</label>
					  <div class="col-sm-10">
					  <input type="file" name="file_bukti_transfer" class="form-control" id="file_bukti_transfer" onchange="readURL(this);" required>
					  <span id="t4_main_image"></span>					  
						<span class="help-block" id="buk_help">Scan atau foto bukti transfer anda lalu upload disini. <i>(Tidak bisa lebih dari 1Mb)</i>.</span>
						<div id="bukti_help"></div>
					  </div>
					</div>
					
					
					
					<div class="form-group">
					  <label class="control-label col-sm-2" for="nama_bank"></label>
					  <div class="col-sm-10">
					  <input type="submit" name="submit" id="submit_formnya" class="btn btn-success" value="Upload">
						<span class="help-block" id="kat_help"></span>
					  </div>
					</div>
				</form>
				<div style="clear:both;"></div>
				</div>
				
				<div style="clear:both;"></div>
				<br><br><br><br><br><br>
				
<script>
/*
$("#go_confirm_bank").submit(function(){
	
	alert("");
	
	return false;	
 });
 */
 
function readURL(input) {
if (input.files && input.files[0]) {
	var reader = new FileReader();

	reader.onload = function (e) 
	{
		$('#t4_main_image').html("<img src='"+e.target.result+"' class='img-thumbnail' width='200px'>");						
		
	};
		
		reader.readAsDataURL(input.files[0]);
		
	}
}

$("#file_bukti_transfer").change(function (){ 
	var iSize = ($("#file_bukti_transfer")[0].files[0].size / 1024); 
	if(iSize > 2000)
	{
		$("#submit_formnya").attr("disabled","disabled");		
		$("#bukti_help").css({"color":"red"});
	}else{
		
		$("#bukti_help").css({"color":"black"});
		$("#submit_formnya").removeAttr("disabled");
		
	}
	if (iSize / 1024 > 1) 
     { 
        if (((iSize / 1024) / 1024) > 1) 
        { 
            iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);
            $("#bukti_help").html( iSize + "Gb"); 
        }
        else
        { 
            iSize = (Math.round((iSize / 1024) * 100) / 100)
            $("#bukti_help").html( iSize + "Mb"); 
        } 
     } 
     else 
     {
        iSize = (Math.round(iSize * 100) / 100)
        $("#bukti_help").html( iSize  + "kb"); 
     }
	
	
	}); 

 </script>
		<?php
		}
		
	}else{
		echo "<div class='alert alert-danger'><strong>Maaf</strong> Kode Pesanan : <b>".htmlentities($id_confirmasi)."</b> tidak tersedia</div>";
	}
	
	die();
	//akhir confirmasi
?>	