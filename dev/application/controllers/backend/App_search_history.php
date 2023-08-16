<?php
error_reporting(1);

defined('BASEPATH') OR exit('No direct script access allowed');



class App_search_history extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    @set_time_limit(0);
    $this->load->library("pagination");
    $this->load->library('session');
    $this->check_admin_login();



  }

  public function get_header($title='')
  {
    $config['title'] = $title;
    $this->load->view('inc/header', $config);
  }

    // admin check login
  private function check_admin_login(){
    $admin_login = $this->session->userdata('admin_id');
    if($admin_login){
      return true;
    } else {
      redirect(base_url('apanel'));
    }
  }

  public function send_email($to_email, $from_email, $subject, $message) { 
    $from_email = "notify.listapp@gmail.com"; 

    $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
    $this->email->set_header('Content-type', 'text/html');

    $this->email->from($from_email, 'LIST APP'); 
    $this->email->to($to_email);
    $this->email->subject($subject); 
    $this->email->message($message); 

         //Send mail 
    $this->email->send();
         /*if($this->email->send()) 
         { echo "sent"; }
         else 
         { echo $this->email->print_debugger(); }*/
       } 

public function index()
{
  $this->get_header('Product Search');
  $this->load->view('backend/app-search/product_search_log');
  $this->load->view('inc/footer');
}
public function p_search_log()
{
  $result= $this->Retailer_model->get_all_entries('product_search_log', array(
            'fields' => array(
                'product_search_log' => array('*'),
                'user' => array('first_name as user_name,phone'),
                'product' => array('product_name'),
                // 'supplier' => array('name as supplier_name'),
            ),
            'sort'    => 'product_search_log.created_date',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'user' => array('user_id','user_id','inner'),  
          'product' => array('product_id','product_id'), 
          // 'supplier' => array('supplier_id','supplier_id'), 
            ),
        // 'multi_joins'=>array(
        //   'select'=>'GROUP_CONCAT(m16j_supplier.name SEPARATOR ",") AS supplier_name',
        //   'table'=>'m16j_supplier',
        //   'col_name'=>'supplier_id',
        //   'col_name1'=>'supplier_id'
        // ),

      // 'custom_where' => "supplier.status='1'",
        )); 
  /*echo $this->db->last_query();
  die;*/

    $data = array();
        $i=1;
        foreach ($result  as $r) {
          $created_date=date('d-m-Y h:i:s', strtotime($r['created_date']));
            array_push($data, array(
                $i,
                htmlentities( (string) $r['user_name'], ENT_QUOTES, 'utf-8', FALSE),                            
                $r['phone'],                            
                $r['search_text'],                            
                $r['product_name'],   
                // $r['supplier_name'],   
                $r['pl_count'],   
                $created_date
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));


}

public function company_search()
{
  $this->get_header('Company Search');
  $this->load->view('backend/app-search/company_search_log');
  $this->load->view('inc/footer');
}
public function c_search_log()
{
  $result= $this->Retailer_model->get_all_entries('company_search_log', array(
            'fields' => array(
                'company_search_log' => array('*'),
                'user' => array('first_name as user_name,phone'),
                'company' => array('company_name'),
            ),
            'sort'    => 'company_search_log.created_date',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'user' => array('user_id','user_id','inner'),  
          'company' => array('company_id','company_id'),  
            ),    
       ///'custom_where' => "user.user_id='".$user_id."' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '".$date."'",
        )); 

    $data = array();
        $i=1;
        foreach ($result  as $r) {
          $created_date=date('d-m-Y h:i:s', strtotime($r['created_date']));
            array_push($data, array(
                $i,
                htmlentities( (string) $r['user_name'], ENT_QUOTES, 'utf-8', FALSE),                           
                $r['phone'],                            
                $r['search_text'],                            
                $r['company_name'],   
                $r['cl_count'],   
                $created_date
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));


}
public function supplier_search()
{
  $this->get_header('supplier Search');
  $this->load->view('backend/app-search/supplier_search_log');
  $this->load->view('inc/footer');
}
public function s_search_log()
{
  $result= $this->Retailer_model->get_all_entries('supplier_search_log', array(
            'fields' => array(
                'supplier_search_log' => array('*'),
                'user' => array('first_name as user_name,phone'),
                'supplier' => array('name'),
            ),
            'sort'    => 'supplier_search_log.created_date',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'user' => array('user_id','user_id','inner'),  
          'supplier' => array('supplier_id','supplier_id'),  
            ),    
       ///'custom_where' => "user.user_id='".$user_id."' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '".$date."'",
        )); 

    $data = array();
        $i=1;
        foreach ($result  as $r) {
          $created_date=date('d-m-Y h:i:s', strtotime($r['created_date']));
            array_push($data, array(
                $i,
                htmlentities( (string) $r['user_name'], ENT_QUOTES, 'utf-8', FALSE),                            
                $r['phone'],                            
                $r['search_text'],                            
                $r['name'],   
                $r['sl_count'],   
                $created_date
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));


}

