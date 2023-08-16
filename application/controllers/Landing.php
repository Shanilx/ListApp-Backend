<?php
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller
{
	private $connection;
	
	/**
	 * Controller constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	public function send_email($to_email, $from_email, $subject, $message) 
	{ 
         $from_email = "nakumrahul5@gmail.com"; 

         //echo $to_email."    <br/>     ".$from_email."    <br/>     ".$subject."     <br/>    ". $message;
         
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

    public function test_email() 
	{ 
         $from_email = "nakumrahul5@gmail.com";
         $to_email='sachi.syscraft@gmail.com';
         //$subject = 'Registration Successful';		//not working
         $subject = 'Mail For';
         $message='this mail is to check <br/> the html formatted mail body on live'; 

         $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		 $this->email->set_header('Content-type', 'text/html');
   
         $this->email->from($from_email, 'LIST APP'); 
         $this->email->to($to_email);
         $this->email->subject($subject); 
         $this->email->message($message); 
   
         //Send mail 
         //$this->email->send();
         if($this->email->send()) 
         { echo "sent"; }
         else 
         { echo $this->email->print_debugger(); }
      }

	public function get_header($title='')
    {
    	$config['title'] = $title;
    	$this->load->view('landing/header_landing', $config);
    }

	public function home()
	{ 
		$this->form_validation->set_rules('first_name','First Name','trim|required');
		$this->form_validation->set_rules('last_name','Last Name','trim|required');
		$this->form_validation->set_rules('email','Email ID','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('mobile','Mobile Number','trim|required|numeric');

		if($this->form_validation->run() == TRUE)
		{
			$date_added = date('Y-m-d H:i:s');
			
			$arr = array(
				'role' => 2,
				'first_name' => $this->input->post('first_name'),
				'last_name' =>$this->input->post('last_name'),
				'email' =>$this->input->post('email'),
				'phone' =>$this->input->post('mobile'),
				'regis_date' => $date_added,
				'type' => 4,
				'status' => 'Deactive',
				'profile_pic'=>'user-avatar.png',
				'login_type' => 0,   //for website
				'social_id' => '',
				'email_verified' => 'no',
			);

			$arr['identity_pic']='certificate_1.png';
			$arr['board_certification']='certificate_1.png';
			$arr['drivers_license']='certificate_1.png';
			$arr['liability_insurance']='certificate_1.png';

			$save_patient = $this->patient_model->save_entry('user',$arr);

			if($save_patient!='')
			{ 
				$session_data = array(
					'user_id' => $save_patient,
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('mobile'),
					);
				$this->session->set_userdata($session_data);

				$this->session->set_flashdata('succ','User has been added successfully.Please fill below details also.');
				redirect(base_url().'signup');
			}
			else
			{
				$this->session->set_flashdata('err','User has not been added. Please try again.');
				redirect(base_url('home'));
			}
        }
        else
        {
        	$this->get_header('Home');
			$this->load->view('landing/landing');
			$this->load->view('landing/footer_landing');
        }
	}

	//function for detailed registration
	function signup()
	{
		$data['country'] = $this->patient_model->GetRecord('countries','','name', 'asc');
        $data['specialization'] = $this->patient_model->GetRecord('doctor_category','','category', 'asc');
        $data['languages'] = $this->patient_model->GetRecord('languages','','name', 'asc');

		if($this->session->userdata('user_id'))
		{
			$user_id = $this->session->userdata('user_id');
			$where = array('user_id' => $user_id);
			$orderby = '';
			$data['records'] = $this->doctor_model->GetRecord('user',$where,$orderby);
			    
		    $this->form_validation->set_rules('first_name','First Name','trim|required');
			$this->form_validation->set_rules('last_name','Last Name','trim|required');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('DOB','DOB','trim|required');
			$this->form_validation->set_rules('phone','Phone','trim|required');
			$this->form_validation->set_rules('alternate_no','Alternate no','trim|required');
			$this->form_validation->set_rules('specialization','specialization','trim|required');
			$this->form_validation->set_rules('qualification','qualification','trim|required');
			$this->form_validation->set_rules('scl_clz','scl_clz','trim|required');
			$this->form_validation->set_rules('university','university','trim|required');
			$this->form_validation->set_rules('country_1','Country','trim|required');
			$this->form_validation->set_rules('state_1','State','trim|required');
			$this->form_validation->set_rules('city_1','City','trim|required');
			$this->form_validation->set_rules('zipcode_1','Zipcode','trim|required');
			$this->form_validation->set_rules('address_1','Address','trim|required');
			$this->form_validation->set_rules('country_2','Country','trim|required');
			$this->form_validation->set_rules('state_2','State','trim|required');
			$this->form_validation->set_rules('city_2','City','trim|required');
			$this->form_validation->set_rules('zipcode_2','Zipcode','trim|required');
			$this->form_validation->set_rules('address_2','Address','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required');
			$this->form_validation->set_rules('list_of_experiences','List of Experiences','trim|required');
			$this->form_validation->set_rules('medical_license_no','Medical License Number','trim|required');
			$this->form_validation->set_rules('cpassword','Confirm Password','trim|required');

			if($this->form_validation->run() == TRUE)
			{ 
				if($this->input->post('DOB'))
		        	{	$dobNew = date('Y-m-d',strtotime(str_replace('-', '/', $this->input->post('DOB')))); }
		        else
		        	{ $dobNew = '0000-00-00'; }
				$date_updated = date('Y-m-d H:i:s');


				//------Upload profile pic--------
			 	$data_pic='';
			 	if(!empty($_FILES['userfile']['name']))
	            {
					//$data['ltype'] = $this->input->post('login_type');
					$config['upload_path'] = './uploads/profile';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '10240';
					$config['create_thumb'] = TRUE;
					$config['encrypt_name']  = TRUE;
					$this->load->library('upload', $config);
					$image = 'userfile';
					if (!$this->upload->do_upload($image))
					{
						$error = array('error' => $this->upload->display_errors());
					}
					else
					{
						$data_pic = array('upload_data' => $this->upload->data());
						
					}
	            }
				if($data_pic)
			    { 
			    	$image_url = $data_pic['upload_data']['file_name'];
			    }else{

	                if($this->input->post('user_image'))
	                {
					  $image_url = $this->input->post('user_image');
			        }else{
			          $image_url = $this->input->post('prev_image');
			        }
			    }
			    //------------Upload profile pic ends------------

			    //------Upload identity verification pic--------
			 	$identity_pic='';
			 	if(!empty($_FILES['identity_file']['name']))
	            {
					//$data['ltype'] = $this->input->post('login_type');
					$config['upload_path'] = './uploads/certificates';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$config['max_size']	= '10240';
					$config['create_thumb'] = TRUE;
					$config['encrypt_name']  = TRUE;
					$this->load->library('upload', $config);
					$img = 'identity_file';
					if (!$this->upload->do_upload($img))
					{
						$error = array('error' => $this->upload->display_errors());
					}
					else
					{
						$identity_pic = array('upload_data' => $this->upload->data());
					}
	            }
				if($identity_pic)
			    { 
			    	$identity_url = $identity_pic['upload_data']['file_name'];
			    }else{

	                if($this->input->post('identity_image'))
	                {
					  $identity_url = $this->input->post('identity_image');
			        }else{
			          $identity_url = $this->input->post('identity_prev_image');
			        }
			    }
			    //------------Upload identity verification pic ends------------

			    //------Upload board certification pic--------
			 	$board_cert_pic='';
			 	if(!empty($_FILES['board_cert_file']['name']))
	            {
					//$data['ltype'] = $this->input->post('login_type');
					$config['upload_path'] = './uploads/certificates';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$config['max_size']	= '10240';
					$config['create_thumb'] = TRUE;
					$config['encrypt_name']  = TRUE;
					$this->load->library('upload', $config);
					$img = 'board_cert_file';
					if (!$this->upload->do_upload($img))
					{
						$error = array('error' => $this->upload->display_errors());
					}
					else
					{
						$board_cert_pic = array('upload_data' => $this->upload->data());
					}
	            }
				if($board_cert_pic)
			    { 
			    	$board_cert_url = $board_cert_pic['upload_data']['file_name'];
			    }else{

	                if($this->input->post('board_cert_image'))
	                {
					  $board_cert_url = $this->input->post('board_cert_image');
			        }else{
			          $board_cert_url = $this->input->post('board_cert_prev_image');
			        }
			    }
			    //------------Upload board certification pic ends------------

			    //------Upload drivers license pic--------
			 	$drivers_lic_pic='';
			 	if(!empty($_FILES['drivers_lic_file']['name']))
	            {
					//$data['ltype'] = $this->input->post('login_type');
					$config['upload_path'] = './uploads/certificates';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$config['max_size']	= '10240';
					$config['create_thumb'] = TRUE;
					$config['encrypt_name']  = TRUE;
					$this->load->library('upload', $config);
					$img = 'drivers_lic_file';
					if (!$this->upload->do_upload($img))
					{
						$error = array('error' => $this->upload->display_errors());
					}
					else
					{
						$drivers_lic_pic = array('upload_data' => $this->upload->data());
					}
	            }
				if($drivers_lic_pic)
			    { 
			    	$drivers_lic_url = $drivers_lic_pic['upload_data']['file_name'];
			    }else{

	                if($this->input->post('drivers_lic_image'))
	                {
					  $drivers_lic_url = $this->input->post('drivers_lic_image');
			        }else{
			          $drivers_lic_url = $this->input->post('drivers_lic_prev_image');
			        }
			    }
			    //------------Upload drivers license pic ends------------

			    //------Upload liability insurance pic--------
			 	$liability_ins_pic='';
			 	if(!empty($_FILES['liability_ins_file']['name']))
	            {
					//$data['ltype'] = $this->input->post('login_type');
					$config['upload_path'] = './uploads/certificates';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$config['max_size']	= '10240';
					$config['create_thumb'] = TRUE;
					$config['encrypt_name']  = TRUE;
					$this->load->library('upload', $config);
					$img = 'liability_ins_file';
					if (!$this->upload->do_upload($img))
					{
						$error = array('error' => $this->upload->display_errors());
					}
					else
					{
						$liability_ins_pic = array('upload_data' => $this->upload->data());
					}
	            }
				if($liability_ins_pic)
			    { 
			    	$liability_ins_url = $liability_ins_pic['upload_data']['file_name'];
			    }else{

	                if($this->input->post('liability_ins_image'))
	                {
					  $liability_ins_url = $this->input->post('liability_ins_image');
			        }else{
			          $liability_ins_url = $this->input->post('liability_ins_prev_image');
			        }
			    }
			    //------------Upload liability insurance pic ends------------

	            $country_1=$this->input->post('country_1');
		        $state_1=$this->input->post('state_1');
		        $city_1=$this->input->post('city_1');
		        $zipcode_1=$this->input->post('zipcode_1');
		        $address_1=$this->input->post('address_1');

		        $country_2=$this->input->post('country_2');
		        $state_2=$this->input->post('state_2');
		        $city_2=$this->input->post('city_2');
		        $zipcode_2=$this->input->post('zipcode_2');
		        $address_2=$this->input->post('address_2');
		        
		        //get lat long
		        $place = '';
		        if($address_1) { $place .= str_replace(' ', '+', htmlspecialchars($address_1)); }
				if($city_1) { $place .= '+'.fetch_placeName('city', $city_1); }
				if($state_1) { $place .= '+'.fetch_placeName('state', $state_1); }
				if($country_1) { $place .= '+'.fetch_placeName('country', $country_1); }

				$lat_long = get_lat_long($place);
				$lat_long_arr = explode(' ', $lat_long);

				if($this->input->post('about'))
		        {
		        	$about = $this->input->post('about');
		        }
		        else
		        {
		        	$about = '';
		        }

				$arr = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' =>$this->input->post('last_name'),
						'phone' =>$this->input->post('phone'),
						'dob' =>$dobNew,
						'gender'=>$this->input->post('gender'),
						'language_id'=>$this->input->post('language'),
						'specialization' => $this->input->post('specialization'),
						'qualification' =>$this->input->post('qualification'),
						'school' =>$this->input->post('scl_clz'),
						'university' =>$this->input->post('university'),
						'country' =>$country_1,
			        	'state' =>$state_1,
			        	'city' =>$city_1,
			        	'zipcode' =>$zipcode_1,
			        	'address' =>htmlspecialchars($address_1),
			        	//'landmark' =>$landmark[0],
						'alternate_no'=>$this->input->post('alternate_no'),
						'update_date' => $date_updated,
						'profile_pic' => $image_url,
						'medical_license_no' => trim($this->input->post('medical_license_no')),
						'identity_pic' => $identity_url,
						'board_certification' => $board_cert_url,
						'drivers_license' => $drivers_lic_url,
						'liability_insurance' => $liability_ins_url,
						'profile' => $this->input->post('profile'),
						'latitude' => $lat_long_arr[0],
						'longitude' => $lat_long_arr[1],
						'list_of_experiences' => $this->input->post('list_of_experiences'),
						'about' => $about,
						
					);
				/*$state_nm = $this->patient_model->GetRecord('states', array('id'=>$state_1), 'name', 'asc'); 

				//check and generate member id
				if($data['records'][0]['member_id']=='' && trim($this->input->post('medical_license_no'))!='')
				{
					$member_id = substr(strtoupper($this->input->post('last_name')), 0,3).trim($this->input->post('medical_license_no')).substr(strtoupper($state_nm_1['name']), 0,1);
					$arr['member_id'] = $member_id;
				}*/

				$where = array('user_id' =>$user_id);
				# Update Doctor record
				$update_patient = $this->doctor_model->UpdateData('user',$arr,$where);

						//get lat long for all cities
                		$place = ''; $lat_long_arr = array(); $lat_long = '';
                		if($address_1) { $place .= str_replace(' ', '+', htmlspecialchars($address_1)); }
						if($city_1) { $place .= fetch_placeName('city', $city_1); }
						if($state_1) { $place .= '+'.fetch_placeName('state', $state_1); }
						if($country_1) { $place .= '+'.fetch_placeName('country', $country_1); }
						$lat_long = get_lat_long($place);
						$lat_long_arr = explode(' ', $lat_long);

                		$dataArray=array(
	                    'user_id'=>$user_id,
	                    'country_id' =>$country_1,
			        	'state_id' =>$state_1,
			        	'city_id' =>$city_1,
			        	'zipcode' =>$zipcode_1,
			        	'area' =>htmlspecialchars($address_1),
			        	'latitude' => $lat_long_arr[0],
						'longitude' => $lat_long_arr[1],
			            );
                        $save_doctor_location = $this->doctor_model->save_entry('dr_location',$dataArray); 

                        //get lat long for all cities
                		$place = ''; $lat_long_arr = array(); $lat_long = '';
                		if($address_2) { $place .= str_replace(' ', '+', htmlspecialchars($address_2)); }
						if($city_2) { $place .= fetch_placeName('city', $city_2); }
						if($state_2) { $place .= '+'.fetch_placeName('state', $state_2); }
						if($country_2) { $place .= '+'.fetch_placeName('country', $country_2); }
						$lat_long = get_lat_long($place);
						$lat_long_arr = explode(' ', $lat_long);

                		$dataArray=array(
	                    'user_id'=>$user_id,
	                    'country_id' =>$country_2,
			        	'state_id' =>$state_2,
			        	'city_id' =>$city_2,
			        	'zipcode' =>$zipcode_2,
			        	'area' =>htmlspecialchars($address_2),
			        	'latitude' => $lat_long_arr[0],
						'longitude' => $lat_long_arr[1],
			            );
                        $save_doctor_location = $this->doctor_model->save_entry('dr_location',$dataArray); 
	            
	            
				if($update_patient!='')
				{ 
					//email for registration to user
					//$subject = 'Registration Successful';
					$message = '';
					$message .= 'Hello '.$this->input->post('first_name').', <br/>';
					$message .= 'Thank you for registering on LIST APP. We will send you an email once we go live. After that you can enjoy our services. <br/>';
					$message .= 'Thanks, <br/> LIST APP Team';
					$subject = 'LIST APP - Registration Successful';
         			//$message='this mail is to view <br/> the html formatted mail body on live'; 
					$this->send_email($this->input->post('email'), '', $subject, $message);


					//email for registration to admin
					$subject = 'LIST APP - Registration Successful';
					$message = '';
					$message .= 'Hello Admin, <br/>';
					$message .= 'User with following details has been registered on LIST APP. Please see below the details of registered user: <br/>';
					$message .= 'Name - '.$this->input->post('first_name').' '.$this->input->post('last_name').'<br/>';
					$message .= 'Email ID - '.$this->input->post('email').' <br/>';
					$message .= 'Mobile Number - '.$this->input->post('phone').' <br/>';
					$message .= 'Thanks, <br/> LIST APP Team';
					$this->send_email('sachi.syscraft@gmail.com,nitinmangule.syscraft@gmail.com', '', $subject, $message);

					$this->session->set_flashdata('succ','User details has been updated successfully.');
					redirect(base_url().'thankyou');
				}
				else
				{
					$this->session->set_flashdata('err','User details has not been updated. Please try again.');
					redirect(base_url().'signup');
				}
			}else{

				$path = base_url().'js/ckfinder';
		        $width = '545px';
		        $height = '100px';
		        basic_editor($path, $width, $height);

		    	$this->get_header('Signup');
				$this->load->view('landing/landing_form',$data);
				$this->load->view('landing/footer_landing');
		    }

		}
		else
		{
			$this->session->set_flashdata('err','Please fill below form to register.');
			redirect(base_url('home'));
		}
			
	}


	//Fetch state as per the selected country
	public function get_state()
	{
		$id = $_POST['country_id'];
		$hide_state = $_POST['hide_state'];
		//echo $hide_state; die;

		$where = array('country_id'=>$id);
		$state= $this->patient_model->GetRecord('states', $where, 'name', 'asc');
		//echo $this->db->last_query();die;
        
		if(!empty($state))
		{
			echo "<option value=''>Select State</option>";
			foreach($state as $st)
			{
				if(!empty($hide_state))
				{
					if($hide_state==$st['id'])
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
			echo "<option value=".'0'.">NA</option>";
		}
		
	
	}



	//Fetch city as per the selected state
	public function get_city()
	{
		$id = $_POST['state_id'];
		$hide_city = $_POST['hide_city'];
		//echo "State id = ".$id." city = ".$hide_city; die;
			
		$where = array('state_id'=>$id);
		$city= $this->patient_model->GetRecord('cities', $where, 'name', 'asc');

		if(!empty($city))
		{
			echo "<option value=''>Select City</option>";
			foreach($city as $cty)
			{
				if(!empty($hide_city))
				{
					if($hide_city==$cty['id'])
					{
						echo "<option selected='selected' value=".$cty['id'].">".$cty['name']."</option>";		
					}
					else
					{
						echo "<option value=".$cty['id'].">".$cty['name']."</option>";
					}
				}
				else
				{
					echo "<option value=".$cty['id'].">".$cty['name']."</option>";
				}
				
			}
		}
		else
		{
			echo "<option value=".'0'.">NA</option>";
		}
	}

	//function for thankyou page
	function thankyou()
	{
		if($this->session->userdata('user_id'))
		{
			$this->session->sess_destroy();
			$this->get_header('Thank You');
			$this->load->view('landing/landing_thankyou');
			$this->load->view('landing/footer_landing');
		}
		else
		{
			$this->session->set_flashdata('err','Please fill below form to register.');
			redirect(base_url('home'));
		}
	}
}
