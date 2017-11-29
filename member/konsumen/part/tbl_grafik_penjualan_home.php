<?php
session_start();
if(!isset($_SESSION['id_pelanggan']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../setting.php');

$id_pelanggan = $_SESSION['id_pelanggan'];
//approved

$q = $db->query("SELECT a.*, b.nama_pelanggan, b.id_pelanggan 
				FROM tbl_confirmasi a 
				INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 
				WHERE a.id_pelanggan='$id_pelanggan' 
					AND a.status_confirmasi='1'
					AND (
							MONTH( a.tgl_disetujui ) = MONTH( CURDATE( ) )
							AND YEAR( a.tgl_disetujui ) = YEAR( CURDATE( ) )
						)									
				GROUP BY a.id_confirmasi 
				ORDER BY a.status_confirmasi ASC, a.id_uniq DESC");  
				

$tgl_confirmasi	= '';
$harga_barang_total	= 0;
$code_uniq_total = 0;
$ongkir_total = 0;
$total_bulan	=0;
$harga_total = 0;

while($data = $q->fetch_object()){
	
	/*
	$qq = $db->query("SELECT a.*, b.nama_barang,b.harga_barang FROM tbl_confirmasi a INNER JOIN tbl_barang b ON a.id_barang = b.id_barang WHERE a.id_confirmasi ='$data->id_confirmasi'");
	$no =0;
	while($row = $qq->fetch_object()){		
		$harga_barang_total+=$row->harga_barang;
		$code_uniq_total += $row->code_uniq;
		$ongkir_total += $row->ongkir;
		//echo $row->harga_barang."-";		
	}
	*/
	
	$tgl_confirmasi		.= "'".tanggalindo($data->tgl_disetujui)." ".$data->jam_disetujui."',";	
	$total_bulan		+= $harga_total;
}

?>	
	<div class="container" id="judul_h1">
	
	
	<h1>GRAFIK BELANJA BULAN INI</h1>
	
	
	</div>
	<div class="container">	
		
		<div class="col-sm-6" style="background:lavender">
			<div id="container_chart"></div>		
		</div>
		
		<div class="col-sm-6">
			<h3>Sales Sumary</h3>
			<div id="tempat_sumary">
				
				<div>This Month : Rp.<?php echo rupiah($total_bulan,2)?></div>
			</div>
		</div>
	</div>
		
	

<script>


var categories = [<?php echo $tgl_confirmasi?>];
var data = {"name":"Penjualan","data":[<?php echo $harga_barang?>]};

$(function () {
	
	
    $('#container_chart').highcharts({
	
        title: {
            text: 'Grafik Sales'
         },
		xAxis: {
            categories: categories 
         },
		yAxis: {
			title: {
               text: 'Sales'
            },
            labels: {
                format: '{value}'
            }
        },
		credits: {
			  enabled: false
		  },

        series: [{
			
			name:"Penjualan",
            data: [<?php echo $harga_barang?>]
        }]

    });
});


</script>
<style>

#tempat_sumary{
	background-color:#082c45;
	color:#ffffff;
	padding:5px;
}
#align_kanan{
	text-align:right;
}
</style>