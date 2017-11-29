<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');

$id_kategori = $_GET['id_kategori'];

?>


	<div class="form-group">
	  <label class="control-label col-sm-2" for="nama_kategori">Sub Kategori</label>
	  <div class="col-sm-10">
	
		<select name="id_sub_kategori" class="form-control" id="id_sub_kategori" >
		<option value="">---Pilih Sub Kategori---</option>
		<?php 
			$q = $db->query("SELECT * FROM tbl_sub_kategori WHERE id_kategori='$id_kategori'");
			while($data = $q->fetch_object())
			{
				echo '<option value="'.$data->id_sub_kategori.'">'.$data->nama_sub_kategori.'</option>';
			}
		?>
		</select>
		<span class="help-block" id="sub_kat_help">Sub Kategori harus diisi.</span>
		
		<!--auto compelete-->  
	  </div>
	</div>
		