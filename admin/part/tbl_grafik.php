<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

$q = $db->query("SELECT id_barang,tgl_update_barang FROM tbl_barang GROUP BY tgl_update_barang");

$tgl_barang 	= '';
$jumlah_product = '';
while($data = $q->fetch_object()){
	$q_tgl		= $db->query("SELECT COUNT(id_barang) AS jumlah FROM tbl_barang WHERE tgl_update_barang='$data->tgl_update_barang'")->fetch_object();
	
	$jumlah_product	.= $q_tgl->jumlah.",";
	$tgl_barang 	.= "'".tanggalindo($data->tgl_update_barang)."',";
	
}


?>	
	<div class="container" id="judul_h1">
	<h1>GRAFIK PRODUCT</h1>
	
	
	</div>
		<div id="container_chart" class="container" ></div>		
		
		
		
</div>

<script>

//Chart
var chart_barang; // globally available
$(document).ready(function() {
	
	//var tanggal_barang = [<?php echo $tgl_barang?>];
	var data = {"name":"Product","data":[<?php echo $jumlah_product?>]};
    var categories = [<?php echo $tgl_barang?>];
	
      chart_barang = new Highcharts.Chart({
         chart: {
            renderTo: 'container_chart',
            type: 'line'
         },   
         title: {
            text: 'Grafik Product'
         },
         xAxis: {
            categories: categories
         },
		 credits: {
			  enabled: false
		  },

         yAxis: {
            title: {
               text: 'Quantity'
            }
         },
              series:[data]
			  
      });
	  
	  
	  
	  
   });



</script>