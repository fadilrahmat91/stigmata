<?php
session_start();
if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');


$q = $db->query("SELECT COUNT(a.id_pelanggan) AS jum_member, DATE_FORMAT(a.tgl_daftar, '%Y-%m-%d') AS tgl_join FROM tbl_pelanggan a GROUP BY tgl_join");

$tgl_daftar='';
$jum_member='';
while($data = $q->fetch_object()){
	
	$tgl_daftar.="'".tanggalindo($data->tgl_join)."',";
	$jum_member.=$data->jum_member.",";
		
}

//echo $jum_member;

?>	
	<div class="container" id="judul_h1">
	<h1>GRAFIK KONSUMEN</h1>
	
	
	</div>
		<div id="container_chart" class="container" ></div>		
		
		
		
</div>

<script>

//Chart
var chart_pelanggan; // globally available
$(document).ready(function() {
	
	var data = {"name":"Konsumen","data":[<?php echo $jum_member?>]};

    var categories = [<?php echo $tgl_daftar?>];

	
      chart_pelanggan = new Highcharts.Chart({
         chart: {
            renderTo: 'container_chart',
            type: 'line'
         },   
         title: {
            text: 'Grafik Konsumen'
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