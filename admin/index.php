<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting.php');
include_once(dirname(__FILE__) . '/../config/function.php');
$obj = new BlioniaClass($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin <?php echo $title?></title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">
	<script type="text/javascript" src="jquery/jquery-1.11.3.js"></script>	
	<script type="text/javascript" src="jquery/jquery.js"></script>	
	<script type="text/javascript" src="js/jsku.js"></script>	
	<script type="text/javascript" src="js/ajaxupload.js"></script>	
		
	<script src="js/bootstrap.min.js"></script>	
	<link href="js/dataTables.jqueryui.js" rel="stylesheet">	
	
	<!--jq UI-->
	<script type="text/javascript" src="jquery/jquery-ui-1.11.4.custom/jquery-ui.js"></script>	
	<!--jq UI-->
	
	
  <!--plugins-->
	
	<link rel="stylesheet" href="<?php echo $alamat?>admin/plugins/tokenfields/bootstrap-tokenfield.css">
	<script src="<?php echo $alamat?>admin/plugins/tokenfields/bootstrap-tokenfield.js"></script>
 
	 
	<script src="<?php echo $alamat?>admin/plugins/ckeditor/ckeditor.js"></script>
	<script src="<?php echo $alamat?>admin/plugins/ckeditor/adapters/jquery.js"></script>
	
	<script src="js/highcharts.js" type="text/javascript"></script>
	<script src="js/exporting_charts.js" type="text/javascript"></script>
	<!--plugins-->
	
	
	
</head>
<script>
//alert('');
</script>
<body>
			
		<?php 
			include ("part/menu.php");		
			
		?>
	
		
		
		 
		 <div class="text-center" id="btn_menu_left"><img src="img/menu.png"></div>
		 <div class="col-sm-3 col-md-2 sidebar" id="menu_left">
		 
		<?php 
			include ("part/menu_left.php");		
		?>	    
		 </div>
		 
		 
		<div class="main" id="mainnya">
		
			
		
			<div id="loading"><img src="<?php echo $alamat?>admin/img/bigLoader.gif"></div>
			<div id="isi_content"></div>
		</div>
		
		<?php		
			//include ("part/footer.php"); 
		?>
		
	
</body>
</html>
<!-- table-->
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap.js"></script>
<!-- table-->
<style>
#btn_menu_left{
	position: fixed;
	top:50%; 
	left:2px; 
	z-index:999999;
	display:block;


	background:#d0d0d0;
	width:70px;
	height:50px;
	text-align:center;
	border:1px solid #a7a6a6;
	font-size:20px;
	color:#fff;
	cursor:pointer;
	opacity: 0.1;
}
#btn_menu_left:hover{
	 opacity: 1;
}
</style>
<script>
$("#btn_menu_left").draggable({});
$("#menu_left").hide();
$("#btn_menu_left").click(function(){
  $('#menu_left').toggle("slide", "left", 500);
  
  if($("#menu_left").is(":visible"))
	{	
		$('#mainnya').toggleClass("col-sm-12 col-sm-offset-3 col-md-10 col-md-offset-2 main");
	}	
});


</script>