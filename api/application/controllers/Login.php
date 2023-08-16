<?php

error_reporting(0);
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: PUT, GET, POST");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//header('Access-Control-Allow-Origin: http://localhost:3000');
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header ("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");
header('Access-Control-Max-Age: 86400');
//ini_set('allow_url_fopen',1);

include_once(APPPATH.'libraries/REST_Controller.php');

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends REST_Controller {



  public function __construct()

  {

    parent::__construct();
    
    date_default_timezone_set('Asia/Kolkata');}

    function randNumber($digits='')

    {

      if(! $digits)

        $digits = 6;

      $num =  rand(pow(10, $digits-1), pow(10, $digits)-1);

      return $num;

    }


    function sendOtpSms($rand_letter,$phone)

    {

      // $api_key = '167511ACh5HC89O597c4889';

      // $msg = '<#> Your ListApp Verification Code is: '.$rand_letter.'. Please do not reply to this message. Thanks for using ListApp. akxkfMVUaCK' ;      
      // $msg = 'Your ListApp Verification Code is: '.$rand_letter.'. Please do not reply to this message. Thanks for using ListApp.' ;      

      // $sms=str_replace(' ','%20',urlencode($msg));   

    // $url = 'https://control.msg91.com/api/sendhttp.php?authkey='.$api_key.'&mobiles='.$phone.'&message='.$sms.'&sender=LSTAPP&route=4&country=91';  

      //$url='https://control.msg91.com/api/sendotp.php?authkey='.$api_key.'&mobile=91'.$phone.'&message='.$sms.'&sender=LSTAPP&otp='.$rand_letter;  
//$template_id="62302c793063856ad54b55c4";
//$template_id="1207164732388449837";
$template_id="62302c793063856ad54b55c4";
$authkey="167511AKkpZMQ762302d09P1";
//$url="https://api.msg91.com/api/v5/otp?template_id=$template_id&mobile=$phone&authkey=$authkey&OTP=$rand_letter";


    //$rs = file_get_contents(trim($url));



      // $ch = curl_init();

      // curl_setopt($ch, CURLOPT_URL, $url);     

      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

      // curl_setopt($ch, CURLOPT_POST, 1); 

      // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      // $result = curl_exec($ch);

      // return ($result)?$result:curl_error($ch);
$phone="91".$phone;
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

return ($result)?$result:curl_error($curl);
// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);



// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }

    }





    public function checkDeviceReg_post()

    {

		

		

      $blank_arr=array();

      $phone=$this->input->post('mobile_no');

      $mobile_unique_id = $this->input->post('mobile_unique_id');

      $device_token = $this->input->post('device_token'); 

      $device_type = $this->input->post('device_type'); 

    //$otp = $this->input->post('otp'); 

      $data=$_POST; 

	  	  

	  				

      if(empty($phone) || empty($mobile_unique_id) || empty($device_token)|| empty($device_type))

      {

        $final_data = array('error'=>'1','message'=>'Please Provide all information');	

        $this->set_response($final_data, REST_Controller::HTTP_OK);

      }

      else

      {

        $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'],"device_token"=>$data['device_token'],'otp_varified'=>1));

        $result = $query_phone->result_array();

        if(!empty($result))

        {

          $final_data = array('error'=>'0','message'=>'Device Registered');		  

          $this->set_response($final_data, REST_Controller::HTTP_OK);

        }

        else

        {

          $final_data = array('error'=>'1','message'=>'Device Not Registered');         

		  $this->set_response($final_data, REST_Controller::HTTP_OK);

        }



      }

    }

    public function checkMobile_post()

    {



      $phone=$this->input->post('mobile_no');

      $data=$_POST; 



      if(empty($phone))

      {

        $final_data = array('error'=>'1','message'=>'Please Provide all information','data'=>'');

        $this->set_response($final_data, REST_Controller::HTTP_OK);

      }

      else

      {

        $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no']));

        $result = $query_phone->result_array();

        if(!empty($result))

        {

          $final_data = array('error'=>'0');

          $this->set_response($final_data, REST_Controller::HTTP_OK);

        }

        else

        {

          $final_data = array('error'=>'1');

          $this->set_response($final_data, REST_Controller::HTTP_OK);

        }



      }

    }





	 public function Login_post()

    {

      $blank_arr=array();

      $phone=$this->input->post('mobile_no');

      $password = $this->input->post('password');

      $device_token = $this->input->post('device_token'); 

      $device_type = $this->input->post('device_type'); 

    //$otp = $this->input->post('otp'); 

      $data=$_POST; 

      $otp='';

	  

      if(empty($phone) || empty($password) || empty($device_token)|| empty($device_type))

      {

        $final_data = array('error'=>'1','message'=>'Please Provide all information');

        $this->set_response($final_data, REST_Controller::HTTP_OK);

      }

      else

      {

        $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no']));

        $result = $query_phone->result_array();

        if(!empty($result))

        {







          foreach($result as $res)

          {

            $stored_salt = $res['salt'];

            $stored_passsword = $res['password'];

          }



          $userPassword = $data['password'];

          $hashedPassword = $userPassword;

          /* changes 22-03-2021 by developer */

          //$hashedPassword = encode($userPassword, $stored_salt);

          //$hashedPassword = encode($userPassword, $stored_salt);

          $where = array(

            'phone'=>$this->input->post('mobile_no'), 

            'pwd_without_encode'=>$hashedPassword

          );

          $select='role,user_id,first_name as full_name,email,phone,address,landmark,state,city,shop_name,otp,status';

          $data = $this->common_model->get_entry_by_data('user',true,$where,$select);

          if($data) 

          {

            if($result[0]['status'] ==='Active') 

            {



              $saved_device_token=$result[0]['device_token'];

              if($device_token != $saved_device_token)

              {

              //$otp_token=mt_rand(100000,999999);
                if($phone=="1111777788"){
                    $otp_token="123456";
                }else{
                $otp_token=$rand_letter = $this->randNumber();
                $sms_rturn= $this->sendOtpSms($rand_letter,$phone);
            }


                $success_device_msg="go to otp";

                $arr=array(

                  'device_type'=>$device_type,

                  'device_token'=>$device_token,

                  'otp_varified'=>'0',

                  'otp'=>$otp_token,



                );

              }

              else

              {



                $success_device_msg="success";

                $arr=array(

                  'device_type'=>$device_type,

                );

              }

              $where_phone=array('phone'=>$phone);

              $response=$this->users_model->UpdateData('user',$arr,$where_phone);



              if(!empty($otp_token))

              {

                $final_data = array('error'=>'1','message'=>'go to otp','data'=>array('OTP'=>$otp_token));

                $this->set_response($final_data, REST_Controller::HTTP_OK);

              }

              else

              {





                if($result[0]['otp_varified']==1)    

                {



                  $retailerDetail=array();



                  $user_id=$data['user_id'];

                  if($result[0]['last_login'] != '')

                  {

                   $last_login_array = json_decode($result[0]['last_login']);

                   $last_login_array[] = date('Y-m-d h:i');

                   $last_login_json = json_encode($last_login_array);

                   

                 }else{

                   $last_login_array = array(date('Y-m-d h:i'));

                   $last_login_json = json_encode($last_login_array);

                 }

                 

                 $upd_arr = array('login_status' =>'1','last_login'=>$last_login_json);

                 $login_status=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');



                 if($data['role']==3){



                  $data['role_name']="Retailer";

                  $data['role_id']=$data['role'];

                  // unset($data['role']);

                } 

                if($data['role']==2){

                  $data['role_name']="Supplier";

                  $data['role_id']=$data['role'];

                  // unset($data['role']);



                }



                $data['state_id']=($data['state'])?$data['state']:'NA';

                $states=$this->users_model->GetCityState('states','name','id',$data['state']);

                $data['state']=($states[0]['name'])?$states[0]['name']:'NA';



                $data['city_id']=($data['city'])?$data['city']:'NA';

                $cities=$this->users_model->GetCityState('cities','name','id',$data['city']);

                $data['city']=($cities[0]['name'])?$cities[0]['name']:'NA';





                $retailerDetail['Role_id']=$data['role_id'];



                $retailerDetail['Role_Name']=$data['role_name'];



                $retailerDetail['User_ID']=$data['user_id'];



                $retailerDetail['OTP']=$data['otp'];



                $retailerDetail['Full_Name']=$data['full_name'];



                $retailerDetail['Email']=$data['email'];



                $retailerDetail['Contact_Number']=$data['phone'];



                $retailerDetail['Area']=$data['landmark'];



                $retailerDetail['Address']=utf8_encode(html_entity_decode($data['address']));



                $retailerDetail['City']=$data['city'];



                $retailerDetail['State']=$data['state'];



                $retailerDetail['Shop_Name']=$data['shop_name'];



                $retailerDetail['CityId']=$data['city_id'];



                $retailerDetail['Stateid']=$data['state_id'];



                $retailerDetails[]=$retailerDetail;

                // if(!empty($otp_token))

                // {

                // $final_data = array('error'=>'1','message'=>'go to otp','data'=>array('OTP'=>$otp_token));

                // $this->set_response($final_data, REST_Controller::HTTP_OK);

                // }else{

                $final_data = array('error'=>'0','message'=>'success','data'=>$retailerDetail);

                $this->set_response($final_data, REST_Controller::HTTP_OK);

                // }





              }

              else

              {
                if($phone=="1111777788"){
                    $otp_token="123456";
                }else{
                $otp_token=$rand_letter = $this->randNumber();
               $sms_rturn= $this->sendOtpSms($rand_letter,$phone);
                }
                $arr=array(          

                  'otp_varified'=>'0',

                  'otp'=>$otp_token,

                );

                $where_phone=array('phone'=>$phone);

                $response=$this->users_model->UpdateData('user',$arr,$where_phone);



                $error = array('error'=>'1','message'=>'OTP Unverified','data'=>array('OTP'=>$result[0]['otp']));

                $this->set_response($error, REST_Controller::HTTP_OK);

              }

            } 

          } 

          else 

          {

// 'Your ListApp a/c is deactivate. Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> Helpline - 9993671716'
        //$error = array('error'=>'1','message'=>'Your account has been deactivated-1. Contact - 9993671716. link:- <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a>');
        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive. <br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

            $this->set_response($error, REST_Controller::HTTP_OK);

          }

        }

        else 

        {

          $error = array('error'=>'1','message'=>'Invalid Mobile Number or password');

          $this->set_response($error, REST_Controller::HTTP_OK);

        }



      } 

      else

      {

        $error = array('error'=>'1','message'=>'Mobile number not registered with us');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    } 

  }





  //Function for User Login via API



    public function Nogin_post()

    {

      $blank_arr=array();

      $phone=$this->input->post('mobile_no');

      $password = $this->input->post('password');

      $device_token = $this->input->post('device_token'); 

      $device_type = $this->input->post('device_type'); 

    //$otp = $this->input->post('otp'); 

      $data=$_POST; 

      $otp='';

	  

      if(empty($phone) || empty($password) || empty($device_token)|| empty($device_type))

      {

        $final_data = array('error'=>'1','message'=>'Please Provide all information');

        $this->set_response($final_data, REST_Controller::HTTP_OK);

      }

      else

      {

        $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no']));

        $result = $query_phone->row();

		//print_r($result); exit;

        if(!empty($result))

        {

			$stored_salt = $result->salt;

			//$stored_passsword = $result->password;

      $stored_passsword = $result->pwd_without_encode;

			

			

			$userPassword = $data['password'];

			//$hashedPassword = md5($userPassword.''.$stored_salt);

      $hashedPassword = $userPassword;

		//echo $stored_passsword.'<br/>'.$hashedPassword;

		//exit;			  

         /* $where = array(

            'phone'=>$this->input->post('mobile_no'), 

            'password'=>$hashedPassword

          );

          $select='role,user_id,first_name as full_name,email,phone,address,landmark,state,city,shop_name,otp,status';

          $data = $this->common_model->get_entry_by_data('user',true,$where,$select);

		*/        

		  if($stored_passsword === $hashedPassword) 

          {

            if($result->status === 'Active') 

            {

			   //$saved_device_token=$resuslt->device_token;

              if($device_token != $resuslt->device_token)

              {

              //$otp_token=mt_rand(100000,999999);

                $otp_token=$rand_letter = $this->randNumber();



                $sms_rturn= $this->sendOtpSms($rand_letter,$phone);



                $success_device_msg = "go to otp";

                $arr=array(

                  'device_type'=>$device_type,

                  'device_token'=>$device_token,

                  'otp_varified'=>'0',

                  'otp'=>$otp_token,

				);



				$where_phone=array('phone'=>$phone);

				$response = $this->users_model->UpdateData('user',$arr,$where_phone);

				

				$final_data = array('error'=>'1','message'=>'go to otp','data'=>array('OTP'=>$otp_token));

				$this->set_response($final_data, REST_Controller::HTTP_OK);

				

              }

              else

              {



                $success_device_msg="success";

                /*$arr=array(

                  'device_type'=>$device_type,

                );*/

				

				if($result->otp_varified == 1)    

                {



					$retailerDetail=array();

					$user_id = $result->user_id;

                  

					if($result->last_login != '')

					{

						$last_login_array = json_decode($result->last_login);

						$last_login_array[] = date('Y-m-d h:i');

						$last_login_json = json_encode($last_login_array);

					}else{

						$last_login_array = array(date('Y-m-d h:i'));

						$last_login_json = json_encode($last_login_array);

					}

                 

                 $upd_arr = array('login_status' =>'1','last_login'=>$last_login_json);

                 $login_status=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');



                 if($result->role == 3){



                  $roleName="Retailer";

                  //$data['role_id']=$result->role;

                  // unset($data['role']);

                } 

                if($data['role']==2){

                  $roleName = "Supplier";

                  //$data['role_id']=$result->role;

                  // unset($data['role']);



                }



				if($data['state']){

					$states=$this->users_model->GetCityState('states','name','id',$data['state']);

					$stateName = ($states[0]['name'])?$states[0]['name']:'NA'; 

				}else{

					$stateName = 'NA';

				}

                //$data['state_id']=($data['state'])?$data['state']:'NA';

                //$states=$this->users_model->GetCityState('states','name','id',$data['state']);

                

				if($data['state']){

					$cities=$this->users_model->GetCityState('cities','name','id',$data['city']);

					$cityName = ($cities[0]['name'])?$cities[0]['name']:'NA';

				}else{

					$cityName = 'NA';

				}



               /* $data['city_id']=($data['city'])?$data['city']:'NA';

                $cities=$this->users_model->GetCityState('cities','name','id',$data['city']);

                $data['city']=($cities[0]['name'])?$cities[0]['name']:'NA';*/





                $retailerDetail['Role_id']= $result->role; //$data['role_id'];



                $retailerDetail['Role_Name']= $roleName; //$data['role_name'];



                $retailerDetail['User_ID']= $result->user_id; //$data['user_id'];



                $retailerDetail['OTP']= $result->otp; //$data['otp'];



                $retailerDetail['Full_Name']= $result->first_name; //$data['full_name'];



                $retailerDetail['Email']= $result->email; //$data['email'];



                $retailerDetailN['Contact_Number']= $result->phone; //$data['phone'];



                $retailerDetail['Area']= $result->landmark; //$data['landmark'];



                $retailerDetail['Address']=utf8_encode(html_entity_decode($result->address)); //$data['address']



                $retailerDetail['City']=$data['city'];



                $retailerDetail['State']=$data['state'];



                $retailerDetail['Shop_Name']=$data['shop_name'];



                $retailerDetail['CityId']=$data['city_id'];



                $retailerDetail['Stateid']=$data['state_id'];



                $retailerDetails[]=$retailerDetail;



                $final_data = array('error'=>'0','message'=>'success','data'=>$retailerDetail);

                $this->set_response($final_data, REST_Controller::HTTP_OK);



				}

              }

			  

             // $where_phone=array('phone'=>$phone);

              //$response = $this->users_model->UpdateData('user',$arr,$where_phone);



               /*if(!empty($otp_token))

              {

               $final_data = array('error'=>'1','message'=>'go to otp','data'=>array('OTP'=>$otp_token));

                $this->set_response($final_data, REST_Controller::HTTP_OK);

              }

              else

              {*/







              /*else

              {

                $otp_token=$rand_letter = $this->randNumber();

                $sms_rturn= $this->sendOtpSms($rand_letter,$phone);

                $arr=array(          

                  'otp_varified'=>'0',

                  'otp'=>$otp_token,

                );

                $where_phone=array('phone'=>$phone);

                $response=$this->users_model->UpdateData('user',$arr,$where_phone);



                $error = array('error'=>'1','message'=>'OTP Unverified','data'=>array('OTP'=>$result[0]['otp']));

                $this->set_response($error, REST_Controller::HTTP_OK);

              }

            } */

          } 

          else 

          {

            //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
              $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

            $this->set_response($error, REST_Controller::HTTP_OK);

          }

        }

        else 

        {

          $error = array('error'=>'1','message'=>'Invalid Mobile Number or password');

          $this->set_response($error, REST_Controller::HTTP_OK);

        }



      } 

      else

      {

        $error = array('error'=>'1','message'=>'Mobile number not registered with us');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    } 

  }



  // New User Sign up..



  public function SignUp_post()

  {

    $blank_arr=array();

    $name = $mobile_number = $role = $password = $area = $address = $shop_name = $state = $city = $device_type = $device_token = $email = $CheckeEmail='';



    //$name         =   $this->input->post('full_name');

    $mobile_number=   $this->input->post('mobile_no');

    $password     =   $this->input->post('password');

    $role         =   $this->input->post('user_type');

    $shop_name    =   $this->input->post('shop_name');

    // $email        =   $this->input->post('email');

    // $area         =   $this->input->post('area');

    // $address      =   $this->input->post('address');

    // $state_id     =   $this->input->post('state_id');

    //$city_id      =   $this->input->post('city_id');

    $device_type  =   $this->input->post('device_type');

    $device_token =   $this->input->post('device_token');

    $mobile_unique_id = $this->input->post('mobile_unique_id');

    $city_id = $this->input->post('city_id');

    // print_r($_POST);die;



    // if($name =='' || $mobile_number =='' || $role == '' || $password == '' || $area== '' || $address =='' || $shop_name =='' || $state_id =='' || $city_id=='' || $device_type =='' || $device_token ==''  || $mobile_unique_id=='')

    if($mobile_number =='' || $role == '' || $password == ''  || $shop_name =='' ||$device_type ==''   || $mobile_unique_id==''){

      //|| $device_token =='' for signup issue

      $final_data = array('error'=>'1','message'=>'Please Provide all information');

      $this->set_response($final_data, REST_Controller::HTTP_OK);

    }else{



      $time=date("Y-m-d h:i:s");

      //check user email already exist or not

      if(!empty($email)){



        $where = array('email'=>$email);

        $CheckeEmail = $this->users_model->GetRecord($where,'user');

      }

      $where2 = array('phone'=>$mobile_number,);

      $mobile_number_exist = $this->users_model->GetRecord($where2,'user');

      if(!empty($CheckeEmail))

      {

        $final_data = array('error'=>'1','message'=>'User with this Email Id Already Exists');

        $this->set_response($final_data, REST_Controller::HTTP_OK);

      }

      else if(!empty($mobile_number_exist))

      {

        $final_data = array('error'=>'1','message'=>'User with this Mobile Number Already Exists. Please Login');

        $this->set_response($final_data, REST_Controller::HTTP_OK);

      }



      else{



        /*$states=$this->users_model->GetCityState('states','id','name',ucfirst($state));

     $state_id=($states[0]['id'])?$states[0]['id']:'0';



     $cities=$this->users_model->GetCityState('cities','id','name',ucfirst($city));

     $city_id=($cities[0]['id'])?$cities[0]['id']:'0';*/

     $salt=random_string('alnum', 16);

        //$otp=mt_rand(100000,999999);



     $otp=$rand_letter = $this->randNumber();



     $sms_rturn= $this->sendOtpSms($rand_letter,$mobile_number);



     //$encrypted_pass= encode($this->input->post('password'),$salt);

     $encrypted_pass= md5($this->input->post('password').''.$salt);

     $arr = array(

          //'first_name'   => $name,

      'phone'        => $mobile_number,

      'password'     => $encrypted_pass,

      'pwd_without_encode'=> $password,

      'role'         => $role,

      'shop_name'    => $shop_name,

          //'email'        => $email,

          //'landmark'     => $area,

          // 'address'      => $address,

          //'state'        => $state_id,

          //'city'         => $city_id,

      'otp'          => $otp,

      'salt'         => $salt,

      'device_type'  => $device_type,

      'device_token'=> $device_token,

      'mobile_unique_id'=> $mobile_unique_id,

      'otp_verify_first'   => '0',

      'status'       => '1',

      'regis_date'   => $time,

      'city'=>$city_id

    );

        // print_r($arr);die;

     $user_id = $this->users_model->InsertData('user',$arr);

     if($user_id)

     {

      $retailerDetail=array();

      $where = array('user_id'=>$user_id);

      $select='role,user_id,first_name as full_name,email,phone,address,landmark,state,city,shop_name,otp,status';

      $retailer=$this->users_model->GetRecord($where,'user','','',$select);

      if(count($retailer) > 0 )

      {

        foreach($retailer as $retailer_val) 

        {



          if($retailer_val['role']==3){



            $retailer_val['role_name']="Retailer";

            $retailer_val['role_id']=$retailer_val['role'];

            unset($retailer_val['role']);

          } 

          if($retailer_val['role']==2){

            $retailer_val['role_name']="Supplier";

            $retailer_val['role_id']=$retailer_val['role'];

            unset($retailer_val['role']);



          }



          if($retailer_val['state'])

          {

            $retailer_val['state_id']=($retailer_val['state'])?$retailer_val['state']:'NA';

            $states=$this->users_model->GetCityState('states','name','id',$retailer_val['state']);

            $retailer_val['state']=($states[0]['name'])?$states[0]['name']:'NA';



          }

          if($retailer_val['city'])

          {

            $retailer_val['city_id']=($retailer_val['city'])?$retailer_val['city']:'NA';

            $cities=$this->users_model->GetCityState('cities','name','id',$retailer_val['city']);

            $retailer_val['city']=($cities[0]['name'])?$cities[0]['name']:'NA';



          }

              /* if($supplier['company_deal'])

      {

       $company_names=$this->users_model->GetCityState('company','company_name','company_id','','',explode(',', $supplier['company_deal']));

       $comp_name_arr=array();

       foreach ($company_names as $C_value) {

         $comp_name_arr[]=$C_value['company_name'];

       }

       $supplier['company_deal']=$comp_name_arr;

     }*/





   }



   $retailerDetail['Role_id']=$retailer_val['role_id'];



   $retailerDetail['Role_Name']=$retailer_val['role_name'];



   $retailerDetail['User_ID']=$retailer_val['user_id'];



   $retailerDetail['OTP']=$retailer_val['otp'];



            //$retailerDetail['Full_Name']=$retailer_val['full_name'];



            // $retailerDetail['Email']=$retailer_val['email'];



   $retailerDetail['Contact_Number']=$retailer_val['phone'];



            //$retailerDetail['Area']=$retailer_val['landmark'];



            // $retailerDetail['Address']=utf8_encode(html_entity_decode($retailer_val['address']));



            // $retailerDetail['City']=$retailer_val['city'];



            //$retailerDetail['State']=$retailer_val['state'];



   $retailerDetail['Shop_Name']=$retailer_val['shop_name'];



            //$retailerDetail['CityId']=$retailer_val['city_id'];



            //$retailerDetail['Stateid']=$retailer_val['state_id'];

   



   $message = array('error'=>'0','message'=>'success','data'=>$retailerDetail);

   $this->set_response($message, REST_Controller::HTTP_OK);



 }

 else

 {

  $message = array('error'=>'0','message'=>'No Record Found');

  $this->set_response($message, REST_Controller::HTTP_OK);

}

}

else

{

  $final_data = array('error'=>'1','message'=>'You have not Sign Up. Please Try Again');

  $this->set_response($final_data, REST_Controller::HTTP_OK);

}

}



}

}









public function StateCity_get ()

{

    //$state  =  $this->input->post('state');

  $where = array('name'=>'India');

  $GetRecord = $this->users_model->GetRecord($where,'countries');

    // print_r($GetRecord);

  $country_id= $GetRecord[0]['id'];

  $country_name= $GetRecord[0]['name'];



  $where = array('country_id'=>$country_id);



  $GetState = $this->users_model->GetRecord($where,'states');

    // print_r($GetState);die;

  $stateCity=array();

  $dataArray=array();

  foreach($GetState as $state)

  {



    $stateCity['state_id']=$state['id'];

    $stateCity['state_name']=$state['name'];

    $where = array('state_id'=>$state['id']);

    $cityArray=array();

    $GetCity = $this->users_model->GetRecord($where,'cities');

    foreach($GetCity as $city)

    {

      $cityArray[]= array('city_id' => $city['id'],'city_name' => $city['name']);

    }

    $stateCity['city']=$cityArray;

    $dataArray[]=$stateCity;





  }



  $final_data = array('error'=>'0','message'=>'success','data'=>$dataArray);

  $this->set_response($final_data, REST_Controller::HTTP_OK);

}    



public function forgotPassword_post()

{

  $blank_arr=array();

  $phone=$this->input->post('mobile_no');

  $device_type = $this->input->post('device_type');

  $device_token = $this->input->post('device_token');

  $data1=$_POST; 

  if(empty($phone) || empty($device_type) || empty($device_token))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data1['mobile_no']));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['status'] ==='Active') 

      {



        $user_id=$result[0]['user_id'];

          //$otp=mt_rand(100000,999999);

        $otp=$rand_letter = $this->randNumber();

        $sms_rturn= $this->sendOtpSms($rand_letter,$phone);

        $arr=array('otp'=>$otp);

        $data=$arr;

        $data_1=$this->users_model->updateOTP('user',$user_id,$arr);

        $message = array('error'=>'0','message'=>'OTP has been sent on Your Mobile','data'=>$data);

        $this->set_response($message, REST_Controller::HTTP_OK);

      }

      else

      {

        //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
          $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }

    } 

    else

    {

      $error = array('error'=>'1','message'=>'Mobile number not registered with us');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }



  }



}

