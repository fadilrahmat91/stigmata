<?php
include_once(dirname(__FILE__) . '/../config/config.php');


function ambil_ongkir($url)
{	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"key:9ccfb3067015ddd3000fb1c984ac06a1"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  return "cURL Error #:" . $err;
	} else {
	  return $response;
	}

}

/*

for($i=1; $i<10; $i++)
{
	$test = "http://api.rajaongkir.com/starter/city?id=$i";
	$ambil = ambil_ongkir($test);
	$jsonIterator = new RecursiveIteratorIterator(
		new RecursiveArrayIterator(json_decode($ambil, TRUE)),
		RecursiveIteratorIterator::SELF_FIRST);
	
	foreach ($jsonIterator as $key => $val) {
		if(is_array($val)) {
		  //  echo "$key:<br>";
		} else {
			echo "$key => $val<br>";
			//$db->query("INSERT INTO ro_city SET '$key'=''")
		}
	}
	echo "$ambil<hr>";
	
}

*/

for($i=501; $i<=550; $i+=1)
{
$url = 'http://api.rajaongkir.com/starter/city?id='.$i.'&key=9ccfb3067015ddd3000fb1c984ac06a1';
$content = file_get_contents($url);
$json = json_decode($content, true);

$city_id = $json['rajaongkir']['results']['city_id'];
$province_id = $json['rajaongkir']['results']['province_id'];
$province = $json['rajaongkir']['results']['province'];
$type = $json['rajaongkir']['results']['type'];
$city_name = $json['rajaongkir']['results']['city_name'];
$postal_code = $json['rajaongkir']['results']['postal_code'];

//echo $url."<br>";
/*
echo $city_id."-";
echo $province_id."-";
echo $province."-";
echo $type."-";
echo $city_name."-";
echo $postal_code.";";
*/
$db->query("INSERT INTO ro_city SET city_id='$city_id', province_id='$province_id', type='$type', city_name='$city_name', postal_code='$postal_code'");
$db->query("INSERT INTO ro_province SET  province_id='$province_id',province='$province'");

echo "<br>";

}

//var_dump($json['rajaongkir']['results']);

?>
