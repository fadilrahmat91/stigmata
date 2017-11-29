<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

//approved
$q = $db->query("SELECT a.*, b.harga_barang 
					FROM tbl_confirmasi a 
					INNER JOIN tbl_barang b 
						ON a.id_barang=b.id_barang
					WHERE a.status_confirmasi='1'
					ORDER BY a.id_uniq ASC");

$tgl_confirmasi	= '';
$harga_barang 	= '';


while($data = $q->fetch_object()){
	
	$harga_barang		.= $data->harga_barang.",";	
	$tgl_confirmasi		.= "'".tanggalindo($data->tgl_disetujui)." ".$data->jam_disetujui."',";	
	
}

?>	
	<div class="container" id="judul_h1">
	<h1>GRAFIK PENJUALAN</h1>
	
	
	</div>
		<div id="container_chart" class="container" ></div>		
		
		
		
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