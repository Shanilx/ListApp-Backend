<?php 
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller

{

	function __construct(){
		parent::__construct();
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
	public function index()
	{
		// $where = array('supplier' => $user_id);
		$where = '';
		$orderby = 'schedule_id';
		$data['schedule_data'] = $this->Schedule_model->GetRecord('schedule',$where,$orderby,'desc');

		$this->get_header('Manage Schedule');
		$this->load->view('backend/schedule/schedule_list', $data);
		$this->load->view('inc/footer'); 
	}
	public function add()
	{
		$this->get_header('Add Schedule');
		$this->load->view('backend/schedule/Addschedule');
		$this->load->view('inc/footer'); 
	}
	public function AddSchedule()
	{
		$this->check_admin_login();
		$arr = array(
					'schedule_name'=>$this->input->post('schedule_name'),
					'date_added'=>Date('Y-m-d h:i:s')
					);
		//print_r($arr);die;
		$save_result=$this->Schedule_model->save_entry('schedule',$arr);
		if($save_result!='')
		{ 
					// $supplier_id = $this->session->set_userdata('supplier_id ');
			$this->session->set_flashdata('succ','Schedule Name has been Added Successfully');
			redirect(base_url().'apanel/Schedule');
		}
		else
		{
			$this->session->set_flashdata('err','Schedule Name has not been Added. Please Try Again');
			redirect(base_url().'apanel/Schedule');
		}
	}
	public function EditSchedule($id)
	{
		$Schedule_id = ci_dec($id);
		$where = array('schedule_id' => $Schedule_id);
		$orderby = '';
		$data['edit_Schedule'] = $this->Schedule_model->GetRecord('schedule',$where,$orderby);

		//print_r($data['edit_Schedule']); die;
		$this->get_header('Edit Schedule');
		$this->load->view('backend/schedule/Editschedule', $data);
		$this->load->view('inc/footer');  


	}
	public function EditData($id)
	{
       $Schedule_id = ci_dec($id);
       $arr = array(
					'schedule_name'=>$this->input->post('schedule_name'),
					'date_added'=>Date('Y-m-d h:i:s')
		           );
        $where = array('schedule_id' => $Schedule_id);
        $update_Schedule = $this->Schedule_model->UpdateData('schedule',$arr,$where);
		if($update_Schedule!='')
		{ 
			$this->session->set_flashdata('succ','Schedule Name has been Updated Successfully');
			redirect(base_url().'apanel/Schedule');
		}
		else
		{
			$this->session->set_flashdata('err','Schedule Name has not been Updated. Please Try Again');
			redirect(base_url().'apanel/Schedule');
		}
	}
	public function DeleteSchedule($id)
	{
        $schedule_id = $id;
		$Delete_Schedule = $this->Schedule_model->DeleteRecord('schedule',$schedule_id);
		if($Delete_Schedule!='')
		{ 
			$this->session->set_flashdata('succ','Schedule Name has been Deleted Successfully');
			redirect(base_url().'apanel/Schedule');
		}
		else
		{
			$this->session->set_flashdata('err','Schedule Name has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/Schedule');
		}

	}
	public function check_shedule_name()
	{
		$schedule_name = trim($this->input->post('schedule_name'));
		$data = $this->Company_model->get_entry_by_data(true, array('schedule_name' => $schedule_name), "schedule_name","schedule");
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
	 public function Schedule_changeStatus(){
    // echo 'ok';

    // $this->check_admin_login();
    // print_r($_POST);
     $action = $this->input->post('ac');
     $actionid = $this->input->post('acid');
    if(!empty($action) && !empty($actionid)){

      if($action == 'block'){
        $status = 0;
      } else {
        $status = 1;
      }
      $this->common_model->update_entry('schedule',array('status'=>$status),array('schedule_id'=>$actionid));
    
      echo 'ok';exit;

    } else {
      echo '';exit;
    }
  }
		 public function ajaxDataTableSchedule()
  {
     //$where = array('status' =>'1');
     $result=$this->Company_model->GetRecord('schedule');

        $data = array();
        $i=1;
        foreach ($result  as $r) {
         
          
          if($r['status']==1){
            $status='<span id="span_active_'.$r['schedule_id'].'" class="label label-success">Active</span>';
            $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="schedule_changeStatus btn btn-default btn-sm" id="block_'.$r['schedule_id'].'" title="Block this Schedule ?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['schedule_id'].'"></i></a>';

             }
            else{
              $status='<span id="span_block_'.$r['schedule_id'].'" class="label label-danger" >Deactive</span>';

              $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="schedule_changeStatus btn btn-default btn-sm" id="activate_'.$r['schedule_id'].'" title="Activate this Schedule ?"><i class="fa fa-check fa-lg" id="icon_'.$r['schedule_id'].'"></i></a>';
            }
          //$view_link="<a class='btn btn-default btn-sm' data-target='#ScheduleModal' data-toggle='modal' href='". base_url()."apanel/Schedule/Schedule_detail/".ci_enc($r['schedule_id'])."' title='View Supplier'><i class='fa fa-eye'></i></a>";                    
          $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Schedule/EditSchedule/" . ci_enc($r['schedule_id'])."'> <i class='fa fa-pencil-square-o'></i></a>";
          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['schedule_id'].")'> <i class='fa fa-trash-o'></i></a>";
             
          $r['date_added']= date('d-m-Y h:i:s',strtotime($r['date_added']));
            array_push($data, array(
                $i,
                $r['schedule_name'],
                $r['date_added'],                
                $status,
                $edit_link.$delete_link.$changeStatus
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/Schedule/Schedule_detail/" . ci_enc($r['schedule_id'])."'> <i class='fa fa-eye'></i></a>
    }
    //Function for Load data in data table using ajax starts

}