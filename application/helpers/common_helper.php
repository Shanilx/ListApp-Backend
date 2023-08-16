<?php
/* This helper contains c0mmon functions.*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
//function to generate aplha numeric random string, with a given length
function randomString($length = 6) 
{
    $alphabets = range('a','z');
    $numbers = range('1','9');
    $password = '';
    $final_array = array_merge($alphabets,$numbers);
    
    while($length--) 
    {
       $key = array_rand($final_array);
       $password .= $final_array[$key];
    }
    if (preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password))
    {
       return $password;
    }
    else
    {
       return  random_string();
    }

 }

 function ci_enc($str){
 $new_str = strtr(base64_encode(addslashes(@gzcompress(serialize($str), 9))), '+/=', '-_.');
 return $new_str; 
}

function ci_dec($str){
 $new_str = unserialize(@gzuncompress(stripslashes(base64_decode(strtr($str, '-_.', '+/=')))));
 return $new_str;
}

function get_data($id){
  $CI =& get_instance();

  $CI->db->select('*');

  $CI->db->from('admin');
  $CI->db->where('id',$id);
  $res = $CI->db->get();

  return $res->result_array();
}

function fdate($datevalue){
  $originalDate = $datevalue;
  $newDate = date("m-d-Y", strtotime($originalDate));
  return $newDate;
}

function fdatetime($datetimevalue){
  $originalDate = $datetimevalue;
  $newDate = date("m-d-Y H:i:s", strtotime($originalDate));
  return $newDate;
}


function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

 function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }


// function encode($value,$salt)
// { 
//         if(!$value){return false;}
//         $text = $value;
//         $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//         $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//         $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, $iv);
//         return trim(safe_b64encode($crypttext)); 
// }


// function decode($value,$salt)
// {
//         if(!$value){return false;}
//         $crypttext = safe_b64decode($value); 
//         $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//         $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//         $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, $crypttext, MCRYPT_MODE_ECB, $iv);
//         return trim($decrypttext);
// }



function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function fetch_pieChartColor($pos)
{
  $color_array = array(
                        '1'=>'002856',
                        '2'=>'8b1e41',
                        '3'=>'7da8ae',
                        '4'=>'62b4e4',
                        '5'=>'035d67'
                      );


  //Fetch the color from above mentioned array
  foreach($color_array as $key=>$value)
  {
    if($key==$pos)
    {
      return $value;
    }

  }

  //If partition is more than 5, then use random color function
  random_color();
  

}


//Fetch country, state or city name
function fetch_placeName($place, $place_id)
{ 
  $CI =& get_instance();

  $CI->db->select('name');

  if($place=="country")
  {
    $CI->db->from('countries');
  }
  elseif($place=="state")
  {
    $CI->db->from('states');
  }
  elseif($place=="city")
  {
    $CI->db->from('cities');
  }

  $CI->db->where('id',$place_id);
  $res = $CI->db->get();

  $place_name =  $res->result_array();

  return $place_name[0]['name'];


}


/*Get category*/
function getCountry()
{
  $CI =& get_instance();
  $CI->load->model('patient_model');
  $countries = $CI->patient_model->GetRecord('countries','','name', 'asc');
  ///echo '<pre>';print_r($countries);die;
  return $countries;
}


/*Get category*/
function getStateOption($country_id,$state_id)
{ 
  $CI =& get_instance();
  $where=array('country_id'=>$country_id);
  $state = $CI->patient_model->GetRecord('states',$where,'name', 'asc');
  //echo '<pre>';print_r($state);die;
  if(!empty($state))
    {
      echo '<option value="">--Select--</option>';
      foreach($state as $st)
      {
        if(!empty($state_id))
        {
          if($state_id==$st['id'])
          { 
            echo "<option selected='selected' value=".$st['id'].">".$st['name']."</option>";
          }
          else
          { 
            echo "<option value=".$st['id'].">".$st['name']."</option>";
          } 
        }
        else
        {
          echo "<option value=".$st['id'].">".$st['name']."</option>";
        }
      }
    }
    else
    {
      echo "<option value=".''.">NA</option>";
    }

  //return $countries;
}