public function resendOTP_post()

{

  $blank_arr=array();

  $phone=$this->input->post('mobile_no');

  $device_type = $this->input->post('device_type');

  $device_token = $this->input->post('device_token');

  $data1=$_POST; 

  if(empty($phone) || empty($device_type) || empty($device_token))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data1['mobile_no']));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['status'] ==='Active') 

      {

        $user_id=$result[0]['user_id'];

          // $otp=mt_rand(100000,999999);

        $otp=$rand_letter = $this->randNumber();

        $sms_rturn= $this->sendOtpSms($rand_letter,$phone);

        $arr=array('otp'=>$otp);

        $data=$arr;

        $data_1=$this->users_model->updateOTP('user',$user_id,$arr);

        $message = array('error'=>'0','message'=>'OTP has been sent on Your Mobile'.$rand_letter,'data'=>$data);

        $this->set_response($message, REST_Controller::HTTP_OK);

      }

      else

      {

        //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
          $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    } 

    else

    {

      $error = array('error'=>'1','message'=>'Mobile number not registered with us');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }



  }



}

/*Check OTP VALIDATE*/



public function otpVerify_post()

{

  $blank_arr=array();

  $phone = $this->input->post('mobile_no');

  $otp   =  $this->input->post('otp');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  $this->input->post('device_token');





  $data=$_POST; 

  if(empty($phone) || empty($otp) || empty($device_type) || empty($device_token))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no']));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['status'] ==='Active') 

      {



        if($result[0]['otp'] == $data['otp']) 

        {

          if($result[0]['otp_verify_first']==0) 

          {



            $message='Welcome to ListApp!



            A new way of discovering Medicines, Suppliers & Companies.



            Enjoy 6 months of Free access to this app.



            Best Wishes,

            Team ListApp';

            $ins_data = array(

              'notification_user_id' =>$result[0]['user_id'],

              'message' =>$message,

              'notification_type' =>1,

              'notification_title'=>'Welcome',

              'notification_to_name'=>$retailer_val['shop_name'],

              'sound' => 'default',

              'alert' => 'Welcome',

            );  

            

            send_gcm_notify($device_token,$ins_data,$device_type);  

            

            

          }



          $user_id=$result[0]['user_id'];

          $upd_arr=array('otp' => $otp,'otp_varified'=>1,'otp_verify_first'=>1,'device_token'=>$device_token);

          $update=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');

          if(!empty($update)){

            $message = array('error'=>'0','message'=>'OTP Verified','data'=>array('user_id'=>$user_id));

            $this->set_response($message, REST_Controller::HTTP_OK);

          }else{

            $message = array('error'=>'1','message'=>'Invalid OTP');

            $this->set_response($message, REST_Controller::HTTP_OK);

          }

        }

        else

        {

          $error = array('error'=>'1','message'=>'Invalid OTP');

          $this->set_response($error, REST_Controller::HTTP_OK);

        }    

      }

      else

      {

        //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
          $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

        $this->set_response($error, REST_Controller::HTTP_OK);

      } 



    } 

    else

    {

      $error = array('error'=>'1','message'=>'Mobile number not registered with us');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }

  }

}

