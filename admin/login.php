<?php
session_start();
if(isset($_SESSION['id_admin'])){
	header ('location: index.php');
}
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting.php');


if(isset($_GET['login'])){
	//$user_admin = trim(mysqli_real_escape_string($_POST['user_admin']));
	//$pass_admin = mysqli_real_escape_string($_POST['pass_admin']);
	$user_admin = trim($_POST['user_admin']);
	$pass_admin = ($_POST['pass_admin']);
	
	
	$q = $db->query("SELECT * FROM tbl_admin WHERE user_admin='$user_admin' AND pass_admin='$pass_admin'");
	
	if(mysqli_num_rows($q)>0){
		
		$data = $q->fetch_object();
		if($data->user_admin == $user_admin && $data->pass_admin === $pass_admin){
			$_SESSION['id_admin'] = $data->id_admin;
			
			header ('location: index.php');	
		}else{
			
			$info ='<font color="red">Periksa penulisan user_admin atau pass_admin</font>';
			
		}		
		
	}else{
	
	$info ='<font color="red">Username atau Password salah...!!</font>';
	
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
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<script type="text/javascript" src="jquery/jquery-1.11.3.js"></script>	
	<script type="text/javascript" src="jquery/jquery.js"></script>	
	<script src="js/bootstrap.min.js"></script>
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
	<h2>Admin <?php echo $title?> Login</h2>
		<form action="?login" method="post">
				<table id="form_login">
					<tr>
						<td>Username</td> <td>: <input type="text" name="user_admin" placeholder="Username"></td>
					</tr>
					<tr>
						<td>Password</td> <td>: <input type="password" name="pass_admin" placeholder="Password"></td>
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