//function for add city  for app search
public function search_city_list()
{
  $this->get_header('City List');
  $this->load->view('backend/app-search/search_city_list');
  $this->load->view('inc/footer');
}

public function search_city_list_table()
{
  $result= $this->Retailer_model->get_all_entries('search_city_list', array(
            'fields' => array(
                'search_city_list' => array('*'),
                'cities' => array('name as city_name'),
                'states' => array('name as state_name'),
                            ),
            'sort'    => 'cities.name',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'cities' => array('id','city_id','inner'),  
          'states' => array('id','state_id','inner'),             
            ),    
       ///'custom_where' => "user.user_id='".$user_id."' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '".$date."'",
        )); 

    $data = array();
        $i=1;
        foreach ($result  as $r) {
          $remove_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['s_city_id'].")' title='Remove'> <i class='fa fa-trash-o'></i></a>";
          $created_date=date('d-m-Y h:i:s', strtotime($r['created_date']));
            array_push($data, array(
                $i,                                           
                $r['city_name'],                            
                $r['state_name'],
                $created_date,
                $remove_link
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));

}

public function city_add()
{
  $this->check_admin_login();
  $where=array('country_id'=>'101');
  $data['states']=$this->Retailer_model->GetRecord('states', $where);
  $this->get_header('Add City');
  $this->load->view('backend/app-search/add_city',$data);
  $this->load->view('inc/footer'); 
}

public function add_city()
{
  $this->check_admin_login();
  $this->form_validation->set_rules('state_id','State Name','trim|required');
  $this->form_validation->set_rules('city_id','City Name','trim|required');   
  if($this->form_validation->run() == TRUE)
  {
    $city_id=trim($this->input->post('city_id'));
    $state_id=trim($this->input->post('state_id'));
    $arr=array(
                'city_id'=>$city_id,
                'state_id'=>$state_id,
                'created_date'=>date('Y-m-d H:i:s')
              );
    $save_result=$this->Company_model->save_entry('search_city_list',$arr);
    if($save_result!='')
    {        
      $this->session->set_flashdata('succ','City has been Added Successfully');
      redirect(base_url().'apanel/city-search/city-list');
    }
    else
    {
      $this->session->set_flashdata('err','City has not been Added. Please Try Again'); 
      $this->get_header('Add City');
      $this->load->view('backend/app-search/add_city');
      $this->load->view('inc/footer'); 
    }
  }else{
    $err=validation_errors();
    $this->session->set_flashdata('err',$err); 
    $this->get_header('Add City');
    $this->load->view('backend/app-search/add_city');
    $this->load->view('inc/footer'); 
  } 
}

public function check_city()
{ 
    $city_id = trim($this->input->post('city_id'));
    $data = $this->Company_model->get_entry_by_data(true, array('city_id' => $city_id), "city_id","search_city_list");
      if($data)
      {
        //return true;
        echo (json_encode(false));
      }
      else
      {
        //return false;
        echo (json_encode(true));
      }
}

public function remove_city($s_city_id='')
{   
    if(empty($s_city_id)){
      $this->session->set_flashdata('err','City has not been Removed. Please Try Again');
      redirect(base_url().'apanel/city-search/city-list');
      return;
    }
    $where=array('s_city_id'=>$s_city_id);
    $remove_city = $this->Retailer_model->DeleteRecord('search_city_list',$where);
    if($remove_city!='')
    { 
      $this->session->set_flashdata('succ','City has been Removed Successfully');
      redirect(base_url().'apanel/city-search/city-list');
    }
    else
    {
      $this->session->set_flashdata('err','City has not been Removed. Please Try Again');
      redirect(base_url().'apanel/city-search/city-list');
    }
}

}//controller class ends here

?>
