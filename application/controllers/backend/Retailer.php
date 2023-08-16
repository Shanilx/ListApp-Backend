<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Retailer extends CI_Controller

{

	public function __construct()
        {
                parent::__construct();
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
		// $where = array('retailer' => $user_id);
		$where = array('role!='=>1);
		$orderby = 'user_id';
		$data['retailer_data'] = $this->Retailer_model->GetRecord('user',$where,$orderby,'desc');
		//print_r($data['records']);die;
		$this->get_header('Manage Retailer');
		$this->load->view('backend/retailer/Retailer_list', $data);
		$this->load->view('inc/footer'); 

		// $this->load->view('Retailer_list', $config);
	}
	public function Showretailer()
	{
		$this->check_admin_login();
		$states['records']=$this->getAllStates();
		$states['companies']=$this->getAllCompany();
		$this->get_header('Add Retailer');
		$this->load->view('backend/retailer/Addretailer',$states);
		$this->load->view('inc/footer'); 
	}
	public function Addretailer()

	{
		$this->check_admin_login();

		$contact_person=implode(',',$this->input->post('contact_person'));
		$contact_person=rtrim($contact_person, ",");
		$contact_person_mobile=implode(',',$this->input->post('contact_person_mobile'));
		$contact_person_mobile=rtrim($contact_person_mobile, ",");

		//$company_deal=$this->input->post('company_deal');

		// $company_deal_new=$this->input->post('company_deal_new');
		// if(!empty($company_deal_new)){
		//  for ($i=0; $i < count($company_deal_new); $i++) 
		//  { 
		//  	$company_deal[]=$this->getIdForProduct('company','company_name',$company_deal_new[$i]);
		//  }
		// }    

        //$company_deal=implode(',', $company_deal);
		//$company_deal=rtrim($company_deal, ",");
		
		$salt=mt_rand(100000,999999);
       // $hashedPassword = encode($this->input->post('password'), $salt);
        $hashedPassword = md5($this->input->post('password').''.$salt);

		$arr = array(
					'first_name' => $this->input->post('name'),
					'phone' =>$this->input->post('mobile_number_R'),
					'password' =>$hashedPassword,
			        'pwd_without_encode'=>$this->input->post('password'),
			        'salt'=>$salt,
					'role'=>$this->input->post('role'),
					'shop_name'=>$this->input->post('shop_name'),
					'landmark'=>htmlspecialchars($this->input->post('area')),	
					'address'=>htmlspecialchars($this->input->post('address')),	
					'state'=>$this->input->post('state_select'),
					'city'=>$this->input->post('city'),
					'email'=>$this->input->post('email'),
					'dl_no'=>$this->input->post('dln_no'),
					'tin_no'=>$this->input->post('tln_no'),
					'estd_year'=>$this->input->post('estd_no'),
					'contact_person'=>$contact_person,//$this->input->post('contact_person'),
					'contact_person_number'=>$contact_person_mobile,//$this->input->post('contact_person'),
					//'company_deal'=>$company_deal,//$this->input->post('company_deal'),
					'authe_no_authe'=>$this->input->post('authe_no_authe'),
					'status'=>'1',
					'regis_date'=> date("Y-m-d h:i:s")
					);
		
		$save_result=$this->Retailer_model->save_entry('user',$arr);
		
		if($save_result!='')
		{ 
				
			$this->session->set_flashdata('succ','Retailer has been Added Successfully');
			redirect(base_url().'apanel/Retailer');
		}
		else
		{
			$this->session->set_flashdata('err','Retailer has not been Added. Please Try Again');
			redirect(base_url().'apanel/Retailer');
		}
     
	}
	public function Editretailer($id)
	{
		$this->check_admin_login();
		$where = array('user_id' => ci_dec($id));
		$orderby = '';
		$data['edit_retailer'] = $this->Retailer_model->GetRecord('user',$where,$orderby);
     // print_r($data);die;

		$data['records']=$this->getAllStates();

		$state_id=$data['edit_retailer'][0]['state']; 

		$data['cities']=$this->getCity($state_id);
		$data['companies']=$this->getAllCompany();
		//print_r($data['companies']); die;
		$this->get_header('Edit Retailer');
		$this->load->view('backend/retailer/Editretailer', $data);
		$this->load->view('inc/footer');  

		//print_r($data['edit_retailer']);die;
	}
	public function EditretailerData($id)
	{
		$this->check_admin_login();
	//print_r($_POST);die;
		$contact_person_arr=array_filter($this->input->post('contact_person'), create_function('$value', 'return $value !== "";'));
		//$company_deal_arr=array_filter($this->input->post('company_deal'), create_function('$value', 'return $value !== "";'));
		$contact_person=implode(',',$contact_person_arr);
		$contact_person=rtrim($contact_person, ",");

		$contact_person_mobile=implode(',',$this->input->post('contact_person_mobile'));
		$contact_person_mobile=rtrim($contact_person_mobile, ",");

           

		//$company_deal_new=$this->input->post('company_deal_new');
		// if(!empty($company_deal_new)){
		//  for ($i=0; $i < count($company_deal_new); $i++) 
		//  {   
		 	
		//  	$company_deal_arr[]=$this->getIdForProduct('company','company_name',$company_deal_new[$i]);
		//  }
		// }    

        

		// $company_deal=implode(',',$company_deal_arr);
		// $company_deal=rtrim($company_deal, ",");
        $real_password=$this->input->post('password');

		
        /*$query_check_p=$this->db->get_where('retailer',array("password"=>$real_password, 'id'=>$id));
        if($query_check_p->num_rows() > 0 ){
        	$real_password=$query_check_p->row()->real_password;
        	$password=$this->input->post('password');
        }else{
        	$password=sha1($this->input->post('password'));
        }*/
        //$hashedPassword = encode($this->input->post('password'), $this->input->post('salt'));
        $hashedPassword = md5($this->input->post('password').''.$this->input->post('salt'));

		$arr = array(
					'first_name' => $this->input->post('name'),
					'phone' =>$this->input->post('mobile_number_R'),
					'password' =>$hashedPassword,
			        'pwd_without_encode'=>$this->input->post('password'),
					'role'=>$this->input->post('role'),
					'shop_name'=>$this->input->post('shop_name'),
					'landmark'=>htmlspecialchars($this->input->post('area')),	
					'address'=>htmlspecialchars($this->input->post('address')),	
					'state'=>$this->input->post('state_select'),
					'city'=>$this->input->post('city'),
					'email'=>$this->input->post('email'),
					'dl_no'=>$this->input->post('dln_no'),
					'tin_no'=>$this->input->post('tln_no'),
					'estd_year'=>$this->input->post('estd_no'),
					'contact_person'=>$contact_person,//$this->input->post('contact_person'),
					'contact_person_number'=>$contact_person_mobile,//$this->input->post('contact_person'),
					//'company_deal'=>$company_deal,//$this->input->post('company_deal'),
					'authe_no_authe'=>$this->input->post('authe_no_authe'),
					'status'=>'1',
					'update_date'=>Date('Y-m-d h:i:s')
					);

		$where = array('user_id' => ci_dec($id));
		// $orderby = '';
		$update_retailer = $this->Retailer_model->UpdateData('user',$arr,$where);
		if($update_retailer!='')
		{ 
			$this->session->set_flashdata('succ','Retailer Details have been Updated Successfully');
			redirect(base_url().'apanel/Retailer');
		}
		else
		{
			$this->session->set_flashdata('err','Retailer Details have not been Updated. Please Try Again');
			redirect(base_url().'apanel/Retailer');
		}

		//print_r($data['edit_user']);die;
	}
	public function Deleteretailer($id)
	{
       $where=array('user_id'=>$id);
		$Delete_retailer = $this->Retailer_model->DeleteRecord('user',$where);
		if($Delete_retailer!='')
		{ 
			$this->session->set_flashdata('succ','Retailer has been Deleted Successfully');
			redirect(base_url().'apanel/Retailer');
		}
		else
		{
			$this->session->set_flashdata('err','Retailer has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/Retailer');
		}

	}

	public function getAllStates()
	{
		$where = array('country_id' => '101','id'=>'21');
		return $data=$this->Retailer_model->GetRecord('states', $where);
		
	}
	public function getAllCompany()
	{
		$where = array('status' => '1');
		$orderby='company_name';
		$sort='ASC';
		return $data=$this->Retailer_model->GetRecord('company', $where,$orderby,$sort);
		
	}
	public function getCity($state_id='')
	{
		
		$where1 = array('state_id' => $state_id,'id'=>'2229');
		return $data1=$this->Retailer_model->GetRecord('cities',$where1);
		
		
	}
	public function getAllCities()
	{     
		
		$state_id=$this->input->post('state_id');
		$where1 = array('state_id' => $state_id,'id'=>'2229');
		$data1=$this->Retailer_model->GetRecord('cities',$where1);

		// print_r($data1); die;
		$cities='<option value="">Select City</option>';
		if(!empty($data1)){
			foreach ($data1 as $value) {
			$cities .='<option value="'.$value['id'].'">'.$value['name'].'</option>';
		  }
		}else{
			//$cities.='<option disabled>Note : Please Select State First </option>';
		}
		

		echo $cities;
	}

 //    public function viewSuplierDetail($id)
	// {
	// 	$where = array('id' => $id);
	// 	$orderby = '';
	// 	$data['record'] = $this->Retailer_model->GetRecord('retailer',$where,$orderby);

	// 	$state_id=$data['record'][0]['state'];
	// 	$city_id=$data['record'][0]['city'];

	// 	$data['state']=$this->getAllStates($state_id);
 

	// 	$data['cities']=$this->getCity($city_id);
	// 	//print_r($data['cities']); die;
	// 	$this->get_header('View Retailer');
	// 	$this->load->view('backend/retailer/Retailer_detail_view', $data);
	// 	$this->load->view('inc/footer');  

	// 	//print_r($data['edit_retailer']);die;
	// }

	public function retailer_changeStatus(){
    // echo 'ok';

    // $this->check_admin_login();
    // print_r($_POST);
     $action = $this->input->post('ac');
     $actionid = $this->input->post('acid');
    if(!empty($action) && !empty($actionid)){

      if($action == 'deactivate'){
        $status = 'Deactive';
        $this->common_model->update_entry('user',array('status'=>$status),array('user_id'=>$actionid,));
      } else {
        $status = 'Active';
        $this->common_model->update_entry('user',array('status'=>$status),array('user_id'=>$actionid));
      }
      
    
      echo 'ok';exit;

    } else {
      echo '';exit;
    }
  }
  public  function retailer_detail($id='')
      {
        $retailer_id=ci_dec($id);
        $where=array('user_id'=>$retailer_id);
        $data['record'] = $this->common_model->GetSingleRecord('user',$where);
        //echo $this->db->last_query();
         // echo "<pre>";

          ///print_r($data);die;
        $this->load->view('backend/retailer/Retailer_detail_view',$data);
    }


    //Function for Load data in data table using ajax starts

     public function GetName($table,$col_id,$val,$rt_colName)
     {
        $where=array($col_id=>$val);
        $data= $this->Retailer_model->GetRecord($table, $where);
        return $data[0][$rt_colName];
     }
   
  public function ajaxDataTableRetailer()
  {
  	error_reporting(1);
     $result=$this->common_model->get_all_entries('user', array(
            'fields' => array(
                'user' => array('*'),
                'role' => array('role_name'),
                'states' => array('name as state_name'),
                'cities' => array('name as city_name'),
            ),
            'sort'    => 'user.user_id',
            'sort_type' => 'desc',
            //'start'    => 0,
           //'limit'    => ,
        'joins' => array(
          'role' => array('role_id','role'),  
          'states' => array('id','state'),  
          'cities' => array('id','city'),  
            ),    
       'custom_where' => "user.role!='1' AND user.otp_verify_first = '1'",

        )); 
        // echo $this->db->last_query();die;
        //echo count($result); 
        $data = array();
        $sn=1;
        foreach ($result  as $r) {      
          
          if(strlen($r['address'])>20){
            $address=substr($r['address'], 0,20).'...';
          }else{
          	$address=$r['address'];
          }
          if(strlen($r['landmark'])>20){
            $area=substr($r['landmark'], 0,20).'...';
          }else{
          	$area=$r['landmark'];
          }

                $contact_person=explode(',',$r['contact_person']);
                if(!empty($contact_person)&& !empty($r['contact_person'])){
                $contact_person_mobiles= explode(',',$r['contact_person_number']);
                 $contact_person_with_no='';
                 $cont_p_no='NA';
                 for ($i=0; $i <count($contact_person) ; $i++) { 
            	if($i < 2){
                  $contact_person_mobile=($contact_person_mobiles[$i])?$contact_person_mobiles[$i]:"NA";
            	 $contact_person_with_no.=$contact_person[$i].' <b>-</b> '. $contact_person_mobile .',<br>';
            	}
            	else{
            		$cont_p_no=rtrim($contact_person_with_no,',<br>').' ...';
            	}
            }
            $cont_p_no=rtrim($contact_person_with_no,',<br>');
            }
            else{
            	$cont_p_no="NA";
            }
            



          if($r['status']=='Active'){
            $status='<span id="span_active_'.$r['user_id'].'" class="label label-success">Active</span>';
            $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="retailer_changeStatus btn btn-default btn-sm" id="deactivate_'.$r['user_id'].'" title="Deactivate" ><i class="fa fa-ban fa-lg" id="icon_'.$r['user_id'].'"></i></a>';

             }
            else{
              $status='<span id="span_deactivate_'.$r['user_id'].'" class="label label-danger" >Deactive</span>';

              $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="retailer_changeStatus btn btn-default btn-sm" id="activate_'.$r['user_id'].'" title="Activate"><i class="fa fa-check fa-lg" id="icon_'.$r['user_id'].'"></i></a>';
            }

          $view_link="<a class='btn btn-default btn-sm' data-target='#retailerModal' data-toggle='modal' href='". base_url()."apanel/Retailer/retailer_detail/".ci_enc($r['user_id'])."' title='View Retailer'><i class='fa fa-eye'></i></a>";                      
          $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Retailer/Editretailer/" . ci_enc($r['user_id'])."' title='Edit' > <i class='fa fa-pencil-square-o'></i></a>";
          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['user_id'].")' title='Delete'> <i class='fa fa-trash-o'></i></a>";
        
        $r['regis_date']= date('d-m-Y h:i:s',strtotime($r['regis_date']));
        $r['authe_no_authe']=($r['authe_no_authe']=='Yes')?$r['authe_no_authe']:"No";
        $r['dl_no']=($r['dl_no'])?$r['dl_no']:"NA";
        $r['tin_no']=($r['tin_no'])?$r['tin_no']:"NA";
        $r['estd_year']=($r['estd_year'])?$r['estd_year']:"NA";
            array_push($data, array(
                $sn,
               utf8_encode( ucfirst($r['role_name'])),
                utf8_encode($r['shop_name']),
                utf8_encode($r['first_name'].' '.$r['last_name']),
                utf8_encode($r['phone']),
                utf8_encode($r['email']),
                utf8_encode($address),
                utf8_encode($r['state_name']),
                utf8_encode($r['city_name']),
                utf8_encode($area),
                utf8_encode($r['dl_no']),
                utf8_encode($r['tin_no']),
                utf8_encode($r['estd_year']),
                utf8_encode($cont_p_no),
                utf8_encode($r['authe_no_authe']),
                utf8_encode($r['regis_date']),
                utf8_encode($status),
                utf8_encode($edit_link. $view_link.$delete_link.$changeStatus)
            ));
            $sn++;

          
        }

 
        echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['retailer_id'])."'> <i class='fa fa-eye'></i></a>
    }
    //Function for Load data in data table using ajax starts


    public function getIdForProduct($table='',$col_name='',$value)
          {
            if($value!=''){
             $where = array($col_name =>$value);
             $data= $this->product_model->GetRecord($table, $where);
             if(is_array($data) && !empty($data)){
              if($table=='company'){
                $id=$data[0]['company_id'];
              }
              else if($table=='form'){
                $id=$data[0]['form_id'];
              }
              else if($table=='packing_type'){
                $id=$data[0]['packing_type_id'];
              }
              else if($table=='packsize'){
                $id=$data[0]['pack_size_id'];
              }
              else if($table=='schedule'){
                $id=$data[0]['schedule_id'];
              }

            }else{
              $arr = array(
                $col_name=>$value,
                'date_added'=>Date('Y-m-d h:i:s')
                );
              $save_data = $this->product_model->save_entry($table,$arr);
              $id=$this->db->insert_id();
            }
            return $id;
          }else{
            return $id='';
          }
        }

public function check_emial_mobile()
	{
		$email = trim($this->input->post('email'));
		$mobile_number = trim($this->input->post('mobile_number'));
		if($email)
		{
			if(strpos($email,'__')==true)
			{
				$exp=explode('__', $email);
				$data=$this->db->query("SELECT * FROM m16j_user WHERE `user_id`!='".$exp['1']."' AND `email`='".$exp[0]."' ")->row();
			}else{

			$data = $this->Retailer_model->get_entry_by_data(true, array('email' => $email), "email","user");
			}
		}
		else if ($mobile_number)
		{
			if(strpos($mobile_number,'__')==true)
			{
				$exp=explode('__', $mobile_number);
				$data=$this->db->query("SELECT * FROM m16j_user WHERE `user_id`!='".$exp['1']."' AND `phone`='".$exp['0']."' ")->row();
			}else{

			$data = $this->Retailer_model->get_entry_by_data(true, array('phone' => $mobile_number), "phone","user");
			}
		}
		
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
	
}//end of controller class