
<?php
$template_id="62302c793063856ad54b55c4";
$authkey="167511AKkpZMQ762302d09P1";
$rand_letter=$_GET['otp'];
$phone=$_GET['phone'];

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=62302c793063856ad54b55c4&mobile=$phone&authkey=167511AKkpZMQ762302d09P1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => json_encode(array("OTP"=>$rand_letter)),
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json"
  ],
]);


    $result = curl_exec($curl);

echo ($result)?$result:curl_error($curl);
die("Ok");


$url="https://api.msg91.com/api/v5/otp?template_id=$template_id&mobile=$phone&authkey=$authkey&OTP=$rand_letter";


    //$rs = file_get_contents(trim($url));



      // $ch = curl_init();

      // curl_setopt($ch, CURLOPT_URL, $url);     

      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

      // curl_setopt($ch, CURLOPT_POST, 1); 

      // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      // $result = curl_exec($ch);

      // echo ($result)?$result:curl_error($ch);


/*$to = "rahulnakum.syscraft@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: noreply@listapp.in" . "\r\n" .
"CC: rahul.nakum@syscraft.com";
if(mail($to,$subject,$txt,$headers)){
	echo "send";
}else{
	echo "not send";
}*/
?>