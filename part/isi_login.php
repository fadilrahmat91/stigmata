<?php
if(isset($_SESSION['session_sementara']))
{
	
	$session_sementara = $_SESSION['session_sementara'];
}else if(isset($_GET['session_sementara']))
{	
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');
	$session_sementara = ($_GET['session_sementara']);
}

if(isset($_SESSION['id_pelanggan']))
{
	$id_pelanggan = $_SESSION['id_pelanggan'];
}else{
	$id_pelanggan = '';
}

if(session_id() == '') {
    session_start();
}

include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');



if(isset($_POST['email_pelanggan']) && isset($_POST['pass_pelanggan']) && isset($_POST['login']) )		
{
	$pass_pelanggan  = mysqli_real_escape_string($db,$_POST['pass_pelanggan']);
	$email_pelanggan = mysqli_real_escape_string($db,$_POST['email_pelanggan']);	
	
	$q = $db->query("SELECT * FROM tbl_pelanggan WHERE email_pelanggan='$email_pelanggan' AND pass_pelanggan='$pass_pelanggan'");
	
	$hit = mysqli_num_rows($q);
	
	
	if($hit>0)
	{	
		$data = $q->fetch_object();
		
		if($data->status_pelanggan ==='0')
		{
			die("non_actif");
		}
		
		if($email_pelanggan == $data->email_pelanggan && $pass_pelanggan === $data->pass_pelanggan)
		{
			$_SESSION['id_pelanggan'] = $data->id_pelanggan;
			die("success");
			
		}else{
			die("wrong");
		}
	}else{
		die("not_found");
	}
	
	die();
}



