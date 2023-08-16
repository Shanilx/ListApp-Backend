<?php
error_reporting(1);
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class SearchProduct extends REST_Controller {

  public function __construct()
  {
    parent::__construct();
  }
  

public function searchProduct_post()
  {
    // Include Mamcache library
    $this->load->driver('cache');
    $this->load->library('memcached_library');

    $blank_arr = array();
    $phone = $this->input->post('mobile_no');
    $product_name = $this->input->post('product_name');
    $user_id = $this->input->post('user_id');
    $device_type = $this->input->post('device_type');
    $device_token = $this->input->post('device_token');
    $combination = $this->input->post('combination');
    $city_id = ($this->input->post('city_id')) ? $this->input->post('city_id') : '2229';
    $offset = $this->input->post('offset');
    $data1 = $_POST;
    if (empty($phone) || (empty($offset) && $offset != 0) || empty($city_id) || empty($device_type) || empty($user_id) || empty($product_name) || empty($device_token)) {
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
          if ($offset > 0) {
            $product_name_key = $product_name . $offset;
            $offset = $offset * 50;
          }
          else {
            $product_name_key = $product_name;
          }
          $no_of_records = 50;
          $like = array(
            'product_name' => $product_name
          );
          // ***********Memcache library get key
          // $this->cache->memcached->clean();
          $results = $this->memcached_library->get($product_name_key);
          $order = array('/','-',' ','%','&','_','.','+','*','@','$','^','(',')','|','!','`','>',"<",'?','#',',',':','[',']','{','}','"',"'" );
           $join_query="SELECT `m16j_product`.`product_id`, `m16j_product`.`product_name`, `m16j_product`.`drug_name`, `m16j_product`.`mrp`, `m16j_product`.`rate`, `m16j_product`.`status`, `m16j_product`.`add_date`, `m16j_company`.`company_name`, `m16j_form`.`Form` as `form`, `m16j_packing_type`.`packingtype_name` as `packing_type`, `m16j_packsize`.`Pack_size` as `pack_size`, `m16j_schedule`.`schedule_name`as `schedule` FROM `m16j_product`LEFT JOIN `m16j_company` ON `m16j_company`.`company_id` = `m16j_product`.`company_name`LEFT JOIN `m16j_form` ON `m16j_form`.`form_id` = `m16j_product`.`form`LEFT JOIN `m16j_packing_type` ON `m16j_packing_type`.`packing_type_id` = `m16j_product`.`packing_type`LEFT JOIN `m16j_packsize` ON `m16j_packsize`.`pack_size_id` = `m16j_product`.`pack_size`LEFT JOIN `m16j_schedule` ON `m16j_schedule`.`schedule_id` = `m16j_product`.`schedule`";
          $name = str_replace($order, '', trim($this->input->post('product_name')));
          if (empty($results) && !empty($name) && empty($combination)) {
            $input = explode(' ', trim($this->input->post('product_name')));
            $product_name1 = trim(str_replace($order, '', trim($input[0])));
            $order_by = substr($this->input->post('product_name') , 0, 3);
            $first_three = substr($product_name1, 0, 3);
            $last_one = substr($product_name1, -1, 2);
            if (strlen($product_name1) <= 1) {
              // $product_name1=trim($this->input->post('product_name'));
              $product_name1 = trim(str_replace($order, '', trim($this->input->post('product_name'))));
              $first_three = substr($product_name1, 0, 3);
              $last_one = substr($product_name1, -1, 2);
            }
            if (strlen($product_name1) <= 6 && strlen($product_name1) > 4) {
              $first_three = substr($product_name1, 0, 4);
              $last_one = substr($product_name1, -1, 2);
            }
            if (strlen($product_name1) >= 7 && strlen($product_name1) > 5) {
              $first_three = substr($product_name1, 0, 5);
              $last_one = substr($product_name1, -1, 2);
            }
            if (strlen($product_name1) >= 9 && strlen($product_name1) > 7) {
              $first_three = substr($product_name1, 0, 7);
              $last_one = substr($product_name1, -1, 2);
            }
            $dq = '"';
            $Sq = "'";
            $column_name = "REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (REPLACE (`m16j_product`.`product_name`,'$sq',''),'$dq',''),'%',''),'}',''),'{',''),']',''),'[',''),':',''),' ',''),',',''),'.',''),'.',''),'#',''),'@',''),'$',''),'^',''),'(',''),')',''),'|',''),'!',''),'`',''),'<',''),'>',''),'?',''),'*',''),'+',''),'-',''),'/','')";          

          $sql =  $join_query." WHERE  $column_name like '" . $name . "%' ORDER BY CASE WHEN LEFT(`m16j_product`.`product_name`, 3) = '$order_by' THEN 1 ELSE 2 END, `m16j_product`.`product_name` ASC LIMIT $offset,$no_of_records";
            $data = $this->db->query($sql)->result_array();
            if (empty($data)) {
              $sql = $join_query." WHERE SUBSTRING_INDEX(`m16j_product`.`product_name`,' ',1) like '" . $first_three . "%" . $last_one . "' ORDER BY CASE WHEN LEFT(`m16j_product`.`product_name`, 3) = '$order_by' THEN 1 ELSE 2 END, `m16j_product`.`product_name` ASC LIMIT $offset,$no_of_records";
              $data = $this->db->query($sql)->result_array();
            }
            if (empty($data) && $offset <= 0) {
              if (strlen(trim($this->input->post('product_name'))) >= 6) {
                $num_vowel = $this->getVowel(trim($this->input->post('product_name')));
                if ($num_vowel > 1) {
                  $sql = $join_query." WHERE levenshtein('$product_name1',SUBSTRING_INDEX(product_name,' ',1)) < 3 ORDER BY CASE WHEN LEFT(`m16j_product`.`product_name`, 3) = '$order_by' THEN 1 ELSE 2 END, `m16j_product`.`product_name` ASC LIMIT $offset,$no_of_records";
                  $data = $this->db->query($sql)->result_array();
                }
              }
              else {
                $sql = $join_query." WHERE levenshtein('$product_name1',SUBSTRING_INDEX(`m16j_product`.`product_name`,' ',1)) < 2 ORDER BY CASE WHEN LEFT(`m16j_product`.`product_name`, 3) = '$order_by' THEN 1 ELSE 2 END, `m16j_product`.`product_name` ASC LIMIT $offset,$no_of_records";
                $data = $this->db->query($sql)->result_array();
              }
            }
          }
          elseif(!empty($combination) && $combination==1) {
            $pName_comb=trim($this->input->post('product_name'));
            if(strpos($pName_comb,'*')!=''){
               $p_n_c=str_replace('*', '%', $pName_comb);              
            }elseif(strpos($pName_comb,'?')!=''){
               $p_n_c=str_replace('?', '%', $pName_comb); 
            }
             $sql = $join_query." WHERE SUBSTRING_INDEX(`m16j_product`.`product_name`,' ',1) like '" . $p_n_c . "' ORDER BY `m16j_product`.`product_name` ASC LIMIT $offset,$no_of_records";
            $data = $this->db->query($sql)->result_array();
           // echo $this->db->last_query();die;
          }
          else {
            $data = $results;
          }
          // echo $this->db->last_query(); die;
          // $query=$this->db->last_query();
          if (empty($data) && $offset == 0) {
            $log_chek = $this->db->get_where('not_found_log', array(
              "log_name" => $data1['product_name']
            ));
            $log_result = $log_chek->result_array();
            if (!empty($log_result)) {
              $search_count = $log_result[0]['search_count'] + 1;
              $log_id = $log_result[0]['log_id'];
              $upd_arr = array(
                'search_count' => $search_count
              );
              $update = $this->users_model->update_entry($upd_arr, 'not_found_log', $log_id, 'log_id');
            }
            else {
              $ins_arr = array(
                'log_name' => $data1['product_name'],
                'search_count' => 1,
                'created_date' => date('Y-m-d h:i:s')
              );
              $this->users_model->InsertData('not_found_log', $ins_arr);
            }
            $message = array(
              'error' => '1',
              'message' => 'No matching records found'
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }
          else {
            $this->memcached_library->add($product_name_key, $data, 7000); //set memcache
           
            if (count($data) > 0) {
              $message = array('error' => '0','message' => 'success','data' => $data);
              $this->set_response($message, REST_Controller::HTTP_OK);
            }
            else {
              $message = array(
                'error' => '1',
                'message' => 'No matching records found'
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
  /*================ Request Not Found Data ends =========================*/


  
}// REST controller End

?>
