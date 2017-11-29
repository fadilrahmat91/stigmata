<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

if(isset($_POST['IdUser']))
{
	$nama_admin = $_POST['Nama'];
	$user_admin = $_POST['Username'];
	$pass_admin = $_POST['Password'];
	$email_admin = $_POST['Email'];
	$db->query("UPDATE tbl_admin SET nama_admin='$nama_admin', user_admin='$user_admin', pass_admin='$pass_admin', email_admin='$email_admin'");
	
	die();
}



$q = $db->query("SELECT * FROM tbl_admin LIMIT 1");
$user = $q->fetch_object();

$IdUser 		= $user->id_admin;
$Nama 			= $user->nama_admin;
$Password 		= $user->pass_admin;
$Username		= $user->user_admin;
$Email	 		= $user->user_admin;
?>
<h1>Data user:</h1>
<div class="alert alert-info" id="alternatif_isi" style="display:none;"></div>
<form id="form_data_user" >
<input name="IdUser" type="hidden" class="form-control" value="<?php echo $IdUser?>">
Nama:<br>
<input name="Nama" class="form-control"  value="<?php echo $Nama?>">
<br>
Username:<br>
<input name="Username" class="form-control" required value="<?php echo $Username?>">
<br>


Password:<br>
<input name="Password" type="password"class="form-control" required value="<?php echo $Password?>">
<br>


Email:<br>
<input name="Email" class="form-control" required value="<?php echo $Email?>">
<br>


<br>

<input type="submit" name="submit" class="btn btn-info btn-block" value="Update">
</form>

<script>
$("#form_data_user").submit(function(){
	
	$.post("part/ganti_pass.php",$(this).serialize(),function(e){
		
		$("#alternatif_isi").html("Berhasil update data..").fadeIn().delay(2000).fadeOut();
	});
	return false;
});
</script>