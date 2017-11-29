<?php
include_once(dirname(__FILE__) . '/../config/config.php');

error_reporting(0);

for($i=0; $i<=1;$i+=1)
{

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "origin=278&destination=27&weight=1000&courier=jne",
	  CURLOPT_HTTPHEADER => array(
		"content-type: application/x-www-form-urlencoded",
		"key:9ccfb3067015ddd3000fb1c984ac06a1"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  
	  echo "$response<br>";
	  
	  $json = json_decode($response, true);

	  
	$weight='1000';
	$origin_city_id = $json['rajaongkir']['origin_details']['city_id'];
	$destination_city_id = $json['rajaongkir']['destination_details']['city_id'];

	$code = $json['rajaongkir']['results'][0]['code'];
	$name = $json['rajaongkir']['results'][0]['name'];

	$res_costs_service = $json['rajaongkir']['results'][0]['costs'];
	$ctc = $res_costs_service[0]['cost'][0]['value'];
	$ctcoke = $res_costs_service[1]['cost'][0]['value'];
	$ctcsps = $res_costs_service[2]['cost'][0]['value'];
	$ctcyes = $res_costs_service[3]['cost'][0]['value'];
	
	$etd_ctc = $res_costs_service[0]['cost'][0]['etd'];
	$etd_ctcoke = $res_costs_service[1]['cost'][0]['etd'];
	$etd_ctcsps = $res_costs_service[2]['cost'][0]['etd'];
	$etd_ctcyes = $res_costs_service[3]['cost'][0]['etd'];
	
	
	/*

		foreach($res_costs_service as $item)
		{
			echo $item['service']."<br>";		
			foreach($item['cost'] as $ongkos)
			{
				echo "-".$ongkos['value']."</br>";
				echo "-".$ongkos['etd']."</br><hr>";
			}
			
		}

	*/

	/*
	
			$db->query("INSERT INTO ro_cost SET 
								weight='$weight', 
								origin_city_id='$origin_city_id', 
								destination_city_id='$destination_city_id', 
								code='$code',
								ctc='$ctc',
								ctcoke='$ctcoke',
								ctcsps='$ctcsps',
								ctcyes='$ctcyes',
								etd_ctc='$etd_ctc',
								etd_ctcoke='$etd_ctcoke',
								etd_ctcsps='$etd_ctcsps',
								etd_ctcyes='$etd_ctcyes'																
								");
								
			$db->query("INSERT INTO ro_code SET  code='$code',name='$name'");
	*/
	}


}