/*Check OTP VALIDATE ends */



/*GET PROFILE DATA STARTS */



public function getProfile_post()

{

  $phone = $this->input->post('mobile_no');

  $user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');



  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($user_id))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"user_id"=>$data['user_id']));



    $result = $query_phone->result_array();

    if(!empty($result))

    {



      $retailerDetail=array();



      $where = array('user_id'=>$user_id);

      $select='user_id,first_name as full_name,email,phone,address,landmark,state,city,shop_name,status,dl_no,estd_year,tin_no,contact_person,contact_person_number';

      $retailer=$this->users_model->GetRecord($where,'user','','',$select);

      if(count($retailer) > 0 )

      {

        foreach($retailer as $retailer_val) 

        {



          if($retailer_val['state'])

          {

            $states=$this->users_model->GetCityState('states','name','id',$retailer_val['state']);

            $retailer_val['state']=($states[0]['name'])?$states[0]['name']:'NA';

          }

          if($retailer_val['city'])

          {

            $cities=$this->users_model->GetCityState('cities','name','id',$retailer_val['city']);

            $retailer_val['city']=($cities[0]['name'])?$cities[0]['name']:'NA';

          }



          if($retailer_val['address']){

            $retailer_val['address']= utf8_encode(html_entity_decode($retailer_val['address']));

          }

          if($retailer_val['landmark']){

            $retailer_val['landmark']= utf8_encode(html_entity_decode($retailer_val['landmark']));

          }

            /* if($supplier['company_deal'])

      {

       $company_names=$this->users_model->GetCityState('company','company_name','company_id','','',explode(',', $supplier['company_deal']));

       $comp_name_arr=array();

       foreach ($company_names as $C_value) {

         $comp_name_arr[]=$C_value['company_name'];

       }

       $supplier['company_deal']=$comp_name_arr;

     }*/



     $retailerDetail[]=$retailer_val;



   }

 }

 else

 {

  $retailerDetail[]="No Supplier In This Location";

}





$data1['retailer']=$retailerDetail;



$message = array('error'=>'0','message'=>'success','data'=>$data1);

$this->set_response($message, REST_Controller::HTTP_OK);

} 

else

{

  $error = array('error'=>'1','message'=>'Invalid User Detail');

  $this->set_response($error, REST_Controller::HTTP_OK);

}

}



}

/*GET PROFILE DATA ENDS*/



/*===========GET searchProduct starts===========*/





public function searchProduct_post()

