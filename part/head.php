<?php
if(!isset($_SESSION['session_sementara']))
{
	$_SESSION['session_sementara'] = session_sementara();
}
?>
<!DOCTYPE HTML>
<head>
<title><?php echo $title?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="<?php echo $alamat?>bootstrap/jquery/jquery-1.11.3.js"></script>	
<script type="text/javascript" src="<?php echo $alamat?>bootstrap/jquery/jquery-ui-1.11.4.custom/jquery-ui.js"></script>		
<script type="text/javascript" src="<?php echo $alamat?>bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $alamat?>bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo $alamat?>bootstrap/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $alamat?>bootstrap/css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $alamat?>bootstrap/css/custom.css">


		 
<link rel="icon" type="image/png" href="<?php echo $alamat?>img/ico.jpg">
<script type="text/javascript" src="<?php echo $alamat?>js/jsku.js"></script>

<!--plugins-->
<!--plugins-->

<!--seo-->
<meta name="description" content="<?php echo $description?>">
<link rel="canonical" href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
<meta property="og:title" content="<?php echo $title?>" />
<meta property="og:type" content="<?php echo $type?>" />
<meta property="og:image" content="/logo.png" />

<!--seo-->






</head>
<body>

