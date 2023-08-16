<?php 
error_reporting(1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Hiring_post extends CI_Controller

{

	public function __construct()
	{
		parent::__construct();
		$this->check_admin_login();
		date_default_timezone_set('Asia/Kolkata');

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
		$this->check_admin_login();
		$where = array('post_status'=>'Active');
		$orderby = 'created_date';
		$data['post_data'] = $this->Retailer_model->GetRecord('hiring_post',$where,$orderby,'desc');
		$this->get_header('Manage Post');
		$this->load->view('backend/hiring_post/hiring_post_list', $data);
		$this->load->view('inc/footer'); 

		// $this->load->view('Retailer_list', $config);
	}
	
	public function delete_post($id)
	{ 
		$where=array('post_id'=>$id);
		$Delete_retailer = $this->common_model->update_entry('hiring_post',array('post_status'=>'Deleted'),$where);	
		//$Delete_retailer = $this->Retailer_model->DeleteRecord('product_sell_post',$where);
		if($Delete_retailer!='')
		{ 
			$this->session->set_flashdata('succ','Post has been Deleted Successfully');
			redirect(base_url().'apanel/hiring-post');
		}
		else
		{
			$this->session->set_flashdata('err','Post has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/hiring-post');
		}

	}
	public function ph_changeStatus(){
		$action = $this->input->post('ac');
		$actionid = $this->input->post('acid');
		if(!empty($action) && !empty($actionid)){

			if($action == 'deactivate'){
				$status = 'Deactive';
				$this->common_model->update_entry('hiring_post',array('post_status'=>$status),array('post_id'=>$actionid,));
			} else {
				$status = 'Active';
				$this->common_model->update_entry('hiring_post',array('post_status'=>$status),array('post_id'=>$actionid));
			}
			echo 'ok';exit;
		} else {
			echo '';exit;
		}
	}
	public function hire_changeStatus(){
		$action = $this->input->post('ac');
		$actionid = $this->input->post('acid');
		if(!empty($action) && !empty($actionid)){

			if($action == 'Hired'){
				$status = 'Hired';
				$this->common_model->update_entry('hiring_post',array('hire_status'=>$status),array('post_id'=>$actionid,));
			} else {
				$status = 'Open';
				$this->common_model->update_entry('hiring_post',array('hire_status'=>$status),array('post_id'=>$actionid));
			}
			echo 'ok';exit;
		} else {
			echo '';exit;
		}
	}
	public  function post_detail($id='')
	{
		$post_id=ci_dec($id);
		$where=array('post_id'=>$post_id);
		$data=  $this->Retailer_model->get_all_entries('hiring_post', array(
			'fields' => array(
				'hiring_post' => array('*'),
				'user' => array('first_name as user_name,phone'),				
			),
			'sort'    => 'hiring_post.created_date',
			'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
			'joins' => array(
				'user' => array('user_id','user_id'),  
				
			),    
			'custom_where' => "hiring_post.post_id='".$post_id."'",

		));
		$rec['record']=$data[0];
		$this->load->view('backend/hiring_post/post_hiring_view',$rec);
	}


	public function ajaxDataTableHiring()
	{

		$result=$this->Retailer_model->get_all_entries('hiring_post', array(
			'fields' => array(
				'hiring_post' => array('*'),
				'user' => array('first_name as user_name,phone'),				
			),
			'sort'    => 'hiring_post.created_date',
			'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
			'joins' => array(
				'user' => array('user_id','user_id'),  
				
			),    
			'custom_where' => "hiring_post.post_status!='Deleted' AND user.status='Active'",

		));  

		$data = array();
		$sn=1;
		foreach ($result  as $r) {    

			if($r['post_status']=='Active'){
				$status='<span id="span_active_'.$r['post_id'].'" class="label label-success">Active</span>';
				$changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="ph_changeStatus btn btn-default btn-sm" id="deactivate_'.$r['post_id'].'" title="Deactivate" ><i class="fa fa-ban fa-lg" id="icon_'.$r['post_id'].'"></i></a>';

			}
			else{
				$status='<span id="span_deactivate_'.$r['post_id'].'" class="label label-danger" >Deactive</span>';

				$changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="ph_changeStatus btn btn-default btn-sm" id="activate_'.$r['post_id'].'" title="Activate"><i class="fa fa-check fa-lg" id="icon_'.$r['post_id'].'"></i></a>';
			}
			if($r['hire_status']=='Open'){
				$hire_status='<span id="span_available_'.$r['post_id'].'" class="label label-success">Open</span>';
				$hireChangeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="hiring_changeStatus btn btn-default btn-sm" id="Hired_'.$r['post_id'].'" title="Hired" ><i class="fa fa-sign-in fa-lg" id="icon_'.$r['post_id'].'"></i></a>';

			}
			else{
				$hire_status='<span id="span_sold_'.$r['post_id'].'" class="label label-danger" >Hired</span>';

				$hireChangeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="hiring_changeStatus btn btn-default btn-sm" id="Open_'.$r['post_id'].'" title="Open"><i class="fa fa-sign-out fa-lg" id="icon_'.$r['post_id'].'"></i></a>';
			}

			if(strlen($r['description']) > 40){
				$r['description']=substr($r['post_description'], 0,40).'...';
			}

			$view_link="<a class='btn btn-default btn-sm' data-target='#postModal' data-toggle='modal' href='". base_url()."apanel/hiring-post/here_detail/".ci_enc($r['post_id'])."' title='View Post'><i class='fa fa-eye'></i></a>";                      
			//$edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/hiring-post/hiring-post-edit/" . ci_enc($r['post_id'])."' title='Edit' > <i class='fa fa-pencil-square-o'></i></a>";


			$delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['post_id'].")' title='Delete'> <i class='fa fa-trash-o'></i></a>";

			$r['created_date']= date('d-m-Y h:i:s',strtotime($r['created_date']));				
			array_push($data, array(
				$sn,
				htmlentities( (string) $r['user_name'], ENT_QUOTES, 'utf-8', FALSE),
				$r['phone'],
				$r['title'],
				$r['description'],
				$r['no_of_jobs'],			
				$r['contact_detail'],			
				$hire_status,
				$r['created_date'],
				$status,
				$view_link.$changeStatus.$delete_link.$hireChangeStatus
			));
			$sn++;


		}

		echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['retailer_id'])."'> <i class='fa fa-eye'></i></a>
	}
    //Function for Load data in data table using ajax starts



	public function getUserType($role)
	{
		$data=array(
			'1'=>'admin',
			'2'=>'supplier',
			'3'=>'retailer',
			'4'=>'other',
			'5'=>'company'
		);
		return $data[$role];
	}





	
}//end of controller class