{

        //Include Mamcache library 

 

  $this->load->driver('cache');

  $this->load->library('memcached_library');

/*$this->load->driver('cache', array(

    'adapter' => 'memcached', 

    'backup' => 'file'

  ));*/

  

  

  $blank_arr=array();

  $phone = $this->input->post('mobile_no');

  $product_name = $this->input->post('product_name');

  $user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  $this->input->post('device_token');

  $city_id   =  ($this->input->post('city_id'))?$this->input->post('city_id'):'2229';

  $offset   =  $this->input->post('offset');



  $data1=$_POST; 

  if(empty($phone)  ||(empty($offset) && $offset!=0) ||empty($city_id) || empty($device_type) || empty($user_id) || empty($product_name)|| empty($device_token))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data1['mobile_no'] ,"user_id"=>$data1['user_id'],"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['device_token'] == $data1['device_token']) 

      {

        if($offset > 0){

          $offset=$offset*50;

        }

        $no_of_records=50;



          // $product_name=trim($product_name);

          // if(strlen($product_name) >=4){



          // $last_one=substr($product_name,-1,2);

          // $last_two=substr($product_name,-2,2);

          // $last_three=substr($product_name,-3,3);

          // }

          // $first_three=substr($product_name,0,3);

          // $first_one=substr($product_name,0,1);

          //  $sql="SELECT * FROM `m16j_product` WHERE SUBSTRING_INDEX(product_name,' ',1) like '".$product_name."%' ORDER BY product_name asc LIMIT $offset ,$no_of_records"; 

          // $data=$this->db->query($sql)->result_array(); 



          // if(empty($data)){



          //   $sql="SELECT * FROM `m16j_product` WHERE SUBSTRING_INDEX(product_name,' ',1) like '".$first_three."%".$last_one."' ORDER BY product_name asc LIMIT $offset ,$no_of_records";

          // $data=$this->db->query($sql)->result_array();

          // }

          // if(empty($data)){

          //   $sql="SELECT * FROM `m16j_product` WHERE SUBSTRING_INDEX(product_name,' ',1) like '".$product_name."%' ORDER BY product_name asc LIMIT $offset ,$no_of_records"; 

          // $data=$this->db->query($sql)->result_array();

          // }

          // if(empty($data)){

          //   $sql="SELECT * FROM `m16j_product` WHERE SUBSTRING_INDEX(product_name,' ',1) like '%".$last_three."' ORDER BY product_name asc LIMIT $offset ,$no_of_records"; 

          // $data=$this->db->query($sql)->result_array();

          // }

          // if(empty($data)){

          //   $sql="SELECT * FROM `m16j_product` WHERE SUBSTRING_INDEX(product_name,' ',1) like '".$first_one."%".$last_three."' ORDER BY product_name asc LIMIT $offset ,$no_of_records"; 

          // $data=$this->db->query($sql)->result_array();

          // }







        $like=array('product_name'=>$product_name);

          //$explode = explode(" ",$product_name);



         // $data=$this->users_model->searchWithLike('product','',$like,$offset,$no_of_records);

        

         //***********************Memcache library get key 

        

        $results = $this->memcached_library->get($product_name);

        

        

        

        

        

        

      //***************************************************

        

        $explode = explode(" ",$product_name);

        

        if(!$results)

        {

          

         

         $data=$this->users_model->searchWithLike('product','',$like,$offset,$no_of_records);

         

       //  $check=($data)?$this->memcached_library->add($product_name, $data,7000):'';

           

         

       }

       else

       {

        

        $data = $results;

       // $this->memcached_library->delete('TRIBETROL');

        

        

      }

          //echo $this->db->last_query();die;

           //========ARp codestart===

      $both = '';

          /* if(empty($data))

          {

            $string_len=strlen($explode[0]);

            $l=1;

            for ($i=2; $i <$string_len ; $i++) { 

            //$end=$string_len-$i;

            $search_text = substr($explode[0],0,$i);

            $search_end = $last_two=substr($explode[0],-$l,$l);

            $sql="SELECT * FROM `m16j_product` WHERE SUBSTRING_INDEX(product_name,' ',1) like '".$search_text."%".$search_end."' ORDER BY product_name asc LIMIT $offset ,$no_of_records";

            $data=$this->db->query($sql)->result_array(); 

            if(!empty($data)){

              $this->memcached_library->add($product_name, $data,7000);

              break;

            }

            $l++;



            }

            



                     

          }*/

          if(empty($data))

          {

            $string_len=strlen($explode[0]);

            for ($i=1; $i <$string_len ; $i++) { 

              $end=$string_len-$i;

              $search_text = array('product_name'=>substr($explode[0],0,$end));

              $data=$this->users_model->searchWithLike('product','',$search_text ,$offset,$no_of_records,'','product_name','asc');

              if(!empty($data))

              {               

               

                if(strlen($search_text['product_name']) == 3){

               //   $this->memcached_library->add($search_text['product_name'], $data,7000);

                }

                else{               

               //   $this->memcached_library->add($product_name, $data,7000);

                }

                break;                

              }



            }                     

          } 

          /*if(empty($data))

          {

            $search_five = array('product_name'=>substr($explode[0],0,5));

            $data=$this->users_model->searchWithLike('product','',$search_five ,$offset,$no_of_records);

          }



          if(empty($data))

          {

            $search_four = array('product_name'=>substr($explode[0],0,4));

            $data=$this->users_model->searchWithLike('product','',$search_four ,$offset,$no_of_records);

          }     

       $search_three = array('product_name'=>substr($explode[0],0,3));

       $third = $this->memcached_library->get(substr($explode[0],0,3));

          

          if(!$third)

          { 

            $data=$this->users_model->searchWithLike('product','',$search_three ,$offset,$no_of_records);

            $this->memcached_library->add($third, $data,7000);  

          }

      else{   

          $data = $third;  

        }*/

        

       /*   if(empty($data))

          { 





            $search_three = array('product_name'=>substr($explode[0],0,3));



            $data=$this->users_model->searchWithLike('product','',$search_three ,$offset,$no_of_records);





          }

*/



        /*  if(empty($data))

          {

            $both = '1';



            $data=$this->users_model->searchWithLike('product','',$like ,$offset,$no_of_records,$both);



          }*/

          //========ARp codeend===

          //$query=$this->db->last_query();

          if(empty($data)){

            $log_chek=$this->db->get_where('not_found_log',array("log_name"=>$data1['product_name']));

            $log_result = $log_chek->result_array();

            if(!empty($log_result))

            {

              $search_count=$log_result[0]['search_count']+1;

              $log_id=$log_result[0]['log_id'];

              $upd_arr=array('search_count' =>$search_count);

              $update=$this->users_model->update_entry($upd_arr,'not_found_log', $log_id,'log_id');

            }

            else

            {

              $ins_arr=array('log_name'=>$data1['product_name'],'search_count'=>1,'created_date'=>date('Y-m-d h:i:s'));

              $this->users_model->InsertData('not_found_log',$ins_arr);

              // echo $this->db->last_query(); die;

            }



            $message = array('error'=>'1','message'=>'No matching records found');

            $this->set_response($message, REST_Controller::HTTP_OK);

          }else

          {

            for ($i=0; $i <count($data) ; $i++) 

            { 





              if($data[$i]['company_name'])

              {

                $company_name=$this->users_model->GetCityState('company','company_name','company_id',$data[$i]['company_name']);



                $data[$i]['company_name']=$company_name[0]['company_name'];

              }

              if($data[$i]['form'])

              {

                $form_name=$this->users_model->GetCityState('form','Form','form_id',$data[$i]['form']);



                $data[$i]['form']=$form_name[0]['Form'];

              }

              if($data[$i]['packing_type'])

              {

                $packingtype_name=$this->users_model->GetCityState('packing_type','packingtype_name','packing_type_id',$data[$i]['packing_type']);



                $data[$i]['packing_type']=$packingtype_name[0]['packingtype_name'];

              }

              if($data[$i]['pack_size'])

              {

                $pack_size_name=$this->users_model->GetCityState('packsize','Pack_size','pack_size_id',$data[$i]['pack_size']);



                $data[$i]['pack_size']=$pack_size_name[0]['Pack_size'];

              }

              if($data[$i]['schedule'])

              {

                $pack_size_name=$this->users_model->GetCityState('schedule','schedule_name','schedule_id',$data[$i]['schedule']);



                $data[$i]['schedule']=$pack_size_name[0]['schedule_name'];

              }

            }

            $message = array('error'=>'0','message'=>'success','data'=>$data);

            $this->set_response($message, REST_Controller::HTTP_OK);

          }



        } 

        else

        {

          $error = array('error'=>'1','message'=>'Your session has been expired');

          $this->set_response($error, REST_Controller::HTTP_OK);

        }     

      } 

      else

      {

        //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
          $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    }



  }



  /*========GET searchProduct ends=================*/



  /*=======search supplier starts==============*/   







  public function searchSupplier_post()

  { 

    $blank_arr=array();

    $shop_name = $this->input->post('shop_name');

    $phone = $this->input->post('mobile_no');

    $user_id   =  $this->input->post('user_id');

    $device_type   =  $this->input->post('device_type');

    $device_token   =  $this->input->post('device_token');

    $city_id   =  ($this->input->post('city_id'))?$this->input->post('city_id'):'2229';

    $offset   =  $this->input->post('offset');



    $data=$_POST; 

    if(empty($shop_name) ||empty($phone)|| empty($device_token) || empty($user_id) || empty($device_type)|| empty($city_id) || (empty($offset)  && $offset!=0) )

    {

      $final_data = array('error'=>'1','message'=>'Please Provide all information');

      $this->set_response($final_data, REST_Controller::HTTP_OK);

    }

    else

    {

      $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"user_id"=>$data['user_id'],"status"=>'Active'));



      $result = $query_phone->result_array();

      if(!empty($result))

      { 

        if($result[0]['device_token'] ==$data['device_token']) 

        {



          if($offset > 0){

            $offset=$offset*50;

          }

          $no_of_records=50;

          $like=array('shop_name'=>$shop_name,'city'=>$city_id,'status'=>1); 

          $select='supplier_id, name as supplier_name,shop_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status';      

          $data=$this->users_model->searchWithLike('supplier',$select,$like,$offset,$no_of_records);

          if(empty($data))

          {

            $message = array('error'=>'1','message'=>'No matching records found');

            $this->set_response($message, REST_Controller::HTTP_OK);

          }

          else

          {

            for ($i=0; $i <count($data) ; $i++) 

            { 

              /*if($data[$i]['state']){

                          $states=$this->users_model->GetCityState('states','name','id',$data[$i]['state']);

                          $data[$i]['state']=($states[0]['name'])?$states[0]['name']:'NA';

                        }*/

                        if($data[$i]['city_name']){

                          $cities=$this->users_model->GetCityState('cities','name','id',$data[$i]['city_name']);

                          $data[$i]['city_name']=($cities[0]['name'])?$cities[0]['name']:'NA';

                        }

                        if($data[$i]['address']){

                          $data[$i]['address']= utf8_encode(html_entity_decode($data[$i]['address']));

                        }

              /* if($data[$i]['company_deal']){

                         $company_names=$this->users_model->GetCityState('company','company_name','company_id','','',explode(',', $data[$i]['company_deal']));

                         $comp_name_arr=array();

                         foreach ($company_names as $C_value) {

                           $comp_name_arr[]=$C_value['company_name'];

                         }

                         $data[$i]['company_deal']=$comp_name_arr;

                       }*/

                     }

                     $message = array('error'=>'0','message'=>'success','data'=>$data);

                     $this->set_response($message, REST_Controller::HTTP_OK);

                   }



                 } 

                 else

                 {

                  $error = array('error'=>'1','message'=>'Your session has been expired');

                  $this->set_response($error, REST_Controller::HTTP_OK);

                }   

              } 

              else

              {

              //  $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
  $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');
                $this->set_response($error, REST_Controller::HTTP_OK);

              }





            }







          }

          /*search supplier ends*/



          /*======================== SEARCH COMPANY STARTS ===============================*/



          public function searchCompany_post()

          { 

            $blank_arr=array();

            $company_name = $this->input->post('company_name');

            $phone = $this->input->post('mobile_no');

            $device_token = $this->input->post('device_token');

            $user_id   =  $this->input->post('user_id');

            $device_type   =  $this->input->post('device_type');

            $city_id   =  ($this->input->post('city_id'))?$this->input->post('city_id'):'2229';

            $offset   =  $this->input->post('offset');









            $data=$_POST; 

            if(empty($company_name) ||empty($phone) || empty($user_id) || empty($device_type) ||  empty($device_token) || empty($city_id) || (empty($offset)  && $offset!=0) )

            {

              $final_data = array('error'=>'1','message'=>'Please Provide all information');

              $this->set_response($final_data, REST_Controller::HTTP_OK);

            }

            else

            {

              $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"user_id"=>$data['user_id'],"status"=>'Active'));



              $result = $query_phone->result_array();

              if(!empty($result))

              { 

                if($result[0]['device_token'] == $data['device_token']) 

                {

                  if($offset > 0){

                    $offset=$offset*50;

                  }

                  $no_of_records=50;

                  $like=array('company_name'=>$company_name,'status'=>1);

                  $data=$this->users_model->searchWithLike('company','',$like,$offset,$no_of_records);

                  if(empty($data)){

                    $message = array('error'=>'1','message'=>'No matching records found');

                    $this->set_response($message, REST_Controller::HTTP_OK);

                  }else{

                    $message = array('error'=>'0','message'=>'success','data'=>$data);

                    $this->set_response($message, REST_Controller::HTTP_OK);

                  } 

                } 

                else

                {

                  $error = array('error'=>'1','message'=>'Your session has been expired');

                  $this->set_response($error, REST_Controller::HTTP_OK);

                }

              }

              else

              {

               // $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
                  $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

                $this->set_response($error, REST_Controller::HTTP_OK);

              }









            }







          }









          /*======================== SEARCH COMPANY ENDS===============================*/





          /*=================== SEARCH PRODUCT WITH SUPPLIER STARTS ============================*/



          public function searchNearBySupplier_post()

          {

            $blank_arr=array();

            $product_id = $this->input->post('product_id');

            $phone = $this->input->post('mobile_no');

            $user_id   =  $this->input->post('user_id');

            $device_type   =  $this->input->post('device_type');

            $device_token   =  $this->input->post('device_token');

            $city_id   =  ($this->input->post('city_id'))?$this->input->post('city_id'):'2229';

            $offset   =  ($this->input->post('offset'))?$this->input->post('offset'):0;









            $data1=$_POST; 



            if(empty($product_id) ||empty($phone) || empty($city_id) || empty($user_id) || empty($device_type) )

            {

              $final_data = array('error'=>'1','message'=>'Please Provide all information');

              $this->set_response($final_data, REST_Controller::HTTP_OK);

            }

            else

            {

              $query_phone=$this->db->get_where('user',array("phone"=>$data1['mobile_no'] ,"status"=>'Active' ,"user_id"=>$data1['user_id']));



              $result = $query_phone->result_array();

              if(!empty($result))

              { 

                if($result[0]['device_token'] == $data1['device_token']) 

                {



                  $where=array('product_id'=>$product_id,'status'=>1);



                  $data=$this->users_model->GetRecord($where,'product');

                  if(empty($data))

                  {

                    $data['record']="No Record Found";

                  }else

                  {   

                    $company_id=$data[0]['company_name'];



                    if( $offset == 0 ){







                      for ($i=0; $i <count($data) ; $i++) 

                      { 







                        if($data[$i]['company_name'])

                        {

                          $company_name=$this->users_model->GetCityState('company','company_name','company_id',$data[$i]['company_name']);



                          $data[$i]['menufecture_by']=$company_name[0]['company_name'];

                        }

                        if($data[$i]['form'])

                        {

                          $form_name=$this->users_model->GetCityState('form','Form','form_id',$data[$i]['form']);



                          $data[$i]['form']=$form_name[0]['Form'];

                        }

                        if($data[$i]['packing_type'])

                        {

                          $packingtype_name=$this->users_model->GetCityState('packing_type','packingtype_name','packing_type_id',$data[$i]['packing_type']);



                          $data[$i]['packing_detail']=$packingtype_name[0]['packingtype_name'];

                          unset($data[$i]['packing_type']);

                        }

                        if($data[$i]['pack_size'])

                        {

                          $pack_size_name=$this->users_model->GetCityState('packsize','Pack_size','pack_size_id',$data[$i]['pack_size']);



                          $data[$i]['pack_size']=$pack_size_name[0]['Pack_size'];

                        }

                        if($data[$i]['schedule'])

                        {

                          $pack_size_name=$this->users_model->GetCityState('schedule','schedule_name','schedule_id',$data[$i]['schedule']);



                          $data[$i]['schedule']=$pack_size_name[0]['schedule_name'];

                        }

                      }

                      $data[0]['composition']=$data[0]['drug_name'];

                      $data[0]['favourite_status']='';

                      if($data[0]['rate']!=''){

                        $data[0]['price']=$data[0]['rate'];

                      }else{

                        $data[0]['price']=$data[0]['mrp'];

                      }



                      $data[0]['used_for_treatment']='';

                      unset($data[0]['drug_name']);

                      unset($data[0]['company_name']);

                      unset($data[0]['form']);

                      unset($data[0]['pack_size']);

                      unset($data[0]['mrp']);

                      unset($data[0]['rate']);

                      unset($data[0]['schedule']);

                      unset( $data[0]['status']);

                      unset( $data[0]['add_date']);



                      $cities=$this->users_model->GetCityState('cities','name','id',$city_id);

                      $data[0]['city_name']=($cities[0]['name'])?$cities[0]['name']:'';





                      $data['product'] = $data[0];

                      unset($data[0]);

                    }else{

                      unset($data[0]);

                    }

                    $supplierNear=array();

                    if($offset > 0 ){

                      $offset=$offset*50;

                    }

                    $no_of_records=50;

                    //$where = array('city'=>$city_id,'status'=>1);

                    //$select='supplier_id, name as supplier_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal,shop_name';

            // $suppliers=$this->users_model->GetRecord($where,'supplier','','',$select,$offset, $no_of_records);

                    //$suppliers=$this->users_model->GetRecord($where,'supplier','','',$select);

                    $sql_s="SELECT supplier_id, name as supplier_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal,shop_name FROM `m16j_supplier` WHERE FIND_IN_SET ('".$company_id."', `company_deal`) AND city='$city_id' AND status ='1' LIMIT $offset, $no_of_records ";

                    $suppliers=$this->db->query($sql_s)->result_array();

                    if(count($suppliers) > 0 )

                    {

                      foreach($suppliers as $supplier) 

                      {

                        $company_name=explode(',', $supplier['company_deal']);

                        if(in_array($company_id, $company_name))

                        {



                          $supplier['supplier_address']= utf8_encode(html_entity_decode($supplier['supplier_address']));

                  /*if($supplier['state']){

                            $states=$this->users_model->GetCityState('states','name','id',$supplier['state']);

                            $supplier['state']=($states[0]['name'])?$states[0]['name']:'NA';

                          }*/

                          if($supplier['city_name']){

                            $cities=$this->users_model->GetCityState('cities','name','id',$supplier['city_name']);

                            $supplier['city_name']=($cities[0]['name'])?$cities[0]['name']:'NA';

                          }

                  /*if($supplier['company_deal']){

                           $company_names=$this->users_model->GetCityState('company','company_name','company_id','','',explode(',', $supplier['company_deal']));

                           $comp_name_arr=array();

                           foreach ($company_names as $C_value) {

                             $comp_name_arr[]=$C_value['company_name'];

                           }

                           $supplier['company_deal']=$comp_name_arr;

                         }*/

                         unset($supplier['company_deal']);

                         $supplierNear[]=$supplier;

                       }

                     }

                   }

                   else

                   {

              //$supplierNear[]="No Supplier In This Location";

                   }





                   $data['suppliers']=$supplierNear;



                 }



                /* if(count($supplierNear)>0 && count($data['suppliers']) >0)

                { */                

                 $message = array('error'=>'0','message'=>'success','data'=>$data);

                 $this->set_response($message, REST_Controller::HTTP_OK);

              /*   }else{

                   $message = array('error'=>'1','message'=>'No More Supplier Found');

                  $this->set_response($message, REST_Controller::HTTP_OK);

                }*/

              } 

              else

              {

                $error = array('error'=>'1','message'=>'Your session has been expired');

                $this->set_response($error, REST_Controller::HTTP_OK);

              }       

            } 

            else

            {

             // $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
                $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

              $this->set_response($error, REST_Controller::HTTP_OK);

            }







          }



        }

        /*======================== SEARCH PRODUCT WITH SUPPLIER ENDS ================*/



        /*======================== Get supplier details starts============================*/





        public function getSupplierDetail_post()

        {

          $blank_arr=array();

          $phone = $this->input->post('mobile_no');

          $supplier_id = $this->input->post('supplier_id');

          $user_id   =  $this->input->post('user_id');

          $device_type   =  $this->input->post('device_type');

          $device_token   =  $this->input->post('device_token');



          $data1=$_POST; 

          if(empty($phone)  || empty($device_type) || empty($user_id) || empty($supplier_id)|| empty($device_token))

          {

            $final_data = array('error'=>'1','message'=>'Please Provide all information');

            $this->set_response($final_data, REST_Controller::HTTP_OK);

          }

          else

          {

            $query_phone=$this->db->get_where('user',array("phone"=>$data1['mobile_no'] ,"status"=>'Active' ,"user_id"=>$data1['user_id']));



            $result = $query_phone->result_array();

            if(!empty($result))

            {   



              if($result[0]['device_token'] == $data1['device_token']) 

              {



                $supplierDetail=array();









                $where = array('supplier_id'=>$supplier_id,'status'=>1);

                $select='supplier_id, name as supplier_name, mobile_number as contact_number, shop_name, area, address, state, city, email, dln_no, tln_no, estd_no, contact_person as contact_person , contact_person_mobile, company_deal as company_dealership, authe_no_authe as authorised, status';

                $suppliers=$this->users_model->GetRecord($where,'supplier','','',$select);

          //$suppliers=$this->users_model->GetRecord($where,'supplier');

                if(count($suppliers) > 0 )

                {

                  foreach($suppliers as $supplier) 

                  {



                    $supplier['address']= utf8_encode(html_entity_decode($supplier['address']));



                    if($supplier['state'])

                    {

                      $states=$this->users_model->GetCityState('states','name','id',$supplier['state']);

                      $supplier['state']=($states[0]['name'])?$states[0]['name']:'NA';

                    }

                    if($supplier['city'])

                    {

                      $cities=$this->users_model->GetCityState('cities','name','id',$supplier['city']);

                      $supplier['city']=($cities[0]['name'])?$cities[0]['name']:'NA';

                    }

                    if($supplier['company_dealership'])

                    {

                      $company_names=$this->users_model->GetCityState('company','company_id,company_name','company_id','','',explode(',', $supplier['company_dealership']));

                      $comp_name_arr=array();

                      foreach ($company_names as $C_value) {

                        $comp_name_arr[]=array('company_id'=>$C_value['company_id'],'company_name'=>$C_value['company_name']);

                      }                



                      $supplier['company_dealership']=$comp_name_arr;



                    }

                    else{

                      $supplier['company_dealership']=array();

                    }



                    if($supplier['status']==1){

                      $supplier['status']='Active';

                    }else{

                      $supplier['status']='Inactive';



                    }

                    $supplier['favourite_status']='';



                    if($supplier['contact_person']!='')

                    {





                      $contact_person=explode(',', $supplier['contact_person']);

                      $contact_person_mo=explode(',', $supplier['contact_person_mobile']);



                      for ($i=0; $i <count($contact_person) ; $i++) 

                      { 

                        $con_both_arr[]=array('contact_name'=>$contact_person[$i],'contact_number'=>$contact_person_mo[$i]);





                      }

                      $supplier['contact_person']=$con_both_arr;

                //unset($supplier['contact_person']);

                      unset($supplier['contact_person_mobile']);



                    }

                    else

                    {

                      $supplier['contact_person']=array();

                //unset($supplier['contact_person']);

                      unset($supplier['contact_person_mobile']);

                    }







                  }

                  if(!empty($supplier))

                  {

                    $supplierDetail[]=$supplier;

                    $data['supplier']=$supplierDetail;

                  }

                  else{



                    $data['supplier'] = array();

                  }



                  $message = array('error'=>'0','message'=>'success','data'=>$data);

                  $this->set_response($message, REST_Controller::HTTP_OK);

                }

                else

                {  



                  $message = array('error'=>'1','message'=>'No record found. Please check Supplier Details');

                  $this->set_response($message, REST_Controller::HTTP_OK);

                }

              } 

              else

              {

                $error = array('error'=>'1','message'=>'Your session has been expired');

                $this->set_response($error, REST_Controller::HTTP_OK);

              }



            }

            else

            {

            //  $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');

                $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

              $this->set_response($error, REST_Controller::HTTP_OK);

            }







          }







        }









        /*======================== Get supplier details end ============================*/

        /*======================== Get terms condition starts ============================*/



        public function getTermsCondition_get()

        {



          $terms=$this->users_model->GetRecord('','terms_conditions');

          $message = array('error'=>'0','message'=>'success','data'=>$terms);

          $this->set_response($message, REST_Controller::HTTP_OK);

        }



        public function getAboutUs_get()

        {

          $about=$this->users_model->GetRecord('','about_us');
          $message = array('error'=>'0','message'=>'success','data'=>$about);
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
        public function privacy_policy_get()

        {

          $privacy_policy=$this->users_model->GetRecord('','privacy_policy');
          $message = array('error'=>'0','message'=>'success','data'=>($privacy_policy[0]['about_content']));
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
        

        /*======================== Get supplier details end ============================*/



        /*============================= CHANGE LICENCE AND TIN NUMBER STARTS ==============================*/



        public function changeLicenceAndTin_post()

        {

          $blank_arr=array();

          $phone = $this->input->post('mobile_no');

          $user_id   =  $this->input->post('user_id');

          $device_type   =  $this->input->post('device_type');

          $device_token   =  $this->input->post('device_token');

          $drug_licence_number   =  trim($this->input->post('drug_licence_number'));

          $tin_number   =  trim($this->input->post('tin_number'));

          $data=$_POST; 

          if(empty($phone)  || empty($device_token)  || empty($device_type) || empty($user_id))

          {

            $final_data = array('error'=>'1','message'=>'Please Provide all information');

            $this->set_response($final_data, REST_Controller::HTTP_OK);

          }

          else

          {

            $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"status"=>'Active' ,"user_id"=>$data['user_id']));



            $result = $query_phone->result_array();

            if(!empty($result))

            {



              if($result[0]['device_token'] == $data['device_token']) 

              {

                $tin_number=($tin_number)?$tin_number:" ";

                $drug_licence_number=($drug_licence_number)?$drug_licence_number:" ";

                $email=($result[0]['email'])?$result[0]['email']:"NA";

                $from_email=$result[0]['email'];

                $subject="Request for updating Drug License Number / GSTIN Number";

                $message="<div><p>Hello Admin,</p>

                <p> Please update my Drug License Number / GSTIN Number:</p>

                <p>Retailer Name: ".$result[0]['first_name']."</p>

                <p>Mobile Number: ".$result[0]['phone']."</p>

                <p>EmailID: ".$email."</p>

                <p>Shop Name: ".$result[0]['shop_name']."<p>

                <p>Drug License Number : ".$drug_licence_number." </p>

                <p>GSTIN Number:".$tin_number."<p></br>  

                Thanks<br>".$result[0]['first_name']."

                <br></div>";



                $sendRequest=$this->send_email('', $from_email, $subject, $message);







          /*$upd_arr=array('dl_no' => $drug_licence_number,'tin_no'=>$tin_number);



      $update=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');

      if(!empty($update))

      {

        $where = array('user_id'=>$user_id);

        $select='user_id,dl_no as drug_lic_number,tin_no as tin_number';

        $retailer=$this->users_model->GetRecord($where,'user','','',$select);

        $updat_detail['user_id']=$retailer[0]['user_id'];

        $updat_detail['drug_lic_number']=$retailer[0]['drug_lic_number'];

        $updat_detail['tin_number']=$retailer[0]['tin_number'];*/



        if($sendRequest==1){

          $message = array('error'=>'0','message'=>'Your request for change Drug License Number / Tin Number is sent successfully.');

          $this->set_response($message, REST_Controller::HTTP_OK);



        }

        else

        {

          $message = array('error'=>'1','message'=>'Your request has not been sent. Please Try Again');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }



      } 

      else

      {

        $error = array('error'=>'1','message'=>'Your session has been expired');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    }

    else

    {

    //  $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');

        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }







  }







}

/*============================= CHANGE LICENCE AND TIN NUMBER ENDS ==============================*//*============================= CHANGE Password STARTS ==============================*/



public function resetPassword_post()

{ 

  $blank_arr=array();

  $phone = $this->input->post('mobile_no');

    //$user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  trim($this->input->post('device_token'));

  $new_password   =  trim($this->input->post('new_password'));

  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($device_token)|| empty($new_password))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {  

      if($result[0]['device_token'] == $data['device_token']) 

      {





        foreach($result as $res)

        {

          $stored_salt = $res['salt'];

          $user_id=$res['user_id'];

          $pwd_without_encode=$res['pwd_without_encode'];



        }

          // if($result[0]['pwd_without_encode'] != $new_password)

          // {

        //$encrypted_pass= encode($new_password,$stored_salt);

        $encrypted_pass= md5($new_password.''.$stored_salt);

        $upd_arr=array('password' => $encrypted_pass,'pwd_without_encode'=>$new_password);



        $update=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');

        if(!empty($update))

        {





          $message = array('error'=>'0','message'=>'Password updated successfully');

          $this->set_response($message, REST_Controller::HTTP_OK);



        }

        else

        {

          $message = array('error'=>'1','message'=>'Password has not been Updated. Please Try Again');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }

          // }else{

          //   $message = array('error'=>'1','message'=>'New password must not same as old password');

          //   $this->set_response($message, REST_Controller::HTTP_OK);

          // }



      } 

      else

      {

        $error = array('error'=>'1','message'=>'Your session has been expired');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    }

    else

    {

     // $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');

        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }







  }







}

