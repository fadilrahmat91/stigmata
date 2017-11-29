<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');




if(isset($_GET['id_provinsi'])){

	
		$id_provinsi = $_GET['id_provinsi'];
		$data_kota = '';
		$q = $db->query("SELECT * FROM tbl_kota WHERE id_provinsi='$id_provinsi'");
		
		if(mysqli_num_rows($q)>0)
		{
			while($data = $q->fetch_object())
			{
				$data_kota .= '<option value="'.$data->id_kota.'">'.$data->nama_kota.'</option>';
			}

			echo $data_kota;		
			
		}else{
			
			echo "<option disabled>Belum ada data</option>";
			
		}
		
				
	
}else{
	
	//echo "Tidak ada";
	
}

?>	
