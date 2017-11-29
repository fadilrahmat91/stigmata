<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');


if(isset($_POST['url_banner_b1']) || isset($_POST['url_banner_b2']))
{

	$url_banner_b1	= $_POST['url_banner_b1'];
	$url_banner_b2	= $_POST['url_banner_b2'];
	$url_banner_b3	= $_POST['url_banner_b3'];
	$url_banner_b4	= $_POST['url_banner_b4'];
	$url_link_b1	= $_POST['url_link_b1'];
	$url_link_b2	= $_POST['url_link_b2'];
	$url_link_b3	= $_POST['url_link_b3'];
	$url_link_b4	= $_POST['url_link_b4'];
	
	$db->query("UPDATE tbl_banner SET
					url_banner_b1='$url_banner_b1',
					url_banner_b2='$url_banner_b2',
					url_banner_b3='$url_banner_b3',
					url_banner_b4='$url_banner_b4',
					url_link_b1='$url_link_b1',
					url_link_b2='$url_link_b2',
					url_link_b3='$url_link_b3',
					url_link_b4='$url_link_b4'			
				");
	

die();
}



$data = $db->query("SELECT * FROM tbl_banner LIMIT 1")->fetch_object();



?>	
<script type="text/javascript" src="<?php echo $alamat?>admin/plugins/ckfinder/ckfinder.js"></script>
<div class="container">
<h1>DATA BANNER</h1>
<form id="form_set_banner">
<div class="col-xs-6" style="border:1px solid lavender; padding:0px !important;">
	<div class="col-lg-6" style="background: lavenderblush">
			<b>B1</b><br>
						<!--auto finder-->
						<input class="form-control  url_banner_b1" id="url_banner_b1" type="hidden" name="url_banner_b1" value="<?php echo $data->url_banner_b1?>">
						Url_link:<input class="form-control  url_link_b1" id="url_link_b1" type="text" name="url_link_b1" value="<?php echo $data->url_link_b1?>" >
							<div id="main_img_show_b1" style="width:144px; height:250px;"><img src="<?php echo $data->url_banner_b1?>" style="width:144px; height:250px;"></div>	

									
							
						<input type="button" value="Browse Server" class="btn btn-default" id="browse_gambar_b1"/>
						<span class="help-block" id="deskripsi_help"><small>Gambar B1 (288px X 500px)</small>
							
						</span>
						 
						<!--auto finder-->  
					
	
	
	</div>
	
	
	<div class="col-lg-6" style="background: lavender">
	
		
		<div class="col-lg-12" style="background: lavender;">
			<b>B2</b><br>
			<!--auto finder-->
						<input class="form-control  url_banner_b2" id="url_banner_b2" type="hidden" name="url_banner_b2" value="<?php echo $data->url_banner_b2?>" required>
						Url_link:<input class="form-control  url_link_b2" id="url_link_b2" type="text" name="url_link_b2" value="<?php echo $data->url_link_b2?>" >
							<div id="main_img_show_b2" style="width:144px; height:144px;"><img src="<?php echo $data->url_banner_b2?>" style="width:144px; height:144px;"></div>	

									
							
						<input type="button" value="Browse Server" class="btn btn-default" id="browse_gambar_b2"/>
						<span class="help-block" id="deskripsi_help"><small>Gambar B2 (288px X 250px)</small>
							
						</span>
						 
						<!--auto finder-->  
			
			
		</div>
		
		
		
		
		
		<!-----------------------------------b3--------------------------------->
			<div class="col-lg-12" style="background: lavender;">
			<b>B3</b><br>
			<!--auto finder-->
						<input class="form-control  url_banner_b3" id="url_banner_b3" type="hidden" name="url_banner_b3" value="<?php echo $data->url_banner_b3?>" required>
						Url_link:<input class="form-control  url_link_b3" id="url_link_b3" type="text" name="url_link_b3" value="<?php echo $data->url_link_b3?>" >
							<div id="main_img_show_b3" style="width:144px; height:144px;"><img src="<?php echo $data->url_banner_b3?>" style="width:144px; height:144px;"></div>	

									
							
						<input type="button" value="Browse Server" class="btn btn-default" id="browse_gambar_b3"/>
						<span class="help-block" id="deskripsi_help"><small>Gambar B2 (288px X 250px)</small>
							
						</span>
						 
						<!--auto finder-->  
			
			
		</div>
		
		
		
	
	</div>
	
	
	<div style="clear:both;"></div>
	
	
	<div class="col-lg-12" style="background:pink">
	
			<b>B4</b><br>
						<!--auto finder-->
						<input class="form-control  url_banner_b4" id="url_banner_b4" type="hidden" name="url_banner_b4" value="<?php echo $data->url_banner_b4?>" required>
						Url_link:<input class="form-control  url_link_b4" id="url_link_b4" type="text" name="url_link_b4" value="<?php echo $data->url_link_b4?>" >
							<div id="main_img_show_b4" style="width:100%; height:30px;"><img src="<?php echo $data->url_banner_b4?>" style="width:100%; height:30px;"></div>	

									
							
						<input type="button" value="Browse Server" class="btn btn-default" id="browse_gambar_b4"/>
						<span class="help-block" id="deskripsi_help"><small>Gambar B4 (1140x50.jpg)</small>
							
						</span>
						 
						<!--auto finder-->  
	
	</div>
	
</div>


<div class="col-xs-6">
	<img src="img/preview.jpg" width="100%" style="border:1px solid lavender">
</div>


<div style="clear:both;"></div><hr><br><br>
<input type="submit" value="Update" class="btn btn-primary">

</form>

</div>


<script>




//ckfinder	
$("#browse_gambar_b1").click(function(){
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '<?php echo $alamat?>admin/plugins/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = function(e)
	{
		$( '#url_banner_b1' ).val(e);
		$( '#main_img_show_b1' ).html("<img src='"+e+"' style='width:144px; height:250px;'>");
	
	}
	
	finder.popup();
	
});


		
					

//ckfinder	
$("#browse_gambar_b2").click(function(){
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '<?php echo $alamat?>admin/plugins/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = function(e)
	{
		$( '#url_banner_b2' ).val(e);
		$( '#main_img_show_b2' ).html("<img src='"+e+"' style='width:144px; height:144px;'>");
	
	}
	
	finder.popup();
	
});



//ckfinder	
$("#browse_gambar_b3").click(function(){
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '<?php echo $alamat?>admin/plugins/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = function(e)
	{
		$( '#url_banner_b3' ).val(e);
		$( '#main_img_show_b3' ).html("<img src='"+e+"' style='width:144px; height:144px;'>");
	
	}
	
	finder.popup();
	
});



		

//ckfinder	
$("#browse_gambar_b4").click(function(){
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '<?php echo $alamat?>admin/plugins/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = function(e)
	{
		$( '#url_banner_b4' ).val(e);
		$( '#main_img_show_b4' ).html("<img src='"+e+"' style='width:100%; height:30px;'>");
	
	}
	
	finder.popup();
	
});



$("#form_set_banner").submit(function(){
	$.post("part/tbl_banner.php",$(this).serialize(),function(e){
		alert("Sukses");
	});
	
	
return false;
});
		

</script>