/*Get category*/
function getCityOption($state_id,$city_id)
{
  $CI =& get_instance();
  $where=array('state_id'=>$state_id);
  $city = $CI->patient_model->GetRecord('cities',$where,'name', 'asc');
  //echo '<pre>';print_r($state);die;
  if(!empty($city))
    {
      echo '<option value="">--Select--</option>';
      foreach($city as $ct)
      {
        if(!empty($city_id))
        {
          if($city_id==$ct['id'])
          {
            echo "<option selected='selected' value=".$ct['id'].">".$ct['name']."</option>";
          }
          else
          {
            echo "<option value=".$ct['id'].">".$ct['name']."</option>";
          } 
        }
        else
        {
          echo "<option value=".$ct['id'].">".$ct['name']."</option>";
        }
      }
    }
    else
    {
      echo "<option value=".''.">NA</option>";
    }

  //return $countries;
}


/*Get category name*/
function getCategoryName($categoryId)
{
  $CI =& get_instance();
  $CI->db->select('category');
  $CI->db->from('doctor_category');
  $CI->db->where('id',$categoryId);
  $res = $CI->db->get();
  $data=$res->result_array();
  if(empty($data))
  {
     echo '--';
  }else{
     echo $data[0]['category'];
  }
}

/*function to split string in specified characters length, without splitting the words*/
function split_string($string)
{
    $output = array();
    while (strlen($string) > 40) {
        $index = strpos($string, ' ', 40);
        $output[] = trim(substr($string, 0, $index));
        $string = substr($string, $index);
    }
    $output[] = trim($string);
    return $output;
}

//function to get latitude and longitude of any city
function get_lat_long($city)
{
    $place = str_replace(' ', '+', $city);
    $geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".$place."&sensor=false");

    $output_deals = json_decode($geocode_stats);

    $latLng = $output_deals->results[0]->geometry->location;

    $lat = $latLng->lat;
    $lng = $latLng->lng;   
    //echo $lat." ".$lng; exit;
    return $lat." ".$lng;
    //return "0 0";
}

function calculate_distance($lat1, $lon1, $lat2, $lon2) 
{ 
  $theta = $lon1 - $lon2; 
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
  $dist = acos($dist); 
  $dist = rad2deg($dist); 
  $miles = $dist * 60 * 1.1515;
  
  return $miles;
      
} 

