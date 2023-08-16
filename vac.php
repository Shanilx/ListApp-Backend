<?php
error_reporting(0);
$date="28-05-2021";
$pinarray[]=452001;
$pinarray[]=452002;
$pinarray[]=452003;
$pinarray[]=452004;
$pinarray[]=452005;
$pinarray[]=452007;
$pinarray[]=452008;
$pinarray[]=452009;
$pinarray[]=4520010;
$pinarray[]=4520012;
$pinarray[]=4520013;
$pinarray[]=4520014;
$pinarray[]=4520015;
$pinarray[]=4520016;
foreach($pinarray  as $pin){
	
$url="https://cdn-api.co-vin.in/api/v2/appointment/sessions/calendarByPin?pincode=$pin&date=$date";
$json = file_get_contents($url);
$data = json_decode($json, TRUE);

echo "$pin<br>";
//print_r($data['centers']);
for($i=0;$i<count($data['centers']);$i++){
	if($data['centers'][$i]["sessions"][0]["available_capacity"]>0){
		echo $data['centers'][0]["address"]."_____";
		// echo $data['centers'][0]["sessions"][0]["available_capacity"];
		echo $data['centers'][0]["sessions"][0]["min_age_limit"]."<br>";
}
}

}
echo "</pre>";
?>
