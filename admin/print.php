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

$id_confirmasi = $_GET['id_confirmasi'];
$rowSet = $db->query("SELECT a.*, b.nama_pelanggan, b.id_pelanggan 
								FROM tbl_confirmasi a 
								INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 
								WHERE id_confirmasi = '$id_confirmasi'
								GROUP BY a.id_confirmasi 
								ORDER BY a.status_confirmasi ASC, a.id_uniq DESC");  	 		 
$row = $rowSet->fetch_object();

$aktif = $row->status_confirmasi;
		 if($aktif==0){ 				
			
				$notif 		= "<b><font color=red>Belum Disetujui</font></b>";
			
		 
			}else if($aktif==1)
			{				
			
				$notif 		= "Telah Disetujui";
			
			}else if($aktif==2)
			{
			
				$notif 		= "Rejected";
				
			}
		

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
	<style>
	body{
		font-family:"Courier New", Courier, monospace;
		font-size:12px;
	}
	.container{
		border:1px solid #aaa;
	}
	@media print {
   .hilang {
        display:none;
    }
}
	
	</style>
	
	<script>
	function print_page() {
		window.print();
	}
	</script>
	<?php 
		if(isset($_GET['go_print']) && ($_GET['go_print']) =="1")
		{
			echo "<script>window.print();</script>";
		}
	?>
	
</head>

<body>			
	
	<div class="container">
			<button onclick="print_page()" class="btn btn-xs hilang"><span class="glyphicon glyphicon-print" ></span> Print</button>
			<h3>Invoice: <?php echo $id_confirmasi?></h3>
		
		 <div class="col-sm-9" >
				
					

			<table >
			<tr >
				<td >ID BELANJA</td>
				
				<td >: <b><?php echo $row->id_confirmasi?></b> </td>
			</tr>

			<tr >
				<td >STATUS</td>
				
				<td >: <b><?php echo $notif ?></b></td>
			</tr>
			<tr >
				<td >TGL ORDER</td>
				
				<td >: <b><?php echo tanggalindo($row->tgl_confirmasi)." ".$row->jam_confirmasi ?></b></td>
			</tr>
			<tr >
				<td >TGL APPROVE</td>
				
				<td >: <b><?php echo tanggalindo($row->tgl_disetujui)  ?></b></td>
			</tr>
			</table>
			
			
			
											<table class="table">
													<tr >
														<th  width="30px">No</th>
														<th >Nama Produk</th>														
														<th >Qty</th>
														
														<th class="data text-right">@ Harga</th>
														<th class="data text-right">Sub Total</th>
														
														
													</tr>

											<?php
												$harga_total = 0;
												$q = $db->query("SELECT a.*, b.nama_barang,b.harga_barang FROM tbl_confirmasi a INNER JOIN tbl_barang b ON a.id_barang = b.id_barang WHERE a.id_confirmasi ='$row->id_confirmasi'");
												$no =0;
												while($data = $q->fetch_object()){
												$no++;
												$harga_total+=($data->harga_barang*$data->qty);
												$code_uniq = $data->code_uniq;
												$ongkir = $data->ongkir;
											?>
												
												<tr >
														<td  width="30px" valign="top"><?php echo $no;?></td>
														<td  width="230px" valign="top"><?php echo $data->nama_barang;?></td>
														<td  width="230px" valign="top"><?php echo $data->qty;?></td>
														<td  style="text-align:right" valign="top"><?php echo rupiah($data->harga_barang);?></td>
														
														
														<td  style="text-align:right" valign="top"><?php echo rupiah($data->harga_barang*$data->qty);?></td>
														
													
													</tr>
												
												<?php
												}
												?>
											
													<tr >
														
														<td colspan="4" style="text-align:right"><b>Uniq : &nbsp;&nbsp;&nbsp;</b></td>
														<td  style="text-align:right"> <b><?php echo $code_uniq;?></b></td>
														
													</tr>
													<tr >
														
														<td  colspan="4" style="text-align:right"><b>Ongkir : &nbsp;&nbsp;&nbsp;</b></td>
														<td   style="text-align:right"> <b><?php echo rupiah($ongkir);?></b></td>
														
													</tr>
											
													<tr >
														
														<td  colspan="4" style="text-align:right"><b>Total : &nbsp;&nbsp;&nbsp;</b></td>
														<td   style="text-align:right"> <b>Rp.<?php echo rupiah($harga_total+$code_uniq+$ongkir);?></b></td>
														
													</tr>
											
											
											</table>
											
											
											
											
			<div style="border-bottom:2px dashed #aaa;"></div>								
											
											
											
											<?php
											$id_pelanggan = $row->id_pelanggan;	
											$data_pelanggan = $db->query("SELECT a.*, b.nama_provinsi,c.nama_kota FROM tbl_pengiriman a 
																							LEFT JOIN tbl_provinsi b ON a.id_provinsi=b.id_provinsi 
																							LEFT JOIN tbl_kota c ON a.id_kota=c.id_kota
																					WHERE a.id_pelanggan='$id_pelanggan'")->fetch_object();
											
											
											?>
											 	DELIVER TO:
											<table class="table">
												<tr >
													<td >Nama </td>	<td ><?php echo $data_pelanggan->nama_pengiriman;?></td>
												</tr>
												<tr >
													<td >Telepon </td>	<td ><?php echo $data_pelanggan->telp_pengiriman;?></td>
												</tr >
												<tr >
													<td >Email </td>	<td ><?php echo $data_pelanggan->email_pengiriman;?></td>
												</tr>
												<tr >
													<td >Alamat </td>	<td ><?php echo $data_pelanggan->alamat_pengiriman;?>, 
																									<?php echo $data_pelanggan->nama_kota;?>,
																									<?php echo $data_pelanggan->nama_provinsi;?>
													
													</td>
												</tr>
											
											</table>
											
			
		 </div>
		 <div class="col-sm-3">
				<!--
				<h5>RETURNS</h5>
				Should you like to make a return:
				<ol>
					<li>Choose a reason (1 to 8) seen below and indicate it under the "Return Reason" above</li>
					<li>Include this slip in your parcel to be returned!</li>
				 </ol>
				Return Reasons<br>
				<table class=" table">
				<tr>
					<td>1. Size too large</td><td>2. Size too small</td><td>3. Not convinced by quality </td><td>4. Don't like product</td>
				</tr>
				<tr>
					<td>5. Wrong item </td><td>6. Defective or damaged </td><td>7. Different from website </td><td>8. Other (please specify)</td>
				</tr> 	 		
							
				</table> 
				 -->
				<b>THANK YOU FOR SHOPPING WITH US!</b>
				<br>
				We hope that you like tour order as much as we do. Get in touch with us at +Telephon Number , Monday - Sunday, 9am - 7pm,

				or drop us as a note at <u>info@homesmart.co.id</u>. 
				<br>
				Happy Shopping!
		 </div>
							
	</div>
	
</body>
</html>
<!-- table-->
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap.js"></script>
<!-- table-->