/*============================= CHANGE Password ENDS ==============================*/



/*============================= User logout STARTS ==============================*/



public function userLogout_post()

{

  $blank_arr=array();

  $phone = $this->input->post('mobile_no');

  $user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');



  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($user_id))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"user_id"=>$data['user_id']));



    $result = $query_phone->result_array();

    if(!empty($result))

    {  



      $upd_arr = array('login_status' =>'0');

      $login_status=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');



      $message = array('error'=>'0','message'=>'Logout ');

      $this->set_response($message, REST_Controller::HTTP_OK);

    } 

    else

    {

      $error = array('error'=>'1','message'=>'Invalid User Detail');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }







  }







}



/*============================= User logout ENDS ==============================*/







/*============================= Edit retailer profile starts ==============================*/



public function editRetailerProfile_post()

{

  $blank_arr=array();

  $otp_token='';

  $phone = $this->input->post('mobile_no');

  $user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  $this->input->post('device_token');

  $device_token   =  $this->input->post('device_token');

  $full_name   =  $this->input->post('full_name');

  $shop_name   =  $this->input->post('shop_name');

  $estd_year   =  $this->input->post('estd_year');

  $dl_no   =  $this->input->post('dl_no');

  $tin_no   =  $this->input->post('tin_no');



  $contact_name_1   =  $this->input->post('contact_name_1');  

  $contact_number_1   =  $this->input->post('contact_number_1');



  $contact_name_2   =  $this->input->post('contact_name_2');  

  $contact_number_2   =  $this->input->post('contact_number_2');



  $contact_name_3   =  $this->input->post('contact_name_3');  

  $contact_number_3   =  $this->input->post('contact_number_3');



  $contact_name_4   =  $this->input->post('contact_name_4');  

  $contact_number_4  =  $this->input->post('contact_number_4');



  $contact_name_5   =  $this->input->post('contact_name_5');  

  $contact_number_5   =  $this->input->post('contact_number_5');



  $email   =  $this->input->post('email');

  $area   =  $this->input->post('area');

  $address   =  $this->input->post('address');

  $state_id   =  $this->input->post('state_id');

  $city_id   =  $this->input->post('city_id');



  $data1=$_POST; 

    //empty($estd_year)  || empty($dl_no) || empty($tin_no) ||

  if(empty($phone)  || empty($device_token)  || empty($device_type) || empty($user_id) || empty($device_token)  || empty($full_name) || empty($shop_name) ||   empty($area) || empty($address) || empty($state_id)  || empty($city_id) )

  { 

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {







    $query_phone=$this->db->get_where('user',array("user_id"=>$data1['user_id'],'status'=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    { 



      if($result[0]['device_token'] == $data1['device_token']) 

      {

          //check user email already exist or not

        $whereNotIn=array($user_id);

        if(!empty($email)){

          $where = array('email'=>$email);

          $CheckeEmail = $this->users_model->GetRecord($where,'user','user_id',$whereNotIn);



        }

        $where_mo = array('phone'=>$phone);

        $CheckeMobile = $this->users_model->GetRecord($where_mo,'user','user_id',$whereNotIn);

        if(!empty($CheckeEmail))

        {

          $final_data = array('error'=>'1','message'=>'User with this Email Id Already Exists');

          $this->set_response($final_data, REST_Controller::HTTP_OK);

        } 

        else if(!empty($CheckeMobile))

        {

          $final_data = array('error'=>'1','message'=>'User with this Mobile Number Already Exists');

          $this->set_response($final_data, REST_Controller::HTTP_OK);

        }

        else{

          $time=date("Y-m-d h:i:s");



          $contact_person='';

          $contact_person_number='';

          if($contact_name_1!='' && $contact_number_1!='')

          {

            $contact_person.=$contact_name_1.',';

            $contact_person_number .=$contact_number_1.',';

          }

          if($contact_name_2!='' && $contact_number_2!='')

          {

            $contact_person.=$contact_name_2.',';

            $contact_person_number .=$contact_number_2.',';

          }

          if($contact_name_3!='' && $contact_number_3!='')

          {

            $contact_person.=$contact_name_3.',';

            $contact_person_number .=$contact_number_3.',';

          }

          if($contact_name_4!='' && $contact_number_4!='')

          {

            $contact_person.=$contact_name_4.',';

            $contact_person_number .=$contact_number_4.',';

          }

          if($contact_name_5!='' && $contact_number_5!='')

          {

            $contact_person.=$contact_name_5.',';

            $contact_person_number .=$contact_number_5.',';

          }





          $contact_person=rtrim($contact_person, ',');

          $contact_person_number=rtrim($contact_person_number ,',');













          $upd_arr = array(

            'first_name'   => $full_name,

            'shop_name'    => $shop_name,

            'email'        => $email,

            'phone'        => $phone,

            'landmark'     => $area,

            'address'      => $address,

            'state'        => $state_id,

            'city'         => $city_id,

            'device_type'  => $device_type,

            'device_token' => $device_token,

            'estd_year'    =>$estd_year,

            'dl_no'        =>$dl_no,

            'tin_no'       =>$tin_no,

            'contact_person' =>$contact_person,

            'contact_person_number'=>$contact_person_number,

            'update_date'    => $time

          );

          if($result[0]['phone']!=$phone)

          {

              //$otp_token=mt_rand(100000,999999);

            $otp_token=$rand_letter = $this->randNumber();

            $sms_rturn= $this->sendOtpSms($rand_letter,$phone);

            $success_device_msg="go to otp";

            $upd_arr['otp_varified']='0';

            $upd_arr['otp']=$otp_token;

          }





          $update=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');







          if(!empty($update))

          {

            $where = array('user_id'=>$user_id);

            $select='first_name as full_name,email,phone as contact_number,address,landmark as area,state,city,dl_no as drug_lic_number,estd_year,tin_no as tin_number ,contact_person,contact_person_number';

            $retailer=$this->users_model->GetRecord($where,'user','','',$select);





            if(count($retailer) > 0 )

            {

              foreach($retailer as $retailer_val) 

              {



                $retailer_val['address']= utf8_encode(html_entity_decode($retailer_val['address']));



                if($retailer_val['state'])

                {

                  $states=$this->users_model->GetCityState('states','name','id',$retailer_val['state']);

                  $retailer_val['state']=($states[0]['name'])?$states[0]['name']:'NA';

                }

                if($retailer_val['city'])

                {

                  $cities=$this->users_model->GetCityState('cities','name','id',$retailer_val['city']);

                  $retailer_val['city']=($cities[0]['name'])?$cities[0]['name']:'NA';

                }

                  /* if($supplier['company_deal'])

      {

       $company_names=$this->users_model->GetCityState('company','company_name','company_id','','',explode(',', $supplier['company_deal']));

       $comp_name_arr=array();

       foreach ($company_names as $C_value) {

         $comp_name_arr[]=$C_value['company_name'];

       }

       $supplier['company_deal']=$comp_name_arr;

     }*/



     if($retailer_val['contact_person']!='')

     {





      $contact_person=explode(',', $retailer_val['contact_person']);

      $contact_person_mo=explode(',', $retailer_val['contact_person_number']);

      $j=1;

      for ($i=0; $i <count($contact_person) ; $i++) 

      { 

        $con_both_arr[]=array('contact_name'=>$contact_person[$i],'contact_number'=>$contact_person_mo[$i]);

        $j++;



      }

      $retailer_val['contact_person']=$con_both_arr;

                    //unset($supplier['contact_person']);

      unset($retailer_val['contact_person_number']);



    }

    else

    {

      $retailer_val['contact_person']=array();

                    //unset($supplier['contact_person']);

      unset($retailer_val['contact_person_number']);

    }











  }

  if($otp_token=='')

  {

    $message = array('error'=>'0','message'=>'success','data'=>$retailer_val);

    $this->set_response($message, REST_Controller::HTTP_OK);

  }

  else

  {

    $message = array('error'=>'1','message'=>'go to otp','data' =>array('OTP'=>$otp_token ));

    $this->set_response($message, REST_Controller::HTTP_OK);

  }





} 

}

else

{

  $message = array('error'=>'1','message'=>'Your Profile Detail has not been Updated. Please Try Again');

  $this->set_response($message, REST_Controller::HTTP_OK);

}



}

} 

else

{

  $error = array('error'=>'1','message'=>'Your session has been expired');

  $this->set_response($error, REST_Controller::HTTP_OK);

}

}

else

{

//  $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
    $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

  $this->set_response($error, REST_Controller::HTTP_OK);

}



}



}

/*============================= Edit retailer profile ENDS ==============================*/





/*GET PROFILE DATA STARTS */



public function retailerProfileDetail_post()

{

  $blank_arr=array();

  $phone = $this->input->post('mobile_no');

  $user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  $this->input->post('device_token');

  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($user_id) || empty($device_token))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"user_id"=>$data['user_id'],"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['device_token'] == $data['device_token']) 

      {



        $retailerDetail=array();

        $where = array('user_id'=>$user_id);

        $select='user_id,first_name as retailer_name,email,phone as contact_number,address,landmark as area,state,city,shop_name,status,dl_no as drug_lic_no,estd_year,tin_no as tin_number,contact_person,contact_person_number';

        $retailer=$this->users_model->GetRecord($where,'user','','',$select);

        if(count($retailer) > 0 )

        {

          foreach($retailer as $retailer_val) 

          {



            $retailer_val['address']= utf8_encode(html_entity_decode($retailer_val['address']));



            if($retailer_val['state'])

            {

              $retailer_val['state_id']=$retailer_val['state'];

              $states=$this->users_model->GetCityState('states','name','id',$retailer_val['state']);

              $retailer_val['state']=($states[0]['name'])?$states[0]['name']:'NA';

            }

            if($retailer_val['city'])

            {

              $retailer_val['city_id']=$retailer_val['city'];

              $cities=$this->users_model->GetCityState('cities','name','id',$retailer_val['city']);

              $retailer_val['city']=($cities[0]['name'])?$cities[0]['name']:'NA';

            }

              /* if($supplier['company_deal'])

      {

       $company_names=$this->users_model->GetCityState('company','company_name','company_id','','',explode(',', $supplier['company_deal']));

       $comp_name_arr=array();

       foreach ($company_names as $C_value) {

         $comp_name_arr[]=$C_value['company_name'];

       }

       $supplier['company_deal']=$comp_name_arr;

     }*/



     if($retailer_val['contact_person']!='')

     {





      $contact_person=explode(',', $retailer_val['contact_person']);

      $contact_person_mo=explode(',', $retailer_val['contact_person_number']);

      $j=1;

      for ($i=0; $i <count($contact_person) ; $i++) 

      { 

        $con_both_arr[]=array('contact_name'=>$contact_person[$i],'contact_number'=>$contact_person_mo[$i]);

        $j++;



      }

      $retailer_val['contact_person']=$con_both_arr;

                //unset($supplier['contact_person']);

      unset($retailer_val['contact_person_number']);



    }

    else

    {

      $retailer_val['contact_person']=array();

                //unset($supplier['contact_person']);

      unset($retailer_val['contact_person_number']);

    }



              // $retailerDetail[]=$retailer_val;



  }



            //$data_arr['retailer']=$retailerDetail;



  $message = array('error'=>'0','message'=>'success','data'=>$retailer_val);

  $this->set_response($message, REST_Controller::HTTP_OK);

}

else

{

  $error = array('error'=>'1','message'=>'Invalid User Details');

  $this->set_response($error, REST_Controller::HTTP_OK);

}







} 

else

{

  $error = array('error'=>'1','message'=>'Your session has been expired');

  $this->set_response($error, REST_Controller::HTTP_OK);

}

}

else

{

  //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
    $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

  $this->set_response($error, REST_Controller::HTTP_OK);

}

}



}

