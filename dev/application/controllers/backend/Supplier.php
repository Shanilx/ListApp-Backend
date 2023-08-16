<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller

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
		$this->check_admin_login();
		// $where = array('supplier' => $user_id);
		$where = '';
		$orderby = 'supplier_id';
		$data['suplier_data'] = $this->Supplier_model->GetRecord('supplier',$where,$orderby,'desc');
		//print_r($data['records']);die;
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
    			$status='<span id="span_active_'.$r['supplier_id'].'" class="label label-success">Active</span><span style="display: none;" id="span_deactivate_'.$r['supplier_id'].'" class="label label-danger" >Deactive</span>';
    			$changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="supplier_changeStatus btn btn-default btn-sm" id="deactivate_'.$r['supplier_id'].'" title="deactivate this Supplier?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['supplier_id'].'"></i></a>';

    		}
    		else{
    			$status='<span  id="span_deactivate_'.$r['supplier_id'].'" class="label label-danger" >Deactive</span> <span style="display: none;" id="span_active_'.$r['supplier_id'].'" class="label label-success">Active</span>';

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
    			// $r['email'],
    			$address,
    			// $area,
    			$city,
    			$state,
    			// $r['dln_no'],
    			// $r['tln_no'],
    			// $r['estd_no'],
    			// $cont_p_no,
    			$comp_name,
    			// $r['authe_no_authe'],
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



    function export_suplier()
    {
    	$this->check_admin_login();
    	$this->phpexcel->setActiveSheetIndex(0);
    	$this->phpexcel->getActiveSheet()->setCellValue('A1', 'Shop Name');
    	$this->phpexcel->getActiveSheet()->setCellValue('B1', 'Supplier Name');
    	$this->phpexcel->getActiveSheet()->setCellValue('C1', 'Contact Number');
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
    	$this->phpexcel->getActiveSheet()->setCellValue('N1', 'Companies Deal With'); 
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
    	$where = '';
    	$data_d = $this->product_model->GetRecord('supplier', $where,'date_added','asc');
    	$exceldata="";
    	foreach ($data_d as $row)
    	{

    		$shop_name=ucfirst($row['shop_name']);
    		$supplier_name=ucfirst($row['name']);
    		$phone=$row['mobile_number'];
    		//$password=$row['real_password'];
    		$address=trim($row['address']);
    		$area=trim($row['area']);
    		$email=$row['email'];
    		$dl_number=$row['dln_no'];
    		$gstin_number=$row['tln_no'];
    		$estd_year=$row['estd_no'];
    		$contact_person=$row['contact_person'];
    		$contact_number=$row['contact_person_mobile'];
    		$authenticated=$row['authe_no_authe'];

    		$company_deal=explode(',', $row['company_deal']);

    		$c_name=array();
    		if(is_array($company_deal) && count($company_deal) > 0)
    		{
    			foreach ($company_deal as $k => $value_c) {
    				if($value_c > 0 )
    				{
    					$c_name[] = $this->GetName('company','company_id',$value_c,'company_name'); 

    				}
    			}
    		}
    		else
    		{
    			$c_name[]=$company_deal;

    		}
    		$companies = trim(implode(',',array_unique(array_map('trim', $c_name))));

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
    			'shop_name'=>$shop_name,
    			'supplier_name'=>$supplier_name,
    			'contact_number'=>$phone,
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
    			'companies_deal' =>$companies,
    			'authenticated'=>$authenticated 
    		);
    		$this->phpexcel->getActiveSheet()->fromArray($exceldata, null, 'A2');
    	}	
              $filename="Supplier List.xlsx"; //save our workbook as this file name
              header("Content-Type: application/vnd.ms-excel");
              header('Content-Disposition: attachment;filename="'.$filename.'"');
              header('Cache-Control: max-age=0'); 
              $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007'); 
              $objWriter->save('php://output');
          }

          public function import_supplier($value='')
          {	
          	$this->check_admin_login();
          	$this->get_header('Upload Supplier');
          	$this->load->view('backend/supplier/upload_supplier');
          	$this->load->view('inc/footer');
          }



          public function bulk_upload()
          {
          	$configUpload['upload_path'] = './uploads/supplier/bulk_files';
          	$configUpload['allowed_types'] = 'xlsx';
          	$configUpload['detect_mime'] = true;
          	$this->load->library('upload', $configUpload);
          	if (!$this->upload->do_upload('csv_file'))
          	{
          		$this->session->set_flashdata('err', 'Please use file in the format of .xlsx');
          		//echo "upload error to file";die;

          		$error = array('error' => $this->upload->display_errors());

          		$this->session->set_flashdata('err', $error['error']);

          		//redirect(base_url().'backend/Supplier/import_supplier');
          	}
          	else
          	{
          		$file_data = $this->upload->data();
          		$file_path =  './uploads/supplier/bulk_files/'.$file_data['file_name'];
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

                      if((!empty($column1))&&(!empty($column2))&&(!empty($column3))&&(!empty($column4))&&(!empty($column5))&&(!empty($column6))&&(!empty($column7))&&(!empty($column8))&&(!empty($column9))&&(!empty($column10))&&(!empty($column11))&&(!empty($column12))&&(!empty($column13))&&(!empty($column14))&&(!empty($column15))&&(!empty($column16))) 
                      {   
                      	if(($column1=='Shop Name')&&($column2=='Supplier Name')&&($column3=='Contact Number')&&($column4=='Password')&&($column5=='Address')&&($column6=='Area')&&($column7=='State')&&($column8=='City')&&($column9=='Email')&&($column10=='DL Number')&&($column11=='GSTIN Number')&&($column12=='ESTD. Year')&&($column13=='Contact Person')&&($column14=='Person Contact Number')&&($column15=='Companies Deal With')&&($column16=='Authenticated'))
                      	{
                  //loop from first data untill last data
                            $total_insert_record=0;
                      		$total_already_exists=0;
                      		for($i=2;$i<=$totalrows;$i++)
                      		{
                      			$shop_name= trim($objWorksheet->getCellByColumnAndRow(0,$i)->getValue());
                      			$supplier_name= trim($objWorksheet->getCellByColumnAndRow(1,$i)->getValue());
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
                      			$company_deal=trim($objWorksheet->getCellByColumnAndRow(14,$i)->getValue());
                      			$authenticated=trim($objWorksheet->getCellByColumnAndRow(15,$i)->getValue());

                    			//validation
                      			if(empty($shop_name) || empty($supplier_name)|| empty($contact_number) || empty($password)|| empty($address)|| empty($area)|| empty($state)|| empty($city)|| empty($email)|| empty($dl_number)|| empty($gstin_number)|| empty($estd_year)|| empty($contact_person)|| empty($contact_person_mobile)|| empty($company_deal)|| empty($authenticated))
                                {
                                    $this->session->set_flashdata('err', 'All column Value Required. Please Try Again');
                                  // redirect(base_url('backend/Supplier/import_supplier'));
                      			}
                                else
                                {   

                                $company_deal=explode(',', $company_deal);
                                $c_id=array();
                                if(count($company_deal) > 0)
                               {
                                    foreach ($company_deal as $k => $value_c) {
                                        if($value_c > 0 )
                                        {
                                          $c_id[]=  $this->getIdForProduct('company','company_name',trim($value_c));

                                        }
                                    }
                                }
                                $state_id=$this->GetName('states','name',$state,'id');
                                $city_id=$this->GetName('cities','name',$city,'id');
                                $companies = trim(implode(',',array_unique(array_map('trim', $c_name))));
                                //print_r($_POST);die;
                                $password1=sha1($password);

                                $arr = array(
                                    'name' => $supplier_name,
                                    'mobile_number' =>$contact_number,
                                    'password' =>$password1,
                                    'real_password'=>$password,
                                    'role'=>"2",//$this->input->post('role'),
                                    'shop_name'=>$shop_name,
                                    'area'=>htmlspecialchars($area),   
                                    'address'=>htmlspecialchars($address), 
                                    'state'=>$state_id,
                                    'city'=>$city_id,
                                    'email'=>$email,
                                    'dln_no'=>$dl_number,
                                    'tln_no'=>$gstin_number,
                                    'estd_no'=>$estd_year,
                                    'contact_person'=>$contact_person,//$this->input->post('contact_person'),
                                    'contact_person_mobile'=>$contact_person_mobile,//$this->input->post('contact_person'),
                                    'company_deal'=>$companies,//$this->input->post('company_deal'),
                                    'authe_no_authe'=>$authenticated,
                                    'status'=>'1',
                                    'date_added'=>Date('Y-m-d H:i:s')
                                        );
                                //print_r($arr);die;
                                 $chek_product=array('shop_name'=>$shop_name,'mobile_number'=>$contact_number);
                                 $already_exist = $this->common_model->get_entry_by_data("supplier",true, $chek_product, "supplier_id");
                                 if(empty($already_exist))
                                 {
                                  $save_result=$this->Supplier_model->save_entry('supplier',$arr);
                                  if($save_result){
                                    $total_insert_record++;
                                  }

                                 }else
                                 {
                                    $total_already_exists++;
                                 }
                                

                                }//end validate else
                                //validation ends

                      		}//for loop end

                            if ($total_insert_record > 0 ) {
                                $succ_msg=$total_insert_record.' Supplier(s) has been Uploaded Succesfully. ';
                                if($total_already_exists > 0)
                                {
                                    $succ_msg.=$total_already_exists .' Supplier(s) Already Exists';
                                }

                                $this->session->set_flashdata('succ', $succ_msg);
                                echo "1";

                              //redirect(base_url('backend/Supplier'));
                            }elseif($total_already_exists > 0){
                               $suc= $total_already_exists .' Supplier(s) Already Exists';
                                $this->session->set_flashdata('err', $suc);
                                //redirect(base_url('backend/Supplier'));
                                echo "1";
                            }else{
                                $this->session->set_flashdata('err','No Supplier has been Uploaded. Please Try Again');
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





}//close controller class