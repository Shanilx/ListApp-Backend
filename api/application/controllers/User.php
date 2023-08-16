<?php 
include_once(APPPATH.'libraries/REST_Controller.php');

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: PUT, GET, POST");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

header('Access-Control-Allow-Origin: *');
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header ("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");
header('Access-Control-Max-Age: 86400');

class User extends REST_Controller

{

	function __construct()

	{

		parent::__construct();	

		// $this->load->library('Image_lib');

	}

	

	



    public function login_post()

    {

    		

		 $email=$this->input->post('email');

		 $password = $this->input->post('password');

		

		 

		if(empty($email) || empty($password)){

			$final_data = array('error'=>'Please Provide all information','message'=>'','data'=>'');

				$this->set_response($final_data, REST_Controller::HTTP_OK);

			// echo json_encode(array('erorr'=>'Please Provide all information','message'=>'','data'=>''));

		}

		else

		{

		$where_salt = array(

			 'email'=>$this->input->post('email')

			);

        	$select_field = '*';

			$data_salt = $this->users_model->get_entry_by_data(true,$where_salt,$select_field);

				// print_r($data_salt);

            if(!empty($data_salt)) {

                $salt = $data_salt['salt'];

            }

			else

			{ 

			// echo json_encode(array('error'=>'Wrong Username or Password.','message'=>'','data'=>''));

			$error = array('error'=>'Wrong Username or Password','message'=>'','data'=>'');

				$this->set_response($error, REST_Controller::HTTP_OK);

			}

		

        

        /* Check user credentials*/ 

			$where = array(

			 'email'=>$email,	

			 'password'=>sha1($salt.$password)

			);

			

			$select_field = '*';

			

            $data = $this->users_model->CheckLogin('signup',$select_field,$where);

           



            

            // echo "<pre>";

            // print_r($data);die;

       

            if($data)

            {

				if($data->status != 1)

				{

					

				// echo json_encode(array('error'=>'Your account has been deactivated. Contact - 9977773388...','message'=>'Your account has been deactivated. Contact - 9977773388.','data'=>''));



				$error = array('error'=>'Your account has been deactivated. Contact - 9977773388..','message'=>'Your account has been deactivated. Contact - 9977773388.','data'=>'');

				$this->set_response($error, REST_Controller::HTTP_OK);

				}

			else{



		       	$record_array = array(

		        	  					'id'=>$data_salt['id'],

		        	  					'email'=>$data_salt['email'],

		        	  					'full_name'=>$data_salt['full_name'],

		        	  					'birth_date'=>$data_salt['birth_date'],

		        	  					'gender'=>$data_salt['gender']



		        	  					);

		       	

		        	  // echo json_encode(array('error'=>'.','message'=>'','data'=>$record_array));

		        	  $final_data = array('error'=>'','message'=>'','data'=>$record_array);

				$this->set_response($final_data, REST_Controller::HTTP_OK);

		        	

		        	}

		        }

		     else

			{  

				

				// echo json_encode(array('error'=>'Wrong Username or Password.','message'=>'','data'=>''));

				$error = array('error'=>'1','message'=>'Wrong Username or Password','data'=>'');

				$this->set_response($error, REST_Controller::HTTP_OK);

				//$this->response($error, REST_Controller::HTTP_OK);

			}

	}

 }

		 /*************************/



	// signup ...

	public function SignUp_post()

  {

    $fullName    =   $this->input->post('full_name');

    $email        =   $this->input->post('email');

    $password     =   $this->input->post('password');

    $birth_date    =   $this->input->post('birth_date');

    $gender      =   $this->input->post('gender');

   

		//check user email already exist or not

	    $where = array('email'=>$email);

	    $CheckeEmail = $this->users_model->GetRecord($where,'signup');

		 if($CheckeEmail)

		  {

		   //Return respose to mobile

		   // echo json_encode(array('error'=>'1','message'=>'This email id already exist','data'=>''));

		  	$final_data = array('error'=>'1','message'=>'This email id already exist','data'=>'');

				$this->set_response($final_data, REST_Controller::HTTP_OK);

		  }



       else

	  		{

	  			

   				$salt=randomString(16);



      //$encrypted_pass= encode($password,$salt);

      $encrypted_pass= md5($password.''.$salt);

	   //Make a new salt for paasword encryption

			   $arr = array(

			    	  'full_name'  => $fullName,

			          'email'      => $email,

			          'password'   => $encrypted_pass,

			          'birth_date'  => $birth_date,

			          'gender'     => $gender,

			          'status'     => '1',

			          'salt'       => $salt

			   );

	             //Accept last inserted id in $user_data

	   $user_data = $this->users_model->InsertData('signup',$arr);

		   if($user_data)

		   {

			    $whereId = array('id'=>$user_data);

			    //Select fields from database

			    $field_name = 'id ,full_name ,email ,birth_date,gender';



			    $GetRecord = $this->users_model->GetRecord($whereId,'signup');



			    // echo json_encode(array('error'=>'0','message'=>'You have been successfully registered','data'=>$GetRecord));

		    //$this->set_response($data, REST_Controller::HTTP_OK);

			    $final_data = array('error'=>'0','message'=>'You have been successfully registered','data'=>$GetRecord);

				$this->set_response($final_data, REST_Controller::HTTP_OK);

		   }

	   		else

	   		{

	   	 		// echo json_encode(array('error'=>'1','message'=>'Someting went wrong','data'=>''));

	    //$this->set_response($data, REST_Controller::HTTP_OK);

	   			 $final_data = array('error'=>'1','message'=>'Someting went wrong','data'=>'');

				$this->set_response($final_data, REST_Controller::HTTP_OK);

	   		}

	  }

    }

