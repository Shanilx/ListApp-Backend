<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller

{

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
	{  $this->check_admin_login();
		$data['notifications'] = $this->common_model->get_entry_by_data('notifications_admin',false,array('not_admin_id!=""'),'*','desc','not_admin_id','','','');	 
		
		$this->get_header('Manage Notifications');
		$this->load->view('backend/notification/manage_notification',$data);
		$this->load->view('inc/footer');		
		
	}
	
	public function Add_Notification()
	{
		$this->check_admin_login(); 
		if (function_exists("set_time_limit") == TRUE)
			{
			    @set_time_limit(0);
			}
		$this->load->helper('common_helper');		
		$this->form_validation->set_rules('notification_type','Notification Type','trim|required');
		$this->form_validation->set_rules('notification_title','Title','trim|required');
		$this->form_validation->set_rules('message','Message','trim|required');
		if($this->form_validation->run() == TRUE)
		{
			$notification_type = $this->input->post('notification_type');
			$title = trim($this->input->post('notification_title'));
			$message = trim($this->input->post('message'));
			$insert_array =array();
			$group=intval($this->input->post('offset'))+1;
			$insert_array = array(
				'notification_type'=>$notification_type,
				'user_group'=>'Group-'.$group,
				'title'=>$title,
				'message'=>$message,
				'create_date'=>date('Y-m-d h:i:s')
			);
			$nRecord=570;
			$offset=intval($this->input->post('offset'));
			if($_POST['offset'] > 0){
        	 $offset=intval($_POST['offset'])*$nRecord;
			}
			$this->common_model->insert_entry('notifications_admin',$insert_array);
			$data['device_token'] = $this->db->query('SELECT user_id,device_type,device_token,notification,first_name,status FROM m16j_user where device_token!="" and status="Active" ORDER BY user_id ASC LIMIT '.$offset.','.$nRecord)->result_array();
			if(!empty($data['device_token']))
			{
				$all_token=array();
				foreach($data['device_token'] as $token)
				{
					if($sendCount >= 500){
						$sendCount=0;
						sleep(60); /*sleeo for 1 menute*/
					}
					$device_type = $token['device_type'];
					$device_token = $token['device_token'];
					$notification =   $token['notification'];
					$notification_to_name =   $token['first_name'];
					$user_id  = $token['user_id'];	
					$ins_data = array(
						'notification_user_id' =>$token['user_id'],
						'message' =>$message,
						'notification_type' =>$notification_type,
						'notification_title'=>$title,
						'notification_to_name'=>$notification_to_name,
						'sound' => 'default',
						'alert' => $title,
					);
					if(in_array($device_token, $all_token))
					{
						$registrationIDs = array();
						$registrationIDs[] = $device_token;
						$ins_data = array(
							'notification_user_id' =>$ins_data['notification_user_id'],
							'notification_message' => $ins_data['message'],
							'comet_message'        => "NA",
							'notification_type'    => $ins_data['notification_type'],
							'notification_title'   =>$ins_data['notification_title'],
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

						if(!empty($notification_data['notification_from_id']))
						{
							$ins_data['notification_from_id'] = $notification_data['notification_from_id'];
						}
						$notification_id=$this->common_model->insert_entry('m16j_notifications',$ins_data);

					}	
					else if($notification == '1')
					{

						send_gcm_notify($device_token,$ins_data,$device_type);
						$all_token[]=$device_token;
					}					
				} 
				$this->session->set_flashdata('succ','Notification has been sent successfully.');
				redirect(base_url().'apanel/Notification');
			}
		}else
		{
			$this->get_header('Send Notification');
			$this->load->view('backend/notification/add_notification');
			$this->load->view('inc/footer');		
		}
	}
	
	
	

	
	

	public function ajaxDataTableNotification()
	{

     //$where = array('status' =>'1');
		$result=$this->product_model->GetRecord('notifications_admin','','create_date', 'DESC');       
		$data = array();
		$i=1;
		foreach ($result  as $r) {


			$view_link="<a class='btn btn-default btn-sm' data-target='#NotificationModal' data-toggle='modal' href='". base_url()."apanel/Notification/Notification_detail/".ci_enc($r['not_admin_id'])."' title='View Supplier'><i class='fa fa-eye'></i></a>";                    

			$delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['not_admin_id'].")'> <i class='fa fa-trash-o'></i></a>";

			if(strlen($r['message']) > 40){
				$message=substr($r['message'], 0 , 40) . '...';
			}else{
				$message=$r['message'];
			}
			$r['create_date']= date('d-m-Y h:i:s',strtotime($r['create_date']));
			if($r['notification_type']== 1)
			{
				$type= "General Notification";
			} 
			else if ($r['notification_type']== 2)
			{
				$type= "Application Update Notification";
			}

			array_push($data, array(
				$i,
				$type,
				$r['user_group'],
				htmlentities($r['title']),
				htmlentities($message),                 
				$r['create_date'],   
				$delete_link.$view_link
			));
			$i++;
		}
		echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/Notification/Notification_detail/" . ci_enc($r['not_admin_id'])."'> <i class='fa fa-eye'></i></a>
	}

	public function DeleteNotification($id)
	{
		$this->load->library('session');
		$company_id = $id;

		$Delete_Notification = $this->common_model->DeleteRecord('notifications_admin','not_admin_id',$id );
		if($Delete_Notification > 0)
		{ 
			$this->session->set_flashdata('succ','Notification has been Deleted Successfully');
			
			redirect(base_url('apanel/Notification'));
		}
		else
		{
			$this->session->set_flashdata('err','Notification has not been Deleted. Please Try Again');
			
			redirect(base_url('apanel/Notification'));
		}

	}

	public  function Notification_detail($id='')
	{
		$notification_id=ci_dec($id);
		$where=array('not_admin_id'=>$notification_id);
		$data['record'] = $this->common_model->GetSingleRecord('notifications_admin',$where);
        //echo $this->db->last_query();
         // echo "<pre>";

          ///print_r($data);die;
		$this->load->view('backend/notification/view_notification',$data);
	}
	

}