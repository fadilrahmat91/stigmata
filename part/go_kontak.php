<?php
session_start();

include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');

if(isset($_POST['Name']) && isset($_POST['Email']) && isset($_POST['captcha_dapat']))
{
	$Name		= anti_inject($_POST['Name']);
	$Email		= anti_inject($_POST['Email']);
	$Message	= anti_inject($_POST['Message']);
	$tgl_kontak = date('Y-m-d');
	
	if($_POST['captcha'] !== $_POST['captcha_dapat'])
	{
	
		echo (1);
	
	}else{
	
	
		if($db->query("INSERT INTO tbl_kontak SET
										tgl_kontak	='$tgl_kontak',
										Name		='$Name',
										Message		='$Message',
										Email		='$Email'
										"))
				{
					
					
					
					//email
		
					$to = $Email;
					$subject = "Kontak Form auto129.com";

					$message = '<p>Dari: '.$Name.' / '.$Email.'.<br>
									
									Pesan:'.$Message.'
					
								</p>';

					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: <'.$Email.'>' . "\r\n";
					$headers .= 'Cc: autoemail@auto129.com' . "\r\n";

				//	mail($to,$subject,$message,$headers);
					
					
					
					
					
					echo (2);
				
				}else{
					
					echo mysqli_error($db);
					
				}
										
		
	
	}
	

}

?>