if(isset($_POST['nama_member']) && isset($_POST['code_pelanggan']) && isset($_POST['vip']) )		
{
	$nama_pelanggan  = mysqli_real_escape_string($db,$_POST['nama_member']);
	$code_uniq = mysqli_real_escape_string($db,$_POST['code_pelanggan']);	
	
	$q = $db->query("SELECT a.*,
							b.*
						FROM tbl_vip_member a
						INNER JOIN tbl_pelanggan b
						ON a.id_pelanggan=b.id_pelanggan
						WHERE a.code_uniq='$code_uniq'");
	
	$hit = mysqli_num_rows($q);
	
	
	if($hit>0)
	{	
		$data = $q->fetch_object();
		
		if($data->status_pelanggan ==='0')
		{
			die("non_actif");
		}
		
		if($nama_pelanggan == $data->nama_pelanggan && $code_uniq === $data->code_uniq)
		{
			$_SESSION['id_pelanggan'] = $data->id_pelanggan;
			die("success");
			
		}else{
			die("wrong");
		}
	}else{
		die("not_found");
	}
	
	die();
}



$_SESSION['random'] = buat_random(5);
if(isset($_POST['email_pelanggan']) && isset($_POST['pass_pelanggan']) && isset($_POST['daftar']) )		
{
		//--------keamanan
			if(!isset($_SESSION['session_sementara']))
			{
				die();
			}
		//--------keamanan
		
		$nama_pelanggan 	= trim($_POST['nama_pelanggan']);
		$alamat_pelanggan 	= trim($_POST['alamat_pelanggan']);
		$email_pelanggan	= trim($_POST['email_pelanggan']);
		$telp_pelanggan		= trim($_POST['telp_pelanggan']);		
		$pass_pelanggan		= trim($_POST['pass_pelanggan']);
		$id_prov			= trim($_POST['id_prov']);
		$id_kab				= trim($_POST['id_kab']);
		$id_kec				= trim($_POST['id_kec']);
		$id_kel				= trim($_POST['id_kel']);		
		$tgl_daftar			= date('Y-m-d H:i:s');
		
		//$cek_user  = $db->query("SELECT user_pelanggan FROM tbl_pelanggan WHERE user_pelanggan='$user_pelanggan'");
		$cek_email = $db->query("SELECT email_pelanggan,id_pelanggan FROM tbl_pelanggan WHERE email_pelanggan='$email_pelanggan'");
		
		if(mysqli_num_rows($cek_email)>0)
		{
			die("Maaf Email : $email_pelanggan Sudah terdaftar..!!");
		}else if(strlen($pass_pelanggan) <= 5 )
		{
			die("Maaf Password minimal 6 karakter");
		
		}else if($_POST['captcha'] !== $_POST['captcha_dapat'])
		{
			die("Maaf kode captcha salah!!");
		}
			
		
		if($db->query("INSERT INTO tbl_pelanggan SET 
										nama_pelanggan		='$nama_pelanggan',
										alamat_pelanggan	='$alamat_pelanggan',
										email_pelanggan		='$email_pelanggan',
										telp_pelanggan		='$telp_pelanggan',										
										pass_pelanggan		='$pass_pelanggan',
										id_prov				='$id_prov',
										id_kab				='$id_kab',
										id_kec				='$id_kec',
										id_kel				='$id_kel',
										tgl_daftar			='$tgl_daftar',
										status_pelanggan	='1'
		"))
		{
			
			$ambil_id = $db->query("SELECT id_pelanggan FROM tbl_pelanggan WHERE email_pelanggan='$email_pelanggan' ORDER BY id_pelanggan DESC LIMIT 1");
			$data = $ambil_id->fetch_object();
			$_SESSION['id_pelanggan'] = $data->id_pelanggan;
			die("success");
			
		}
		
		//var_dump($_POST);
		
	die();
}

//setting daerah
if(isset($_GET['id_kec']) && !empty($_GET['id_kec']))
{
	$data_kel 	= '';
	$id_kec 	= $_GET['id_kec'];	
	$q = $db->query("SELECT * FROM daerah_kelurahan WHERE id_kec='$id_kec'");
		$data_kel .= '<option value="">---Pilih Kelurahan---</option>';
	while($data = $q->fetch_object())
	{
		$data_kel .= '<option value="'.$data->id_kel.'">'.$data->nama.'</option>';
	}
	echo $data_kel;
die();
}


if(isset($_GET['id_kab']) && !empty($_GET['id_kab']))
{
	$data_kec 	= '';
	$id_kab 	= $_GET['id_kab'];	
	$q = $db->query("SELECT * FROM daerah_kecamatan WHERE id_kab='$id_kab'");
	$data_kec .= '<option value="">---Pilih Kecamatan---</option>';
	while($data = $q->fetch_object())
	{
		$data_kec .= '<option value="'.$data->id_kec.'">'.$data->nama.'</option>';
	}
	echo $data_kec;
die();
}


if(isset($_GET['id_prov']) && !empty($_GET['id_prov']))
{
	$data_kab 	= '';
	$id_prov 	= $_GET['id_prov'];	
	$q = $db->query("SELECT * FROM daerah_kabupaten WHERE id_prov='$id_prov'");
	$data_kab .= '<option value="">---Pilih Kabupaten---</option>';
	while($data = $q->fetch_object())
	{
		$data_kab .= '<option value="'.$data->id_kab.'">'.$data->nama.'</option>';
	}
	echo $data_kab;
die();
}



$data_prov = '';
$q = $db->query("SELECT * FROM daerah_provinsi");
while($data = $q->fetch_object())
{
	$data_prov .= '<option value="'.$data->id_prov.'">'.$data->nama.'</option>';
}
			
?>    	
 
 
  <ul class="nav nav-pills">
    <li class="" style="width:45%;"><a href="#login" data-toggle="pill" class="btn btn-warning">Sudah pernah belanja</a></li>
    <li class="" style="width:45%;float:right;"><a href="#register" data-toggle="pill" class="btn btn-success">Pelanggan Baru</a></li>
    
  </ul>

  <div class="tab-content">
    <div id="login" class="tab-pane fade">
      
       
      <!---------------------login--------------->
          
 <div class="alert " id="div_login">			
			<b>Masuk</b>
			<div id="notif_login"></div>
			<small>Sudah Pernah Belanja? silahkan Login dibawah ini.</small>
			<form id="form_login_konsumen" action="<?php echo $alamat?>part/isi_login.php" method="post">
			<input type="hidden" name="login">
				<div class="form-group">
							  <label class="control-label col-sm-2" for="email_pelanggan">Email</label>
							  <div class="col-sm-10">						
								<input type="email" class="form-control  email_pelanggan " id="email_pelanggan" name="email_pelanggan" value="" placeHolder="Email Pelanggan" required/>			
								<span class="help-block" id="kat_help">Email harus diisi.</span>												
							  </div>
							</div>
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="pass_pelanggan">Password</label>
							  <div class="col-sm-10">						
								<input type="password" class="form-control  pass_pelanggan" id="pass_pelanggan" name="pass_pelanggan" value="" placeHolder="Password" required/>			
								<span class="help-block" id="kat_help">Password harus diisi.</span>												
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="pass_pelanggan"></label>
							  <div class="col-sm-10">						
								<input type="submit" name="sibmit" id="submit_login" value="Login &rarr;" class="btn btn-warning">
								<span class="help-block" id="kat_help"></span>												
							  </div>
							</div>
					
			</form> 		
			<div class="clear"></div>
 </div>
      <!---------------------login--------------->


    </div>
    <div id="register" class="tab-pane fade">
        <!---------------register---------------------->      

       
<div class="alert" id="div_login">			
			<b>Mendaftar:</b>
			
			<div id="notif_daftar"></div>
			<form id="form_daftar_konsumen" action="<?php echo $alamat?>part/isi_login.php" method="post">
				  <input type="hidden" class="form-control" name="daftar">
					
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="email_pelanggan">Email</label>
							  <div class="col-sm-10">						
								<input type="email" class="form-control  email_pelanggan " id="email_pelanggan" name="email_pelanggan" value="" placeHolder="Email Pelanggan" required/>			
								<span class="help-block" id="kat_help">Email harus diisi.</span>												
							  </div>
							</div>
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="pass_pelanggan">Password</label>
							  <div class="col-sm-10">						
								<input type="password" class="form-control  pass_pelanggan" id="pass_pelanggan" name="pass_pelanggan" value="" placeHolder="Password" required/>			
								<span class="help-block" id="kat_help">Password harus diisi.</span>												
							  </div>
							</div>
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="nama_pelanggan">Nama</label>
							  <div class="col-sm-10">						
								<input type="text" class="form-control  nama_pelanggan " id="nama_pelanggan" name="nama_pelanggan" value="" placeHolder="Nama Pelanggan" required/>			
								<span class="help-block" id="kat_help">Nama harus diisi.</span>												
							  </div>
							</div>
									
							
							<div class="form-group">
							  <label class="control-label col-sm-2" for="telp_pelanggan">Telp/HP</label>
							  <div class="col-sm-10">						
								<input type="text" class="form-control  telp_pelanggan" id="telp_pelanggan" name="telp_pelanggan" value="" placeHolder="Telp Pelanggan" required/>			
								<span class="help-block" id="kat_help">Telp/HP harus diisi.</span>												
							  </div>
							</div>
							
							
							<a href="#" id="lanjut_alamat" class="btn btn-success">Lanjut &rarr;</a>
							
							<div id="group_alamat" style="display:none;">
							
							
							<h3 id="alamatnya">Alamat:</h3>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="id_prov">Provinsi</label>
							  <div class="col-sm-10">						
								<select class="form-control  id_prov" id="id_prov" name="id_prov" >		
									
									<option value="">---Pilih Provinsi---</option>
									
									<?php echo $data_prov;?>
									
								</select>
								<span class="help-block" id="id_prov_help">Provinsi harus diisi.</span>												
							  </div>
							</div>
							
							
							<div id="t4_div_kab" style="display:none; margin-top:10px;">
								<div class="form-group">
								  <label class="control-label col-sm-2" for="id_kab">Kabupaten</label>
								  <div class="col-sm-10">						
									<select class="form-control  id_kab" id="id_kab" name="id_kab" >		
										
									<option value="">---Pilih Kab---</option>
									
										
									</select>
									<span class="help-block" id="kab_help">Kabupaten harus diisi.</span>												
								  </div>
								</div>								
							</div>
									
						
							<div id="t4_div_kec" style="display:none; margin-top:10px;">
								<div class="form-group">
								  <label class="control-label col-sm-2" for="id_kec">Kecamatan</label>
								  <div class="col-sm-10">						
									<select class="form-control  id_kec" id="id_kec" name="id_kec" >		
										
									<option value="">---Pilih Kecamatan---</option>
									
										
									</select>
									<span class="help-block" id="kec_help">Kecamatan harus diisi.</span>												
								  </div>
								</div>
							</div>
							
							<div id="t4_div_kel" style="display:none; margin-top:10px;">
								<div class="form-group">
								  <label class="control-label col-sm-2" for="id_kel">Kelurahan</label>
								  <div class="col-sm-10">						
									<select class="form-control  id_kel" id="id_kel" name="id_kel" >		
										
									<option value="">---Pilih Kelurahan---</option>
									
										
									</select>
									<span class="help-block" id="kel_help">Kelurahan harus diisi.</span>												
								  </div>
								</div>
							</div>
								
								<div class="form-group" id="t4_div_alamat_pelanggan" style="display:none;margin-top:10px;">
								  <label class="control-label col-sm-2" for="id_kab">Alamat</label>
								  <div class="col-sm-10">						
									<textarea class="form-control alamat_pelanggan" id="alamat_pelanggan" name="alamat_pelanggan" required></textarea>
									<span class="help-block" id="alamat_help">Alamat Lengkap.</span>												
								  </div>
								</div>
							</div>
							
						
						<div class="form-group randomnya" style="display:none;">
							  <label class="control-label col-sm-2" for="Sekurity">Sekurity*</label>
							  <div class="col-sm-10">
							  <span style="color:#808080;">
														<span style="font-size: 24px;">
													
															<span style="font-family: comic sans ms,cursive;">
																<strong>
																	<span style="background-color:#e6e6fa;" ><?php echo $_SESSION['random'] ;?></span> 
																</strong>
															</span>
														</span>
													</span>
												
								
									<input name="captcha" type="text" class="form-control" size="10" id="captcha" required style="width:200px;"/> <span id="captcha_span"></span>
									<input name="captcha_dapat" type="hidden" value="<?php echo $_SESSION['random'] ;?>" size="10"  /> 
							
								<span class="help-block" id="name_help">Sekurity harus diisi.</span>
							  </div>
							</div>
								
							
					
					<div class="form-group" id="save_and_finish" style="display:none">        
					  <div class="col-sm-offset-2 col-sm-10">
						<button type="submit" id="simpan" class="btn btn-warning">Save And Finish &rarr;</button>
					  </div>
					</div>
					
							
					
					
					<div class="clear"></div>
					<div id="notif_reg_bottom"></div>
					</div>		
					
				  </form>
				  
		

        <!---------------register---------------------->
    </div>
   
  </div>
</div>


<script>
 $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });



$("#lanjut_alamat").click(function(){
	loading_menu();
	
	$("#group_alamat").fadeIn();
	go_to("alamatnya");
	loading_menu_hide();
	
return false;	
});


$("#id_kel").change(function(){
	loading_menu();
	var id_kel = $(this).val();
	if(id_kab =='')
	{
		$("#t4_div_alamat_pelanggan").fadeOut();
		$("#alamat_help").css({"color":"Red"});
		//alert("Pilih Provinsi");
		loading_menu_hide();
		return false;
	}else{
	
		$("#t4_div_alamat_pelanggan,.randomnya").fadeIn();
		$("#alamat_pelanggan").focus();
		$("#save_and_finish").fadeIn();
		go_to("t4_div_alamat_pelanggan");		
		
	}
	
	loading_menu_hide();
	
});
$("#id_kec").change(function(){
	loading_menu();
	var id_kec = $(this).val();
	//alert(id_kab);
	
	if(id_kec =='')
	{
		$("#t4_div_kec").fadeOut();
		$("#kec_help").css({"color":"Red"});
		//alert("Pilih Provinsi");
		loading_menu_hide();
		return false;
	}else{
	
		$.get("<?php echo $alamat?>part/isi_login.php",{id_kec:id_kec},function(e){
		
			
			$("#id_kel").html(e);
			$("#t4_div_kel").fadeIn();
			go_to("t4_div_kel");
			
		});
		
		
	}
	
	loading_menu_hide();
	
});

$("#id_kab").change(function(){
	loading_menu();
	var id_kab = $(this).val();
	//alert(id_kab);
	
	if(id_kab =='')
	{
		$("#t4_div_kec").fadeOut();
		$("#id_kab_help").css({"color":"Red"});
		//alert("Pilih Provinsi");
		loading_menu_hide();
		return false;
	}else{
	
		$.get("<?php echo $alamat?>part/isi_login.php",{id_kab:id_kab},function(e){
		
			
			$("#id_kec").html(e);
			$("#t4_div_kec").fadeIn();
			go_to("t4_div_kec");
			
		});
		
		
	}
	
	loading_menu_hide();
	
});

$("#id_prov").change(function(){
	loading_menu();
	var id_prov = $(this).val();
	//alert(id_prov);
	
	if(id_prov =='')
	{
		$("#t4_div_kab").fadeOut();
		$("#id_prov_help").css({"color":"Red"});
		//alert("Pilih Provinsi");
		loading_menu_hide();
		return false;
	}else{
	
		$.get("<?php echo $alamat?>part/isi_login.php",{id_prov:id_prov},function(e){
		
			
			$("#id_kab").html(e);
			$("#t4_div_kab").fadeIn();
			go_to("t4_div_kab");
			
		});
		
		
	}
	
	loading_menu_hide();
	
});


$("#form_login_konsumen").submit(function(){
	loading_menu();
	var target = $(this).attr("action");
	var value = $(this).serialize();
	
	$.post(target,value,function(e){
		if(e == "success")
		{
			//alert("");
			  window.location = "<?php echo $alamat?>kasir.php";
		}else if( e == "wrong")
		{
			alert("Kombinasi email salah!");
		}else if( e == "not_found")
		{
			$("#notif_login").hide().html("<div class='alert alert-danger'>Maaf.. Email Atau password salah..!!</div>").fadeIn();
			go_to("div_login");
		}else if( e == "non_actif")
		{
			$("#notif_login").hide().html("<div class='alert alert-danger'>Maaf.. Acount ini telah di nonaktifkan..!!</div>").fadeIn();
			go_to("div_login");
		}
		
		loading_menu_hide();
	});
	return false;
});

$("#form_daftar_konsumen").submit(function(){
	loading_menu();
	var target = $(this).attr("action");
	var value = $(this).serialize();
	
	$.post(target,value,function(e){
		
		if(e == "success")
		{
			//alert("");
			  window.location = "<?php echo $alamat?>kasir.php";
		}else{
			
			$("#notif_daftar,#notif_reg_bottom").fadeOut().html("<div class='alert alert-danger'>"+e+"</div>").fadeIn();
			go_to("notif_reg_bottom");
		}
		
		loading_menu_hide();
	});
	return false;
});


</script>

<style>

#notif_login{
	color:red;
}
</style>