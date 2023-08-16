<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller

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
		$orderby = 'supplier_id';
		$data['suplier_data'] = $this->Supplier_model->GetRecord('supplier',$where,$orderby,'desc');
// 		print_r($data['suplier_data']);die;
		$this->get_header('Manage Supplier');
		$this->load->view('backend/supplier/Supplier_list', $data);
		$this->load->view('inc/footer'); 

		// $this->load->view('Supplier_list', $config);
	}
	public function Showsupplier()
	{
		$this->check_admin_login();
		$states['records']=$this->getAllStates();
		$states['companies']=$this->getAllCompany();
		$this->get_header('Add Supplier');
		$this->load->view('backend/supplier/Addsupplier',$states);
		$this->load->view('inc/footer'); 
	}
	public function Addsupplier()

	{
		$this->check_admin_login();

		$contact_person=implode(',',$this->input->post('contact_person'));
		$contact_person=rtrim($contact_person, ",");
		$contact_person_mobile=implode(',',$this->input->post('contact_person_mobile'));
		$contact_person_mobile=rtrim($contact_person_mobile, ",");

		$company_deal=$this->input->post('company_deal');

		$company_deal_new=$this->input->post('company_deal_new');
		if(!empty($company_deal_new)){
		 for ($i=0; $i < count($company_deal_new); $i++) 
		 { 
		 	$company_deal[]=$this->getIdForProduct('company','company_name',$company_deal_new[$i]);
		 }
		}    

        $company_deal=implode(',', $company_deal);
		$company_deal=rtrim($company_deal, ",");
		//print_r($_POST);die;
         $password=sha1($this->input->post('password'));

		$arr = array(
			        'name' => $this->input->post('name'),
			        'mobile_number' =>$this->input->post('mobile_number'),
			        'password' =>$password,
			        'real_password'=>$this->input->post('password'),
					'role'=>"2",//$this->input->post('role'),
					'shop_name'=>$this->input->post('shop_name'),
					'area'=>htmlspecialchars($this->input->post('area')),	
					'address'=>htmlspecialchars($this->input->post('address')),	
					'state'=>$this->input->post('state_select'),
					'city'=>$this->input->post('city'),
					'email'=>$this->input->post('email'),
					'dln_no'=>$this->input->post('dln_no'),
					'tln_no'=>$this->input->post('tln_no'),
					'estd_no'=>$this->input->post('estd_no'),
					'contact_person'=>$contact_person,//$this->input->post('contact_person'),
					'contact_person_mobile'=>$contact_person_mobile,//$this->input->post('contact_person'),
					'company_deal'=>$company_deal,//$this->input->post('company_deal'),
					'authe_no_authe'=>$this->input->post('authe_no_authe'),
					'status'=>'1',
					'date_added'=>Date('Y-m-d H:i:s')
					);
		//print_r($arr);die;
		$save_result=$this->Supplier_model->save_entry('supplier',$arr);
		//echo $this->db->last_query();die;
		//print_r($save_result);
		if($save_result!='')
		{ 
					// $supplier_id = $this->session->set_userdata('supplier_id ');
			$this->session->set_flashdata('succ','Supplier has been Added Successfully');
			redirect(base_url().'apanel/Supplier');
		}
		else
		{
			$this->session->set_flashdata('err','Supplier has not been Added. Please Try Again');
			redirect(base_url().'apanel/Supplier');
		}
       // $this->load->view('add_supplier.php');
	}
	public function Editsupplier($id)
	{
		$this->check_admin_login();
		$where = array('supplier_id' => $id);
		$orderby = '';
		$data['edit_supplier'] = $this->Supplier_model->GetRecord('supplier',$where,$orderby);
		$data['records']=$this->getAllStates();

		$state_id=$data['edit_supplier'][0]['state']; 

		$data['cities']=$this->getCity($state_id);
		$data['companies']=$this->getAllCompany();
		//print_r($data['companies']); die;
		$this->get_header('Edit Supplier');
		$this->load->view('backend/supplier/Editsupplier', $data);
		$this->load->view('inc/footer');  

		//print_r($data['edit_supplier']);die;
	}
	public function EditsupplierData($id)
	{
		$this->check_admin_login();
	//print_r($_POST);die;
		$contact_person_arr=array_filter($this->input->post('contact_person'), create_function('$value', 'return $value !== "";'));
		$company_deal_arr=array_filter($this->input->post('company_deal'), create_function('$value', 'return $value !== "";'));
		$contact_person=implode(',',$contact_person_arr);
		$contact_person=rtrim($contact_person, ",");

		$contact_person_mobile=implode(',',$this->input->post('contact_person_mobile'));
		$contact_person_mobile=rtrim($contact_person_mobile, ",");

           

		$company_deal_new=$this->input->post('company_deal_new');
		if(!empty($company_deal_new)){
		 for ($i=0; $i < count($company_deal_new); $i++) 
		 {   
		 	
		 	$company_deal_arr[]=$this->getIdForProduct('company','company_name',$company_deal_new[$i]);
		 }
		}    

        

		$company_deal=implode(',',$company_deal_arr);
		$company_deal=rtrim($company_deal, ",");
        $real_password=$this->input->post('password');

		
        /*$query_check_p=$this->db->get_where('supplier',array("password"=>$real_password, 'id'=>$id));
        if($query_check_p->num_rows() > 0 ){
        	$real_password=$query_check_p->row()->real_password;
        	$password=$this->input->post('password');
        }else{
        	$password=sha1($this->input->post('password'));
        }*/
        $password=sha1($this->input->post('password'));

		$arr = array(
					'name' => $this->input->post('name'),
					'mobile_number' =>$this->input->post('mobile_number'),
					'password' =>$password,
			        'real_password'=>$this->input->post('password'),
					'role'=>'2',//$this->input->post('role'),
					'shop_name'=>$this->input->post('shop_name'),
					'area'=>htmlspecialchars($this->input->post('area')),	
					'address'=>htmlspecialchars($this->input->post('address')),	
					'state'=>$this->input->post('state_select'),
					'city'=>$this->input->post('city'),
					'email'=>$this->input->post('email'),
					'dln_no'=>$this->input->post('dln_no'),
					'tln_no'=>$this->input->post('tln_no'),
					'estd_no'=>$this->input->post('estd_no'),
					'contact_person'=>$contact_person,//$this->input->post('contact_person'),
					'contact_person_mobile'=>$contact_person_mobile,//$this->input->post('contact_person'),
					'company_deal'=>$company_deal,//$this->input->post('company_deal'),
					'authe_no_authe'=>$this->input->post('authe_no_authe'),
					'status'=>'1',
					'date_added'=>Date('Y-m-d H:i:s')
					);

		$where = array('supplier_id' => $id);
		// $orderby = '';
		$update_supplier = $this->Supplier_model->UpdateData('supplier',$arr,$where);
		if($update_supplier!='')
		{ 
			$this->session->set_flashdata('succ','Supplier Details have been Updated Successfully');
			redirect(base_url().'apanel/Supplier');
		}
		else
		{
			$this->session->set_flashdata('err','Supplier Details have not been Updated. Please Try Again');
			redirect(base_url().'apanel/Supplier');
		}

		//print_r($data['edit_supplier']);die;
	}
	public function Deletesupplier($id)
	{

		$Delete_supplier = $this->Supplier_model->DeleteRecord('supplier',$id);
		if($Delete_supplier!='')
		{ 
			$this->session->set_flashdata('succ','Supplier has been Deleted Successfully');
			redirect(base_url().'apanel/Supplier');
		}
		else
		{
			$this->session->set_flashdata('err','Supplier has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/Supplier');
		}

	}

	public function getAllStates()
	{
		$where = array('country_id' => '101');
		return $data=$this->Supplier_model->GetRecord('states', $where);
		
	}
	public function getAllCompany()
	{
		$where = array('status' => '1');
		$orderby='company_name';
		$sort='ASC';
		return $data=$this->Supplier_model->GetRecord('company', $where,$orderby,$sort);
		
	}
	public function getCity($state_id='')
	{
		
		$where1 = array('state_id' => $state_id);
		return $data1=$this->Supplier_model->GetRecord('cities',$where1);
		
		
	}
	public function getAllCities()
	{     
		
		$state_id=$this->input->post('state_id');
		$where1 = array('state_id' => $state_id);
		$data1=$this->Supplier_model->GetRecord('cities',$where1);

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
	// 	$data['record'] = $this->Supplier_model->GetRecord('supplier',$where,$orderby);

	// 	$state_id=$data['record'][0]['state'];
	// 	$city_id=$data['record'][0]['city'];

	// 	$data['state']=$this->getAllStates($state_id);
 

	// 	$data['cities']=$this->getCity($city_id);
	// 	//print_r($data['cities']); die;
	// 	$this->get_header('View Supplier');
	// 	$this->load->view('backend/supplier/Supplier_detail_view', $data);
	// 	$this->load->view('inc/footer');  

	// 	//print_r($data['edit_supplier']);die;
	// }

	public function supplier_changeStatus(){
    // echo 'ok';

    // $this->check_admin_login();
    // print_r($_POST);
     $action = $this->input->post('ac');
     $actionid = $this->input->post('acid');
    if(!empty($action) && !empty($actionid)){

      if($action == 'deactivate'){
        $status = 0;
      } else {
        $status = 1;
      }
      $this->common_model->update_entry('supplier',array('status'=>$status),array('supplier_id'=>$actionid));
    
      echo 'ok';exit;

    } else {
      echo '';exit;
    }
  }
  public  function supplier_detail($id='')
      {
        $supplier_id=ci_dec($id);
        $where=array('supplier_id'=>$supplier_id);
        $data['record'] = $this->common_model->GetSingleRecord('supplier',$where);
        //echo $this->db->last_query();
         // echo "<pre>";

          ///print_r($data);die;
        $this->load->view('backend/supplier/Supplier_detail_view',$data);
    }


    //Function for Load data in data table using ajax starts

     public function GetName($table,$col_id,$val,$rt_colName)
     {
        $where=array($col_id=>$val);
        $data= $this->Supplier_model->GetRecord($table, $where);
        return $data[0][$rt_colName];
     }
   
     public function ajaxDataTableSupplier()
  {

     $result=$this->Supplier_model->GetRecord('supplier');

        $data = array();
        $sn=1;
        foreach ($result  as $r) {
          
          if($r['company_deal']>0){
          	$c_id=explode(',',$r['company_deal'] );
            $company_names= $this->Supplier_model->ajaxGetCompany('company','company_id',$c_id,'company_name');
            //print_r($data);
            //$this->db->last_query() ; die;
            
            $comp=array();
            $companies='';
            foreach ($company_names as $company_name) {
            	$comp[]=$company_name['company_name'];
            }
            for ($i=0; $i <count($comp) ; $i++) { 
            	if($i < 2){

            	 $companies.=$comp[$i].',<br>';
            	}
            	else{
            		$companies=rtrim($companies,',<br>').'...';
            		break;
            	}
            }

            $comp_name=rtrim($companies,',<br>');

            }else{
            	$comp_name='NA';
            } 
         
          
          if($r['state']>0){
            $state=$this->GetName('states','id',$r['state'],'name');
          }
          if($r['city']>0){
            $city=$this->GetName('cities','id',$r['city'],'name');
          }
          if(strlen($r['address'])>20){
            $address=substr($r['address'], 0,20).'...';
          }else{
          	$address=$r['address'];
          }
          if(strlen($r['area'])>20){
            $area=substr($r['area'], 0,20).'...';
          }else{
          	$area=$r['area'];
          }

                $contact_person=explode(',',$r['contact_person']);
                $contact_person_mobiles= explode(',',$r['contact_person_mobile']);
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

            



          if($r['status']==1){
            $status='<span id="span_active_'.$r['supplier_id'].'" class="label label-success">Active</span>';
            $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="supplier_changeStatus btn btn-default btn-sm" id="deactivate_'.$r['supplier_id'].'" title="deactivate this Supplier?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['supplier_id'].'"></i></a>';

             }
            else{
              $status='<span id="span_deactivate_'.$r['supplier_id'].'" class="label label-danger" >Deactive</span>';

              $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="supplier_changeStatus btn btn-default btn-sm" id="activate_'.$r['supplier_id'].'" title="Activate this Supplier?"><i class="fa fa-check fa-lg" id="icon_'.$r['supplier_id'].'"></i></a>';
            }

          $view_link="<a class='btn btn-default btn-sm' data-target='#supplierModal' data-toggle='modal' href='". base_url()."apanel/Supplier/supplier_detail/".ci_enc($r['supplier_id'])."' title='View Supplier'><i class='fa fa-eye'></i></a>";                      
          $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Supplier/Editsupplier/" . $r['supplier_id']."'> <i class='fa fa-pencil-square-o'></i></a>";
          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['supplier_id'].")'> <i class='fa fa-trash-o'></i></a>";

          //$href= $r['supplier_id'];
            array_push($data, array(
                $sn,
                $r['shop_name'],
                $r['name'],
                $r['mobile_number'],
                $r['email'],
                $address,
                $area,
                $city,
                $state,
                $r['dln_no'],
                $r['tln_no'],
                $r['estd_no'],
                $cont_p_no,
                $comp_name,
                $r['authe_no_authe'],
                $status,
                $edit_link. $view_link.$delete_link.$changeStatus
            ));
            $sn++;

          
        }
 
        echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['supplier_id'])."'> <i class='fa fa-eye'></i></a>
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
                'date_added'=>Date('Y-m-d H:i:s')
                );
              $save_data = $this->product_model->save_entry($table,$arr);
              $id=$this->db->insert_id();
            }
            return $id;
          }else{
            return $id='';
          }
        }

function changestatus()
{
		if(empty($this->input->post('add_submit'))){
	    $this->get_header('Add Supplier');
	    $data=array();
		$this->load->view('backend/supplier/changestatus',$data);
		$this->load->view('inc/footer'); 
		}else{
			
			$mobile_number=$this->input->post('mobile_number');
			$ustatus=$this->input->post('status');
			// if($ustatus=="Active")
			// {
			// 	$status=1;

			// }else{
			// 	$status=0;
			// }

			$mobilearray=explode("\n",$mobile_number);
			foreach($mobilearray as $number)
			{
				if(!empty($number)){
					$number=trim($number);
				//echo $q="update m16j_user set login_status='$status' where phone='$number'";
				 $this->common_model->update_entry('user',array('status'=>$ustatus),array('phone'=>$number));
				// echo $this->db->last_query();die;
				//echo "<br>";
				}
			}
			//die;
			$this->session->set_flashdata('succ','Status has been updated. ');
			redirect(base_url().'apanel/changestatus');
		}
}
	
}