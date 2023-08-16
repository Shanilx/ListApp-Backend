<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->deletUnwantedUser();
	}

	public function get_header($title='')
	{
		$config['title'] = $title;
		$this->load->view('inc/header', $config);
	}

	public function send_email($to_email, $from_email, $subject, $message) 
	{ 
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


     //for handle 404
	public function guestUser()
	{	
		
		$this->load->view('website/guest_user');
		
	}

     public function index()
     { 
     	$admin_login = $this->session->userdata('admin_login');

     	$config['title'] = 'Login';
     	if($admin_login){
     		redirect(base_url('apanel/dashboard'));
     	}

     	$this->form_validation->set_rules('email','Email','trim|required|valid_email');
     	$this->form_validation->set_rules('password','Password','trim|required');
     	if($this->form_validation->run() == TRUE)
     	{     		
     		$data=$_POST;
     		$query_email=$this->db->get_where('user',array("email"=>$data['email'], 'role'=>1));
     		$result = $query_email->result_array();

     		if(!empty($result))
     		{
     			foreach($result as $res)
     			{
     				$stored_salt = $res['salt'];
     				$stored_passsword = $res['password'];
     			}
     			
     			$userPassword = $data['password'];
     			$hashedPassword = encode($userPassword, $stored_salt);

     			$where = array(
     				'email'=>$this->input->post('email'),	
     				'password'=>$hashedPassword
     				);

				//check admin credentials			
     			$data = $this->common_model->get_entry_by_data('user',true,$where);

     			if($data) 
     			{

     				if($data['status'] == 'Active') {

     					$session_array = array(
     						
     						'admin_login' => true,
     						'admin_email' => $data['email'],
     						'admin_fname'  => $data['first_name'],
     						'admin_lname'  => $data['last_name'],
     						'admin_image'  => $data['profile_pic'],
     						'role_id'  => $data['role'],
     						'admin_id'	=> $data['user_id']			
     						);
     					
     					$this->session->set_userdata($session_array);
     					
					  //update last login for amdin
					 //$this->common_model->save_entry('users',array('last_login'=>date('Y-m-d H:i:s')),'id',$data['id']);
     					
     					
					 //-----------------For Set Cookies Remember Me-------------------
     					
     					if (isset($_POST['remember_me']))
     					{
     						
     						$this->input->set_cookie("a_name", $this->session->userdata('admin_email'), time()+2592000);

     						$this->input->set_cookie("a_id", $this->session->userdata('admin_id'), time()+2592000);
     						
     						$this->input->set_cookie("a_password", $_POST['password'], time()+2592000);
     					}
     					
					 	//------------------------------------------------------------
     					redirect(base_url('apanel/dashboard'));
     					

     				} else {

     					$this->session->set_flashdata('posted_email',$this->input->post('email'));
     					$this->session->set_flashdata('err',"Your status has been disabled by admin");
     					redirect(base_url('apanel'));

     				}

     			}
     			else 
     			{
     				$this->session->set_flashdata('posted_email',$this->input->post('email'));
     				$this->session->set_flashdata('err',"Invalid email or password");
     				redirect(base_url('apanel'));
     			}
     		}	
     		else
     		{
     			$this->session->set_flashdata('posted_email',$this->input->post('email'));
     			$this->session->set_flashdata('err',"Invalid email or password");
     			redirect(base_url('apanel'));
     		}

     	} 
     	else 
     	{
     		$this->load->view('inc/login_header',$config);
     		$this->load->view('backend/login');
			//$this->load->view('inc/footer');
     	}
     	
     	
     }

     public function ChangePassword() 
     {  
     	$session_admin_id = $this->session->userdata('admin_id');
     	
     	$date_added = date('Y-m-d H:i:s');
     	
		$salt = randomString(16); //creating 4 digit alpha numeric salt
		$userPassword = $this->input->post('pass_value');
		
		$hashedPassword = encode($userPassword, $salt);     //encode function in commen_helper 

		
		$arr = array(
			'update_date'		=>$date_added,
			'salt'				=>$salt,
			'password'			=>$hashedPassword,
			'pwd_without_encode'=>$userPassword			
			);			

		$where = array('user_id' =>$session_admin_id);
		$user_data = $this->common_model->UpdateData('user',$arr,$where);
		
		echo "done";
		die;

		/*$idd = $this->input->post('hidden_id');			 
		if($user_data!='')
		{ 
			$this->session->set_flashdata('succ',"Password has been updated successfully.");
			redirect(base_url().$idd);
		}
		else
		{
			$this->session->set_flashdata('err','Password not updated. Please try again.');
			redirect(base_url().$idd);
		}*/
		
		
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


	// for admin logout
	public function logout()
	{
		$newdata = array(
			'admin_email' => '',
			'admin_fname'  => '',
			'admin_lname'  => '',
			'role_id'  => '',
			'admin_id'	=> '',
			'team_id'	=> '',
			'admin_login' => FALSE,
			);
		
		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
		redirect(base_url('apanel'));
	}

	//To send forgot password URL to user
	public function forgot_password()
	{
		   $this->check_admin_login();
			/*$check=0;
			$email = $this->input->post('member_email');

			$where = array(
							'email' => $email, 
						);
			
			//fetch record for email
			$check_register = $this->common_model->get_entry_by_data('user',true,$where);

			if($check_register)
			{
				$first_name = $check_register['first_name'];
				$email = $check_register['email'];
				$password = $check_register['password'];
				$salt = $check_register['salt'];

				$password_decode = decode($password, $salt);

				//Email Helper
				send_forgot_passsword($first_name, $email, $password_decode);

				$check = 1;
			}
			
			echo $check;
			die;*/

			$this->form_validation->set_rules('member_email','Email','trim|required|valid_email');
			if($this->form_validation->run()==FALSE)
			{
				echo "Please enter valid email id";
			}
			else
			{
				$email = $this->input->post('member_email');
				$find_email = $this->common_model->GetRecord('user',array('email'=>$email, 'role'=>1));
				if(!$find_email)
				{
					echo "Please submit correct Email ID";
				}
				else
				{
					$where = array(
						'email' => $email, 
						);
					$check_register = $this->common_model->get_entry_by_data('user',true,$where);

					if($check_register)
					{
						$first_name = $check_register['first_name'];
						$email = $check_register['email'];
						$password_decode = $check_register['pwd_without_encode'];
						
						$subject = 'Password Information';
						$message = '';
						$message .= 'Hello '.$find_email[0]['first_name'].', <br/>';
						$message .= 'Please check below, the username and password of your account. <br/> Username : '.$email.' <br/> Password : '.$password_decode.' <br/>';
						$message .= 'Thanks, <br/> LIST APP Team';

						$this->send_email($email, '', $subject, $message);

						$check = 1;
						echo "done";
					}


			/*//generate unique token for one time link
				$rand = randomString();
				$token = $find_email[0]['user_id']."_".$rand;
				$time = strtotime('+2 day');

				//update user table for token and time
				$save_token = $this->doctor_model->UpdateData('user',array('forgot_token' => $token, 'forgot_expiration' => $time),array('user_id'=>$find_email[0]['user_id']));
		
				$subject = 'Reset Password Link';
				$message = '';
				$message .= 'Hello '.$find_email[0]['first_name'].', <br/>';
				$message .= 'Please click on below link for resetting your password. <br/> <a href="'.base_url().'user/resetPassword/'.$token.'">'.base_url().'user/resetPassword/'.$token.'</a> <br/>';
				$message .= 'Thanks, <br/> LIST APP Team';
				$this->send_email($email, '', $subject, $message);
				//mail($email, $subject, $message);*/
				//echo "done";
			}
		}
		
		
		exit;

	}

	//for handle 404
	public function page_not_found()
	{	
		//$this->check_admin_login();
		$this->get_header('Page not found');
		$this->load->view('page_not_found');
		$this->load->view('inc/footer');
	}
	

	//Admin Dashboard
	public function dashboard()
	{
		$this->check_admin_login();
		$where=array('status'=>1);
		$where_r=array('status'=>'Active','role'=>3,'otp_verify_first'=>1);
		$where_s=array('status'=>'Active','role'=>2,'otp_verify_first'=>1);
		$where_o=array('status'=>'Active','role'=>4,'otp_verify_first'=>1);
		$where_c=array('status'=>'Active','role'=>5,'otp_verify_first'=>1);
		$data['product']=$this->common_model->count_results('product',$where);
		$data['supplier']=$this->common_model->count_results('supplier',$where);
		$data['company']=$this->common_model->count_results('company',$where);
		$data['retailer']=$this->common_model->count_results('user',$where_r);
		$data['app_supplier']=$this->common_model->count_results('user',$where_s);
		$data['app_other']=$this->common_model->count_results('user',$where_o);
		$data['app_company']=$this->common_model->count_results('user',$where_c);
		$session_admin_id = $this->session->userdata('admin_id');
		$session_role_id = $this->session->userdata('role_id');

		
		$config['title'] = 'Login';
		$this->get_header('Dashboard');
		$this->load->view('backend/dashboard',$data);
		$this->load->view('inc/footer');
	}


	//------------Set Profile---------------
	public function profile()
	{  
		$this->check_admin_login();
		$data['rec'] = $this->common_model->get_entry_by_data('user',true,array('user_id'=>$this->session->userdata('admin_id')));

		$this->form_validation->set_rules('fname','First Name','trim|required');
		$this->form_validation->set_rules('lname','Last Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('address','Address','trim|required');
		$this->form_validation->set_rules('landmark','Landmark','trim|required');
		

		if($this->form_validation->run() == TRUE)
		{  
			$data=$_POST;

			$where = array(
				'user_id'=>$this->session->userdata('admin_id')
				);

			$data = $this->common_model->get_entry_by_data('user',true,$where);

			if($data) 
			{
				
			 	//------Upload profile pic--------
				$data_pic='';
				//$data['ltype'] = $this->input->post('login_type');
				$config['upload_path'] = './uploads/profile';
				$config['allowed_types'] = '*';
				$config['max_size']	= '10240';
				$config['create_thumb'] = TRUE;
				$config['encrypt_name']  = TRUE;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
				}
				else
				{
					$data_pic = array('upload_data' => $this->upload->data());
					
				}

				if($data_pic)
					$image_url = $data_pic['upload_data']['file_name'];
				else
					$image_url = $this->input->post('prev_image');


				$records = array (
					'first_name' => $this->input->post ('fname'),
					'last_name' => $this->input->post ('lname'),
					'email' => $this->input->post ('email'),
					'address' => $this->input->post ('address'),
					'landmark' => $this->input->post ('landmark'),
					'profile_pic' => $image_url,
					'update_date' => date('Y-m-d H:i:s'),
					);

				$where_id = array(
					'user_id'=>$this->session->userdata('admin_id')
					);

				//update profile for admin/subadmin
				$this->common_model->update_entry('user',$records,$where_id);
				
				//update the session variables
				$session_array = array(
					
					'admin_fname'  => $this->input->post ('fname'),
					'admin_lname'  => $this->input->post ('lname'),
					);
				
				$this->session->set_userdata($session_array);
				$this->session->set_flashdata('succ',"Profile has been Updated Successfully");
				redirect(base_url('apanel/profile'));

			}
			else { 
					//$this->session->set_flashdata('posted_email',$this->input->post('email'));
				$this->session->set_flashdata('err',"Records Not Updated");
				redirect(base_url('apanel/profile'));

			}
			
		}
		else
		{ 
			$this->get_header('Profile');
			$this->load->view('backend/profile',$data);
			$this->load->view('inc/footer');
		}
		
	}
	//function for delete unwanted user
	public function deletUnwantedUser()
	{
		//$this->check_admin_login();
		$from_date='2017-12-10';
		$to_date=Date('Y-m-d');
		$where=array('DATE_FORMAT(regis_date,"%Y-%m-%d") < '=>$to_date ,'DATE_FORMAT(regis_date,"%Y-%m-%d") >'=>$from_date,'otp_verify_first'=>'0');
        $unwantedUser= $this->Retailer_model->get_all_entries('user', array(
            'fields' => array(
                'user' => array('user_id'),               
            ),
            'sort'    => 'user.user_id',
            'sort_type' => 'asc',            
	        'custom_where' => 'DATE_FORMAT(regis_date,"%Y-%m-%d") < "'.$to_date.'" AND DATE_FORMAT(regis_date,"%Y-%m-%d") >"'.$from_date.'" AND otp_verify_first=0',

	        ));
        if(!empty($unwantedUser) && !empty($unwantedUser[0]['user_id'])){
		      $Delete_retailer = $this->Retailer_model->DeleteRecord('user',$where);
        }

	}
	
}

?>