/*GET PROFILE DATA ENDS*/



/*================ Request Not Found Data Starts =========================*/

public function notFoundRequest_post()

{

  $this->load->library('email');

  $this->load->helper('path');

  $base_url="../uploads/notfoundfile";

  $phone = $this->input->post('mobile_no');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  $this->input->post('device_token');

  $product_name   =  trim($this->input->post('product_name'));

  $description   =  trim($this->input->post('description'));

  $request_type   =  trim($this->input->post('request_type'));

  $cityname= trim($this->input->post('city'));

  $file_name   =  $_FILES['file_name']['name'];
  $issue   =  $this->input->post('issue');
  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($device_token) || empty($issue) || empty($description)|| empty($product_name))
  {
    $final_data = array('error'=>'1','message'=>'Please Provide all information');
    $this->set_response($final_data, REST_Controller::HTTP_OK);
  }
  else
  { 

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'],"status"=>'Active'));
    $result = $query_phone->result_array();

    if(!empty($result))
    {

      if($result[0]['device_token'] == $data['device_token']) 
      {
          //------Upload not found file pic--------
        $data_pic='';
        $fileName='';

        $file_name=$_FILES['file_name']['name'];

        if($file_name){

          $ext = pathinfo($file_name, PATHINFO_EXTENSION);  

          $fileName=uniqid().time().'.'.$ext;     
        }

        $config['upload_path'] = $base_url;

        $config['allowed_types'] = '*';

        $config['max_size'] = '10240';

        $config['create_thumb'] = TRUE;

        $config['encrypt_name']  = false;

        $config['file_name']  = $fileName;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_name'))
        {
          $error = array('error' => $this->upload->display_errors()); 
            //print_r($error);die;
        }
        else
        {
          $data_pic = array('upload_data' => $this->upload->data());
        }

        $full_path='';
        if($data_pic){
          $image_url =$data_pic['upload_data']['file_name'];
          $full_path= $data_pic['upload_data']['full_path'];
        }
        else{
          $image_url ="0";
        }

        //end not found file

        $user_id=$result[0]['user_id'];

        $req_arr=array(
          'retailer_id'=>$user_id,
          'file_name'=>$fileName,
          'issue'=>$issue,
          'issue_description'=>$description,
          'search_keyword'=>$product_name
        );
        $insert_id = $this->users_model->InsertData('not_found_request',$req_arr);
        if($insert_id)
        {
          $from_email=$result[0]['email'];
            //$from_email="rahulnakum.syscraft@gmail.com";
          if($request_type=='1'){
            $subject="PNFR ".$result[0]['phone']." ".$result[0]['shop_name']." From ".$cityname;
            $message="<div><p>Hello Admin,</p>

            <p> Please upload the requested Medicine/Product on the App.</p>

            <p> Medicine Name: ".$product_name."</p>

            <p>Description: ".$description." </p><br>  

            Thanks<br>".$result[0]['first_name']."

            <br></div>";

            $this->send_email('', $from_email, $subject, $message,$fileName);
          }
          else if($request_type=='2')
          {
            $subject="CNFR ".$result[0]['phone']." ".$result[0]['shop_name']." From ".$cityname;

            $message="<div><p>Hello Admin,</p>

            <p> Please provide the details of requested Company on the App.</p>

            <p> Company Name: ".$product_name."</p>

            <p>Description: ".$description." </p><br>  

            Thanks<br>".$result[0]['first_name']."

            <br></div>";



            $this->send_email('', $from_email, $subject, $message,$fileName);

          }

          $message = array('error'=>'0','message'=>'Your request has been sent successfully');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }else{

          $message = array('error'=>'1','message'=>'Your request has not been sent');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }

      }else{

        $error = array('error'=>'1','message'=>'Your session has been expired');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }

    }
    else
    {

     // $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }

  }

}





