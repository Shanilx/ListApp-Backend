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
	public function AddProductSynonym()
	{
		 $this->check_admin_login();
		 $synonym_product_name=$this->input->post('synonym_product');
		 $id=$this->input->post('id');
		 $product_name=$this->input->post('product_name');
		 $where= array(
			'product_name' => $product_name
		 );
		 $product_id = $this->Supplier_model->GetRecord('product',$where,'','desc');
		 $arr = array(
			'product_id' => $product_id[0]['product_id'],
			'product_synonym' => $synonym_product_name
		 );
		 $duplicate_synonym = $this->Supplier_model->GetRecord('product_synonyms', $arr = array(
			'product_id' => $product_id[0]['product_id'],
			'product_synonym' => $synonym_product_name
		 ),'','desc');
		 if($duplicate_synonym){
			$this->session->set_flashdata('err','Product has Already Mapped');
			redirect(base_url().'apanel/Supplier/AddBulkProduct/'.$id);
		 }else{
			 $this->Supplier_model->save_entry('product_synonyms',$arr);
			 $this->Supplier_model->DeleteSupplierDraft('draft_product', $synonym_product_name);
			 $this->session->set_flashdata('succ','Product has been Mapped Successfully');
			 redirect(base_url().'apanel/Supplier/AddBulkProduct/'.$id);
		 }

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

	public function Product($id)
	{
		$this->check_admin_login();
		$where = array('id' => $id);
		$data = $this->Draft_product_model->GetRecord('draft_product', $where);
		$this->get_header('Add Products');
		$this->load->view('backend/supplier/AddSupplierProduct',array('data'=>$data));
		$this->load->view('inc/footer'); 

  
   }
	// Bulk Uploads of Products
	public function upload_bulk_product()
	{
		$supplier_id = $this->input->post('id');
	
		$config['upload_path'] = FCPATH . 'uploads/supplier_product_csv_files/';
		$config['allowed_types'] = 'xlsx';
		$config['detect_mime'] = true;

		$this->upload->initialize($config);
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('csv_file')) {
			$error = array('error' => $this->upload->display_errors());
		
            $this->session->set_flashdata('err', $error['error']);
			echo json_encode(array('supplier_id' => $supplier_id, 'response' => '2'));
		
		}  else {
			$file_data = $this->upload->data();
			$file_path = './uploads/supplier_product_csv_files/' . $file_data['file_name'];
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($file_path);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$column1 = $objWorksheet->getCell('A1')->getValue();
			$column2 = $objWorksheet->getCell('B1')->getValue();
	
			if ($column1 == 'Product Name' && $column2 == 'Company Name') {
				$unnecessary_data = [];
				$necessary_data = [];
	
				for ($i = 2; $i <= $objWorksheet->getHighestRow(); $i++) {
					$product_name = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
					$company_name = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
			
					if (!empty($product_name) && !empty($company_name)) {
						// Get company_id
						$company_id = $this->Supplier_product_model->get_entry_by_data("company", true, array('company_name' => $company_name), "company_name");
				
						// Get product_info
						$product_info = $this->Supplier_product_model->get_entry_by_data("product", true, array('product_name' => $product_name), "product_name, product_id");
				
						$product_id = $product_info['product_id'];
						//Get supplier Product 

						$supplier_product = $this->Supplier_product_model->get_entry_by_data("product_synonyms", true, array('product_synonym' => $product_name), "id");
						
						if (($supplier_product !== null && $supplier_product !== false) || ($product_info !== null && $product_info !== false && $company_id !== null && $company_id !== false)) {

							$necessary_data[] = array(
								'existing_products' => $product_id,
								'id' => $supplier_id
							);
							
						} else {
							// Unnecessary data
							$unnecessary_data[] = array(
								'product_name' => $product_name,
								'company_name' => $company_name,
								'supplier_id' => $supplier_id
							);
						}
					}
				}
				print_r($necessary_data);
						print_r($unnecessary_data);
	
				// Save necessary data
				if (!empty($necessary_data)) {
					$this->Supplier_product_model->save_bulk_entry('supplier_product', $necessary_data);
				}
	
				// Save unnecessary data
				if (!empty($unnecessary_data)) {
					$this->Draft_product_model->save_bulk_entry('draft_product', $unnecessary_data);
				}
	
				// Clean up: delete the uploaded file
				if (file_exists($file_path)) {
					unlink($file_path);
				}
	
				$this->session->set_flashdata('succ', "Uploaded successfully");
				echo json_encode(array('supplier_id' => $supplier_id, 'response' => '1'));
			} else {
				// Invalid file format
				$this->session->set_flashdata('err', "File should have columns 'Product Name' and 'Company Name'");
				echo json_encode(array('supplier_id' => $supplier_id, 'response' => '3'));

			}
		}
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
		$data =[];
		if($save_result!='')
		{ 
			$companyIDs =$company_deal; // Extract the array from the data
			$supplierID =$save_result; // Extract the single value from the data
			$data=[$companyIDs,$supplierID];
			$this->Supplier_company_model->save_bulk_entry('supplier_company',$data);
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
		$data =[];
		$update_supplier = $this->Supplier_model->UpdateData('supplier',$arr,$where);
		if($update_supplier!='')
		{ 
			$companyIDs =$company_deal; // Extract the array from the data
			$update_supplier_company = $this->Supplier_company_model->UpdateData('supplier_company',$companyIDs,$where);
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
		public function AddBulkProduct($id)
		{
			$this->check_admin_login();
			
			$where = array('supplier_id' => $id);
			$data = $this->Draft_product_model->GetRecord('draft_product', $where);
		
			// Create two separate data arrays
			$dataWithFull = $data;  // This one contains the full data
			$SupplierId = $id;  // This one contains only the extracted supplier_id
		
			$this->get_header('Add Products');
			$this->load->view('backend/supplier/AddProducts', array('dataWithFull' => $dataWithFull, 'SupplierId' => $SupplierId));
			$this->load->view('inc/footer'); 
		}

		public function addProduct()
        {
          $this->check_admin_login();
          $this->session->unset_userdata('per_page');

          $this->form_validation->set_rules('product_name','Product Name','trim|required');
          $this->form_validation->set_rules('company_name','Company Name','trim|required');
      // $this->form_validation->set_rules('form_p','Form','trim|required');
      // $this->form_validation->set_rules('mrp','MRP','trim|required');  


			
          if($this->form_validation->run() == TRUE)
          {
            $page_no=$this->input->post('page_no');
            $company_name=$this->input->post('company_name');
            $company_id=$this->getIdForProduct('company','company_name',$company_name);
            $schedule_name=$this->input->post('schedule');
            $schedule_id=$this->getIdForProduct('schedule','schedule_name',$schedule_name);
            $packing_type=$this->input->post('packing_type');
            $packing_type_id=$this->getIdForProduct('packing_type','packingtype_name',$packing_type);
            $pack_size=$this->input->post('pack_size');
            $pack_size_id=$this->getIdForProduct('packsize','Pack_size',$pack_size);
            $form=$this->input->post('form_p');
            $form_id=$this->getIdForProduct('form','Form',$form);


			$supplier_id =$this->input->post("supplier_id");
			$product_name =$this->input->post("product_name");
			$id =$this->input->post("id");

            $date_added = date('Y-m-d H:i:s');
            $arr = array(
            'product_name' => $this->input->post('product_name'),
			'company_name' =>$company_id,//$this->input->post('company_name'),
			'packing_type' =>$packing_type_id,//$this->input->post('packing_type'),
			'pack_size' =>$pack_size_id, //$this->input->post('pack_size'),
			'drug_name' =>$this->input->post('drug_name'),
			'form' =>$form_id,//$this->input->post('form_p'),
			'mrp' =>$this->input->post('mrp'),
			'rate' =>$this->input->post('rate'),
			'schedule' =>$schedule_id,//$this->input->post('schedule'),
			'status' =>'1',
			'add_date'=>$date_added 
          );


		  $save_product = $this->product_model->save_entry('product', $arr);
		  if ($save_product != '') {
            // Delete supplier draft if product added successfully
            $Delete_supplier_product = $this->Supplier_model->DeleteSupplierDraft('draft_product', $product_name);
            if ($Delete_supplier_product != '') {
                $details = array(
                    'supplier_id' => $supplier_id,
                    'product_id' => $save_product
                );
                // Save supplier product relationship
                 $this->Supplier_model->save_entry('supplier_product', $details);
            }

            $this->session->set_flashdata('succ', 'Product has been Added Successfully');
            redirect(base_url() . 'apanel/product/1');
        } else
            {
              $this->session->set_flashdata('err','Product has not been Added. Please Try Again');
			  redirect(base_url() . 'apanel/Supplier/Product/' .$id);
            }

          }
          else
          {
            $where=array('status'=>'1');
            $data['companies'] = $this->product_model->GetRecord('company',$where);
            $this->get_header('Add Product');
            $this->load->view('backend/product/addProdcut',$data);
            $this->load->view('inc/footer');
          }
        }

		public function getProduct()
		{
		 $product_name=$this->input->post('ptype_name');
	  
	  
		 $res =$this->common_model->getSuggetion('product',' product_name',$product_name);
		 $sugetion="";
		  //echo $this->db->last_query();die;
		 $sugetion.='<ul style="list-style: none;margin-left:0px;">';
	  
		 if(!empty($res)){
		  $pk=1;
		  foreach ($res as $value) {
			if($pk==1){
	  
			$sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_packingtype change_bg"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['product_name'].'">'.$value['product_name'].'</a></li>';
			}else{
	  
			$sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_packingtype"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['product_name'].'">'.$value['product_name'].'</a></li>';
			}
			$pk++;
		  }
	  
		}
		/*else
		{
			$sugetion.='<li style="background: lavender;margin-left: -40px;"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none" class="sugg_company" > No Match Found</a></li>';
		  }*/
		  $sugetion.='</ul>';
	  
		  echo $sugetion;
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