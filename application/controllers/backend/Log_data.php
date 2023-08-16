<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_data extends CI_Controller

{

	// function __construct()
	// 	parent::__construct();
	// 	//$this->load->library("pagination");
	// }
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

	public function index()
	{
		$this->check_admin_login();
		// $where = array('supplier' => $user_id);
		$where = '';
		$orderby = 'created_date';
		$data['log'] = $this->Company_model->GetRecord('not_found_log',$where,$orderby,'desc');

		$this->get_header('Manage Logs');
		$this->load->view('backend/notfoundlog/manage_log', $data);
		$this->load->view('inc/footer'); 
	}
	
	
	
	

	 public function ajaxDataTableLog()
  {
     //$where = array('status' =>'1');
     $result=$this->product_model->GetRecord('not_found_log','','created_date', 'DESC');
        $data = array();
        $i=1;
        foreach ($result  as $r) {      
          //$view_link="<a class='btn btn-default btn-sm' data-target='#NotificationModal' data-toggle='modal' href='". base_url()."apanel/Notification/Notification_detail/".ci_enc($r['not_admin_id'])."' title='View Supplier'><i class='fa fa-eye'></i></a>"; 
          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['log_id'].")'> <i class='fa fa-trash-o'></i></a>";             
          if(strlen($r['message']) > 40){
          	$message=substr($r['message'], 0 , 40) . '...';
          }else{
          	$message=$r['message'];
          }
            array_push($data, array(
                $i,
                $r['log_name'],                            
                $r['search_count'],                            
                // $r['created_date'],   
                $delete_link
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/Notification/Notification_detail/" . ci_enc($r['not_admin_id'])."'> <i class='fa fa-eye'></i></a>
    }

    public function DeleteLog_data($id)
	{
		$this->load->library('session');
        $company_id = $id;
         
		$Delete_Notification = $this->common_model->DeleteRecord('not_found_log','log_id',$id );
		if($Delete_Notification > 0)
		{ 
			$this->session->set_flashdata('succ','Log has been Deleted Successfully');
			
			redirect(base_url('apanel/Log-data'));
		}
		else
		{
			$this->session->set_flashdata('err','Log has not been Deleted. Please Try Again');
			
			redirect(base_url('apanel/Log-data'));
		}

	}

	
	

}