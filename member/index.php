<?php
session_start();
if(isset($_SESSION['reseller']))
{
	header ('location: reseller');
}else if(isset($_SESSION['id_pelanggan']))
{
	header ('location: konsumen');
}else{	
	header ('location: login.php');
} 