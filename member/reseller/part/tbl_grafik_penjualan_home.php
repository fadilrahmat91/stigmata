<?php
session_start();
if(!isset($_SESSION['reseller']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

$id_reseller = $_SESSION['reseller'];
//approved
$q = $db->query("SELECT a . * , b.harga_barang
					FROM tbl_confirmasi a
					INNER JOIN tbl_barang b ON a.id_barang = b.id_barang
					WHERE (MONTH( a.tgl_disetujui ) = MONTH( CURDATE( ) )
					AND YEAR( a.tgl_disetujui ) = YEAR( CURDATE( ) )) AND a.status_confirmasi='1' AND a.id_pelanggan='$id_reseller'
					ORDER BY a.id_uniq ASC
				");

$tgl_confirmasi	= '';
$harga_barang 	= '';
$total_bulan	=0;

while($data = $q->fetch_object()){
	
	$harga_barang		.= $data->harga_barang.",";	
	$tgl_confirmasi		.= "'".tanggalindo($data->tgl_disetujui)." ".$data->jam_disetujui."',";	
	$total_bulan		+= $data->harga_barang;
}

?>	
	<div class="container" id="judul_h1">
	<h1>GRAFIK BELANJA BULAN INI</h1>
	
	
	</div>
	<div class="container">	
		
		
		<div id="container_chart"></div>		
		
		
		<div class="span3 bs-docs-sidebar">
			<h3>Sales Sumary</h3>
			<div id="tempat_sumary">
				
				<div>This Month : Rp.<?php echo rupiah($total_bulan,2)?></div>
			</div>
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
#container_chart{
	width:70%;
	float:right;
}
#tempat_sumary{
	background-color:#082c45;
	color:#ffffff;
	padding:5px;
}
#align_kanan{
	text-align:right;
}
</style>