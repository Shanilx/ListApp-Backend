<?php
error_reporting(0);
print_r($_SERVER); die;
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class SearchProduct extends REST_Controller {

  public function __construct()
  {
    parent::__construct();
	

  }
  

  /*===========GET searchProduct starts===========*/


  public function searchProduct_post()
  {
	  //Include Mamcache library
	  $this->load->library('memcached_library');
	  $this->load->driver('Cache');
    $this->load->driver('cache', array(
    'adapter' => 'memcached', 
    'backup' => 'file'
));
	 
	  
    $blank_arr=array();
    $phone = $this->input->post('mobile_no');
    $product_name = $this->input->post('product_name');
    $user_id   =  $this->input->post('user_id');
    $device_type   =  $this->input->post('device_type');
    $device_token   =  $this->input->post('device_token');
    $city_id   =  ($this->input->post('city_id'))?$this->input->post('city_id'):'2229';
    $offset   =  $this->input->post('offset');

    $data1=$_POST; 
    // if(empty($phone)  ||(empty($offset) && $offset!=0) ||empty($city_id) || empty($device_type) || empty($user_id) || empty($product_name)|| empty($device_token))
    // {
    //   $final_data = array('error'=>'1','message'=>'Please Provide all information');
    //   $this->set_response($final_data, REST_Controller::HTTP_OK);
    // }
    // else
    // {
      $query_phone=$this->db->get_where('user',array("phone"=>$data1['mobile_no'] ,"user_id"=>$data1['user_id'],"status"=>'Active'));

      $result = $query_phone->result_array();
      if(!empty($result))
      {
        if($result[0]['device_token'] ==$data1['device_token']) 
        {
          if($offset > 0){
            $offset=$offset*50;
          }else{
            $offset='0';
          }
          $no_of_records=50;

        

          $like=array('product_name'=>$product_name);
		  //***********************Memcache library get key 
		  
		  	$results = $this->memcached_library->get($product_name);
			
			
			
			
		  //***************************************************
		 
          $explode = explode(" ",$product_name);
		  
		  if(!$results)
		  {
			 $data=$this->users_model->searchWithLike('product','',$like,$offset,$no_of_records);		  
		 // echo $this->db->last_query();die;
		   $this->memcached_library->add($product_name, $data,7000);  
			  
		  }
		  else
		  {
			  
			  $data = $results;
		  }
          $both = '';
           if(empty($data))
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
            

                     
          }
          if(empty($data))
          {
            $string_len=strlen($explode[0]);
            for ($i=1; $i <$string_len ; $i++) { 
              $end=$string_len-$i;
            $search_text = array('product_name'=>substr($explode[0],0,$end));
            $data=$this->users_model->searchWithLike('product','',$search_text ,$offset,$no_of_records);
            if(!empty($data))
            {
              if(strlen($search_text) == 3){
              $this->memcached_library->add($search_text, $data,7000);
              }
              else{
              $this->memcached_library->add($product_name, $data,7000);
              }
              break;                
            }

            }

                     
          } 
         


    //       if(empty($data))
    //       {
    //         $search_four = array('product_name'=>substr($explode[0],0,4));
    //         $data=$this->users_model->searchWithLike('product','',$search_four ,$offset,$no_of_records);
    //       }
		  
		  // // memcache for third result
		  // $search_three = array('product_name'=>substr($explode[0],0,3));
		  // $third = $this->memcached_library->get(substr($explode[0],0,3));
		 
		  
    //       if(!$third)
    //       { 
    //         $data=$this->users_model->searchWithLike('product','',$search_three ,$offset,$no_of_records);
			 //     $this->memcached_library->add($third, $data,7000);  

    //       }
		  // else{
			 // 			$data = $third; 
		  // }


    //       if(empty($data))
    //       {
    //         $both = '1';

    //         $data=$this->users_model->searchWithLike('product','',$like ,$offset,$no_of_records,$both);

    //       }
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
              $ins_arr=array('log_name'=>$data1['product_name'],'search_count'=>1,'created_date'=>date('Y-m-d H:i:s'));
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
        $error = array('error'=>'1','message'=>'Your account has been deactivated. Contact - 9977773388.');
        $this->set_response($error, REST_Controller::HTTP_OK);
      }

    //}

  }

  /*========GET searchProduct ends=================*/


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
    $from_email='notify.listapp@gmail.com';

    /*$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
         $this->email->set_header('Content-type', 'text/html');*/

    // $this->email->set_header('MIME-Version', '1.0; charset=iso-8859-1');
    // $this->email->set_header('Content-type', 'text/html');

    $this->email->from($from_email, 'ListApp'); 
    $this->email->to($to_email);

    $this->email->cc('nivesh.syscraft@gmail.com,sankalp.syscraft@gmail.com,rahulnakum.syscraft@gmail.com');

    $this->email->subject($subject); 
    $this->email->message($message); 
    if($fileName){
      $attechment=set_realpath('../uploads/notfoundfile/').$fileName;
      $this->email->attach($attechment);
    }
    return $this->email->send(); 


  }
  /*================ Request Not Found Data ends =========================*/


  
}// REST controller End

?>
