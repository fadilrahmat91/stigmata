<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

$obj = new BlioniaClass($db);

if(isset($_GET['hitNewProduct']))
{
		
	echo($obj->hitNewProduct());
	
	
		
}

if(isset($_GET['hitNewKontak']))
{
		
	echo($obj->hitNewKontak());
	
	
		
}

if(isset($_GET['hitNewConfirmasi']))
{
		
	echo($obj->hitNewConfirmasi());
	
	
		
}

if(isset($_GET['hitNewKonsumen']))
{
		
	echo($obj->hitNewKonsumen());
	
	
		
}
if(isset($_GET['hitNewBankConfirmasi']))
{
		
	echo($obj->hitNewBankConfirmasi());
	
	
		
}


?>	