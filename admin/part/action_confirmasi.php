<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

if(isset($_GET))
{
		
		$id_confirmasi		= trim($_GET['id_confirmasi']);
		$tgl_disetujui		= date("Y-m-d");
		$jam_disetujui		= date("H:i");
		
		
		if(isset($_GET['id_confirmasi']) && isset($_GET['setujui_confirm']))
		{
			$id_confirmasi 	= $_GET['id_confirmasi'];
			$harga_total	= $_GET['total_dana_belanja'];
			$quantity	 	= $_GET['quantity'];
			$id_admin		= $_GET['id_admin'];
			
			$rowSet = $db->query("SELECT a.id_barang, b.stok_barang
								FROM tbl_confirmasi a 
								INNER JOIN tbl_barang b ON a.id_barang = b.id_barang 
								WHERE a.id_confirmasi='$id_confirmasi'
								");
			$hit = mysqli_num_rows($rowSet);
			
			while($data = $rowSet->fetch_object())
			{
				$id_barang = $data->id_barang;
				$db->query("UPDATE tbl_barang SET stok_barang=stok_barang-1 WHERE id_barang='$id_barang'");
				
			}
			
			$db->query("UPDATE tbl_confirmasi SET tgl_disetujui='$tgl_disetujui', jam_disetujui='$jam_disetujui', status_confirmasi='1' WHERE id_confirmasi='$id_confirmasi'");
			
			$db->query("INSERT INTO tbl_final_confirmasi SET id_confirmasi='$id_confirmasi', harga_total='$harga_total', quantity='$quantity', id_admin='$id_admin'");
			//echo $id_confirmasi;
			
		}
		
		if(isset($_GET['id_confirmasi']) && isset($_GET['reject_confirm']))
		{
			$id_confirmasi 	= $_GET['id_confirmasi'];			
			$id_admin		= $_GET['id_admin'];
			$reason			= $_GET['reason'];
			$tgl_disetujui	= date("Y-m-d");
			$jam_disetujui	= date("H:i:s");
			$db->query("INSERT INTO tbl_reject_reason SET id_confirmasi='$id_confirmasi', id_admin='$id_admin', reason='$reason'");
			$db->query("UPDATE tbl_confirmasi SET tgl_disetujui='$tgl_disetujui', jam_disetujui='$jam_disetujui', status_confirmasi='2' WHERE id_confirmasi='$id_confirmasi'");
			
		}
		
		if(isset($_GET['id_confirmasi']) && isset($_GET['set_bank_admin_status']) )
		{
			$id_confirmasi = $_GET['id_confirmasi'];
			
			
			$db->query("UPDATE tbl_bukti_transfer SET admin_cek='1' WHERE id_confirmasi='$id_confirmasi'");
			
			//echo $id_confirmasi;
			
		}	
		
		if(isset($_GET['id_confirmasi']) && isset($_GET['update_status_shipping']) )
		{
			$id_confirmasi = $_GET['id_confirmasi'];			
			$resi_shipping = $_GET['resi_shipping'];			
			$id_shipping   = $_GET['id_shipping'];			
						
			$db->query("UPDATE tbl_final_confirmasi SET status_shipping='1', id_confirmasi='$id_confirmasi', resi_shipping='$resi_shipping',id_shipping='$id_shipping'  WHERE id_confirmasi='$id_confirmasi'");
			
			//echo $id_confirmasi;
			
		}	
		
}

?>	