public function send_email($to_email, $from_email, $subject, $message,$fileName) {     

  $this->load->library('email');

  $this->load->helper('path');

  $config['protocol']='sendmail';

  $config['wordwrap'] = TRUE;

  $config['mailtype'] = 'html';

  $config['priority'] = '1';

  $config['charset'] = 'utf-8';

  $config['crlf']      = "\r\n";

  $config['newline']      = "\r\n";

  $this->email->initialize($config);

  $to_email='notify.listapp@gmail.com';

  $from_email='notify@listapp.in';



    /*$this->email->set_header('MIME-Version', '1.0; charset=utf-8');

    $this->email->set_header('Content-type', 'text/html');*/



    // $this->email->set_header('MIME-Version', '1.0; charset=iso-8859-1');

    // $this->email->set_header('Content-type', 'text/html');



    $this->email->from($from_email, 'ListApp'); 

    $this->email->to($to_email);

   // $this->email->cc('rahulnakum.syscraft@gmail.com');



    $this->email->subject($subject); 

    $this->email->message($message); 

    if($fileName){

      $attechment=set_realpath('../uploads/notfoundfile/').$fileName;

      $this->email->attach($attechment);

      if(file_exists($attechment)){

        unlink($attechment);

      }

    }

    return $this->email->send(); 





  }

  /*================ Request Not Found Data ends =========================*/





  /*===========GET searchProduct starts===========*/





  public function searchProduct_test_post()

  { 

    $blank_arr=array();

    $phone = $this->input->post('mobile_no');

    $product_name = $this->input->post('product_name');

    $user_id   =  $this->input->post('user_id');

    $device_type   =  $this->input->post('device_type');

    $city_id   =  ($this->input->post('city_id'))?$this->input->post('city_id'):'2229';

    $offset   =  $this->input->post('offset');



    $data=$_POST; 

    if(empty($phone)  ||(empty($offset) && $offset!=0) ||empty($city_id) || empty($device_type) || empty($user_id) || empty($product_name))

    {

      $final_data = array('error'=>'1','message'=>'Please Provide all information');

      $this->set_response($final_data, REST_Controller::HTTP_OK);

    }

    else

    {

      $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"user_id"=>$data['user_id']));



      $result = $query_phone->result_array();

      if(!empty($result))

      { 

        if($offset > 0){

          $offset=$offset*50;

        }

        $no_of_records=50;

        $like=array('product_name'=>$product_name);

        $data2=$this->users_model->viewProduct($like=array(), $pId='',$offset='',$no_of_records='');

        //$query=$this->db->last_query();

        if(empty($data2)){

          $message = array('error'=>'1','message'=>'No matching records found');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }else

        {



          $message = array('error'=>'0','message'=>'success','data'=>$data2);

          $this->set_response($message, REST_Controller::HTTP_OK);

        }

      } 

      else

      {

        $error = array('error'=>'1','message'=>'Invalid User');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    }



  }



  /*========GET searchProduct ends=================*/



  /*======= Get Company Details Starts =====================*/

  public function companyDetail_post()

  { 



    $user_id   =  $this->input->post('user_id');

    $phone = $this->input->post('mobile_no');

    $device_type   =  $this->input->post('device_type');

    $device_token   =  $this->input->post('device_token');

    $company_id   =  $this->input->post('company_id');

    $offset   =  $this->input->post('offset');

    $city   =  $this->input->post('city');



    $data=$_POST; 

    if(empty($company_id) ||empty($phone)|| empty($device_token) || empty($user_id) || empty($device_type))

    {

      $final_data = array('error'=>'1','message'=>'Please Provide all information');

      $this->set_response($final_data, REST_Controller::HTTP_OK);

    }

    else

    {

      $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"user_id"=>$data['user_id'],"status"=>'Active'));



      $result = $query_phone->result_array();

      if(!empty($result))

      { 

        if($result[0]['device_token'] == $data['device_token']) 

        {

          if($offset==0)

          {

            $where_company=array('company_id'=>$company_id,'status'=>1);

            $data1['company_detail']=$this->users_model->GetRecord($where_company,'company');

          }

          if($offset > 0){

            $offset=$offset*50;

          }

          $no_of_records=50;

          $like=array('status'=>1,'city'=>$city); 

          $select='supplier_id, name as supplier_name,shop_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal';      

          // $suppliers=$this->users_model->searchWithLike('supplier',$select,$like,$offset,$no_of_records);

          $suppliers=$this->users_model->searchWithLike('supplier',$select,$like);

          if(empty($suppliers))

          {

            $message = array('error'=>'1','message'=>'No matching records found');

            $this->set_response($message, REST_Controller::HTTP_OK);

          }

          else

          {

            $supplierNear=array();

            foreach($suppliers as $supplier) 

            {

              $company_name=explode(',', $supplier['company_deal']);

              if(in_array($company_id, $company_name))

              {



                $supplier['address']= utf8_encode(html_entity_decode($supplier['address']));

                /*if($supplier['state']){

            $states=$this->users_model->GetCityState('states','name','id',$supplier['state']);

            $supplier['state']=($states[0]['name'])?$states[0]['name']:'NA';

          }*/

          if($supplier['city_name']){

            $cities=$this->users_model->GetCityState('cities','name','id',$supplier['city_name']);

            $supplier['city_name']=($cities[0]['name'])?$cities[0]['name']:'NA';

          }

                /*if($supplier['company_deal']){

           $company_names=$this->users_model->GetCityState('company','company_name','company_id','','',explode(',', $supplier['company_deal']));

           $comp_name_arr=array();

           foreach ($company_names as $C_value) {

             $comp_name_arr[]=$C_value['company_name'];

           }

           $supplier['company_deal']=$comp_name_arr;

         }*/

         unset($supplier['company_deal']);

         $supplierNear[]=$supplier;

       }

     }

     if(!empty($supplierNear)) {

      $data1['suppliers']=$supplierNear;

    }

    else{

      $data1['suppliers']=array();

    }    

    $message = array('error'=>'0','message'=>'success','data'=>$data1);

    $this->set_response($message, REST_Controller::HTTP_OK);

  }   

} 

else

{

  $error = array('error'=>'1','message'=>'Your session has been expired');

  $this->set_response($error, REST_Controller::HTTP_OK);

}

}

else

{

  //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
    $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

  $this->set_response($error, REST_Controller::HTTP_OK);

}

}

}

/*======= Get Company Details Ends =====================*/



/*================ Request Not Found Data Starts =========================*/

public function notFoundSupplier_post()

{

  $this->load->library('email');

  $this->load->helper('path');

  $base_url="../uploads/notfoundfile";





  $phone = $this->input->post('mobile_no');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  $this->input->post('device_token');

  $keyword   =  trim($this->input->post('keyword'));

    //$name   =  trim($this->input->post('name'));

  $description   =  trim($this->input->post('description'));

  $cityname   =  trim($this->input->post('city'));

  $file_name   =  $_FILES['file_name']['name'];

  $issue   =  $this->input->post('issue');

  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($device_token) || empty($keyword) || empty($issue) || empty($description))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  { 

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'],"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['device_token'] == $data['device_token']) 

      {



          //------Upload not found file pic--------

        $data_pic='';

        $fileName='';

        $file_name=$_FILES['file_name']['name'];

        if($file_name){

          $ext = pathinfo($file_name, PATHINFO_EXTENSION);  

          $fileName=uniqid().time().'.'.$ext;     



        }

        $config['upload_path'] = $base_url;

        $config['allowed_types'] = '*';

        $config['max_size'] = '10240';

        $config['create_thumb'] = TRUE;

        $config['encrypt_name']  = false;

        $config['file_name']  = $fileName;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_name'))

        {

          $error = array('error' => $this->upload->display_errors()); 

            //print_r($error);die;

        }

        else

        {

          $data_pic = array('upload_data' => $this->upload->data());



        }



        $full_path='';

        if($data_pic){

          $image_url =$data_pic['upload_data']['file_name'];

          $full_path= $data_pic['upload_data']['full_path'];



        }

        else{

          $image_url ="0";

        }



          //end not found file







        $user_id=$result[0]['user_id'];

        $req_arr=array(

          'retailer_id'=>$user_id,

          'file_name'=>$fileName,

          'issue'=>$issue,

          'issue_description'=>$description,

          'search_keyword'=>$keyword

        );







        $insert_id = $this->users_model->InsertData('not_found_request',$req_arr);

        if($insert_id)

        {

          $from_email=$result[0]['email'];

            //$from_email="rahulnakum.syscraft@gmail.com";



          $subject="SNFR ".$result[0]['phone']." ".$result[0]['shop_name']." From ".$cityname;

          $message="<div><p>Hello Admin,</p>

          <p> Please provide the details of requested supplier in App for ".$keyword."</p>    

          <p>Description: ".$description." </p><br>  

          Thanks<br>".$result[0]['first_name']."

          <br></div>";





          $this->send_email('', $from_email, $subject, $message,$fileName);



          $message = array('error'=>'0','message'=>'Your request has been sent successfully');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }else{

          $message = array('error'=>'1','message'=>'Your request has not been sent');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }



      }else{

        $error = array('error'=>'1','message'=>'Your session has been expired');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    }

    else

    {

     // $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }



  }

}



/*======== CODE FOR CHANGE MOBILE NUMBER STARTS ==========================*/

public function SendOtpForNew_post()

{

  $blank_arr=array();

  $phone=$this->input->post('mobile_no');

  $device_type = $this->input->post('device_type');

  $device_token = $this->input->post('device_token');

  $new_mobile_no = $this->input->post('new_mobile_no');

  $user_id = $this->input->post('user_id');

  $data1=$_POST; 

  if(empty($phone) || empty($device_type) || empty($device_token)|| empty($user_id)|| empty($new_mobile_no))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data1['mobile_no'],"user_id"=>$data1['user_id'],"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['device_token'] == $data1['device_token']) 

      {

        $whereNotIn=array($user_id);

        $where2 = array('phone'=>$new_mobile_no);

        $mobile_number_exist = $this->users_model->GetRecord($where2,'user','user_id',$whereNotIn);



        if(empty($mobile_number_exist))

        {





          $user_id=$result[0]['user_id'];

            //$otp=mt_rand(100000,999999);

          $otp=$rand_letter = $this->randNumber();

          $sms_rturn= $this->sendOtpSms($rand_letter,$new_mobile_no);

          $arr=array(

            'new_mo_otp'=>$otp,

            'new_otp_varified'=>'0',

            'new_mobile_no'=>$new_mobile_no,

          );



          $data_1=$this->users_model->updateOTP('user',$user_id,$arr);

          $OTP['OTP']=$otp;

          $message = array('error'=>'0','message'=>'OTP has been sent on Your Mobile','data'=>$OTP);

          $this->set_response($message, REST_Controller::HTTP_OK);

        }

        else

        {

          $final_data = array('error'=>'1','message'=>'User with this Mobile Number Already Exists');

          $this->set_response($final_data, REST_Controller::HTTP_OK);

        }  

      }

      else

      {

        $error = array('error'=>'1','message'=>'Your session has been expired');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }

    }

    else

    {

     // $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }



  }



}



/*Check OTP VALIDATE*/



public function otpVerifyNew_post()

{



  $new_mobile_no = $this->input->post('new_mobile_no');

  $phone = $this->input->post('mobile_no');

  $new_otp   =  $this->input->post('new_otp');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  $this->input->post('device_token');

  $user_id   =  $this->input->post('user_id');





  $data=$_POST; 

  if(empty($new_mobile_no) || empty($new_otp) || empty($device_type) || empty($device_token))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'],'user_id'=>$user_id,'status'=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {

      if($result[0]['device_token'] ==$data['device_token']) 

      {



        if($result[0]['new_mo_otp'] == $data['new_otp']) 

        {



          $user_id=$result[0]['user_id'];



          $upd_arr=array('new_mo_otp'=> $new_mo_otp,'new_otp_varified'=>1,'phone'=>$new_mobile_no);

          $update=$this->users_model->update_entry($upd_arr,'user', $user_id,'user_id');

          if(!empty($update)){

            $message = array('error'=>'0','message'=>'Your Mobile number has been Updated successfully','data'=>array('user_id'=>$user_id));

            $this->set_response($message, REST_Controller::HTTP_OK);

          }else{

            $message = array('error'=>'1','message'=>'Your Mobile number has not been Updated. Please Try Again');

            $this->set_response($message, REST_Controller::HTTP_OK);

          }

        }

        else

        {

          $error = array('error'=>'1','message'=>'Invalid OTP');

          $this->set_response($error, REST_Controller::HTTP_OK);

        }    

      }

      else

      {

        $error = array('error'=>'1','message'=>'Your session has been expired');

        $this->set_response($error, REST_Controller::HTTP_OK);

      } 



    } 

    else

    {

    //  $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');

        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }

  }

}

/*Check OTP VALIDATE ends */

/*======== CODE FOR CHANGE MOBILE NUMBER Ends ==========================*/

/*======== CODE FOR NOTIFICATION STARTS ==========================*/

public function getNotification_post()