function editor($path,$width,$height='300px') {
    //Loading Library For Ckeditor
    $CI =& get_instance();
    $CI->load->library('ckeditor');
    $CI->load->library('ckFinder');
    //configure base path of ckeditor folder 
    //$CI->ckeditor->basePath = base_url().'js/ckeditor/';
    $CI->ckeditor->basePath = base_url().'js/ckeditor/';
    $CI->ckeditor->config['toolbar'] = 'Full';
    $CI->ckeditor->config['language'] = 'en';
    $CI->ckeditor->config['width'] = $width;
    $CI->ckeditor->config['height'] = $height;
    //configure ckfinder with ckeditor config 
    $CI->ckfinder->SetupCKEditor($CI->ckeditor,$path); 
  }

  function basic_editor($path,$width,$height='200px') {
    //Loading Library For Ckeditor
    $CI =& get_instance();
    $CI->load->library('ckeditor');
    $CI->load->library('ckFinder');
    //configure base path of ckeditor folder 
    //$CI->ckeditor->basePath = base_url().'js/ckeditor/';
    $CI->ckeditor->basePath = base_url().'js/ckeditor/';
    $CI->ckeditor->config['toolbar'] =
    [
      ['Source','Cut','Copy','Paste','Undo','Redo', '-','Bold','Italic','Underline','Strike', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'NumberedList', 'BulletedList'],[ 'Link', 'Unlink', '-', 'Styles','Format','Font','FontSize'],[ 'TextColor','BGColor']
    ];
    $CI->ckeditor->config['language'] = 'en';
    $CI->ckeditor->config['width'] = $width;
    $CI->ckeditor->config['height'] = $height;
          
    //configure ckfinder with ckeditor config 
    $CI->ckfinder->SetupCKEditor($CI->ckeditor,$path); 
  }

  function video_editor($path,$width,$height='200px') {
    //Loading Library For Ckeditor
    $CI =& get_instance();
    $CI->load->library('ckeditor');
    $CI->load->library('ckFinder');
    //configure base path of ckeditor folder 
    //$CI->ckeditor->basePath = base_url().'js/ckeditor/';
    $CI->ckeditor->basePath = base_url().'js/ckeditor/';
    $CI->ckeditor->config['toolbar'] =
    [
      ['Source','Cut','Copy','Paste','Undo','Redo', '-','Bold','Italic','Underline','Strike', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], ['NumberedList', 'BulletedList', 'Link', 'Unlink', '-', 'Styles','Format'],['Font','FontSize', 'TextColor','BGColor']
    ];
    $CI->ckeditor->config['language'] = 'en';
    $CI->ckeditor->config['width'] = $width;
    $CI->ckeditor->config['height'] = $height;
          
    //configure ckfinder with ckeditor config 
    $CI->ckfinder->SetupCKEditor($CI->ckeditor,$path); 
  }


  function html_cut($text, $max_length)
  {
      $tags   = array();
      $result = "";

      $is_open   = false;
      $grab_open = false;
      $is_close  = false;
      $in_double_quotes = false;
      $in_single_quotes = false;
      $tag = "";

      $i = 0;
      $stripped = 0;

      $stripped_text = strip_tags($text);

      while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
      {
          $symbol  = $text{$i};
          $result .= $symbol;

          switch ($symbol)
          {
             case '<':
                  $is_open   = true;
                  $grab_open = true;
                  break;

             case '"':
                 if ($in_double_quotes)
                     $in_double_quotes = false;
                 else
                     $in_double_quotes = true;

              break;

              case "'":
                if ($in_single_quotes)
                    $in_single_quotes = false;
                else
                    $in_single_quotes = true;

              break;

              case '/':
                  if ($is_open && !$in_double_quotes && !$in_single_quotes)
                  {
                      $is_close  = true;
                      $is_open   = false;
                      $grab_open = false;
                  }

                  break;

              case ' ':
                  if ($is_open)
                      $grab_open = false;
                  else
                      $stripped++;

                  break;

              case '>':
                  if ($is_open)
                  {
                      $is_open   = false;
                      $grab_open = false;
                      array_push($tags, $tag);
                      $tag = "";
                  }
                  else if ($is_close)
                  {
                      $is_close = false;
                      array_pop($tags);
                      $tag = "";
                  }

                  break;

              default:
                  if ($grab_open || $is_close)
                      $tag .= $symbol;

                  if (!$is_open && !$is_close)
                      $stripped++;
          }

          $i++;
      }

      while ($tags)
          $result .= "</".array_pop($tags).">";

      return $result;
  }


  function fetchStatus($status)
  { 
    $status_array = array();
    //If logged in user is a Doctor
    
    $status_array = array(
                            '1' => 'Pending',
                            '2' => 'Confirmed',
                            '3' => 'Canceled',
                            '4' => 'Rescheduled',
                            '5' => 'Declined',
                            '6' => 'Completed'
                          );

    return $status_array[$status];
    
  }

  //get no. of booked appointments 
  function total_booked_appointments($doc_id, $location_id, $app_date)
  {
    $CI =& get_instance();
    $CI->load->model('home_model');
    $bookings = $CI->home_model->get_all_entries('meeting_schedule', array(
              'fields' => array(
                  'meeting_schedule' => array('*'),
              ),
              'sort'    => 'meeting_schedule.app_date_time',
              'sort_type' => 'desc',
        //'custom_where' => "doc_id = '".$doc_id."' AND location_id='".$location_id."' AND app_date_time like '".$app_date."%' AND (app_status_by_doc = 2 OR app_status_by_patient = 2) AND (app_status_by_doc != 3 AND app_status_by_patient != 3) AND (app_status_by_doc != 6 AND app_status_by_patient != 6)",
          'custom_where' => "doc_id = '".$doc_id."' AND location_id='".$location_id."' AND app_date_time like '".$app_date."%' AND (appointment_status = 1 OR appointment_status = 4)",
          ));

    return count($bookings);
  }


  //fetch the no. of bookings limit set the database
  function total_limitBookings($doc_id, $location_id, $avail_date)
  {

    $CI =& get_instance();
    $CI->load->model('home_model');
    $bookings = $CI->home_model->get_all_entries('doctors_availability', array(
              'fields' => array(
                  'doctors_availability' => array('*'),
              ),
              'sort'    => 'doctors_availability.updated_date',
              'sort_type' => 'desc',
              'custom_where' => "doctor_id = '".$doc_id."' AND location_id='".$location_id."' AND all_dates like '%".$avail_date."%'",
          ));
    //echo "<pre>";
    //print_r($bookings); die;
    return $bookings[0]['user_limit'];

  }



  function classpurchaseduser($app_id)
  {
      $CI =& get_instance();
      $CI->load->model('home_model');
      $data=$CI->home_model->get_all_entries('meeting_schedule', array(
              'fields' => array(
                  'meeting_schedule' => array('*'),
              ),
              'sort'    => 'meeting_schedule.app_date_time',
              'sort_type' => 'desc',
        'custom_where' => "app_id = '".$app_id."'",
          ));

      $quickblox=array();
      $app_callees=array();
      if($data)
      {
            $dat_qb=$CI->home_model->get_all_entries('quickblox', array(
              'fields' => array(
                  'quickblox' => array('*'),
                  'user' => array('*'),
              ),
              'sort'    => 'quickblox.created_date',
              'sort_type' => 'desc',
              'joins' => array(
                'user' => array('user_id','user_id'),
                ),
        'custom_where' => "quickblox.user_id = '".$data[0]['patient_id']."'",
          ));
            
            $app_callees[]=array("id"=>$dat_qb[0]['quickblox_id'],'name'=>$dat_qb[0]['first_name']." ".$dat_qb[0]['last_name']);
        
      }
     // $app_callees=json_encode($app_array);
      return  $app_callees;
  }


  function GetConfiguser($app_id)
  {
      $CI =& get_instance();
      $CI->load->model('home_model');
      $data=$CI->home_model->get_all_entries('meeting_schedule', array(
              'fields' => array(
                  'meeting_schedule' => array('*'),
              ),
              'sort'    => 'meeting_schedule.app_date_time',
              'sort_type' => 'desc',
        'custom_where' => "app_id = '".$app_id."'",
          ));
      $quickblox=array();
      $app_callees=array();
      if($data)
      {
        
            $dat_qb=$CI->home_model->get_all_entries('quickblox', array(
              'fields' => array(
                  'quickblox' => array('*'),
                  'user' => array('*'),
              ),
              'sort'    => 'quickblox.created_date',
              'sort_type' => 'desc',
              'joins' => array(
                'user' => array('user_id','user_id'),
                ),
        'custom_where' => "quickblox.user_id = '".$data[0]['patient_id']."'",
          ));
            $qbuser[]=array("id"=>$dat_qb[0]['quickblox_id'],"login"=>$dat_qb[0]['login'],"password"=>$dat_qb[0]['password'],"full_name"=> $dat_qb[0]['first_name']." ".$dat_qb[0]['last_name']);
           
           // $qbuser[]=array("id"=>'16354248',"login"=>'t@gmail.com',"password"=>"Fit123Quick","full_name"=>'tag craft');
           // $qbuser[]=array("id"=>'16267372',"login"=>'aditi@gmail.com',"password"=>"Fit123Quick","full_name"=>'aditi');
        
      }
      return  $qbuser;
  }

  //function to get average rating of doctor
  function get_avg_rating($doctor_id)
  {
      $CI =& get_instance();
      $CI->load->model('home_model');
      $data=$CI->home_model->get_all_entries('meeting_schedule', array(
              'fields' => array(
                  'meeting_schedule' => array('AVG(rating) as average_rating'),
              ),
              'sort'    => 'meeting_schedule.app_date_time',
              'sort_type' => 'desc',
        'custom_where' => "doc_id = '".$doctor_id."' AND (appointment_status=8 OR appointment_status=1 OR appointment_status=4) AND rating!=0",
          ));
      
      return $data[0]['average_rating'];
  }

  //function to get no. of reviews of doctor
  function get_reviews_count($doctor_id)
  {
      $CI =& get_instance();
      $CI->load->model('home_model');
      $data=$CI->home_model->get_all_entries('meeting_schedule', array(
              'fields' => array(
                  'meeting_schedule' => array('review'),
              ),
              'sort'    => 'meeting_schedule.app_date_time',
              'sort_type' => 'desc',
        'custom_where' => "doc_id = '".$doctor_id."' AND (appointment_status=8 OR appointment_status=1 OR appointment_status=4) AND review!=''",
          ));
      
      return count($data);
  }

