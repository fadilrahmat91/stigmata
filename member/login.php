<?php
session_start();
if(isset($_SESSION['reseller'])){
	header ('location: reseller');
}else if(isset($_SESSION['pelanggan']))
{
	header ('location: pelanggan');
}
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting.php');


if(isset($_GET['login'])){
	//$user_admin = trim(mysqli_real_escape_string($_POST['user_admin']));
	//$pass_admin = mysqli_real_escape_string($_POST['pass_admin']);
	$email_pelanggan = trim($_POST['email_pelanggan']);
	$pass_pelanggan = ($_POST['pass_pelanggan']);
	
	
	$q = $db->query("SELECT * FROM tbl_pelanggan WHERE email_pelanggan='$email_pelanggan' AND pass_pelanggan='$pass_pelanggan'");
	//echo "SELECT * FROM tbl_pelanggan WHERE email_pelanggan='$email_pelanggan' AND pass_pelanggan='$pass_pelanggan' AND go_reseller='2'";
	
	if(mysqli_num_rows($q)>0){
		
		$data = $q->fetch_object();
		if($data->email_pelanggan == $email_pelanggan && $data->pass_pelanggan === $pass_pelanggan && $data->go_reseller === '2'){
			$_SESSION['reseller'] = $data->id_pelanggan;
			
			header ('location: reseller');	
			
		}else if($data->email_pelanggan == $email_pelanggan && $data->pass_pelanggan === $pass_pelanggan && $data->go_reseller === '1'){
			$_SESSION['id_pelanggan'] = $data->id_pelanggan;
			
			header ('location: konsumen');	
		}else{
			
			$info ='<font color="red">Periksa penulisan Email atau password</font>';
			
		}		
		
	}else{
	
		$info ='<font color="red">Email atau Password salah...!!</font>';
	
	}
}else if(isset($_GET['loggedout'])){
	
	$info ='<div class="alert alert-success alert-dismissable" id="alertnya">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Anda berhasil Log Out !!
			</div>';
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin <?php echo $title?></title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="konsumen/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="konsumen/css/custom.css">
	<script type="text/javascript" src="konsumen/jquery/jquery-1.11.3.js"></script>	
	<script type="text/javascript" src="konsumen/jquery/jquery.js"></script>	
	<script src="konsumen/js/bootstrap.min.js"></script>
<style>
#form_login tr td{
padding:10px;
}
#form_login{
border:1px solid #aaa;
}
</style>
</head>
<script>
//alert('');
</script>
<body>
	<div class="container">
	<h2>Costumer Center <?php echo $title?> Login</h2>
		<form action="?login" method="post">
				<table id="form_login">
					<tr>
						<td>Email</td> <td>: <input type="text" name="email_pelanggan" placeholder="Email"></td>
					</tr>
					<tr>
						<td>Password</td> <td>: <input type="password" name="pass_pelanggan" placeholder="Password"></td>
					</tr>
					
					<tr>
						<td></td><td><input type="submit" value="Login" name="login" class="btn btn-primary"></td>
					</tr>
						<?php
							if(isset($_GET['login']) || isset($_GET['loggedout'])){echo $info;}
						?>
						
					</table>
					
				</form>
	</div>
</body>
</html>
<!-- table-->
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap.js"></script>
<!-- table-->