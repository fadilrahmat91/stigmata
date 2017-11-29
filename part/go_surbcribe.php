<?php
	
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');


//var_dump($_POST);
//echo 1;

if(isset($_POST['email_surbcribe']))
{
	$email_surbcribe=$_POST['email_surbcribe'];
	if($db->query("INSERT INTO tbl_surbcribe SET email_surbcribe='$email_surbcribe'")==TRUE)
	{
		echo 1;
	}
}