   public function update_post()

 {

  $userId  = $this->input->post('id');

  $name   = $this->input->post('full_name');

  $email        =   $this->input->post('email');

  $password     =   $this->input->post('password');

  $birth_date    =   $this->input->post('birth_date');

  $gender      =   $this->input->post('gender');

  // $mobile_no  = $this->input->post('mobilenumber');



  //Check User ID exist or not

  $where = array('id'=>$userId);

  $checkUserId = $this->users_model->GetRecord($where,'signup');

  // print_r($checkUserId);die;

	  if($checkUserId)

	  {

	   	$update_arr = array(

	    'full_name'=>$name,

	    'email'    => $email,

		'birth_date'  => $birth_date,

		 'gender'     => $gender

		 );

             //update user data according to user id

   $whereId = array('id'=>$userId);

   $updatePassword = $this->users_model->UpdateData('signup',$update_arr,$whereId);

   // print_r($updatePassword);

     if($updatePassword)

   	{

	   $GetRecord = $this->users_model->GetRecord($whereId,'signup');

	    // echo json_encode(array('error'=>'0','message'=>'Your profile has been updated successfully','data'=>$GetRecord));

	   $final_data = array('error'=>'0','message'=>'Your profile has been updated successfully','data'=>$GetRecord);

				$this->set_response($final_data, REST_Controller::HTTP_OK);

	}

   else

   {

    // echo json_encode(array('error'=>'1','message'=>'Something went wrong','data'=>''));

    $final_data = array('error'=>'1','message'=>'Something went wrong','data'=>$GetRecord);

				$this->set_response($final_data, REST_Controller::HTTP_OK);

   }

  }

  else

  {

   // echo json_encode(array('error'=>'1','message'=>'User does not exist','data'=>''));

  	$final_data = array('error'=>'1','message'=>'User does not exist','data'=>'');

				$this->set_response($final_data, REST_Controller::HTTP_OK);

  }

}

function sliderlist_get()
  {
    
     $sliderlist=$this->comman_model->GetRecord('m16j_slider','');
    
      if($sliderlist){
       return json_output(200,array('status' => 200,'message' => 'Success','data'=>$sliderlist));   
    }else{
       return json_output(201,array('status' => 201,'message' => 'not found','data'=>array()));   
    }
  }

  /* Update otp 17-01-2022 */

  function getotp_post(){

    $method = $_SERVER['REQUEST_METHOD'];
      if($method != 'POST'){
      echo json_encode(array('status' => 400,'message' => 'Bad request'));
      return ;
       } 
		  //$data = json_decode(file_get_contents('php://input'), true);
       $data = $this->input->post();
		  //, 'role'=>1
		  $query_email=$this->db->get_where('user_test',array("phone"=>$data['phone']));
	
		  $result = $query_email->result_array();
		  if(!empty($result))  
		  {
		    $otp=123456;
		    $arr["otp"]=$otp;
		    $user_data = $this->common_model->UpdateData('user_test',$arr,array("phone"=>$data['phone']));
		    echo json_encode(array('status' => 200,'message' => 'success',"otp"=>$otp));
		    
		  }else{
		     echo json_encode(array('status' => 201,'message' => 'not Found'));
		  }
		}

		function getUserProfile_post(){

          extract($this->input->post());
          if(empty($phone)){
              $mess =  json_encode(array('status' => 201,'message' => 'not found','data'=>'Mobile number is required'));
              return $this->set_response($mess, REST_Controller::HTTP_OK);
              exit;
          }else{
            $get_record = $this->common_model->GetSingleRecord('m16j_user_test',array('phone'=>$phone));
            
            if(empty($get_record)){
              $mess = array('status' => 201,'message' => 'record not exist please provide correct mobile number');
              return $this->set_response($mess, REST_Controller::HTTP_OK);
            }else{
              $mess = array('status' => 200,'message' => 'success', 'data'=>$get_record);
                return $this->set_response($mess, REST_Controller::HTTP_OK);
            }
            
          }
        }


	// end signup...

}

