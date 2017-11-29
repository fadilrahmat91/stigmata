<?php
session_start();
if(isset($_SESSION['session_sementara']))
{
	$session_sementara = $_SESSION['session_sementara'];
}else if(isset($_GET['session_sementara']))
{	
	$session_sementara = ($_GET['session_sementara']);
}
include_once(dirname(__FILE__) . '/../config/config.php');
include_once(dirname(__FILE__) . '/../config/setting_front.php');
include_once(dirname(__FILE__) . '/../config/function.php');


	$q = $db->query("SELECT a.id_barang, a.id_keranjang, c.nama_brand, c.id_brand, e.nama_barang, e.harga_barang, e.id_kategori 
		FROM tbl_keranjang a
		INNER JOIN tbl_barang e ON a.id_barang = e.id_barang					
		LEFT JOIN tbl_brand c ON e.id_brand = c.id_brand		
		WHERE a.session_sementara ='$session_sementara'
		ORDER BY e.nama_barang, a.id_keranjang DESC
	");


	$li_barang='';
	$no =0;
	$total = 0;
	while($data=$q->fetch_object())
	{
		$no ++;
		$total+=$data->harga_barang;
		$nama_kategori = ambil_nama_kat($db,$data->id_kategori);
		$li_barang .= "<li><a href='".link_detail($data->id_barang,$nama_kategori,$data->nama_barang)."'>$data->nama_barang</a></li>";
	}
?>
			
                        <span class="img-thumbnail bg-kasir" title="<?php echo $no?> item(s) - Rp.<?php echo rupiah($total)?>" id="tooltip">
								<span class="glyphicon glyphicon-shopping-cart"></span>
								<?php 
									if($total!==0 OR $no !==0)
										{
											echo '<span class="badge badge_keranjang">'.$no.'</span>';
										}
								
								?>
								
						<a href="<?php echo $alamat?>kasir.php">
							<span class="badge badge_ceck_out">Cek</span>
						</a>
						<span class="badge badge_close">x</span>
						</span>
						
						
						
			  	   
	<script>		  
	$("#tooltip").tooltip();
	$("#tooltip").draggable({});
	
	$("#tooltip").on("click",function(){
		$(".badge_close,.badge_ceck_out").show();
		
	})
	
	$(".badge_close").on("click",function(){
		$("#tooltip").hide();
		
		return false;
	})
	
	</script>		  
	<style>
	.badge_keranjang{
		background:#11c170;
		border:1px solid #dddddd;
		position:absolute;
		top:-5px;
		
	}
	.badge_ceck_out{
		background:#11c170;
		border:1px solid #dddddd;
		position:absolute;
		top:-5px;
		left:-20px;
		display:none;
	}
	.badge_close{
		background:red;
		border:1px solid #dddddd;
		position:absolute;
		top:30px;
		right:-7px;
		display:none;
	}
	#t4_keranjang{
		 position: fixed;
		 top:50%; 
		 right:17px; 
		 z-index:999999;
		 display:block;
	}
	.bg-kasir{
		 border-radius: 50px;
		 background:#dc235c;
		 width:50px;
		 height:50px;
		 text-align:center;
		 padding-top:15px;
		 font-size:20px;
		 color:#fff;
	}
	</style>