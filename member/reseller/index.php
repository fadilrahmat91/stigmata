<?php
session_start();
if(!isset($_SESSION['reseller']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting.php');
include_once(dirname(__FILE__) . '/../config/function.php');
$obj = new BlioniaClass($db);
$profilReseller = $obj->profilkonsumen($_SESSION['reseller']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reseller Center  <?php echo $title?></title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css">
	<script type="text/javascript" src="jquery/jquery-1.11.3.js"></script>	
	<script type="text/javascript" src="jquery/jquery.js"></script>	
	<script type="text/javascript" src="js/jsku.js"></script>	
		
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
	<div class="container">
		<h1>
			Reseller Center <strong>Blionia </strong>
		</h1>
  
  
	
	</div>
	<?php 
		include ("part/menu.php");		
		
	?>
	
	
	<div id="loading"><img src="<?php echo $alamat?>admin/img/bigLoader.gif"></div>
	<div id="isi_content"></div>
	
	
	<?php		
		include ("part/footer.php"); 
	?>
</body>
</html>
<!-- table-->
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap.js"></script>
<!-- table-->