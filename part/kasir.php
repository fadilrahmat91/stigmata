<?php
if(isset($_SESSION['session_sementara']))
{
	$session_sementara = $_SESSION['session_sementara'];
}else if(isset($_GET['session_sementara']))
{	
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');
	$session_sementara = ($_GET['session_sementara']);
}
?>
<form action="<?php echo $alamat;?>confirmasi_pembayaran.php" method="post">
<div class="center_content">


      
	<h3>Daftar Belanja <?phpif(isset($_SESSION['nama_pelanggan'])){ echo $_SESSION['nama_pelanggan'] ;}?> </h3>

	
	<table class="data">
			<tr class="data">
				<th class="data" width="30px">No</th>
				<th class="data">Nama Barang</th>
				
				<th class="data">Harga Per Item</th>
				<th class="data" width="75px">&nbsp;&nbsp;&nbsp;Pilihan</th>
				
			</tr>



	<?php 
	if(isset($_GET['batal_beli']))
	{
		$id_hapus = $_GET['batal_beli'];
		if($db->query("DELETE FROM tbl_keranjang_sementara WHERE id_keranjang='$id_hapus'"))
		{
			status_ajax("Berhasil menghapus..", $alamat."kasir.php");
		}
	
	}
	$tabel_post 	= $db->query("SELECT * FROM tbl_keranjang_sementara WHERE session_sementara='$session_sementara' ORDER BY id_keranjang DESC, id_barang DESC");
	$harga_total	= 0;
	$no				= 0;
	while($row 		= $tabel_post->fetch_object()){
	 
	 $id 			= $row->id_barang;
	 $harga			= $row->harga_per_item;
	 $harga_total  += $harga;
	 $no+=1;
	 
	 $query = $db->query("SELECT COUNT(*) AS kuantitas FROM tbl_keranjang_sementara WHERE id_barang='$id'")->fetch_object();
	 $kuantitas = $query->kuantitas;
	  
		$query = $db->query("SELECT * FROM submit WHERE id='$id'")->fetch_object();
		$nama = $query->judul;
		
		if($link_set->link_on==1)
			{
				
				$link_judul = $alamat."read/".$query->id."/".$query->tahun."/".$query->link;
				
			}else{
			
				
				$link_judul = $alamat."read.php?id=".$query->id."&t=".$query->tahun."&link=".$query->link;

			}
		
     
	 ?>
	 

			<tr class="data">
				<td class="data" width="30px"><?php echo $no;?></td>
				<td class="data" width="230px"><a href="<?php echo $link_judul;?>"><?php echo $nama;?></a></td>
				
				<td class="data" style="text-align:right"><?php echo rupiah($harga,2);?></td>
				
				
			<td td class="data" style="text-align:center"><a href="?batal_beli=<?php echo $row->id_keranjang;?>" title="Hapus" onClick="return warning();"><img src="images/hapus.png" alt="Hapus"></a></td>
			</tr>
			<input type="hidden" name="multi_barang[]" value="<?php echo $id;?>" >

		<?php } ?>

			<tr>
				<td></td>
				<td style="text-align:right">Total : &nbsp;&nbsp;&nbsp;</td>
				<td style="text-align:right"> Rp.<?php echo rupiah($harga_total, 2);?></td>
				<td></td>
			</tr>
			
			</table>
			
	 <a href="<?php echo $alamat;?>"><input type="button" value="Lanjutkan Belanja"></a> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;

<?php 
	if(!isset($_SESSION['nama_pelanggan']) && !isset($_SESSION['email']))
	{
	
	?>
	 
	  <a href="<?php echo $alamat.'register.php';?>"><input type="button" value="Selesai Belanja"></a>

<?php
	}
?>	  
    
	
	
	
	
	
	
	<?php
		if(isset($_SESSION['nama_pelanggan']) && isset($_SESSION['email']))
		{
			
			$id_pelanggan 		= $_SESSION['id_pelanggan'];
			$nama_pelanggan		= $_SESSION['nama_pelanggan'];
			$alamat_pelanggan	= $_SESSION['alamat'];
			$kota 				= $_SESSION['kota'];
			$propinsi			= $_SESSION['propinsi'];
			$telepon_pelanggan	= $_SESSION['telepon'];
			$email_pelanggan	= $_SESSION['email'];
			$tanggal_bergabung	= $_SESSION['tanggal_bergabung'];
		?>
		<div>
		<h3>Data Anda</h3>
		<table class="data">
			<tr>
				<td>Nama</td><td>: <?php echo $nama_pelanggan;?></td>
			</tr>
			<tr>
				<td>Email</td><td>: <?php echo $email_pelanggan;?></td>
			</tr>
			
			<tr>
				<td>No.Telepon</td><td>: <?php echo $telepon_pelanggan;?></td>
			</tr>
			<tr>
				<td>Alamat</td><td>: <?php echo $alamat_pelanggan;?></td>
			</tr>
			<tr>
				<td>Kota</td><td>: <?php echo $kota;?></td>
			</tr>
			<tr>
				<td>Propinsi</td><td>: <?php echo $propinsi;?></td>
			</tr>
			
			
		</table>
		<br>
		<h3>Data Tujuan Pengiriman</h3>
		Edit data dibawah ini jika pengiriman ke alamat lain.
		<table >
		
			<tr>
			<input type="hidden" name="id_pelanggan" value="<?php echo $_SESSION['id_pelanggan'];?>">
				<td>Nama</td><td> <input type="text" name="nama_pengiriman" value="<?php echo $nama_pelanggan;?>" class="inputya"></td>
			</tr>
			<tr>
				<td>Email</td><td>  <input type="text" name="email_pelanggan" value="<?php echo $email_pelanggan;?>" class="inputya"></td>
			</tr>
			<tr>
				<td>No.Telepon</td><td> <input type="text" name="telepon_pelanggan" value="<?php echo $telepon_pelanggan;?>" class="inputya"></td>
			</tr>

			<tr>
				<td>Alamat</td><td><textarea name="alamat_pengiriman"><?php echo $alamat_pelanggan;?></textarea></td>
			</tr>
			
			<tr>
				<td>Kota</td><td><input type="text" name="kota" value="<?php echo $kota;?>"></td>
			</tr>
			<tr>
				<td>Propinsi</td><td><input type="text" name="propinsi"  value="<?php echo $propinsi;?>"></td>
			</tr>
			
			
		
			
			
		</table>
		
		 <div>
		 <br>
			 <p>
			 <?php
			if($harga_total > 0){ 
			
				echo '<input type="submit" name="submit" value="Konfirmasi Belanja Anda">';
			 
			}else{
				
				echo '<input type="submit" name="submit" value="Konfirmasi Belanja Anda" disabled>';

			}
			
			
			?>
			</p>
		 </div>

		 </form>
		</div>
		
	<?php	
		}
	
	?>
	
	
	
	</div>
    