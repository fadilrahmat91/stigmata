<?php
session_start();
if(!isset($_SESSION['reseller']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');
$obj = new BlioniaClass($db);
$profilReseller = $obj->profilReseller($_SESSION['reseller']);
?>	
	<div class="container" id="judul_h1">
		<h1>PROFIL</h1>
	
	</div>
	
	<div class="container" id="tempat_profil">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_pelanggan">Nama</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_pelanggan " id="nama_pelanggan" name="nama_pelanggan" value="<?php echo $profilReseller->nama_pelanggan?>"  required/>			
			<span class="help-block" id="kat_help"> </span>												
		  </div>
		</div>
				
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email_pelanggan">Email</label>
		  <div class="col-sm-10">						
			<input type="email" class="form-control  email_pelanggan " id="email_pelanggan" name="email_pelanggan" value="<?php echo $profilReseller->email_pelanggan?>"  required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="telp_pelanggan">Telp/HP</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  telp_pelanggan" id="telp_pelanggan" name="telp_pelanggan" value="<?php echo $profilReseller->telp_pelanggan?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="user_pelanggan">Username</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  user_pelanggan" id="user_pelanggan" name="user_pelanggan" value="<?php echo $profilReseller->user_pelanggan?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="pass_pelanggan">Password</label>
		  <div class="col-sm-10">						
			<input type="password" class="form-control  pass_pelanggan" id="pass_pelanggan" name="pass_pelanggan" value="<?php echo $profilReseller->pass_pelanggan?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_provinsi">Provinsi</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_provinsi" id="nama_provinsi" name="nama_provinsi" value="<?php echo $profilReseller->nama_provinsi?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_kota">Kota</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_kota" id="nama_kota" name="nama_kota" value="<?php echo $profilReseller->nama_kota?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		
		<div class="form-group" id="t4_div_alamat_pelanggan">
		  <label class="control-label col-sm-2" for="id_kota">Alamat</label>
		  <div class="col-sm-10">						
			<textarea class="form-control alamat_pelanggan" id="alamat_pelanggan" name="alamat_pelanggan" required><?php echo $profilReseller->alamat_pelanggan?></textarea>
			<span class="help-block" id="kat_help">Alamat Lengkap.</span>												
		  </div>
		</div>
		
	</div>