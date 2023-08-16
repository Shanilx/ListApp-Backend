<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Retailer extends CI_Controller

{

	public function __construct()
        {
                parent::__construct();
                $this->check_admin_login();
                date_default_timezone_set('Asia/Kolkata');
                $this->deletUnwantedUser();
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
		$states['cities']=$this->getCity('21');
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
        $hashedPassword = encode($this->input->post('password'), $salt);

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
        $hashedPassword = encode($this->input->post('password'), $this->input->post('salt'));

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
		$where = array('country_id' => '101');
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
		
		$where1 = array('state_id' => $state_id);
		return $data1=$this->Retailer_model->GetRecord('cities',$where1);
		
		
	}
	public function getAllCities()
	{     
		
		$state_id=$this->input->post('state_id');
		$where1 = array('state_id' => $state_id);
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
     //$where = array('role!='=>1,'otp_verify_first'=>1);
     // $result=$this->Retailer_model->GetRecord('user',$where,'user_id','desc');
     $result=$this->Retailer_model->get_all_entries('user', array(
            'fields' => array(
                'user' => array('*'),
                'role' => array('role_name'),
                'states' => array('name as state_name'),
                'cities' => array('name as city_name'),
            ),
            'sort'    => 'user.user_id',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'role' => array('role_id','role'),  
          'states' => array('id','state'),  
          'cities' => array('id','city'),  
            ),    
       'custom_where' => "user.role!='1' AND user.otp_verify_first = '1'",

        ));  

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
            $status='<span id="span_active_'.$r['user_id'].'" class="label label-success">Active</span><span style="display:none;" id="span_deactivate_'.$r['user_id'].'" class="label label-danger" >Deactive</span>';
            $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="retailer_changeStatus btn btn-default btn-sm" id="deactivate_'.$r['user_id'].'" title="Deactivate" ><i class="fa fa-ban fa-lg" id="icon_'.$r['user_id'].'"></i></a>';

             }
            else{
              $status='<span id="span_deactivate_'.$r['user_id'].'" class="label label-danger" >Deactive</span><span style="display:none;" id="span_active_'.$r['user_id'].'" class="label label-success">Active</span>';

              $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="retailer_changeStatus btn btn-default btn-sm" id="activate_'.$r['user_id'].'" title="Activate"><i class="fa fa-check fa-lg" id="icon_'.$r['user_id'].'"></i></a>';
            }

          $view_link="<a class='btn btn-default btn-sm' data-target='#retailerModal' data-toggle='modal' href='". base_url()."apanel/Retailer/retailer_detail/".ci_enc($r['user_id'])."' title='View Retailer'><i class='fa fa-eye'></i></a>";                      
          $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Retailer/Editretailer/" . ci_enc($r['user_id'])."' title='Edit' > <i class='fa fa-pencil-square-o'></i></a>";

        //  $lh_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Retailer/login-history/" . ci_enc($r['user_id'])."/today' title='Login History'> <i class='fa fa-history'></i></a>";

          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['user_id'].")' title='Delete'> <i class='fa fa-trash-o'></i></a>";
        
        $r['regis_date']= date('d-m-Y h:i:s',strtotime($r['regis_date']));
        $r['authe_no_authe']=($r['authe_no_authe']=='Yes')?$r['authe_no_authe']:"No";
        $r['dl_no']=($r['dl_no'])?$r['dl_no']:"NA";
        $r['tin_no']=($r['tin_no'])?$r['tin_no']:"NA";
        $r['estd_year']=($r['estd_year'])?$r['estd_year']:"NA";
            array_push($data, array(
                $sn,
                ucfirst($r['role_name']),
                $r['shop_name'],
                htmlentities( (string) $r['first_name'].' '.$r['last_name'], ENT_QUOTES, 'utf-8', FALSE),
                $r['phone'],
                //$r['email'],
                $address,
                $r['state_name'],
                $r['city_name'],
                //$area,
                //$r['dl_no'],
                //$r['tin_no'],
               // $r['estd_year'],
                //$cont_p_no,
                //$r['authe_no_authe'],
                $r['regis_date'],
                $status,
                $edit_link. $view_link.$delete_link.$changeStatus
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
				$data=$this->db->query("SELECT * FROM m16j_user WHERE `user_id`!='".$exp['1']."' AND `email`='".$exp[0]."' ")->result_array();
			}else{

			$data = $this->Retailer_model->get_entry_by_data(flase, array('email' => $email), "email","user");
			}
		}
		else if ($mobile_number)
		{
			if(strpos($mobile_number,'__')==true)
			{
				$exp=explode('__', $mobile_number);
				$data=$this->db->query("SELECT * FROM m16j_user WHERE `user_id`!='".$exp['1']."' AND `phone`='".$exp['0']."'")->result_array();
			}else{

			$data = $this->Retailer_model->get_entry_by_data(flase, array('phone' => $mobile_number), "phone","user");
			}
		}
		
		if(!empty($data)&& $data[0]['otp_verify_first']===1)
		{
			echo (json_encode(false));
		}
		else
		{
			if(!empty($data) && $data[0]['otp_verify_first']===0){
				$where_un=array('user_id'=>$data[0]['user_id'],'otp_verify_first'=>0);
				$this->Retailer_model->DeleteRecord('user',$where_un);
			}
			echo (json_encode(true));
		}
	}

	 function export_retailer()
    {
    	$this->check_admin_login();
    	$this->phpexcel->setActiveSheetIndex(0);
    	$this->phpexcel->getActiveSheet()->setCellValue('A1', 'Firm Name');
    	$this->phpexcel->getActiveSheet()->setCellValue('B1', 'Retailer Name');
    	$this->phpexcel->getActiveSheet()->setCellValue('C1', 'Mobile Number');
    	//$this->phpexcel->getActiveSheet()->setCellValue('D1', 'Password');
    	$this->phpexcel->getActiveSheet()->setCellValue('D1', 'Address');
    	$this->phpexcel->getActiveSheet()->setCellValue('E1', 'Area');
    	$this->phpexcel->getActiveSheet()->setCellValue('F1', 'State');
    	$this->phpexcel->getActiveSheet()->setCellValue('G1', 'City');
    	$this->phpexcel->getActiveSheet()->setCellValue('H1', 'Email');
    	$this->phpexcel->getActiveSheet()->setCellValue('I1', 'DL Number');
    	$this->phpexcel->getActiveSheet()->setCellValue('J1', 'GSTIN Number'); 
    	$this->phpexcel->getActiveSheet()->setCellValue('K1', 'ESTD. Year'); 
    	$this->phpexcel->getActiveSheet()->setCellValue('L1', 'Contact Person'); 
    	$this->phpexcel->getActiveSheet()->setCellValue('M1', 'Person Contact Number'); 
    	$this->phpexcel->getActiveSheet()->setCellValue('N1', 'Uesr Type'); 
    	$this->phpexcel->getActiveSheet()->setCellValue('O1', 'Authenticated'); 

    	$this->phpexcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->phpexcel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	//$this->phpexcel->getActiveSheet()->getStyle('P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //make the font become bold
    	$this->phpexcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
    	$this->phpexcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
    	//$this->phpexcel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
    	$where = array('role!='=>1);
    	$data_d = $this->product_model->GetRecord('user', $where,'regis_date','asc');
    	$exceldata="";
    	foreach ($data_d as $row)
    	{

    		$shop_name=ucfirst($row['shop_name']);
    		$retailer_name=ucfirst($row['first_name']);
    		$phone=$row['phone'];
    		//$password=$row['pwd_without_encode'];
    		$address=trim($row['address']);
    		$area=trim($row['landmark']);
    		$email=$row['email'];
    		$dl_no=$row['dl_no'];
    		$gstin_number=$row['tin_no'];
    		$estd_year=$row['estd_year'];
    		$contact_person=$row['contact_person'];
    		$contact_number=$row['contact_person_number'];
    		$authenticated=$row['authe_no_authe'];
    		$role=ucfirst($this->getUserType($row['role']));
    		$state='NA';
    		$city='NA';
    		if($row['state'] > 0)
    		{
    			$state=$this->GetName('states','id',$row['state'],'name');                   	
    		}
    		if($row['city']>0)
    		{
    			$city=$this->GetName('cities','id',$row['city'],'name');                   	
    		}
    		$exceldata[] = array(
    			'firm_name'=>$shop_name,
    			'retailer_name'=>$retailer_name,
    			'mobile_number'=>$phone,
    			//'password'=>$password ,
    			'address'=>$address,
    			'area'=>$area,
    			'state' =>$state ,
    			'city'=> $city,
    			'email'=>$email,
    			'dl_number'=>$dl_number,
    			'gstin_number'=>$gstin_number,
    			'estd_year'=>$estd_year,
    			'contact_person' =>$contact_person,
    			'person_contact_number'=>$contact_number,
    			'user_type' =>$role,
    			'authenticated'=>$authenticated 
    		);
    		$this->phpexcel->getActiveSheet()->fromArray($exceldata, null, 'A2');
    	}	
              $filename="Retailer List.xlsx"; //save our workbook as this file name
              header("Content-Type: application/vnd.ms-excel");
              header('Content-Disposition: attachment;filename="'.$filename.'"');
              header('Cache-Control: max-age=0'); 
              $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007'); 
              $objWriter->save('php://output');
          }

          public function import_retailer($value='')
          {	
          	$this->check_admin_login();
          	$this->get_header('Upload Retailer');
          	$this->load->view('backend/retailer/upload_retailer');
          	$this->load->view('inc/footer');
          }



          public function bulk_upload()
          {
          	$configUpload['upload_path'] = './uploads/retailer/bulk_files';
          	$configUpload['allowed_types'] = 'xlsx';
          	$configUpload['detect_mime'] = true;
          	$this->load->library('upload', $configUpload);
          	if (!$this->upload->do_upload('csv_file'))
          	{
          		$this->session->set_flashdata('err', 'Please use file in the format of .xlsx');
          		//echo "upload error to file";die;

          		$error = array('error' => $this->upload->display_errors());

          		$this->session->set_flashdata('err', $error['error']);

          		//redirect(base_url().'backend/Retailer/import_retailer');
          	}
          	else
          	{
          		$file_data = $this->upload->data();
          		$file_path =  './uploads/retailer/bulk_files/'.$file_data['file_name'];
          		$extension=$file_data['file_ext'];  
          		if( $file_data['file_size'] > 0)
          		{
                       $objReader= PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                       $objReader->setReadDataOnly(true);    
                  //Load excel file
                       $objPHPExcel=$objReader->load($file_path);    
                      $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();  //Count Numbe of rows avalable in excel         
                      $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);  
                      $time= date('Y-m-d h:i:s');  
                       // echo $time;die;
                      $column1= trim($objWorksheet->getCellByColumnAndRow(0,1)->getValue());           
                      $column2= trim($objWorksheet->getCellByColumnAndRow(1,1)->getValue());           
                      $column3= trim($objWorksheet->getCellByColumnAndRow(2,1)->getValue());           
                      $column4= trim($objWorksheet->getCellByColumnAndRow(3,1)->getValue());           
                      $column5= trim($objWorksheet->getCellByColumnAndRow(4,1)->getValue());           
                      $column6= trim($objWorksheet->getCellByColumnAndRow(5,1)->getValue());           
                      $column7= trim($objWorksheet->getCellByColumnAndRow(6,1)->getValue());           
                      $column8= trim($objWorksheet->getCellByColumnAndRow(7,1)->getValue()); 
                      $column9= trim($objWorksheet->getCellByColumnAndRow(8,1)->getValue());
                      $column10= trim($objWorksheet->getCellByColumnAndRow(9,1)->getValue());
                      $column11= trim($objWorksheet->getCellByColumnAndRow(10,1)->getValue());
                      $column12= trim($objWorksheet->getCellByColumnAndRow(11,1)->getValue());
                      $column13= trim($objWorksheet->getCellByColumnAndRow(12,1)->getValue());
                      $column14= trim($objWorksheet->getCellByColumnAndRow(13,1)->getValue());
                      $column15= trim($objWorksheet->getCellByColumnAndRow(14,1)->getValue());
                      $column16= trim($objWorksheet->getCellByColumnAndRow(15,1)->getValue());


                      if((!empty($column1))&&(!empty($column3))&&(!empty($column4))&&(!empty($column15))) 
                      { 
                      	if(($column1=='Firm Name')&&($column2=='Retailer Name')&&($column3=='Mobile Number')&&($column4=='Password')&&($column5=='Address')&&($column6=='Area')&&($column7=='State')&&($column8=='City')&&($column9=='Email')&&($column10=='DL Number')&&($column11=='GSTIN Number')&&($column12=='ESTD. Year')&&($column13=='Contact Person')&&($column14=='Person Contact Number')&&($column15=='User Type')&&($column16=='Authenticated'))
                      	{
                  //loop from first data untill last data
                            $total_insert_record=0;
                      		$total_already_exists=0;
                      		$total_inccorect_mo=0;
                      		$total_not_insert_record=0;
                      		for($i=2;$i<=$totalrows;$i++)
                      		{
                      			$shop_name= trim($objWorksheet->getCellByColumnAndRow(0,$i)->getValue());
                      			$retailer_name= trim($objWorksheet->getCellByColumnAndRow(1,$i)->getValue());
                      			$contact_number= $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
                      			$password= trim($objWorksheet->getCellByColumnAndRow(3,$i)->getValue());
                      			$address= trim($objWorksheet->getCellByColumnAndRow(4,$i)->getValue());
                      			$area= trim($objWorksheet->getCellByColumnAndRow(5,$i)->getValue());
                      			$state=trim($objWorksheet->getCellByColumnAndRow(6,$i)->getValue());
                      			$city= trim($objWorksheet->getCellByColumnAndRow(7,$i)->getValue());
                      			$email=trim($objWorksheet->getCellByColumnAndRow(8,$i)->getValue());
                      			$dl_number= $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();
                      			$gstin_number= $objWorksheet->getCellByColumnAndRow(10,$i)->getValue();
                      			$estd_year= $objWorksheet->getCellByColumnAndRow(11,$i)->getValue();
                      			$contact_person=trim($objWorksheet->getCellByColumnAndRow(12,$i)->getValue());
                      			$contact_person_mobile= $objWorksheet->getCellByColumnAndRow(13,$i)->getValue();
                      			$user_type=trim($objWorksheet->getCellByColumnAndRow(14,$i)->getValue());
                      			$authenticated=trim($objWorksheet->getCellByColumnAndRow(15,$i)->getValue());

                    			//validation
                      			if(empty($shop_name) || empty($contact_number) || empty($password)|| empty($user_type))
                                {
                                    $this->session->set_flashdata('err', 'Firm Name, Mobile Number, Password, User Type are Required. Please Try Again');
                                  // redirect(base_url('backend/Retailer/import_retailer'));
                      			}
                                else
                                {   

                                
                                $state_id=$this->GetName('states','name',$state,'id');
                                $city_id=$this->GetName('cities','name',$city,'id');

                                $salt=mt_rand(100000,999999);
        						$hashedPassword = encode($password, $salt);
        							$role=3;
        						 if(strtolower($user_type)=="retailer"){
						            $role=3;
						          }
						          else if(strtolower($user_type)=="supplier"){
						            $role=2;
						          }
						          else if(strtolower($user_type)=="other"){
						            $role=4;
						          }else if(strtolower($user_type)=="company"){
						            $role=5;
          						}
                              
                                $arr = array(
											'first_name' => $retailer_name,
											'phone' =>$contact_number,
											'password' =>$hashedPassword,
									        'pwd_without_encode'=>$password,
									        'salt'=>$salt,
											'role'=>$role,
											'shop_name'=>$shop_name,
											'landmark'=>htmlspecialchars($area),	
											'address'=>htmlspecialchars($address),	
											'state'=>$state_id,
											'city'=>$city_id,
											'email'=>$email,
											'dl_no'=>$dl_number,
											'tin_no'=>$gstin_number,
											'estd_year'=>$estd_year,
											'contact_person'=>$contact_person,
											'contact_person_number'=>$contact_person_mobile,
											'authe_no_authe'=>$authenticated,
											'status'=>'1',
											'regis_date'=> date("Y-m-d h:i:s")
											);
								
								
                                //print_r($arr);die;
                                 $chek_product=array('phone'=>$contact_number);
                                 $already_exist = $this->common_model->get_entry_by_data("user",true, $chek_product, "user_id");
                                 if(empty($already_exist))
                                 {
                                 	if(strlen($contact_number)==10)
                                 	{
	                                  $save_result=$this->Retailer_model->save_entry('user',$arr);
	                                  if($save_result){
	                                    $total_insert_record++;
	                                  }
                                	}
                                else{
                                  	$total_inccorect_mo++;
                                  }

                                 }else
                                 {
                                    $total_already_exists++;
                                 }
                                

                                }//end validate else
                                //validation ends

                      		}//for loop end

                            if ($total_insert_record > 0 ) {
                                $succ_msg=$total_insert_record.' Retailer(s) has been Uploaded Succesfully. ';
                                if($total_already_exists > 0)
                                {
                                	$succ_msg.=$total_already_exists .' Retailer(s) Already Exists. ';
                                }
                                if($total_inccorect_mo > 0)
                                {
                                	$succ_msg.=$total_inccorect_mo .' Retailer(s) Mobile Number Are Incoorect.';
                                }
                                $this->session->set_flashdata('succ', $succ_msg);
                                echo "1";

                              //redirect(base_url('backend/Retailer'));
                            } elseif ($total_already_exists > 0) {
                               if($total_already_exists > 0)
                                {
                                	$suc.=$total_already_exists .' Retailer(s) Already Exists. ';
                                }
                                if($total_inccorect_mo > 0)
                                {
                                	$suc.=$total_inccorect_mo .' Retailer(s) Mobile Number Are Incoorect.';
                                }
                                $this->session->set_flashdata('err', $suc);
                                //redirect(base_url('backend/Retailer'));
                                echo "1";
                            }
                            elseif($total_inccorect_mo > 0)
                                {
                                $suc=$total_inccorect_mo .' Retailer(s) Mobile Number Are Incoorect.';
                                $this->session->set_flashdata('err', $suc);
                                }else{
                                	$this->session->set_flashdata('err', 'No Retailer has been Uploaded. Please Try Again');
                                }

                      	}
                      	else
                      	{
                      		$this->session->set_flashdata('err', 'Column Name should be according to Sample XLSX File. Please Try Again');
                                echo "2";
                      	}
                      }
                      else
                      {
                      	$this->session->set_flashdata('err', 'Column Name should be according to Sample XLSX File. Please Try Again');                       
                      	echo "2";

                      }
                  }
              }

          }

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


 public  function screen_detail($id='')
      {
      	error_reporting(1);
        $lh_id=ci_dec($id); 
        $where=array('login_id'=>$retailer_id);
        $data = $this->Retailer_model->get_all_entries('user', array(
            'fields' => array(
                'user' => array('first_name as user_name,phone'),
                'login_history' => array('*'),
            ),
            'sort'    => 'login_history.created_date',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'login_history' => array('user_id','user_id'),  
            ),    
       'custom_where' => "login_history.lh_id='".$lh_id."'",

        ));
        $rec['record']=$data[0];
        $this->load->view('backend/retailer/screen_detail_view',$rec);
    }


public function login_history($type)
{
	//$user_id=ci_dec($user_id);
	$type=trim($type);	
	switch ($type) {
		case 'today':
			$date=Date('Y-m-d');
			break;
		case 'last_week':
			$date=Date('Y-m-d' ,strtotime('today - 7 days'));
			break;	
		case 'last_month':
			$date=Date('Y-m-d' ,strtotime('today - 30 days'));
			break;		
		default:
			$date=Date('Y-m-d');
			break;
	}
	
      $data['record']= $this->Retailer_model->get_all_entries('user', array(
            'fields' => array(
                'user' => array('first_name as user_name,phone'),
                'login_history' => array('*'),
            ),
            'sort'    => 'login_history.created_date',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'login_history' => array('user_id','user_id'),  
            ),    
       'custom_where' => "DATE_FORMAT(created_date,'%Y-%m-%d') >= '".$date."'",

        ));    
      	//echo $this->db->last_query();die;
      	$this->get_header('login History');
      	$this->load->view('backend/retailer/login_history' ,$data);
      	$this->load->view('inc/footer');

}

//function for delete unwanted user
	public function deletUnwantedUser()
	{
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
		    $this->Retailer_model->DeleteRecord('user',$where);
        }

	}


	
}//end of controller class