//   // function to get doctor specilization
//   //function to get no. of reviews of doctor
//   function get_specialization($spec_id)
//   {
//       $CI =& get_instance();
//       $CI->load->model('doctor_model');
//       $where = array(
//           'id' => $spec_id
//         );
//       $data['record'] = $CI->doctor_model->GetRecord('m16j_doctor_category
// ', $where,'','');

//       $specs = $data['record']['category'];

//   }
/*Get category*/
function getuserdetails($user_id)
{
  $CI =& get_instance();
  $CI->load->model('doctor_model');
  // $countries = $CI->patient_model->GetRecord('countries','','name', 'asc');
  ///echo '<pre>';print_r($countries);die;
  $where = array(
            'user_id' => $user_id,
      );
  $orderby = '';
  $doctor_records = $CI->doctor_model->GetRecord('user',$where,$orderby);
  return $doctor_records;
}

/*for ratin gnumber*/
function getratingnumber($doc_rating_id)
{
  //echo $doc_rating_id;die;
  $CI =& get_instance();
  $CI->load->model('doctor_model');

$Where_data=array(
                'appointment_status' =>'8',
                'doc_id' =>$doc_rating_id,
           );

  $orderby = '';
  $doctor_rating = $CI->doctor_model->GetRecord_rating('meeting_schedule',$Where_data,$orderby);
 // echo "<pre>";print_r($doctor_rating);

$i=0;
  foreach($doctor_rating as $key=>$value) {
    $i++;
    echo "<pre>";
    print_r($value);
    $data_rating  = $value[0]['rating'];
    $data_row  =  $value['num_row'][0];
    $data_rating = $net_rating+$data_rating;
   echo $net_rating = $data_rating/$data_row;
  } 
  
  //echo $net_rating;
  return $net_rating;
}

