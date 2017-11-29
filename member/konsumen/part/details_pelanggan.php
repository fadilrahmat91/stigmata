<?php
session_start();
if(!isset($_SESSION['id_pelanggan']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../setting.php');
$q = $db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
							FROM tbl_pelanggan a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
							LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
							LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
							WHERE a.id_pelanggan ='".$_SESSION['id_pelanggan']."'");
$profilkonsumen = $q->fetch_object();
?>	
	<div class="container" id="judul_h1">
		<h1>PROFIL</h1>
	
	</div>
	
	<div class="container" id="tempat_profil">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_pelanggan">Nama</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_pelanggan " id="nama_pelanggan" name="nama_pelanggan" value="<?php echo $profilkonsumen->nama_pelanggan?>"  required/>			
			<span class="help-block" id="kat_help"> </span>												
		  </div>
		</div>
				
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email_pelanggan">Email</label>
		  <div class="col-sm-10">						
			<input type="email" class="form-control  email_pelanggan " id="email_pelanggan" name="email_pelanggan" value="<?php echo $profilkonsumen->email_pelanggan?>"  required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="telp_pelanggan">Telp/HP</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  telp_pelanggan" id="telp_pelanggan" name="telp_pelanggan" value="<?php echo $profilkonsumen->telp_pelanggan?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="pass_pelanggan">Password</label>
		  <div class="col-sm-10">						
			<input type="password" class="form-control  pass_pelanggan" id="pass_pelanggan" name="pass_pelanggan" value="<?php echo $profilkonsumen->pass_pelanggan?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_provinsi">Provinsi</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_provinsi" id="nama_provinsi" name="nama_provinsi" value="<?php echo $profilkonsumen->nama_provinsi?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="nama_kabupaten">Kab</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_kabupaten" id="nama_kabupaten" name="nama_kabupaten" value="<?php echo $profilkonsumen->nama_kabupaten?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		 <label class="control-label col-sm-2" for="nama_kabupaten">Kec</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_kabupaten" id="nama_kabupaten" name="nama_kabupaten" value="<?php echo $profilkonsumen->nama_kecamatan?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		<div class="form-group">
		 <label class="control-label col-sm-2" for="nama_kabupaten">Kec</label>
		  <div class="col-sm-10">						
			<input type="text" class="form-control  nama_kabupaten" id="nama_kabupaten" name="nama_kabupaten" value="<?php echo $profilkonsumen->nama_kelurahan?>" required/>			
			<span class="help-block" id="kat_help"> </span>			
		  </div>
		</div>
		
		
		<div class="form-group" id="t4_div_alamat_pelanggan">
		  <label class="control-label col-sm-2" for="id_kota">Alamat</label>
		  <div class="col-sm-10">						
			<textarea class="form-control alamat_pelanggan" id="alamat_pelanggan" name="alamat_pelanggan" required><?php echo $profilkonsumen->alamat_pelanggan?></textarea>
			<span class="help-block" id="kat_help">Alamat Lengkap.</span>												
		  </div>
		</div>
		
	</div>