<?php
error_reporting(1);
include_once (APPPATH . 'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends REST_Controller
{
  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Kolkata');
    //$messsage=json_encode($_POST);
    //@mail('sam.walker0909@gmail.com', 'post data by ravi', $messsage);
    //@mail('rahulnakum.syscraft@gmail.com', 'post data by ravi', $messsage);
  }
  function randNumber($digits = '')
  {
    if (!$digits) $digits = 6;
    $num = rand(pow(10, $digits - 1) , pow(10, $digits) - 1);
    return $num;
  }
  function sendOtpSms($rand_letter, $phone)
  {
    $api_key = '167511ACh5HC89O597c4889';
    $msg = 'Your ListApp Verification Code is: ' . $rand_letter . '. Please do not reply to this message. Thanks for using ListApp.';
    $sms = str_replace(' ', '%20', $msg);
    // $url = 'https://control.msg91.com/api/sendhttp.php?authkey='.$api_key.'&mobiles='.$phone.'&message='.$sms.'&sender=LSTAPP&route=4&country=91';
    $url = 'https://control.msg91.com/api/sendotp.php?authkey=' . $api_key . '&mobile=91' . $phone . '&message=' . $sms . '&sender=LSTAPP&otp=' . $rand_letter;
    // $rs = file_get_contents(trim($url));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    return ($result) ? $result : curl_error($ch);
  }
  public function checkDeviceReg_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $mobile_unique_id = $this->input->post('mobile_unique_id');
    $device_token = $this->input->post('device_token');
    $device_type = $this->input->post('device_type');
    // $otp = $this->input->post('otp');
    $data = $_POST;
    if (empty($phone) || empty($mobile_unique_id) || empty($device_token) || empty($device_type)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information',
        'data' => ''
      );
      $api_name='checkDeviceReg';
      $post=json_encode($_POST);
      $msg=$final_data['message'];
      $this->error_log($api_name,$post,$msg,$phone);
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "device_token" => $data['device_token'],
        'otp_varified' => 1
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        $user_id = $result[0]['user_id'];
        /*if(!empty($user_id)){
        $this->login_history($user_id);
        }*/
        $final_data = array(
          'error' => '0',
          'message' => 'Device Registered',
          'data' => ''
        );
        $this->set_response($final_data, REST_Controller::HTTP_OK);
      }
      else {
        $final_data = array(
          'error' => '1',
          'message' => 'Device Not Registered',
          'data' => ''
        );
        $this->set_response($final_data, REST_Controller::HTTP_OK);
      }
    }
  }
  public function checkMobile_post()

  {

    $phone = $this->input->post('mobile_no');
    $data = $_POST;
    if (empty($phone)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information',
        'data' => ''
      );
      $api_name='checkMobile';
      $post=json_encode($_POST);
      $msg=$final_data['message'];
      $this->error_log($api_name,$post,$msg,$phone);
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no']
      ));
      $result = $query_phone->result_array();
      /*print_r($result[0]['user_id']);*/
      if (!empty($result)) {
        if ($result[0]['otp_verify_first'] === '0' && $result[0]['otp_varified'] === '0') {
          $delete = $this->db->query("DELETE FROM`m16j_user` WHERE `user_id`='" . $result[0]['user_id'] . "' AND `phone`='" . $phone . "'");
          $final_data = array(
            'error' => '1'
          );
          $this->set_response($final_data, REST_Controller::HTTP_OK);
        }
        else {
          $user_id = $result[0]['user_id'];
          /*if(!empty($user_id)){
          $this->login_history($user_id);
          }*/
          $final_data = array(
            'error' => '0'
          );
          $this->set_response($final_data, REST_Controller::HTTP_OK);
        }
      }
      else {
        $final_data = array(
          'error' => '1'
        );
        $this->set_response($final_data, REST_Controller::HTTP_OK);
      }
    }
  }
  // Function for User Login via API
  public function Login_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $password = $this->input->post('password');
    $device_token = $this->input->post('device_token');
    $device_type = $this->input->post('device_type');
    // $otp = $this->input->post('otp');
    $data = $_POST;
    $otp = '';
    if (empty($phone) || empty($password) || empty($device_token) || empty($device_type)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $api_name='Login';
      $post=json_encode($data);
      $msg=$final_data['message'];
      $this->error_log($api_name,$post,$msg,$phone);
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        foreach($result as $res) {
          $stored_salt = $res['salt'];
          $stored_passsword = $res['password'];
        }
        $userPassword = $data['password'];
        $hashedPassword = encode($userPassword, $stored_salt);
        $where = array(
          'phone' => $this->input->post('mobile_no') ,
          'password' => $hashedPassword
        );
        $select = 'role,user_id,first_name as full_name,email,phone,address,landmark,state,city,shop_name,otp,status';
        $data = $this->common_model->get_entry_by_data('user', true, $where, $select);
        if ($data) {
          if ($result[0]['status'] === 'Active') {
            $saved_device_token = $result[0]['device_token'];
            if ($device_token != $saved_device_token) {
              // $otp_token=mt_rand(100000,999999);
              //$otp_token = $rand_letter = $this->randNumber();
             // $sms_rturn = $this->sendOtpSms($rand_letter, $phone);
              //$success_device_msg = "go to otp";
              $arr = array(
                'device_type' => $device_type,
                'device_token' => $device_token,
               // 'otp_varified' => '0',
                //'otp' => $otp_token,
              );
            }
            else {
              $success_device_msg = "success";
              $arr = array(
                'device_type' => $device_type,
              );
            }
            $where_phone = array(
              'phone' => $phone
            );
            $response = $this->users_model->UpdateData('user', $arr, $where_phone);
           /* if (!empty($otp_token)) {
              $final_data = array(
                'error' => '1',
                'message' => 'go to otp',
                'data' => array(
                  'OTP' => $otp_token
                )
              );
              $this->set_response($final_data, REST_Controller::HTTP_OK);
            }
            else {*/
              if ($result[0]['otp_varified'] == 1) {
                $retailerDetail = array();
                $user_id = $data['user_id'];
                $upd_arr = array(
                  'login_status' => '1'
                );
                $login_status = $this->users_model->update_entry($upd_arr, 'user', $user_id, 'user_id');
                if ($data['role'] == 3) {
                  $data['role_name'] = "Retailer";
                  $data['role_id'] = $data['role'];
                  // unset($data['role']);
                }
                if ($data['role'] == 2) {
                  $data['role_name'] = "Supplier";
                  $data['role_id'] = $data['role'];
                  // unset($data['role']);
                }
                $data['state_id'] = ($data['state']) ? $data['state'] : 'NA';
                $states = $this->users_model->GetCityState('states', 'name', 'id', $data['state']);
                $data['state'] = ($states[0]['name']) ? $states[0]['name'] : 'NA';
                $data['city_id'] = ($data['city']) ? $data['city'] : 'NA';
                $cities = $this->users_model->GetCityState('cities', 'name', 'id', $data['city']);
                $data['city'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
                $retailerDetail['Role_id'] = $data['role_id'];
                $retailerDetail['Role_Name'] = $data['role_name'];
                $retailerDetail['User_ID'] = $data['user_id'];
                $retailerDetail['OTP'] = $data['otp'];
                $retailerDetail['Full_Name'] = $data['full_name'];
                $retailerDetail['Email'] = $data['email'];
                $retailerDetail['Contact_Number'] = $data['phone'];
                $retailerDetail['Area'] = $data['landmark'];
                $retailerDetail['Address'] = html_entity_decode($data['address']);
                $retailerDetail['City'] = $data['city'];
                $retailerDetail['State'] = $data['state'];
                $retailerDetail['Shop_Name'] = $data['shop_name'];
                $retailerDetail['CityId'] = $data['city_id'];
                $retailerDetail['Stateid'] = $data['state_id'];
                $retailerDetails[] = $retailerDetail;
                // if(!empty($otp_token))
                // {
                // $final_data = array('error'=>'1','message'=>'go to otp','data'=>array('OTP'=>$otp_token));
                // $this->set_response($final_data, REST_Controller::HTTP_OK);
                // }else{
                $final_data = array(
                  'error' => '0',
                  'message' => 'success',
                  'data' => $retailerDetail
                );
                $this->set_response($final_data, REST_Controller::HTTP_OK);
                // }
              }
              else {
                $otp_token = $rand_letter = $this->randNumber();
                $sms_rturn = $this->sendOtpSms($rand_letter, $phone);
                $arr = array(
                  'otp_varified' => '0',
                  'otp' => $otp_token,
                );
                $where_phone = array(
                  'phone' => $phone
                );
                $response = $this->users_model->UpdateData('user', $arr, $where_phone);
                $error = array(
                  'error' => '1',
                  'message' => 'OTP Unverified',
                  'data' => array(
                    'OTP' => $result[0]['otp']
                  )
                );
                $this->set_response($error, REST_Controller::HTTP_OK);
              }
            //}else close
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'Your account has been deactivated by administrator'
            );
            $this->set_response($error, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Invalid Mobile Number or password'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Mobile number not registered with us'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  // New User Sign up..
  public function SignUp_post()

  {
    $blank_arr = array();
    $name = $mobile_number = $role = $password = $area = $address = $shop_name = $state = $city = $device_type = $device_token = $email = $CheckeEmail = '';
    // $name         =   $this->input->post('full_name');
    $mobile_number = $this->input->post('mobile_no');
    $password = $this->input->post('password');
    $role = $this->input->post('user_type');
    $shop_name = $this->input->post('shop_name');
    // $email        =   $this->input->post('email');
    // $area         =   $this->input->post('area');
    // $address      =   $this->input->post('address');
    $state_id = $this->input->post('state_id');
    $city_id = $this->input->post('city_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $mobile_unique_id = $this->input->post('mobile_unique_id');  
    if ($mobile_number == '' || $role == '' || $password == '' || $shop_name == '' || $device_type == ''  || $state_id == '' || $city_id == '') {
    // $device_token == '' || $mobile_unique_id == ''
      $empty_field='';      
        $final_data = array(
        'error' => '1',
        'message' => 'Please Provide All Information'
      );
      $api_name='Sign Up';
      $post=json_encode($_POST);
      $msg=$final_data['message'];
      $this->error_log($api_name,$post,$msg,$mobile_number);
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $time = date("Y-m-d h:i:s");
      // check user email already exist or not
      if (!empty($email)) {
        $where = array(
          'email' => $email
        );
        $CheckeEmail = $this->users_model->GetRecord($where, 'user');
      }
      $where2 = array(
        'phone' => $mobile_number,
      );
      $mobile_number_exist = $this->users_model->GetRecord($where2, 'user');
      if (!empty($CheckeEmail)) {
        $final_data = array(
          'error' => '1',
          'message' => 'User with this Email Id Already Exists'
        );
        $this->set_response($final_data, REST_Controller::HTTP_OK);
      }
      else if (!empty($mobile_number_exist) && $mobile_number_exist[0]['otp_verify_first'] == '1') {
        $final_data = array(
          'error' => '1',
          'message' => 'User with this Mobile Number Already Exists. Please Login'
        );
        $this->set_response($final_data, REST_Controller::HTTP_OK);
      }
      else {
        if (!empty($mobile_number_exist) && $mobile_number_exist[0]['otp_verify_first'] == '0' && $mobile_number_exist[0]['otp_varified'] == '0') {
          $delete = $this->db->query("DELETE FROM`m16j_user` WHERE `user_id`='" . $mobile_number_exist[0]['user_id'] . "' AND `phone`='" . $mobile_number . "'");
          $final_data = array(
            'error' => '1'
          );
          $this->set_response($final_data, REST_Controller::HTTP_OK);
        }
        $salt = random_string('alnum', 16);
        $otp = $rand_letter = $this->randNumber();
        $sms_rturn = $this->sendOtpSms($rand_letter, $mobile_number);
        $encrypted_pass = encode($this->input->post('password') , $salt);
        $arr = array(
          // 'first_name'   => $name,
          'phone' => $mobile_number,
          'password' => $encrypted_pass,
          'pwd_without_encode' => $password,
          'role' => $role,
          'shop_name' => $shop_name,
          // 'email'        => $email,
          // 'landmark'     => $area,
          // 'address'      => $address,
          'state' => $state_id,
          'city' => $city_id,
          'otp' => $otp,
          'salt' => $salt,
          'device_type' => $device_type,
          'device_token' => $device_token,
          'mobile_unique_id' => $mobile_unique_id,
          'otp_verify_first' => '0',
          'status' => '1',
          'regis_date' => $time
        );
        // print_r($arr);die;
        $user_id = $this->users_model->InsertData('user', $arr);
        if ($user_id) {
          $retailerDetail = array();
          $where = array(
            'user_id' => $user_id
          );
          $select = 'role,user_id,first_name as full_name,email,phone,address,landmark,state,city,shop_name,otp,status';
          $retailer = $this->users_model->GetRecord($where, 'user', '', '', $select);
          if (count($retailer) > 0) {
            foreach($retailer as $retailer_val) {
              if ($retailer_val['role'] == 3) {
                $retailer_val['role_name'] = "Retailer";
                $retailer_val['role_id'] = $retailer_val['role'];
                unset($retailer_val['role']);
              }
              if ($retailer_val['role'] == 2) {
                $retailer_val['role_name'] = "Supplier";
                $retailer_val['role_id'] = $retailer_val['role'];
                unset($retailer_val['role']);
              }
              if ($retailer_val['state']) {
                $retailer_val['state_id'] = ($retailer_val['state']) ? $retailer_val['state'] : 'NA';
                $states = $this->users_model->GetCityState('states', 'name', 'id', $retailer_val['state']);
                $retailer_val['state'] = ($states[0]['name']) ? $states[0]['name'] : 'NA';
              }
              if ($retailer_val['city']) {
                $retailer_val['city_id'] = ($retailer_val['city']) ? $retailer_val['city'] : 'NA';
                $cities = $this->users_model->GetCityState('cities', 'name', 'id', $retailer_val['city']);
                $retailer_val['city'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
              }
            }
            $retailerDetail['Role_id'] = $retailer_val['role_id'];
            $retailerDetail['Role_Name'] = $retailer_val['role_name'];
            $retailerDetail['User_ID'] = $retailer_val['user_id'];
            $retailerDetail['OTP'] = $retailer_val['otp'];
            $retailerDetail['Contact_Number'] = $retailer_val['phone'];
            $retailerDetail['City'] = $retailer_val['city'];
            $retailerDetail['State'] = $retailer_val['state'];
            $retailerDetail['Shop_Name'] = $retailer_val['shop_name'];
            $message = array(
              'error' => '0',
              'message' => 'success',
              'data' => $retailerDetail
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '0',
              'message' => 'No Record Found'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $final_data = array(
            'error' => '1',
            'message' => 'You have not Sign Up. Please Try Again'
          );
          $this->set_response($final_data, REST_Controller::HTTP_OK);
        }
      }
    }
  }
  public function StateCity_get()

  {
    // $state  =  $this->input->post('state');
    $where = array(
      'name' => 'India'
    );
    $GetRecord = $this->users_model->GetRecord($where, 'countries');
    // print_r($GetRecord);
    $country_id = $GetRecord[0]['id'];
    $country_name = $GetRecord[0]['name'];
    $where = array(
      'country_id' => $country_id
    );
    $GetState = $this->users_model->GetRecord($where, 'states');
    // print_r($GetState);die;
    $stateCity = array();
    $dataArray = array();
    foreach($GetState as $state) {
      $stateCity['state_id'] = $state['id'];
      $stateCity['state_name'] = $state['name'];
      $where = array(
        'state_id' => $state['id']
      );
      $cityArray = array();
      $GetCity = $this->users_model->GetRecord($where, 'cities');
      foreach($GetCity as $city) {
        $cityArray[] = array(
          'city_id' => $city['id'],
          'city_name' => $city['name']
        );
      }
      $stateCity['city'] = $cityArray;
      $dataArray[] = $stateCity;
    }
    $final_data = array(
      'error' => '0',
      'message' => 'success',
      'data' => $dataArray
    );
    $this->set_response($final_data, REST_Controller::HTTP_OK);
  }
  public function state_post()

  {
    $country_id = $this->input->post('country_id');
    if (empty($country_id) || !is_numeric($country_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide Country ID'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
      return;
    }
    $where = array(
      'country_id' => $country_id
    );
    $allState = $this->users_model->GetRecord($where, 'states');
    $final_data = array(
      'error' => '0',
      'message' => 'success',
      'data' => $allState
    );
    $this->set_response($final_data, REST_Controller::HTTP_OK);
  }
  public function cities_post()

  {
    $state_id = $this->input->post('state_id');
    if (empty($state_id) || !is_numeric($state_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide State ID'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
      return;
    }
    $where = array(
      'state_id' => $state_id
    );
    $allCities = $this->users_model->GetRecord($where, 'cities');
    $final_data = array(
      'error' => '0',
      'message' => 'success',
      'data' => $allCities
    );
    $this->set_response($final_data, REST_Controller::HTTP_OK);
  }
  public function forgotPassword_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $data1 = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data1['mobile_no']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['status'] === 'Active') {
          $user_id = $result[0]['user_id'];
          $otp = $rand_letter = $this->randNumber();
          $sms_rturn = $this->sendOtpSms($rand_letter, $phone);
          $arr = array(
            'otp' => $otp
          );
          $data = $arr;
          $data_1 = $this->users_model->updateOTP('user', $user_id, $arr);
          $message = array(
            'error' => '0',
            'message' => 'OTP has been sent on Your Mobile',
            'data' => $data
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your account has been deactivated by administrator'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Mobile number not registered with us'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function resendOTP_post()
  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $data1 = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data1['mobile_no']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['status'] === 'Active') {
          $user_id = $result[0]['user_id'];
          $otp = $rand_letter = $this->randNumber();
          $sms_rturn = $this->sendOtpSms($rand_letter, $phone);
          $arr = array(
            'otp' => $otp
          );
          $data = $arr;
          $data_1 = $this->users_model->updateOTP('user', $user_id, $arr);
          $message = array(
            'error' => '0',
            'message' => 'OTP has been sent on Your Mobile',
            'data' => $data
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your account has been deactivated by administrator'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Mobile number not registered with us'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*Check OTP VALIDATE*/
  public function otpVerify_post()
  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $otp = $this->input->post('otp');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $data = $_POST;
    if (empty($phone) || empty($otp) || empty($device_type) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['status'] === 'Active') {
          if ($result[0]['otp'] == $data['otp']) {
            if ($result[0]['otp_verify_first'] == 0) {
              $message = 'Welcome to ListApp!
A new way of discovering Medicines, Suppliers & Companies.
Enjoy 6 months of Free access to this app.

Best Wishes,
Team ListApp';
              $ins_data = array(
                'notification_user_id' => $result[0]['user_id'],
                'message' => html_entity_decode($message),
                'notification_type' => 1,
                'notification_title' => 'Welcome',
                'notification_to_name' => $retailer_val['shop_name'],
                'sound' => 'default',
                'alert' => 'Welcome',
              );
              send_gcm_notify($device_token, $ins_data, $device_type);
            }
            $user_id = $result[0]['user_id'];
            $upd_arr = array(
              'otp' => $otp,
              'otp_varified' => 1,
              'otp_verify_first' => 1,
              'device_token' => $device_token
            );
            $update = $this->users_model->update_entry($upd_arr, 'user', $user_id, 'user_id');
            if (!empty($update)) {
              $message = array(
                'error' => '0',
                'message' => 'OTP Verified',
                'data' => array(
                  'user_id' => $user_id
                )
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
            }
            else {
              $message = array(
                'error' => '1',
                'message' => 'Invalid OTP'
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
            }
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'Invalid OTP'
            );
            $this->set_response($error, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your account has been deactivated by administrator'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Mobile number not registered with us'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*Check OTP VALIDATE ends */

  /*===========GET searchProduct starts===========*/
  public function searchProduct_post()
  {
    $this->load->driver('cache');
    $this->load->library('memcached_library');    
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
        if($result[0]['device_token'] ==$data1['device_token']) 
        {
          $no_of_records=50;
          if($offset > 0) {
            $product_name_key = $product_name . $offset;
            $offset = intval($offset) * intval($no_of_records);
          }
          else {
            $product_name_key = $product_name;
          }
          $order = array('/','-',' ','%','&','_','.','+','*','@','$','^','(',')','|','!','`','>',"<",'?','#',',',':','[',']','{','}','"',"'" );
          // remove all spacial character
            $dq = '"';
            $Sq = "'";
            $column_name = "REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (`p`.`product_name`,'$sq',''),'$dq',''),'%',''),'}',''),'{',''),']',''),'[',''),':',''),' ',''),',',''),'.',''),'.',''),'#',''),'@',''),'$',''),'^',''),'(',''),')',''),'|',''),'!',''),'`',''),'<',''),'>',''),'?',''),'*',''),'+',''),'-',''),'/','')";
          $_name = str_replace($order, '', trim($this->input->post('product_name')));
          $like=array($column_name=>$_name);
          
          $results = $this->memcached_library->get($product_name_key);
          $explode = explode(" ",$product_name);
          if(!$results)
          {
           $data=$this->users_model->searchWithLikeProduct($like ,$offset,$no_of_records,'','asc');
           //$this->memcached_library->add($product_name_key, $data,7000);  
         }
         else
         {          
          $data = $results;
        }
        $both = '';
          if(empty($data))
          {
            $string_len=strlen($explode[0]);
            for ($i=1; $i <$string_len ; $i++) { 
              $end=$string_len-$i;
              $search_text = array('product_name'=>substr($explode[0],0,$end));
              $data=$this->users_model->searchWithLikeProduct($search_text ,$offset,$no_of_records,'','asc');
              if(!empty($data))
              {
                if(strlen($search_text) == 3){
                  $product_name_key=$search_text.$offset;
                  $this->memcached_library->add($product_name_key, $data,7000);
                }
                else{
                  $this->memcached_library->add($product_name_key, $data,7000);
                }
                break;                
              }

            }                     
          } 
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
            }
            $message = array('error'=>'1','message'=>'No matching records found');
            $this->set_response($message, REST_Controller::HTTP_OK);
          }else
          {
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
        $error = array('error'=>'1','message'=>'Your account has been deactivated by administrator');
        $this->set_response($error, REST_Controller::HTTP_OK);
      }

    }

  }
  /*========GET searchProduct ends=================*/
  /*=======search supplier starts==============*/
  public function searchSupplier_post()

  {
    $blank_arr = array();
    $shop_name = $this->input->post('shop_name');
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $city_id = $this->input->post('city_id');
    $offset = $this->input->post('offset');
    $data = $_POST;
    if (empty($shop_name) || empty($phone) || empty($device_token) || empty($user_id) || empty($device_type) || empty($city_id) || (empty($offset) && $offset != 0)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "user_id" => $data['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          if ($offset > 0) {
            $offset = $offset * 50;
          }
          $no_of_records = 50;
          //$city_id = '2229';
          $like = array(
            'shop_name' => $shop_name,
            //'city' => $city_id,
            'status' => 1
          );
          $select = 'supplier_id, name as supplier_name,shop_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status';
          $data = $this->users_model->searchWithLike('supplier', $select, $like, $offset, $no_of_records);
          if (empty($data)) {
            $message = array(
              'error' => '1',
              'message' => 'No matching records found'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            for ($i = 0; $i < count($data); $i++) {
              /*if($data[$i]['state']){
              $states=$this->users_model->GetCityState('states','name','id',$data[$i]['state']);
              $data[$i]['state']=($states[0]['name'])?$states[0]['name']:'NA';
              }*/
              if ($data[$i]['city_name']) {
                $cities = $this->users_model->GetCityState('cities', 'name', 'id', $data[$i]['city_name']);
                $data[$i]['city_name'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
              }
              if ($data[$i]['supplier_address']) {
                $data[$i]['supplier_address'] = html_entity_decode($data[$i]['supplier_address']);
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
            $message = array(
              'error' => '0',
              'message' => 'success',
              'data' => $data
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*search supplier ends*/
  /*======================== SEARCH COMPANY STARTS ===============================*/
  public function searchCompany_post()

  {
    $blank_arr = array();
    $company_name = $this->input->post('company_name');
    $phone = $this->input->post('mobile_no');
    $device_token = $this->input->post('device_token');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $city_id = $this->input->post('city_id');
    $offset = $this->input->post('offset');
    $data = $_POST;
    if (empty($company_name) || empty($phone) || empty($user_id) || empty($device_type) || empty($device_token) || empty($city_id) || (empty($offset) && $offset != 0)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "user_id" => $data['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          if ($offset > 0) {
            $offset = $offset * 50;
          }
          $no_of_records = 50;
          $like = array(
            'company_name' => $company_name,
            'status' => 1
          );
          $data = $this->users_model->searchWithLike('company', '', $like, $offset, $no_of_records);
          if (empty($data)) {
            $message = array(
              'error' => '1',
              'message' => 'No matching records found'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '0',
              'message' => 'success',
              'data' => $data
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*======================== SEARCH COMPANY ENDS===============================*/
  /*=================== SEARCH PRODUCT WITH SUPPLIER STARTS ============================*/
  public function searchNearBySupplier_post()

  {
    $blank_arr = array();
    $product_id = $this->input->post('product_id');
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $city_id = $this->input->post('city_id');
    $offset = $this->input->post('offset');
    $data1 = $_POST;
    if (empty($product_id) || empty($phone) || empty($city_id) || empty($user_id) || empty($device_type)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data1['mobile_no'],
        "status" => 'Active',
        "user_id" => $data1['user_id']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $where = array(
            'product_id' => $product_id,
            'status' => 1
          );
          $data = $this->users_model->GetRecord($where, 'product');
          if (empty($data)) {
            $data['record'] = "No Record Found";
          }
          else {
            $company_id = $data[0]['company_name'];
            if ($offset == 0) {
              for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['company_name']) {
                  $company_name = $this->users_model->GetCityState('company', 'company_name', 'company_id', $data[$i]['company_name']);
                  $data[$i]['menufecture_by'] = $company_name[0]['company_name'];
                }
                if ($data[$i]['form']) {
                  $form_name = $this->users_model->GetCityState('form', 'Form', 'form_id', $data[$i]['form']);
                  $data[$i]['form'] = $form_name[0]['Form'];
                }
                if ($data[$i]['packing_type']) {
                  $packingtype_name = $this->users_model->GetCityState('packing_type', 'packingtype_name', 'packing_type_id', $data[$i]['packing_type']);
                  $data[$i]['packing_detail'] = $packingtype_name[0]['packingtype_name'];
                  unset($data[$i]['packing_type']);
                }
                if ($data[$i]['pack_size']) {
                  $pack_size_name = $this->users_model->GetCityState('packsize', 'Pack_size', 'pack_size_id', $data[$i]['pack_size']);
                  $data[$i]['pack_size'] = $pack_size_name[0]['Pack_size'];
                }
                if ($data[$i]['schedule']) {
                  $pack_size_name = $this->users_model->GetCityState('schedule', 'schedule_name', 'schedule_id', $data[$i]['schedule']);
                  $data[$i]['schedule'] = $pack_size_name[0]['schedule_name'];
                }
              }
              $data[0]['composition'] = $data[0]['drug_name'];
              $data[0]['favourite_status'] = '';
              if ($data[0]['rate'] != '') {
                $data[0]['price'] = $data[0]['rate'];
              }
              else {
                $data[0]['price'] = $data[0]['mrp'];
              }
              $data[0]['used_for_treatment'] = '';
              unset($data[0]['drug_name']);
              unset($data[0]['company_name']);
              unset($data[0]['form']);
              unset($data[0]['pack_size']);
              unset($data[0]['mrp']);
              unset($data[0]['rate']);
              unset($data[0]['schedule']);
              unset($data[0]['status']);
              unset($data[0]['add_date']);
              $cities = $this->users_model->GetCityState('cities', 'name', 'id', $city_id);
              $data[0]['city_name'] = ($cities[0]['name']) ? $cities[0]['name'] : '';
              $data['product'] = $data[0];
              unset($data[0]);
            }
            else {
              unset($data[0]);
            }
            $supplierNear = array();
            if ($offset > 0) {
              $offset = $offset * 50;
            }
            $no_of_records = 50;
            //$city_id = '2229';
            $where = array(
              'city' => $city_id,
              'status' => 1
            );
            // $select='supplier_id, name as supplier_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal,shop_name';
            $sql_s = "SELECT supplier_id, name as supplier_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal,shop_name FROM `m16j_supplier` WHERE FIND_IN_SET ('" . $company_id . "', `company_deal`) AND city='$city_id' AND status ='1'  LIMIT $offset, $no_of_records ";
            $suppliers = $this->db->query($sql_s)->result_array();
            // $suppliers=$this->users_model->GetRecord($where,'supplier','','',$select);
            // $suppliers=$this->users_model->GetRecord($where,'supplier');
            if (count($suppliers) > 0) {
              foreach($suppliers as $supplier) {
                $company_name = explode(',', $supplier['company_deal']);
                if (in_array($company_id, $company_name)) {
                  $supplier['supplier_address'] = html_entity_decode($supplier['supplier_address']);
                  /*if($supplier['state']){
                  $states=$this->users_model->GetCityState('states','name','id',$supplier['state']);
                  $supplier['state']=($states[0]['name'])?$states[0]['name']:'NA';
                  }*/
                  if ($supplier['city_name']) {
                    $cities = $this->users_model->GetCityState('cities', 'name', 'id', $supplier['city_name']);
                    $supplier['city_name'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
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
                  $supplierNear[] = $supplier;
                }
              }
            }
            else {
              // $supplierNear[]="No Supplier In This Location";
            }
            $data['suppliers'] = $supplierNear;
          }
          $message = array(
            'error' => '0',
            'message' => 'success',
            'data' => $data
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*======================== SEARCH PRODUCT WITH SUPPLIER ENDS ================*/
  /*======================== Get supplier details starts============================*/
  public function getSupplierDetail_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $supplier_id = $this->input->post('supplier_id');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $data1 = $_POST;
    if (empty($phone) || empty($device_type) || empty($user_id) || empty($supplier_id) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data1['mobile_no'],
        "status" => 'Active',
        "user_id" => $data1['user_id']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $supplierDetail = array();
          $where = array(
            'supplier_id' => $supplier_id,
            'status' => 1
          );
          $select = 'supplier_id, name as supplier_name, mobile_number as contact_number, shop_name, area, address, state, city, email, dln_no, tln_no, estd_no, contact_person as contact_person , contact_person_mobile, company_deal as company_dealership, authe_no_authe as authorised, status';
          $suppliers = $this->users_model->GetRecord($where, 'supplier', '', '', $select);
          // $suppliers=$this->users_model->GetRecord($where,'supplier');
          if (count($suppliers) > 0) {
            foreach($suppliers as $supplier) {
              $supplier['address'] = html_entity_decode($supplier['address']);
              if ($supplier['state']) {
                $states = $this->users_model->GetCityState('states', 'name', 'id', $supplier['state']);
                $supplier['state'] = ($states[0]['name']) ? $states[0]['name'] : 'NA';
              }
              if ($supplier['city']) {
                $cities = $this->users_model->GetCityState('cities', 'name', 'id', $supplier['city']);
                $supplier['city'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
              }
              if ($supplier['company_dealership']) {
                $company_names = $this->users_model->GetCityState('company', 'company_id,company_name', 'company_id', '', '', explode(',', $supplier['company_dealership']));
                $comp_name_arr = array();
                foreach($company_names as $C_value) {
                  $comp_name_arr[] = array(
                    'company_id' => $C_value['company_id'],
                    'company_name' => $C_value['company_name']
                  );
                }
                $supplier['company_dealership'] = $comp_name_arr;
              }
              else {
                $supplier['company_dealership'] = array();
              }
              if ($supplier['status'] == 1) {
                $supplier['status'] = 'Active';
              }
              else {
                $supplier['status'] = 'Inactive';
              }
              $supplier['favourite_status'] = '';
              if ($supplier['contact_person'] != '') {
                $contact_person = explode(',', $supplier['contact_person']);
                $contact_person_mo = explode(',', $supplier['contact_person_mobile']);
                for ($i = 0; $i < count($contact_person); $i++) {
                  $con_both_arr[] = array(
                    'contact_name' => $contact_person[$i],
                    'contact_number' => $contact_person_mo[$i]
                  );
                }
                $supplier['contact_person'] = $con_both_arr;
                // unset($supplier['contact_person']);
                unset($supplier['contact_person_mobile']);
              }
              else {
                $supplier['contact_person'] = array();
                // unset($supplier['contact_person']);
                unset($supplier['contact_person_mobile']);
              }
            }
            if (!empty($supplier)) {
              $supplierDetail[] = $supplier;
              $data['supplier'] = $supplierDetail;
            }
            else {
              $data['supplier'] = array();
            }
            $message = array(
              'error' => '0',
              'message' => 'success',
              'data' => $data
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '1',
              'message' => 'No record found. Please check Supplier Details'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*======================== Get supplier details end ============================*/
  /*======================== Get terms condition starts ============================*/
  public function getTermsCondition_get()

  {
    $terms = $this->users_model->GetRecord('', 'terms_conditions');
    $message = array(
      'error' => '0',
      'message' => 'success',
      'data' => $terms
    );
    $this->set_response($message, REST_Controller::HTTP_OK);
  }
  public function getAboutUs_get()

  {
    $about = $this->users_model->GetRecord('', 'about_us');
    $message = array(
      'error' => '0',
      'message' => 'success',
      'data' => $about
    );
    $this->set_response($message, REST_Controller::HTTP_OK);
  }
  /*======================== Get supplier details end ============================*/
  /*============================= CHANGE LICENCE AND TIN NUMBER STARTS ==============================*/
  public function changeLicenceAndTin_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $drug_licence_number = trim($this->input->post('drug_licence_number'));
    $tin_number = trim($this->input->post('tin_number'));
    $data = $_POST;
    if (empty($phone) || empty($device_token) || empty($device_type) || empty($user_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "status" => 'Active',
        "user_id" => $data['user_id']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          $tin_number = ($tin_number) ? $tin_number : " ";
          $drug_licence_number = ($drug_licence_number) ? $drug_licence_number : " ";
          $email = ($result[0]['email']) ? $result[0]['email'] : "NA";
          $from_email = $result[0]['email'];
          $subject = "Request for updating Drug License Number / GSTIN Number";
          $message = "<div><p>Hello Admin,</p>
                <p> Please update my Drug License Number / GSTIN Number:</p>
                <p>Retailer Name: " . $result[0]['first_name'] . "</p>
                <p>Mobile Number: " . $result[0]['phone'] . "</p>
                <p>EmailID: " . $email . "</p>
                <p>Shop Name: " . $result[0]['shop_name'] . "<p>
                <p>Drug License Number : " . $drug_licence_number . " </p>
                <p>GSTIN Number:" . $tin_number . "<p></br>  
                Thanks<br />" . $result[0]['first_name'] . "
                <br /></div>";
          $sendRequest = $this->send_email('', $from_email, $subject, $message);
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
          if ($sendRequest == 1) {
            $message = array(
              'error' => '0',
              'message' => 'Your request for change Drug License Number / Tin Number is sent successfully.'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '1',
              'message' => 'Your request has not been sent. Please Try Again'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*============================= CHANGE LICENCE AND TIN NUMBER ENDS ==============================*/
  /*============================= CHANGE Password STARTS ==============================*/
  public function resetPassword_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    // $user_id   =  $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = trim($this->input->post('device_token'));
    $new_password = trim($this->input->post('new_password'));
    $data = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token) || empty($new_password)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          foreach($result as $res) {
            $stored_salt = $res['salt'];
            $user_id = $res['user_id'];
            $pwd_without_encode = $res['pwd_without_encode'];
          }
          // if($result[0]['pwd_without_encode'] != $new_password)
          // {
          $encrypted_pass = encode($new_password, $stored_salt);
          $upd_arr = array(
            'password' => $encrypted_pass,
            'pwd_without_encode' => $new_password,
            'login_status' => 1
          );
          $update = $this->users_model->update_entry($upd_arr, 'user', $user_id, 'user_id');
          if (!empty($update)) {
            $user_details = $this->get_user_details($user_id);
            $message = array(
              'error' => '0',
              'message' => 'Password updated successfully',
              'data' => $user_details
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '1',
              'message' => 'Password has not been Updated. Please Try Again'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          // }else{
          //   $message = array('error'=>'1','message'=>'New password must not same as old password');
          //   $this->set_response($message, REST_Controller::HTTP_OK);
          // }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*============================= CHANGE Password ENDS ==============================*/
  /*============================= User logout STARTS ==============================*/
  public function userLogout_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $data = $_POST;
    if (empty($phone) || empty($device_type) || empty($user_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "user_id" => $data['user_id']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        $upd_arr = array(
          'login_status' => '0',
          'device_token' => '0'
        );
        $login_status = $this->users_model->update_entry($upd_arr, 'user', $user_id, 'user_id');
        $message = array(
          'error' => '0',
          'message' => 'Logout '
        );
        $this->set_response($message, REST_Controller::HTTP_OK);
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Invalid User Detail'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*============================= User logout ENDS ==============================*/
  /*======================= Edit retailer profile starts ======================*/
  public function editRetailerProfile_post()

  {
    $blank_arr = array();
    $otp_token = '';
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $device_token = $this->input->post('device_token');
    $full_name = $this->input->post('full_name');
    $shop_name = $this->input->post('shop_name');
    $estd_year = $this->input->post('estd_year');
    $dl_no = $this->input->post('dl_no');
    $tin_no = $this->input->post('tin_no');
    $role = $this->input->post('user_type');
    $contact_name_1 = $this->input->post('contact_name_1');
    $contact_number_1 = $this->input->post('contact_number_1');
    $contact_name_2 = $this->input->post('contact_name_2');
    $contact_number_2 = $this->input->post('contact_number_2');
    $contact_name_3 = $this->input->post('contact_name_3');
    $contact_number_3 = $this->input->post('contact_number_3');
    $contact_name_4 = $this->input->post('contact_name_4');
    $contact_number_4 = $this->input->post('contact_number_4');
    $contact_name_5 = $this->input->post('contact_name_5');
    $contact_number_5 = $this->input->post('contact_number_5');
    $email = $this->input->post('email');
    $area = $this->input->post('area');
    $address = $this->input->post('address');
    $state_id = $this->input->post('state_id');
    $city_id = $this->input->post('city_id');
    $data1 = $_POST;
    // empty($estd_year)  || empty($dl_no) || empty($tin_no) ||
    if (empty($phone) || empty($device_token) || empty($device_type) || empty($user_id) || empty($device_token) || empty($full_name) || empty($shop_name) || empty($area) || empty($address) || empty($state_id) || empty($city_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        'status' => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          // check user email already exist or not
          $whereNotIn = array(
            $user_id
          );
          if (!empty($email)) {
            $where = array(
              'email' => $email
            );
            $CheckeEmail = $this->users_model->GetRecord($where, 'user', 'user_id', $whereNotIn);
          }
          $where_mo = array(
            'phone' => $phone
          );
          $CheckeMobile = $this->users_model->GetRecord($where_mo, 'user', 'user_id', $whereNotIn);
          if (!empty($CheckeEmail)) {
            $final_data = array(
              'error' => '1',
              'message' => 'User with this Email Id Already Exists'
            );
            $this->set_response($final_data, REST_Controller::HTTP_OK);
          }
          else if (!empty($CheckeMobile)) {
            $final_data = array(
              'error' => '1',
              'message' => 'User with this Mobile Number Already Exists'
            );
            $this->set_response($final_data, REST_Controller::HTTP_OK);
          }
          else {
            $time = date("Y-m-d h:i:s");
            $contact_person = '';
            $contact_person_number = '';
            if ($contact_name_1 != '' && $contact_number_1 != '') {
              $contact_person.= $contact_name_1 . ',';
              $contact_person_number.= $contact_number_1 . ',';
            }
            if ($contact_name_2 != '' && $contact_number_2 != '') {
              $contact_person.= $contact_name_2 . ',';
              $contact_person_number.= $contact_number_2 . ',';
            }
            if ($contact_name_3 != '' && $contact_number_3 != '') {
              $contact_person.= $contact_name_3 . ',';
              $contact_person_number.= $contact_number_3 . ',';
            }
            if ($contact_name_4 != '' && $contact_number_4 != '') {
              $contact_person.= $contact_name_4 . ',';
              $contact_person_number.= $contact_number_4 . ',';
            }
            if ($contact_name_5 != '' && $contact_number_5 != '') {
              $contact_person.= $contact_name_5 . ',';
              $contact_person_number.= $contact_number_5 . ',';
            }
            $contact_person = rtrim($contact_person, ',');
            $contact_person_number = rtrim($contact_person_number, ',');
            $upd_arr = array(
              'first_name' => $full_name,
              'shop_name' => $shop_name,
              'email' => $email,
              'phone' => $phone,
              'landmark' => $area,
              'address' => $address,
              'state' => $state_id,
              'city' => $city_id,
              'device_type' => $device_type,
              'device_token' => $device_token,
              'estd_year' => $estd_year,
              'dl_no' => $dl_no,
              'tin_no' => $tin_no,
              'contact_person' => $contact_person,
              'contact_person_number' => $contact_person_number,
              'update_date' => $time
            );
            if ($result[0]['phone'] != $phone) {
              // $otp_token=mt_rand(100000,999999);
              $otp_token = $rand_letter = $this->randNumber();
              $sms_rturn = $this->sendOtpSms($rand_letter, $phone);
              $success_device_msg = "go to otp";
              $upd_arr['otp_varified'] = '0';
              $upd_arr['otp'] = $otp_token;
            }
            if (!empty($this->input->post('user_type'))) {
              $upd_arr['role'] = $this->input->post('user_type');
            }
            $update = $this->users_model->update_entry($upd_arr, 'user', $user_id, 'user_id');
            if (!empty($update)) {
              $where = array(
                'user_id' => $user_id
              );
              $select = 'role,first_name as full_name,email,phone as contact_number,address,landmark as area,state,city,dl_no as drug_lic_number,estd_year,tin_no as tin_number ,contact_person,contact_person_number';
              $retailer = $this->users_model->GetRecord($where, 'user', '', '', $select);
              if (count($retailer) > 0) {
                foreach($retailer as $retailer_val) {
                  $retailer_val['address'] = html_entity_decode($retailer_val['address']);
                  if ($retailer_val['state']) {
                    $states = $this->users_model->GetCityState('states', 'name', 'id', $retailer_val['state']);
                    $retailer_val['state'] = ($states[0]['name']) ? $states[0]['name'] : 'NA';
                  }
                  if ($retailer_val['city']) {
                    $cities = $this->users_model->GetCityState('cities', 'name', 'id', $retailer_val['city']);
                    $retailer_val['city'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
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
                  if ($retailer_val['contact_person'] != '') {
                    $contact_person = explode(',', $retailer_val['contact_person']);
                    $contact_person_mo = explode(',', $retailer_val['contact_person_number']);
                    $j = 1;
                    for ($i = 0; $i < count($contact_person); $i++) {
                      $con_both_arr[] = array(
                        'contact_name' => $contact_person[$i],
                        'contact_number' => $contact_person_mo[$i]
                      );
                      $j++;
                    }
                    $retailer_val['contact_person'] = $con_both_arr;
                    // unset($supplier['contact_person']);
                    unset($retailer_val['contact_person_number']);
                  }
                  else {
                    $retailer_val['contact_person'] = array();
                    // unset($supplier['contact_person']);
                    unset($retailer_val['contact_person_number']);
                  }
                  $retailer_val['role_name'] = $this->getRole($retailer_val['role']);
                }
                if ($otp_token == '') {
                  $message = array(
                    'error' => '0',
                    'message' => 'success',
                    'data' => $retailer_val
                  );
                  $this->set_response($message, REST_Controller::HTTP_OK);
                }
                else {
                  $message = array(
                    'error' => '1',
                    'message' => 'go to otp',
                    'data' => array(
                      'OTP' => $otp_token
                    )
                  );
                  $this->set_response($message, REST_Controller::HTTP_OK);
                }
              }
            }
            else {
              $message = array(
                'error' => '1',
                'message' => 'Your Profile Detail has not been Updated. Please Try Again'
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
            }
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*============================= Edit retailer profile ENDS ==============================*/
  /*GET PROFILE DATA STARTS */
  public function retailerProfileDetail_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $data = $_POST;
    if (empty($phone) || empty($device_type) || empty($user_id) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "user_id" => $data['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          $retailerDetail = array();
          $where = array(
            'user_id' => $user_id
          );
          $select = 'role,user_id,first_name as retailer_name,email,phone as contact_number,address,landmark as area,state,city,shop_name,status,dl_no as drug_lic_no,estd_year,tin_no as tin_number,contact_person,contact_person_number';
          $retailer = $this->users_model->GetRecord($where, 'user', '', '', $select);
          if (count($retailer) > 0) {
            foreach($retailer as $retailer_val) {
              $retailer_val['address'] = html_entity_decode($retailer_val['address']);
              if ($retailer_val['state']) {
                $retailer_val['state_id'] = $retailer_val['state'];
                $states = $this->users_model->GetCityState('states', 'name', 'id', $retailer_val['state']);
                $retailer_val['state'] = ($states[0]['name']) ? $states[0]['name'] : 'NA';
              }
              if ($retailer_val['city']) {
                $retailer_val['city_id'] = $retailer_val['city'];
                $cities = $this->users_model->GetCityState('cities', 'name', 'id', $retailer_val['city']);
                $retailer_val['city'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
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
              if ($retailer_val['contact_person'] != '') {
                $contact_person = explode(',', $retailer_val['contact_person']);
                $contact_person_mo = explode(',', $retailer_val['contact_person_number']);
                $j = 1;
                for ($i = 0; $i < count($contact_person); $i++) {
                  $con_both_arr[] = array(
                    'contact_name' => $contact_person[$i],
                    'contact_number' => $contact_person_mo[$i]
                  );
                  $j++;
                }
                $retailer_val['contact_person'] = $con_both_arr;
                // unset($supplier['contact_person']);
                unset($retailer_val['contact_person_number']);
              }
              else {
                $retailer_val['contact_person'] = array();
                // unset($supplier['contact_person']);
                unset($retailer_val['contact_person_number']);
              }
              $retailer_val['role_name'] = $this->getRole($retailer_val['role']);
              // $retailerDetail[]=$retailer_val;
            }
            // $data_arr['retailer']=$retailerDetail;
            $message = array(
              'error' => '0',
              'message' => 'success',
              'data' => $retailer_val
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'Invalid User Details'
            );
            $this->set_response($error, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
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
    $base_url = "../uploads/notfoundfile";
    $phone = $this->input->post('mobile_no');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $product_name = trim($this->input->post('product_name'));
    $description = trim($this->input->post('description'));
    $request_type = trim($this->input->post('request_type'));
    $file_name = $_FILES['file_name']['name'];
    $issue = $this->input->post('issue');
    $data = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token) || empty($issue) || empty($description) || empty($product_name)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          // ------Upload not found file pic--------
          $data_pic = '';
          $fileName = '';
          $file_name = $_FILES['file_name']['name'];
          if ($file_name) {
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $fileName = uniqid() . time() . '.' . $ext;
          }
          $config['upload_path'] = $base_url;
          $config['allowed_types'] = '*';
          $config['max_size'] = '10240';
          $config['create_thumb'] = TRUE;
          $config['encrypt_name'] = false;
          $config['file_name'] = $fileName;
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload('file_name')) {
            $error = array(
              'error' => $this->upload->display_errors()
            );
            // print_r($error);die;
          }
          else {
            $data_pic = array(
              'upload_data' => $this->upload->data()
            );
          }
          $full_path = '';
          if ($data_pic) {
            $image_url = $data_pic['upload_data']['file_name'];
            $full_path = $data_pic['upload_data']['full_path'];
          }
          else {
            $image_url = "0";
          }
          // end not found file
          $user_id = $result[0]['user_id'];
          $req_arr = array(
            'retailer_id' => $user_id,
            'file_name' => $fileName,
            'issue' => $issue,
            'issue_description' => $description,
            'search_keyword' => $product_name
          );
          $insert_id = $this->users_model->InsertData('not_found_request', $req_arr);
          if ($insert_id) {
            $from_email = $result[0]['email'];
            // $from_email="rahulnakum.syscraft@gmail.com";
            if ($request_type == '1') {
              $subject = "PNFR " . $result[0]['phone'] . " " . $result[0]['shop_name'];
              $message = "<div><p>Hello Admin,</p>
            <p> Please upload the requested Medicine/Product on the App.</p>
            <p> Medicine Name: " . $product_name . "</p>
            <p>Description: " . $description . " </p><br />  
            Thanks<br />" . $result[0]['first_name'] . "
            <br /></div>";
              $this->send_email('', $from_email, $subject, $message, $fileName);
            }
            else if ($request_type == '2') {
              $subject = "CNFR " . $result[0]['phone'] . " " . $result[0]['shop_name'];
              $message = "<div><p>Hello Admin,</p>
            <p> Please provide the details of requested Company on the App.</p>
            <p> Company Name: " . $product_name . "</p>
            <p>Description: " . $description . " </p><br />  
            Thanks<br />" . $result[0]['first_name'] . "
            <br /></div>";
              $this->send_email('', $from_email, $subject, $message, $fileName);
            }
            $message = array(
              'error' => '0',
              'message' => 'Your request has been sent successfully'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '1',
              'message' => 'Your request has not been sent'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function send_email($to_email, $from_email, $subject, $message, $fileName)

  {
    $this->load->library('email');
    $this->load->helper('path');
    $config['protocol'] = 'sendmail';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
    $config['priority'] = '1';
    $config['charset'] = 'utf-8';
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
    $this->email->initialize($config);
    // $to_email='notify.listapp@gmail.com';
    // $from_email='notify.listapp@gmail.com';
    $from_email = 'rahulnakum.syscraft@gmail.com';
    $to_email = 'rahulnakum.syscraft@gmail.com';
    /*$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
    $this->email->set_header('Content-type', 'text/html');*/
    // $this->email->set_header('MIME-Version', '1.0; charset=iso-8859-1');
    // $this->email->set_header('Content-type', 'multipart/mixed');
    $this->email->from($from_email, 'ListApp');
    $this->email->to($to_email);
    // $this->email->cc('nivesh.syscraft@gmail.com,sankalp.syscraft@gmail.com,rahulnakum.syscraft@gmail.com');
    $this->email->subject($subject);
    $this->email->message($message);
    if ($fileName) {
      $attechment = set_realpath('../uploads/notfoundfile/') . $fileName;
      $this->email->attach($attechment);
    }
    $send = $this->email->send();
    unlink($attechment);
    return $send;
    // print_r($this->email->print_debugger()); die;
  }
  /*================ Request Not Found Data ends =========================*/
  /*======= Get Company Details Starts =====================*/
  public function companyDetail_post()

  {
    $user_id = $this->input->post('user_id');
    $phone = $this->input->post('mobile_no');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $company_id = $this->input->post('company_id');
    $offset = $this->input->post('offset');
    $data = $_POST;
    if (empty($company_id) || empty($phone) || empty($device_token) || empty($user_id) || empty($device_type)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "user_id" => $data['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          if ($offset == 0) {
            $where_company = array(
              'company_id' => $company_id,
              'status' => 1
            );
            $data1['company_detail'] = $this->users_model->GetRecord($where_company, 'company');
          }
          if ($offset > 0) {
            $offset = $offset * 50;
          }
          $no_of_records = 50;
          $like = array(
            'status' => 1
          );
          // $select='supplier_id, name as supplier_name,shop_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal';
          // $suppliers=$this->users_model->searchWithLike('supplier',$select,$like,$offset,$no_of_records);
          // $suppliers=$this->users_model->searchWithLike('supplier',$select,$like);
          $sql_s = "SELECT supplier_id, name as supplier_name, address as supplier_address,city as city_name, authe_no_authe as authorised_status,company_deal,shop_name FROM `m16j_supplier` WHERE FIND_IN_SET ('" . $company_id . "', `company_deal`) AND status ='1' LIMIT $offset, $no_of_records ";
          $suppliers = $this->db->query($sql_s)->result_array();
          if (empty($suppliers)) {
            $message = array(
              'error' => '1',
              'message' => 'No Supplier found'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $supplierNear = array();
            foreach($suppliers as $supplier) {
              /*  $company_name=explode(',', $supplier['company_deal']);
              if(in_array($company_id, $company_name))
              {*/
              $supplier['supplier_address'] = html_entity_decode($supplier['supplier_address']);
              /*if($supplier['state']){
              $states=$this->users_model->GetCityState('states','name','id',$supplier['state']);
              $supplier['state']=($states[0]['name'])?$states[0]['name']:'NA';
              }*/
              if ($supplier['city_name']) {
                $cities = $this->users_model->GetCityState('cities', 'name', 'id', $supplier['city_name']);
                $supplier['city_name'] = ($cities[0]['name']) ? $cities[0]['name'] : 'NA';
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
              $supplierNear[] = $supplier;
              // }
            }
            if (!empty($supplierNear)) {
              $data1['suppliers'] = $supplierNear;
            }
            else {
              $data1['suppliers'] = array();
            }
            $message = array(
              'error' => '0',
              'message' => 'success',
              'data' => $data1
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
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
    $base_url = "../uploads/notfoundfile";
    $phone = $this->input->post('mobile_no');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $keyword = trim($this->input->post('keyword'));
    // $name   =  trim($this->input->post('name'));
    $description = trim($this->input->post('description'));
    $file_name = $_FILES['file_name']['name'];
    $issue = $this->input->post('issue');
    $data = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token) || empty($keyword) || empty($issue) || empty($description)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          // ------Upload not found file pic--------
          $data_pic = '';
          $fileName = '';
          $file_name = $_FILES['file_name']['name'];
          if ($file_name) {
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $fileName = uniqid() . time() . '.' . $ext;
          }
          $config['upload_path'] = $base_url;
          $config['allowed_types'] = '*';
          $config['max_size'] = '10240';
          $config['create_thumb'] = TRUE;
          $config['encrypt_name'] = false;
          $config['file_name'] = $fileName;
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload('file_name')) {
            $error = array(
              'error' => $this->upload->display_errors()
            );
            // print_r($error);die;
          }
          else {
            $data_pic = array(
              'upload_data' => $this->upload->data()
            );
          }
          $full_path = '';
          if ($data_pic) {
            $image_url = $data_pic['upload_data']['file_name'];
            $full_path = $data_pic['upload_data']['full_path'];
          }
          else {
            $image_url = "0";
          }
          // end not found file
          $user_id = $result[0]['user_id'];
          $req_arr = array(
            'retailer_id' => $user_id,
            'file_name' => $fileName,
            'issue' => $issue,
            'issue_description' => $description,
            'search_keyword' => $keyword
          );
          $insert_id = $this->users_model->InsertData('not_found_request', $req_arr);
          if ($insert_id) {
            $from_email = $result[0]['email'];
            // $from_email="rahulnakum.syscraft@gmail.com";
            $subject = "SNFR " . $result[0]['phone'] . " " . $result[0]['shop_name'];
            $message = "<div><p>Hello Admin,</p>
          <p> Please provide the details of requested supplier in App for " . $keyword . "</p>    
          <p>Description: " . $description . " </p><br />  
          Thanks<br />" . $result[0]['first_name'] . "
          <br /></div>";
            $this->send_email('', $from_email, $subject, $message, $fileName);
            $message = array(
              'error' => '0',
              'message' => 'Your request has been sent successfully'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '1',
              'message' => 'Your request has not been sent'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*======== CODE FOR CHANGE MOBILE NUMBER STARTS ==========================*/
  public function SendOtpForNew_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $new_mobile_no = $this->input->post('new_mobile_no');
    $user_id = $this->input->post('user_id');
    $data1 = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token) || empty($user_id) || empty($new_mobile_no)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data1['mobile_no'],
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $whereNotIn = array(
            $user_id
          );
          $where2 = array(
            'phone' => $new_mobile_no
          );
          $mobile_number_exist = $this->users_model->GetRecord($where2, 'user', 'user_id', $whereNotIn);
          if (empty($mobile_number_exist)) {
            $user_id = $result[0]['user_id'];
            // $otp=mt_rand(100000,999999);
            $otp = $rand_letter = $this->randNumber();
            $sms_rturn = $this->sendOtpSms($rand_letter, $new_mobile_no);
            $arr = array(
              'new_mo_otp' => $otp,
              'new_otp_varified' => '0',
              'new_mobile_no' => $new_mobile_no,
            );
            $data_1 = $this->users_model->updateOTP('user', $user_id, $arr);
            $OTP['OTP'] = $otp;
            $message = array(
              'error' => '0',
              'message' => 'OTP has been sent on Your Mobile',
              'data' => $OTP
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $final_data = array(
              'error' => '1',
              'message' => 'User with this Mobile Number Already Exists'
            );
            $this->set_response($final_data, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*Check OTP VALIDATE*/
  public function otpVerifyNew_post()

  {
    $new_mobile_no = $this->input->post('new_mobile_no');
    $phone = $this->input->post('mobile_no');
    $new_otp = $this->input->post('new_otp');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $user_id = $this->input->post('user_id');
    $data = $_POST;
    if (empty($new_mobile_no) || empty($new_otp) || empty($device_type) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        'user_id' => $user_id,
        'status' => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          if ($result[0]['new_mo_otp'] == $data['new_otp']) {
            $user_id = $result[0]['user_id'];
            $upd_arr = array(
              'new_mo_otp' => $new_mo_otp,
              'new_otp_varified' => 1,
              'phone' => $new_mobile_no
            );
            $update = $this->users_model->update_entry($upd_arr, 'user', $user_id, 'user_id');
            if (!empty($update)) {
              $message = array(
                'error' => '0',
                'message' => 'Your Mobile number has been Updated successfully',
                'data' => array(
                  'user_id' => $user_id
                )
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
            }
            else {
              $message = array(
                'error' => '1',
                'message' => 'Your Mobile number has not been Updated. Please Try Again'
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
            }
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'Invalid OTP'
            );
            $this->set_response($error, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*Check OTP VALIDATE ends */
  /*======== CODE FOR CHANGE MOBILE NUMBER Ends ==========================*/
  /*======== CODE FOR NOTIFICATION STARTS ==========================*/
  public function getNotification_post()

  {
    header('Content-Type: text/html; charset=utf-8');
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = trim($this->input->post('device_token'));
    $data = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token) || empty($user_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          $notifications = $notifications = $this->users_model->GetRecord_order('notifications', array(
            "notification_user_id" => $user_id
          ) , 'notification_date', 'DESC', '');
          // $noti_result = $notifications->result_array();
          $post_arr = array();
          // print_r($notifications); die;
          foreach($notifications as $noti_value) {
            $title = htmlentities((string)$noti_value['notification_title'], ENT_QUOTES, 'utf-8', FALSE);
            $meassage = htmlentities((string)$noti_value['notification_message'], ENT_QUOTES, 'utf-8', FALSE);
            $post_arr[] = array(
              'notification_id' => $noti_value['notification_id'],
              'type' => $noti_value['notification_type'],
              'title' => $title,
              'meassage' => html_entity_decode($meassage),
              'read' => $noti_value['is_read'],
              'date' => date('d-m-Y', strtotime($noti_value['notification_date'])) ,
              'time' => date('h:i A', strtotime($noti_value['notification_date'])) ,
              'current_date' => date('d-m-Y')
            );
          }
          if (!empty($post_arr)) {
            // $upd_arr=array('is_read'=> 1);
            // $update=$this->users_model->update_entry($upd_arr,'notifications', $user_id,'notification_user_id');
            $message = array(
              'error' => '0',
              'message' => 'scuccess',
              'data' => $post_arr
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '1',
              'message' => 'No notifications for this user'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          // }else{
          //   $message = array('error'=>'1','message'=>'New password must not same as old password');
          //   $this->set_response($message, REST_Controller::HTTP_OK);
          // }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*======== CODE FOR FOR NOTIFICATION Ends ==========================*/
  public function readNotification_post()

  {
    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = trim($this->input->post('device_token'));
    $notification_id = $this->input->post('notification_id');
    $notification_type = $this->input->post('notification_type');
    $data = $_POST;
    if (empty($phone) || empty($device_type) || empty($device_token) || empty($user_id) || empty($notification_id) || empty($notification_type)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          $update_data = array(
            'is_read' => 1
          );
          $where = array(
            'notification_id' => $notification_id,
            'notification_user_id' => $user_id,
            'notification_type' => $notification_type
          ); //'notification_id'=>$notification_id,
          $this->common_model->update_entry('notifications', $update_data, $where);
          $final_data = array(
            'error' => '0',
            'message' => 'success',
            'is_read' => '1'
          );
          $this->set_response($final_data, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*=============== Unread Notification coun Starts =========================*/
  public function UnreadNotification_post()

  {
    $user_id = $this->input->post('user_id');
    $device_token = $this->input->post('device_token');
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $select = "COUNT(`notification_id`) as unread";
          $where = array(
            'notification_user_id' => $data1['user_id'],
            'is_read' => 2
          );
          $unread = $this->users_model->GetRecord($where, 'notifications', '', '', $select);
          $unread_count['unread'] = intval($unread[0]['unread']);
          $error = array(
            'error' => '0',
            'message' => 'success',
            'data' => $unread_count
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*=============== Unread Notification coun ends =========================*/
  public function getVowel($string = '')

  {
    // get the input value and convert string to lowercase
    $string = strtolower($string);
    // all vowels in array
    $vowels = array('a','e','i','o','u');
    // find length of the string
    $len = strlen($string);
    $num = 0;
    // loop through each letter
    for ($i = 0; $i < $len; $i++) {
      if (in_array($string[$i], $vowels)) {
        $num++;
      }
    }
    return $num;
  }
  public function get_user_details($user_id = '')

  {
    if (empty($user_id)) {
      return $user_id;
    }
    $user_details = $this->users_model->get_all_entries('user', array(
      'fields' => array(
        'role' => array(
          'role_id as Role_id ,role_name as Role_Name'
        ) ,
        'user' => array(
          'user_id as User_ID,first_name as Full_Name,email As Email,phone as Contact_Number,address as Address,landmark as Area,shop_name as Shop_Name,status'
        ) ,
        'states' => array(
          'name as State',
          'id as Stateid'
        ) ,
        'cities' => array(
          'name as City',
          'id as Stateid'
        ) ,
      ) ,
      'sort' => 'user.user_id',
      'sort_type' => 'asc',
      //   'start'    => 0,
      // 'limit'    => 4,
      'joins' => array(
        'role' => array(
          'role_id',
          'role'
        ) ,
        'states' => array(
          'id',
          'state'
        ) ,
        'cities' => array(
          'id',
          'city'
        ) ,
      ) ,
      'custom_where' => "user.user_id='" . $user_id . "'",
    ));
    // print_r($user_details);die;
    return $user_details[0];
  }
  public function screen_history_post()

  {
    $user_id = $this->input->post('user_id');
    $device_token = $this->input->post('device_token');
    $screen_visit = $this->input->post('screen_visit');
    $curr_date = date('Y-m-d H:i:s');
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($screen_visit)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          if (is_array($screen_visit)) {
            $screen_visit = implode(',', $screen_visit);
          }
          $insertArr = array(
            'user_id' => $user_id,
            'screen_visit' => $screen_visit,
            'created_date' => $curr_date
          );
          $this->users_model->InsertData('login_history', $insertArr);
          $error = array(
            'error' => '0',
            'message' => 'success'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function product_search_log_post()
  {
    $user_id = $this->input->post('user_id');
    $product_id = $this->input->post('product_id');
    $search_text = trim($this->input->post('search_text'));
    $supplier_id = trim($this->input->post('supplier_id'));
    $data1 = $_POST;
    if (empty($user_id) || empty($product_id) || empty($search_text)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        $check_ps = $this->db->get_where('product_search_log', array(
          "user_id" => $user_id,
          'search_text' => $search_text,
          'product_id' =>$product_id
        ));
        $check_plog = $check_ps->result_array();
        if (!empty($check_plog) && !empty($check_plog[0]['ps_id'])) {
          $pl_count = $check_plog[0]['pl_count'] + 1;
          $ps_id = $check_plog[0]['ps_id'];
          $supp_ids = $check_plog[0]['supplier_id'];
          $where = array(
            'ps_id' => $ps_id,
            'user_id' => $user_id
          );
          $plogArr = array(
            'user_id' => $user_id,
            'search_text' => $search_text,
            'product_id' => $product_id,
            'pl_count' => $pl_count,
            'created_date' => date('Y-m-d H:i:s')
          );
          if(!empty($supplier_id) && !is_array($supplier_id)){
             $plogArr['supplier_id'] =$supp_ids.','.$supplier_id; 
          }elseif(is_array($supplier_id)){
            $plogArr['supplier_id'] =$supp_ids.','.implode(',', $supplier_id);           
          }
          $save = $this->users_model->UpdateData('product_search_log', $plogArr, $where);
        }
        else {
          $plogArr = array(
            'user_id' => $user_id,
            'search_text' => $search_text,
            'product_id' => $product_id,
            'pl_count' => 1,
            'created_date' => date('Y-m-d H:i:s')
          );
          if(!empty($supplier_id) && !is_array($supplier_id)){
             $plogArr['supplier_id'] =$supplier_id; 
          }elseif(is_array($supplier_id)){
            $plogArr['supplier_id'] =implode(',', $supplier_id);           
          }
          $save = $this->users_model->InsertData('product_search_log', $plogArr);
        }
        if ($save) {
          $error = array(
            'error' => '0',
            'message' => 'Log has been Added Successfully'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Log has not been Added. Pleas Try Again'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function company_search_log_post()
  {
    $user_id = $this->input->post('user_id');
    $company_id = $this->input->post('company_id');
    $search_text = trim($this->input->post('search_text'));
    $data1 = $_POST;
    if (empty($user_id) || empty($company_id) || empty($search_text)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        $check_cs = $this->db->get_where('company_search_log', array(
          "user_id" => $user_id,
          'search_text' => $search_text,
          'company_id' => $company_id
        ));
        $check_clog = $check_cs->result_array();
        if (!empty($check_clog) && !empty($check_clog[0]['cs_id'])) {
          $cl_count = $check_clog[0]['cl_count'] + 1;
          $cs_id = $check_plog[0]['cs_id'];
          $where = array(
            'cs_id' => $cs_id,
            'user_id' => $user_id
          );
          $clogArr = array(
            'user_id' => $user_id,
            'search_text' => $search_text,
            'company_id' => $company_id,
            'cl_count' => $cl_count,
            'created_date' => date('Y-m-d H:i:s')
          );
          $save = $this->users_model->UpdateData('company_search_log', $clogArr, $where);
        }
        else {
          $clogArr = array(
            'user_id' => $user_id,
            'search_text' => $search_text,
            'company_id' => $company_id,
            'cl_count' => 1,
            'created_date' => date('Y-m-d H:i:s')
          );
          $save = $this->users_model->InsertData('company_search_log', $clogArr);
        }
        if ($save) {
          $error = array(
            'error' => '0',
            'message' => 'Log has been Added Successfully'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Log has not been Added. Pleas Try Again'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function supplier_search_log_post()
  {
    $user_id = $this->input->post('user_id');
    $supplier_id = $this->input->post('supplier_id');
    $search_text = trim($this->input->post('search_text'));
    $data1 = $_POST;
    if (empty($user_id) || empty($supplier_id) || empty($search_text)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        $check_ss = $this->db->get_where('supplier_search_log', array(
          "user_id" => $user_id,
          'search_text' => $search_text,
          'supplier_id' => $supplier_id
        ));
        $check_slog = $check_ss->result_array();
        if (!empty($check_slog) && !empty($check_slog[0]['ss_id'])) {
          $sl_count = $check_slog[0]['sl_count'] + 1;
          $ss_id = $check_slog[0]['ss_id'];
          $where = array(
            'ss_id' => $ss_id,
            'user_id' => $user_id
          );
          $slogArr = array(
            'user_id' => $user_id,
            'search_text' => $search_text,
            'supplier_id' => $supplier_id,
            'sl_count' => $sl_count,
            'created_date' => date('Y-m-d H:i:s')
          );
          $save = $this->users_model->UpdateData('supplier_search_log', $slogArr, $where);
        }
        else {
          $slogArr = array(
            'user_id' => $user_id,
            'search_text' => $search_text,
            'supplier_id' => $supplier_id,
            'sl_count' => 1,
            'created_date' => date('Y-m-d H:i:s')
          );
          $save = $this->users_model->InsertData('supplier_search_log', $slogArr);
        }
        if ($save) {
          $error = array(
            'error' => '0',
            'message' => 'Log has been Added Successfully'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Log has not been Added. Pleas Try Again'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function getRole($role_id = '')

  {
    $where = array(
      'role_id' => $role_id
    );
    $role = $this->db->get_where('role', array(
      'role_id' => $role_id
    ));
    $role_res = $role->result();
    if (!empty($role_res)) {
      return $role_res[0]->role_name;
    }
    else {
      return false;
    }
  }
  public function upload_product_csv_post()

  {
    $this->load->library('email');
    $this->load->helper('path');
    $base_url = "../uploads/notfoundfile";
    $phone = $this->input->post('mobile_no');
    $device_token = $this->input->post('device_token');
    $description = trim($this->input->post('description'));
    $file_name = $_FILES['product_csv_file']['name'];
    $data = $_POST;
    if (empty($phone) || empty($device_token) || empty($description) || empty($file_name)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data['mobile_no'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data['device_token']) {
          // ------Upload not found file pic--------
          $data_pic = '';
          $fileName = '';
          $file_name = $_FILES['product_csv_file']['name'];
          if ($file_name) {
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            if (strtolower($ext) != "csv" && !empty($ext)) {
              $final_data = array(
                'error' => '1',
                'message' => 'Please upload file in CSV format'
              );
              $this->set_response($final_data, REST_Controller::HTTP_OK);
              return;
            }
            $fileName = uniqid() . time() . '.' . $ext;
          }
          $config['upload_path'] = $base_url;
          $config['allowed_types'] = 'csv';
          $config['max_size'] = '10240';
          $config['create_thumb'] = TRUE;
          $config['encrypt_name'] = false;
          $config['file_name'] = $fileName;
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload('product_csv_file')) {
            $error = array(
              'error' => $this->upload->display_errors()
            );
            // print_r($error);die;
          }
          else {
            $data_pic = array(
              'upload_data' => $this->upload->data()
            );
          }
          $full_path = '';
          if ($data_pic) {
            $image_url = $data_pic['upload_data']['file_name'];
            $full_path = $data_pic['upload_data']['full_path'];
          }
          else {
            $image_url = "0";
          }
          // end not found file
          $user_id = $result[0]['user_id'];
          $req_arr = array(
            'retailer_id' => $user_id,
            'file_name' => $fileName,
            'issue' => 'suplier product list upload',
            'issue_description' => $description,
          );
          $insert_id = $this->users_model->InsertData('not_found_request', $req_arr);
          if ($insert_id) {
            $from_email = $result[0]['email'];
            $subject = "RPUC " . $result[0]['phone'] . " " . $result[0]['shop_name'];
            $message = "<div><p>Hello Admin,</p>
          <p> Please upload the CSV file.</p>            
          <p>Description: " . $description . " </p><br />  
          Thanks<br />" . $result[0]['first_name'] . "
          <br /></div>";
            $this->send_email('', $from_email, $subject, $message, $fileName);
            $message = array(
              'error' => '0',
              'message' => 'Your request has been sent successfully'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $message = array(
              'error' => '1',
              'message' => 'Your request has not been sent'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*---- fuction for sell post----*/
  // `m16j_product_sell_post`(`post_id`, `user_id`, `product_name`, `post_description`, `mrp`, `selling_price`, `margin`, `quantity`, `contact_detail`, `sold_status`, `product_expire_date`, `post_status`, `like_count`, `view_count`, `interested_user`, `created_date`, `updated_date`)
  public function sell_post_save_post()

  {
    $user_id = $this->input->post('user_id');
    $post_id = $this->input->post('post_id');
    $device_token = $this->input->post('device_token');
    $product_name = $this->input->post('product_name');
    $description = $this->input->post('description');
    $mrp = $this->input->post('mrp');
    $selling_price = $this->input->post('selling_price');
    $margin_per = $this->input->post('margin_persent');
    $margin_rupee = $this->input->post('margin_rupee');
    $quantity = $this->input->post('quantity');
    $contact_detail = $this->input->post('contact_detail');
    $expire_date = $this->input->post('expire_date');
    $curr_date = date('Y-m-d H:i:s');
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($product_name || $description) || empty($mrp) || empty($selling_price) || empty($margin_per) || empty($margin_rupee) || empty($quantity) || empty($contact_detail) || empty($expire_date)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $insertArr = array(
            'user_id' => $user_id,
            'product_name' => $product_name,
            'post_description' => $description,
            'mrp' => $mrp,
            'selling_price' => $selling_price,
            'margin' => $margin_per . '/' . $margin_rupee,
            'quantity' => $quantity,
            'contact_detail' => $contact_detail,
            'product_expire_date' => $expire_date,
            'created_date' => $curr_date,
          );
          if (!empty($post_id) && $post_id > 0) {
            $wh_sell = array(
              'post_id' => $post_id
            );
            $save = $this->users_model->UpdateData('product_sell_post', $insertArr, $wh_sell);
          }
          else {
            $save = $this->users_model->InsertData('product_sell_post', $insertArr);
          }
          if (!empty($save)) {
            $error = array(
              'error' => '0',
              'message' => 'Your post has been saved successfully'
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'Your post has not been saved. Please try again'
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function all_sell_post_post()

  {
    $user_id = $this->input->post('user_id');
    $device_token = $this->input->post('device_token');
    $before_7day = Date('Y-m-d', strtotime('today - 7 days'));
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $posts = $this->users_model->get_all_entries('product_sell_post', array(
            'fields' => array(
              'product_sell_post' => array(
                '*'
              ) ,
              'user' => array(
                'first_name as user_name,phone'
              ) ,
            ) ,
            'sort' => 'product_sell_post.created_date',
            'sort_type' => 'desc',
            //   'start'    => 0,
            // 'limit'    => 4,
            'joins' => array(
              'user' => array(
                'user_id',
                'user_id'
              ) ,
            ) ,
            'custom_where' => "product_sell_post.post_status='Active' AND product_sell_post.sold_status='Available' AND user.status='Active' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '" . $before_7day . "'",
          ));
          if (!empty($posts)) {
            $error = array(
              'error' => '0',
              'message' => 'success',
              'data' => $posts
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'No post Found',
              'data' => array()
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function view_sell_post_post()

  {
    $user_id = $this->input->post('user_id');
    $post_id = $this->input->post('post_id');
    $device_token = $this->input->post('device_token');
    $before_7day = Date('Y-m-d', strtotime('today - 7 days'));
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($post_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $post = $this->users_model->get_all_entries('product_sell_post', array(
            'fields' => array(
              'product_sell_post' => array(
                '*'
              ) ,
              'user' => array(
                'first_name as user_name,phone'
              ) ,
            ) ,
            'sort' => 'product_sell_post.created_date',
            'sort_type' => 'desc',
            //   'start'    => 0,
            // 'limit'    => 4,
            'joins' => array(
              'user' => array(
                'user_id',
                'user_id'
              ) ,
            ) ,
            'custom_where' => "product_sell_post.post_status='Active' AND product_sell_post.sold_status='Available' AND user.status='Active' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '" . $before_7day . "' AND product_sell_post.post_id='" . $post_id . "'",
          ));
          if (!empty($post)) {
            $error = array(
              'error' => '0',
              'message' => 'success',
              'data' => $post
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'No post Found',
              'data' => array()
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function sp_view_incr_post()

  {
    $user_id = $this->input->post('user_id');
    $post_id = $this->input->post('post_id');
    $device_token = $this->input->post('device_token');
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($post_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $post = $this->db->get_where('product_sell_post', array(
            "post_id" => $data1['post_id']
          ));
          $post_d = $post->result_array();
          if (!empty($post_d) && !empty($post_d[0]['post_id'])) {
            $db_view = intval($post_d[0]['view_count'] + 1);
            $upd_view = array(
              'view_count' => $db_view
            );
            $wh_p = array(
              'post_id' => $post_d[0]['post_id']
            );
            $save = $this->users_model->UpdateData('product_sell_post', $upd_view, $wh_p);
            $error = array(
              'error' => '0',
              'message' => 'success'
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'failed'
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function sp_intrested_user_post()

  {
    $user_id = $this->input->post('user_id');
    $post_id = $this->input->post('post_id');
    $device_token = $this->input->post('device_token');
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($post_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $post = $this->db->get_where('product_sell_post', array(
            "post_id" => $data1['post_id']
          ));
          $post_d = $post->result_array();
          if (!empty($post_d) && !empty($post_d[0]['post_id'])) {
            $interested_user = $post_d[0]['interested_user'];
            $inter_user = explode(',', $interested_user);
            if (!in_array($user_id, $inter_user) && !empty($inter_user) && !empty($user_id)) {
              array_push($inter_user, $user_id);
              $all_int_u = implode(',', array_filter(array_unique($inter_user)));
              $like_count = intval($post_d[0]['like_count'] + 1);
            }
            else {
              $key = array_search($user_id, $inter_user); // Returns 2.
              array_splice($inter_user, $key, 1);
              $all_int_u = implode(',', array_filter(array_unique($inter_user)));
              $like_count = intval($post_d[0]['like_count'] - 1);
              if ($like_count < 0) {
                $like_count = 0;
              }
            }
            $upd_int = array(
              'like_count' => $like_count,
              'interested_user' => $all_int_u
            );
            // print_r($upd_int);die;
            $wh_p = array(
              'post_id' => $post_d[0]['post_id']
            );
            $save = $this->users_model->UpdateData('product_sell_post', $upd_int, $wh_p);
            $error = array(
              'error' => '0',
              'message' => 'success'
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'failed'
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function sp_change_status_post()

  {
    $user_id = $this->input->post('user_id');
    $post_id = $this->input->post('post_id');
    $device_token = $this->input->post('device_token');
    $sold_status = $this->input->post('sold_status');
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($post_id) || empty($sold_status)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      if (!in_array($sold_status, array(
        'Available',
        'Sold'
      ))) {
        $final_data = array(
          'error' => '1',
          'message' => 'Status value must be Available or Sold'
        );
        $this->set_response($final_data, REST_Controller::HTTP_OK);
        return;
      }
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $post = $this->db->get_where('product_sell_post', array(
            "post_id" => $data1['post_id'],
            'user_id' => $data1['user_id']
          ));
          $post_d = $post->result_array();
          if (!empty($post_d)) {
            $upd_int = array(
              'sold_status' => $sold_status
            );
            $wh_p = array(
              'post_id' => $post_d[0]['post_id'],
              'user_id' => $post_d[0]['user_id']
            );
            $save = $this->users_model->UpdateData('product_sell_post', $upd_int, $wh_p);
            $error = array(
              'error' => '0',
              'message' => 'Post status has been changed successfully'
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'Something went wrong. Please try again'
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*---- fuction for sell post----*/
  /*---- fuction for hiring post----*/
  public function hire_post_save_post()

  {
    $user_id = $this->input->post('user_id');
    $post_id = $this->input->post('post_id');
    $device_token = $this->input->post('device_token');
    $title = $this->input->post('hire_title');
    $description = $this->input->post('description');
    $no_of_jobs = $this->input->post('no_of_jobs');
    $contact_detail = $this->input->post('contact_detail');
    $curr_date = date('Y-m-d H:i:s');
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($title) || empty($description) || empty($no_of_jobs) || empty($contact_detail)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          // `user_id`, `title`, `description`, `no_of_jobs`, `contact_detail`, `like_count`, `view_count`, `hire_status`, `post_status`, `created_date`, `updated_date`
          $insertArr = array(
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'no_of_jobs' => $no_of_jobs,
            'contact_detail' => $contact_detail,
            'created_date' => $curr_date,
          );
          if (!empty($post_id) && $post_id > 0) {
            $wh_sell = array(
              'post_id' => $post_id
            );
            $save = $this->users_model->UpdateData('hiring_post', $insertArr, $wh_sell);
          }
          else {
            $save = $this->users_model->InsertData('hiring_post', $insertArr);
          }
          if (!empty($save)) {
            $error = array(
              'error' => '0',
              'message' => 'Your post has been saved successfully'
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'Your post has not been saved. Please try again'
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function all_hiring_post_post()

  {
    $user_id = $this->input->post('user_id');
    $device_token = $this->input->post('device_token');
    $before_7day = Date('Y-m-d', strtotime('today - 7 days'));
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $posts = $this->users_model->get_all_entries('hiring_post', array(
            'fields' => array(
              'hiring_post' => array(
                '*'
              ) ,
              'user' => array(
                'first_name as user_name,phone'
              ) ,
            ) ,
            'sort' => 'hiring_post.created_date',
            'sort_type' => 'desc',
            //   'start'    => 0,
            // 'limit'    => 4,
            'joins' => array(
              'user' => array(
                'user_id',
                'user_id'
              ) ,
            ) ,
            'custom_where' => "hiring_post.post_status='Active' AND hiring_post.hire_status='Open' AND user.status='Active' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '" . $before_7day . "'",
          ));
          if (!empty($posts)) {
            $error = array(
              'error' => '0',
              'message' => 'success',
              'data' => $posts
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'No post Found',
              'data' => array()
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  public function view_hire_post_post()

  {
    $user_id = $this->input->post('user_id');
    $post_id = $this->input->post('post_id');
    $device_token = $this->input->post('device_token');
    $before_7day = Date('Y-m-d', strtotime('today - 7 days'));
    $data1 = $_POST;
    if (empty($user_id) || empty($device_token) || empty($post_id)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "user_id" => $data1['user_id'],
        "status" => 'Active'
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['device_token'] == $data1['device_token']) {
          $post = $this->users_model->get_all_entries('hiring_post', array(
            'fields' => array(
              'hiring_post' => array(
                '*'
              ) ,
              'user' => array(
                'first_name as user_name,phone'
              ) ,
            ) ,
            'sort' => 'hiring_post.created_date',
            'sort_type' => 'desc',
            //   'start'    => 0,
            // 'limit'    => 4,
            'joins' => array(
              'user' => array(
                'user_id',
                'user_id'
              ) ,
            ) ,
            'custom_where' => "hiring_post.post_status='Active' AND hiring_post.hire_status='Open' AND user.status='Active' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '" . $before_7day . "' AND hiring_post.post_id='" . $post_id . "'",
          ));
          if (!empty($post)) {
            $error = array(
              'error' => '0',
              'message' => 'success',
              'data' => $post
            );
          }
          else {
            $error = array(
              'error' => '1',
              'message' => 'No post Found',
              'data' => array()
            );
          }
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your session has been expired'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Your account has been deactivated by administrator'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  }
  /*---- fuction for hiring post----*/

  //get search city
  public function get_city_for_search_post()
  {    
    error_reporting(1);
    $phone = $this->input->post('mobile_no'); 
    $device_token = $this->input->post('device_token');
    $data1 = $_POST;
    if (empty($phone)  || empty($device_token)) {
      $final_data = array(
        'error' => '1',
        'message' => 'Please Provide all information'
      );
      $this->set_response($final_data, REST_Controller::HTTP_OK);
    }
    else {
      $query_phone = $this->db->get_where('user', array(
        "phone" => $data1['mobile_no']
      ));
      $result = $query_phone->result_array();
      if (!empty($result)) {
        if ($result[0]['status'] === 'Active') {
          $d_C= $this->users_model->get_all_entries('search_city_list', array(
            'fields' => array(
                'search_city_list' => array('city_id'),
                'cities' => array('name as city_name'),
                //'states' => array('name as state_name'),
                            ),
            'sort'    => 'cities.name',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'cities' => array('id','city_id','inner'),  
          //'states' => array('id','state_id','inner'),             
            ),    
       //'custom_where' => "user.user_id='".$user_id."' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '".$date."'",
        )); 
          if(!empty($d_C)){
            $message = array(
              'error' => '0',
              'message' => 'success',
              'data' => $d_C
            );            
          }else{
            $message = array(
              'error' => '1',
              'message' => 'No city has been set for search',
              );  
          }
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
        else {
          $error = array(
            'error' => '1',
            'message' => 'Your account has been deactivated by administrator'
          );
          $this->set_response($error, REST_Controller::HTTP_OK);
        }
      }
      else {
        $error = array(
          'error' => '1',
          'message' => 'Mobile number not registered with us'
        );
        $this->set_response($error, REST_Controller::HTTP_OK);
      }
    }
  
  }

  // fuction api error 
  public function error_log($api_name='',$post='',$msg='',$user_mob='')
  {  
      if(!empty($user_mob)){
        $query_phone = $this->db->get_where('api_error_log', array(
        "user_mobile" => $user_mob,
        "api_name" => $api_name
      ));
        $result =$query_phone->row();
        if(!empty($result)){
         $arr=array('user_mobile'=>$user_mob,'api_name'=>$api_name,'post_data'=>$post,'err_message'=>$msg);
         $wh_e=array('error_id'=>$result->error_id);
         $this->users_model->UpdateData('api_error_log', $arr,$wh_e);

        }else{
              $arr=array('user_mobile'=>$user_mob,'api_name'=>$api_name,'post_data'=>$post,'err_message'=>$msg);
              $this->users_model->InsertData('api_error_log', $arr);          
        }
      }else{
        $arr=array('user_mobile'=>$user_mob,'api_name'=>$api_name,'post_data'=>$post,'err_message'=>$msg);
        $this->users_model->InsertData('api_error_log', $arr);
      }
      
   
  }
} // REST controller End

?>