//function to generate aplha numeric random string, with a given length
  function send_gcm_notify ($device_token,$notification_data=array(),$device_type='')
  {
    date_default_timezone_set('Asia/Kolkata');
    $ci =& get_instance();    
    $apiKey = 'AAAAFC0hNZQ:APA91bFMp1OeUBJiPCjtraBTvjL4kE5z7kJqLyW7dEii5rZlN5MKmKISbiVfyBmhuiNOOQvBhiZPo22hY0CZ75JYHbLmn15LG6-5FM4BfAydDqUOH926hpYuXJfhROHpqyllifiQ5uqb';
    $url = 'https://fcm.googleapis.com/fcm/send';    
    $query = $ci->db->query("SELECT * FROM `m16j_notifications` WHERE `device_token` = '".$device_token."' AND `is_read` = '2'");
    $row= $query->num_rows();     
    $notification_data['badge'] = $row + 1;     
    $registrationIDs = array();
    $registrationIDs[] = $device_token;
    $ins_data = array(
      'notification_user_id' =>$notification_data['notification_user_id'],
      'notification_message' => $notification_data['message'],
      'comet_message'        => "NA",
      'notification_type'    => $notification_data['notification_type'],
      'notification_title'   =>$notification_data['notification_title'],
      'notification_date' => date('Y-m-d H:i:s'),
      'device_type'=>$device_type,
      'device_token' => $device_token,                
      'sended_date' => Date('Y-m-d'),                
      'sended_time' => Date('h:i a'),   
    );              
    if(!empty($notification_data['notification_to_name']))
    {
      $ins_data['notification_to_name'] = $notification_data['notification_to_name'];      
    }
    $notification_id=$ci->common_model->insert_entry('m16j_notifications',$ins_data);   
    $notification_data['notification_id']=$notification_id;
    $notification_data['date']=Date('d-m-Y');
    $notification_data['time']=Date('h:i A');  
    $fields = array(
      'registration_ids'  => $registrationIDs,
      'data'              => $notification_data,
    );
    $headers = array(
      'Authorization: key=' . $apiKey,
      'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));        
    $result = curl_exec($ch);    
    if ($result === FALSE) {
     return die('Problem occurred: ' . curl_error($ch));
   }else{
    return $result;
  }

}

?>