{ 

  $blank_arr=array();

  $phone = $this->input->post('mobile_no');

  $user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  trim($this->input->post('device_token'));



  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($device_token)|| empty($user_id))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {  

      if($result[0]['device_token'] == $data['device_token']) 

      {





        $notifications= $notifications=$this->users_model->GetRecord_order('notifications',array("notification_user_id"=>$user_id),'notification_date','DESC','');



          //$noti_result = $notifications->result_array();

        $post_arr=array();

        foreach ($notifications as $noti_value) 

        {  

          $post_arr[]=array('notification_id'=>$noti_value['notification_id'],'type'=>$noti_value['notification_type'],'title'=>$noti_value['notification_title'],'meassage'=>$noti_value['notification_message'],'read'=>$noti_value['is_read'],'date'=>date('d-m-Y', strtotime($noti_value['notification_date'])),'time'=> date('h:i A', strtotime($noti_value['notification_date'])),'current_date'=>date('d-m-Y'));

        }



        if(!empty($post_arr))

        {



          $upd_arr=array('is_read'=> 1);

          $update=$this->users_model->update_entry($upd_arr,'notifications', $user_id,'notification_user_id');

          $message = array('error'=>'0','message'=>'scuccess','data'=>$post_arr);

          $this->set_response($message, REST_Controller::HTTP_OK);



        }

        else

        {

          $message = array('error'=>'1','message'=>'No notifications for this user');

          $this->set_response($message, REST_Controller::HTTP_OK);

        }

          // }else{

          //   $message = array('error'=>'1','message'=>'New password must not same as old password');

          //   $this->set_response($message, REST_Controller::HTTP_OK);

          // }



      } 

      else

      {

        $error = array('error'=>'1','message'=>'Your session has been expired');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }



    }

    else

    {

      //$error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
        $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

      $this->set_response($error, REST_Controller::HTTP_OK);

    }







  }







}

/*======== CODE FOR FOR NOTIFICATION Ends ==========================*/



public function readNotification_post()

{ 

  $blank_arr=array();

  $phone = $this->input->post('mobile_no');

  $user_id   =  $this->input->post('user_id');

  $device_type   =  $this->input->post('device_type');

  $device_token   =  trim($this->input->post('device_token'));



  $notification_id = $this->input->post('notification_id');



  $notification_type = $this->input->post('notification_type');



  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($device_token)|| empty($user_id) || empty($notification_id) || empty($notification_type))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {  



      if($result[0]['device_token'] == $data['device_token']) 

      {









        $update_data = array('is_read'=>1);



          $where = array('notification_id'=>$notification_id,'notification_user_id'=>$user_id,'notification_type'=>$notification_type);//'notification_id'=>$notification_id,

          $this->common_model->update_entry('notifications',$update_data,$where);



          $final_data = array('error'=>'0','message'=>'success','is_read'=>'1');

          $this->set_response($final_data, REST_Controller::HTTP_OK);



        }



        else

        {

          $error = array('error'=>'1','message'=>'Your session has been expired');

          $this->set_response($error, REST_Controller::HTTP_OK);

        }



      }

      else

      {

      //  $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
          $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }







    }







  }

       public function getSupplierCities_get()

        {



          $about=$this->users_model->getUniqueCities();

          $message = array('error'=>'0','message'=>'success','data'=>$about);

          $this->set_response($message, REST_Controller::HTTP_OK);



        }

         public function getCity_get()

        {

          $city=$this->input->get('city');

          $about=$this->users_model->getCityId($city);

          $message = array('error'=>'0','message'=>'success','data'=>$about);

          $this->set_response($message, REST_Controller::HTTP_OK);

            

        }

        public function getSupplierId_get()

        {

          $city=$this->input->get('city');

          $about=$this->users_model->getSupplierId($city);

          $message = array('error'=>'0','message'=>'success','data'=>$about);

          $this->set_response($message, REST_Controller::HTTP_OK);

            

        }

        

        public function getState_get()

        {

          $state=$this->input->get('state');

          $about=$this->users_model->getStateId($state);

          $message = array('error'=>'0','message'=>'success','data'=>$about);

          $this->set_response($message, REST_Controller::HTTP_OK);

            

        }

        public function getCityById_get()

        {

          $city=$this->input->get('city');

          $about=$this->users_model->getCityname($city);

          $message = array('error'=>'0','message'=>'success','data'=>$about);

          $this->set_response($message, REST_Controller::HTTP_OK);

            

        }

        

        public function postNotification_post()

    { 

    $blank_arr=array();

    $phone = $this->input->post('mobile_no');

    $user_id   =  $this->input->post('user_id');

    $device_type   =  $this->input->post('device_type');

    $device_token   =  trim($this->input->post('device_token'));

    $notification_id = $this->input->post('notification_id');

    $notification_type = $this->input->post('type');

    $notification_title =$this->input->post('title');

    $msg   =  $this->input->post('msg');

  $data=$_POST; 

  if(empty($phone)  || empty($device_type) || empty($device_token)|| empty($user_id) || empty($notification_id) || empty($notification_type))

  {

    $final_data = array('error'=>'1','message'=>'Please Provide all information');

    $this->set_response($final_data, REST_Controller::HTTP_OK);

  }

  else

  {

    $query_phone=$this->db->get_where('user',array("phone"=>$data['mobile_no'] ,"status"=>'Active'));



    $result = $query_phone->result_array();

    if(!empty($result))

    {  



      if($result[0]['device_token'] == $data['device_token']) 

      {

        $not_data['notification_id']=$notification_id;

        $not_data['notification_user_id']=$user_id;

        $not_data['notification_type']=$notification_type;

        $not_data['notification_date']=date('Y-m-d H:i:s');

        $not_data['notification_message']=$msg;

        $not_data['device_type']=$device_type;

        $not_data['device_token']=$device_token;

        $not_data['notification_title']=$notification_title;

        $not_data['is_read']="1";

        

        

        $entryid= $this->common_model->insert_entry('notifications',$not_data);

          $this->set_response($entryid, REST_Controller::HTTP_OK);

        }



        else

        {

          $error = array('error'=>'1','message'=>'Your session has been expired');

          $this->set_response($error, REST_Controller::HTTP_OK);

        }



      }

      else

      {

      //  $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9993671716.');
          $error = array('error'=>'1','message'=>'Your ListApp a/c is inactive.<br> Recharge Now - <a href="https://bit.ly/Li-Sub">https://bit.ly/Li-Sub</a> <br> Helpline - 9993671716');

        $this->set_response($error, REST_Controller::HTTP_OK);

      }







    }







  }

        public function getstates_get()

        {

          $about=$this->users_model->getStates();

          $message = array('error'=>'0','message'=>'success','data'=>$about);

          $this->set_response($message, REST_Controller::HTTP_OK);

        }

        public function getCityByState_get()

        {

          $statename=$this->input->get('state');

          $about=$this->users_model->getStateCities($statename);

          $message = array('error'=>'0','message'=>'success','data'=>$about);

          $this->set_response($message, REST_Controller::HTTP_OK);

        }

        public function createOrderList_post(){

            $productname=$this->input->post('product');

            $suppliername=$this->input->post('supplier');

            $quantity=$this->input->post('quantity');

            $scheme=$this->input->post('scheme');

            $user_id=$this->input->post('user');

            $contact=$this->input->post('contact');

            $isordered=$this->input->post('isordered');

             

             $where_product=array('product'=>$productname,'user'=>$user_id);

             $ins_arr=array('product'=>$productname,'supplier'=>$suppliername,'quantity'=>$quantity,'user'=>$user_id,'scheme'=>$scheme,'contact'=>$contact,'isordered'=>$isordered);

            $upd_arr=array('supplier'=>$suppliername,'quantity'=>$quantity,'scheme'=>$scheme,'contact'=>$contact,'isordered'=>$isordered);

            $message='Nothing happened';

             $query=$this->db->get_where('orderlist',$where_product);

            $res=$query->num_rows();

            if($res==0){

                

            $this->users_model->InsertData('orderlist',$ins_arr);

            $message='Data Inserted';

            }else{

				$response = $this->users_model->UpdateData('orderlist',$upd_arr,$where_product);

				$message='Data Updated';

            }

            $this->set_response($message, REST_Controller::HTTP_OK);

        }

        public function fetchOrderList_get(){

            $user_id=$this->input->get('user');

            

            $where = array('user'=>$user_id);

            $orders=$this->users_model->GetRecord($where,'orderlist');

            $message = array('error'=>'0','message'=>'success','data'=>$orders);

            $this->set_response($message, REST_Controller::HTTP_OK);

        }

        public function listSuppliers_post()

  { 

    $blank_arr=array();

    $shop_name = $this->input->post('shop_name');

    $phone = $this->input->post('mobile_no');

    $city_id   =  ($this->input->post('city_id'))?$this->input->post('city_id'):'2229';

    $offset   =  $this->input->post('offset');



 //   $data=$_POST; 

    

    

           $no_of_records=50;

        //   $like=array('shop_name'=>$shop_name,'city'=>$city_id,'status'=>1); 

        //   $select='supplier_id, name as supplier_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal,shop_name';      

        //   $data=$this->users_model->searchWithLike('supplier',$select,$like,50,$no_of_records);

         

        //              $message = array('error'=>'0','message'=>'success','data'=>$data);

        //              $this->set_response($message, REST_Controller::HTTP_OK);

        

       // ,'','',$select);

                    $sql_s="SELECT supplier_id,name as supplier_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal,shop_name FROM `m16j_supplier` WHERE name LIKE '%$shop_name%' AND status='1'";

                    $suppliers=$this->db->query($sql_s)->result_array();

                    

                   

            



                   $data['suppliers']=$suppliers;



                 



                 $message = array('error'=>'0','message'=>'success','data'=>$suppliers);

                 $this->set_response($suppliers, REST_Controller::HTTP_OK);

           

              } 

        function bannerlist_get()
        {
           
           $sliderlist=$this->common_model->GetRecord('m16j_slider');
           
            if(!empty($sliderlist)){
             
              foreach($sliderlist as $k=>$v)
              {
              $sliderlist[$k]["image_url"]='https://listapp.in/uploads/slider/'.$v["image_url"];
              }
               echo  json_encode(array('status' => 200,'message' => 'Success','data'=>$sliderlist));  
              
            }else{
              echo  json_encode(array('status' => 201,'message' => 'not found','data'=>'Sorry, record not found!')); 
               //echo json_encode(201,array('status' => 201,'message' => 'not found','data'=>array('Sorry, record not found!')));   
            }
            
        }

        function userSignup_post(){

          extract($this->input->post());
          if(empty($first_name) || empty($last_name) || empty($phone) || empty($address)){

              $mess =  json_encode(array('status' => 201,'message' => 'not found','data'=>'All field are require'));
              return $this->set_response($mess, REST_Controller::HTTP_OK);
              exit;
          }else{
            $data['first_name'] = (!empty($first_name) ? $first_name : '');
            $data['last_name'] = (!empty($last_name) ? $last_name : '');
            $data['email'] = (!empty($email) ? $email : '');
            $data['phone'] = (!empty($phone) ? $phone : '');
            $data['address'] = (!empty($address) ? $address : '');
            $data['gstn_no'] = (!empty($gstn_no) ? $gstn_no : '');
            $data['dl_no'] = (!empty($dl_no) ? $dl_no : '');
            $data['role'] = 3;
            $data['regis_date'] = date("Y-m-d H:i:s");
            //$data['login_status'] = 1; // active
            
            
            $get_duplicate = $this->common_model->GetSingleRecord('m16j_user_test',array('phone'=>$phone));

            if(!empty($get_duplicate)){
              
              $mess = array('status' => 200,'message' => 'phone is already exist');
              return $this->set_response($mess, REST_Controller::HTTP_OK);
              

            }else{
  
              $res = $this->common_model->insert_entry('m16j_user_test',$data);
              $userID = $this->db->insert_id();
              $get_user_rec = $this->common_model->GetSingleRecord('m16j_user_test',array('user_id'=>$userID));
              if(!empty($res)){

                $mess = array('status' => 200,'message' => 'Record inserted', 'data'=>$get_user_rec);
                return $this->set_response($mess, REST_Controller::HTTP_OK);

              }else{

                $mess =  array('status' => 201,'message' => 'record not insert');
                return $this->set_response($mess, REST_Controller::HTTP_OK);
                

              }
            }
            
          }
        }

        function userProfileUpdate_post(){
          
          extract($this->input->post());
          if(empty($first_name) || empty($last_name) || empty($phone) || empty($address)){

              $mess =  json_encode(array('status' => 201,'message' => 'not found','data'=>'All field are require'));
              return $this->set_response($mess, REST_Controller::HTTP_OK);
              exit;
          }else{
            $data['first_name'] = (!empty($first_name) ? $first_name : '');
            $data['last_name'] = (!empty($last_name) ? $last_name : '');
            $data['email'] = (!empty($email) ? $email : '');
            $data['address'] = (!empty($address) ? $address : '');
            $data['gstn_no'] = (!empty($gstn_no) ? $gstn_no : '');
            $data['dl_no'] = (!empty($dl_no) ? $dl_no : '');
            $data['update_date'] = date("Y-m-d H:i:s");
            //$data['login_status'] = 1; // active
            
            
            $get_duplicate = $this->common_model->GetSingleRecord('m16j_user_test',array('phone'=>$phone));

            if(empty($get_duplicate)){
              $mess = array('status' => 200,'message' => 'record not exist OR something is wrong');
              return $this->set_response($mess, REST_Controller::HTTP_OK);
            }else{
  
              $res = $this->common_model->updateRecord('m16j_user_test',array('phone'=>$phone) ,$data);
              $mess = array('status' => 200,'message' => 'Record updated ');
                return $this->set_response($mess, REST_Controller::HTTP_OK);
            }
            
          }
        }





          



        

            



}// REST controller End







?>

