<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

$data_prov = '';
$q = $db->query("SELECT * FROM tbl_provinsi");
while($data = $q->fetch_object())
{
	$data_prov .= '<option value="'.$data->id_provinsi.'">'.$data->nama_provinsi.'</option>';
}

?>	

<div class="container">
	<h2>Tambah Pelanggan</h2>	
	
	<div id="form_lanjut_barang"></div>
	<!--<button class="btn btn-warning  btn-xs" id="tutup_tambah_data">Tutup</button>-->
	<div id="alert_placeholder"></div>	
	
	  <form class="form-horizontal" role="form" method="post" id="form_tambah_pelanggan" action="part/simpan_tambah_pelanggan.php">
	  <input type="hidden" class="form-control" name="simpan_pelanggan">
		<h3>Data Pelanggan:</h3>
				
				
				<div class="form-group">
				  <label class="control-label col-sm-2" for="nama_pelanggan">Nama</label>
				  <div class="col-sm-10">						
					<input type="text" class="form-control  nama_pelanggan " id="nama_pelanggan" name="nama_pelanggan" value="" placeHolder="Nama Pelanggan" required/>			
					<span class="help-block" id="kat_help">Nama harus diisi.</span>												
				  </div>
				</div>
						
				<div class="form-group">
				  <label class="control-label col-sm-2" for="email_pelanggan">Email</label>
				  <div class="col-sm-10">						
					<input type="email" class="form-control  email_pelanggan " id="email_pelanggan" name="email_pelanggan" value="" placeHolder="Email Pelanggan" required/>			
					<span class="help-block" id="kat_help">Email harus diisi.</span>												
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="control-label col-sm-2" for="telp_pelanggan">Telp/HP</label>
				  <div class="col-sm-10">						
					<input type="text" class="form-control  telp_pelanggan" id="telp_pelanggan" name="telp_pelanggan" value="" placeHolder="Telp Pelanggan" required/>			
					<span class="help-block" id="kat_help">Telp/HP harus diisi.</span>												
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="control-label col-sm-2" for="user_pelanggan">Username</label>
				  <div class="col-sm-10">						
					<input type="text" class="form-control  user_pelanggan" id="user_pelanggan" name="user_pelanggan" value="" placeHolder="Username" required/>			
					<span class="help-block" id="kat_help">Username harus diisi.</span>												
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="control-label col-sm-2" for="pass_pelanggan">Password</label>
				  <div class="col-sm-10">						
					<input type="text" class="form-control  pass_pelanggan" id="pass_pelanggan" name="pass_pelanggan" value="" placeHolder="Password" required/>			
					<span class="help-block" id="kat_help">Password harus diisi.</span>												
				  </div>
				</div>
				
				<h3 id="alamatnya">Alamat:</h3>
				<div class="form-group">
				  <label class="control-label col-sm-2" for="id_provinsi">Provinsi</label>
				  <div class="col-sm-10">						
					<select class="form-control  id_provinsi" id="id_provinsi" name="id_provinsi" >		
						
						<option value="">---Pilih Provinsi---</option>
						
						<?php echo $data_prov;?>
						
					</select>
					<span class="help-block" id="id_provinsi_help">Provinsi harus diisi.</span>												
				  </div>
				</div>
				
				
				<div id="t4_div_kota">
					<div class="form-group">
					  <label class="control-label col-sm-2" for="id_kota">Kota</label>
					  <div class="col-sm-10">						
						<select class="form-control  id_kota" id="id_kota" name="id_kota" >		
							
																		
							
						</select>
						<span class="help-block" id="kat_help">Kota harus diisi.</span>												
					  </div>
					</div>
					
					<div class="form-group" id="t4_div_alamat_pelanggan">
					  <label class="control-label col-sm-2" for="id_kota">Alamat</label>
					  <div class="col-sm-10">						
						<textarea class="form-control alamat_pelanggan" id="alamat_pelanggan" name="alamat_pelanggan" required></textarea>
						<span class="help-block" id="kat_help">Alamat Lengkap.</span>												
					  </div>
					</div>
				</div>
						
			
					
				
		
		<div class="form-group" id="save_and_finish">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" id="simpan" class="btn btn-warning">Save And Finish</button>
		  </div>
		</div>
		

		
	  </form>
	  
</div>

<script>
$("#save_and_finish,#t4_div_kota").hide(0);
$("#id_provinsi").change(function(){
	
	var id_provinsi = $(this).val();
	if(id_provinsi =='')
	{
		$("#t4_div_kota").fadeOut();
		$("#id_provinsi_help").css({"color":"Red"});
		//alert("Pilih Provinsi");
		
		return false;
	}else{
	
		$.get("part/select_kota.php",{id_provinsi:id_provinsi},function(e){
		
			//alert(e);
			if($("#t4_div_kota").fadeIn())
			{
				$("#id_kota").html('<option value="">---Pilih Kota---</option>'+e);
				go_to("alamatnya");
				
			}
			
			//alert(e);
			
		});
		
		
	}
	
	
	
	
});


$("#id_kota").change(function(){
	
	var id_kota = $(this).val();
	if(id_kota =='')
	{
		
		alert("Pilih Kota");
		return false;
	}else{
	
		$("#save_and_finish").fadeIn();
		
	}
	
	
	
	
});

$("#form_tambah_pelanggan").submit(function(){

	var link = $(this).attr("action");
	var data = $(this).serialize();
	//alert(data);
	
	$.post(link,data,function(e){
	
		if(e==1)
		{
			load_menu_hash("part/tbl_pelanggan.php");
		}else{
		
			alert(e);
		
		}
	
	});
	
	return false;
});

</script>


