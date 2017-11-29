<?php
session_start();
if(!isset($_SESSION['id_pelanggan']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../setting.php');

$q = $db->query("SELECT * FROM tbl_pelanggan WHERE id_pelanggan='".$_SESSION['id_pelanggan']."'");
$profilkonsumen = $q->fetch_object();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Costumer <?php echo $title?></title>
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
			Customer Center <strong>Blionia</strong>
		</h1>
  
  
	
	</div>
			
		<nav id="myNavbar" class="navbar navbar-default" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.php">Home</a>
						
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
						  
							<li class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle">Pemesanan <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#tbl_belanja" id="tbl_belanja">Semua Data</a></li>
									<li><a href="#tbl_data_belanja_aproved" id="tbl_data_belanja_aproved">Data Di Approved</a></li>
									<li><a href="#tbl_confirmasi_bank" id="tbl_confirmasi_bank">Data Confirmasi Bank<span id="t4_notif_in_newbankconfrim"></span></a></li>							
								</ul>
							</li>
							
							
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo $profilkonsumen->nama_pelanggan?> <b class="caret"></b></a>
								<ul class="dropdown-menu">
									
									<li><a href="#details_pelanggan" id="details_pelanggan">Details</a></li>
									<li class="divider"></li>
									<li><a href="part/logout.php">LogOut</a></li>
								</ul>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
			</nav>
			
		<script>
		load_menu_hash("part/tbl_grafik_penjualan_home.php");
		load_menu("tbl_belanja","part/tbl_belanja.php");
		load_menu("tbl_confirmasi_bank","part/tbl_belanja.php?tbl_confirmasi_bank");
		load_menu("tbl_data_belanja_aproved","part/tbl_belanja.php?tbl_data_belanja_aproved");
		load_menu("harga_poin","part/harga_poin.php");
		load_menu("tbl_poin","part/tbl_poin.php");
		load_menu("details_pelanggan","part/details_pelanggan.php");
		
		</script>
	
	
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