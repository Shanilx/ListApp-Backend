<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Packingtype extends CI_Controller

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
		// $where = array('supplier' => $user_id);
		$where = '';
		$orderby = 'packing_type_id';
		$data['Packingtype_data'] = $this->Packingtype_model->GetRecord('packing_type',$where,$orderby,'desc');

		$this->get_header('Manage Packing Type');
		$this->load->view('backend/packingtype/packingtype_list', $data);
		$this->load->view('inc/footer'); 
	}

	public function ajaxDataTablePacking()
	{

		$result=$this->Packingtype_model->GetRecord('packing_type');

		$data = array();
		$i=1;
		foreach ($result  as $r) {
			
			if($r['status']==1){
				$status='<span id="span_active_'.$r['packing_type_id'].'" class="label label-success">Active</span>';
				$changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Packingtype_changeStatus btn btn-default btn-sm" id="block_'.$r['packing_type_id'].'" title="Block this Packing Type?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['packing_type_id'].'"></i></a>';

			}
			else{
				$status='<span id="span_block_'.$r['packing_type_id'].'" class="label label-danger" >Deactive</span>';

				$changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Packingtype_changeStatus btn btn-default btn-sm" id="activate_'.$r['packing_type_id'].'" title="Activate this Packing Type?"><i class="fa fa-check fa-lg" id="icon_'.$r['packing_type_id'].'"></i></a>';
			}
			/*$view_link="<a class='btn btn-default btn-sm' data-target='#productModal' data-toggle='modal' href='<?php echo base_url();?>apanel/product/product_detail/'". ci_enc($r['packing_type_id']."' title='View Product'><i class='fa fa-eye'></i></a>";  */                    
			$edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Packingtype/EditPackingtype/" . ci_enc($r['packing_type_id'])."'> <i class='fa fa-pencil-square-o'></i></a>";
			$delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['packing_type_id'].")'> <i class='fa fa-trash-o'></i></a>";

          $r['date_added']= date('d-m-Y h:i:s',strtotime($r['date_added']));
			array_push($data, array(
				$i,
				$r['packingtype_name'],
				$r['date_added'],                
				$status,
				$edit_link.$delete_link.$changeStatus
				));
			$i++;
		}
		
		echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['packing_type_id'])."'> <i class='fa fa-eye'></i></a>
	}
    //Function for Load data in data table using ajax starts



	public function add()
	{
		$this->get_header('Add Packing Type');
		$this->load->view('backend/packingtype/Addpackintype');
		$this->load->view('inc/footer'); 
	}
	public function AddPackingtype()
	{
		$this->check_admin_login();
		$arr = array(
			'packingtype_name'=>$this->input->post('Packingtype_name'),
			'date_added'=>Date('Y-m-d h:i:s')
			);
		//print_r($arr);die;
		$save_result=$this->Packingtype_model->save_entry('packing_type',$arr);
		if($save_result!='')
		{ 
					// $supplier_id = $this->session->set_userdata('supplier_id ');
			$this->session->set_flashdata('succ','Packingtype Name has been Added Successfully');
			redirect(base_url().'apanel/Packingtype');
		}
		else
		{
			$this->session->set_flashdata('err','Packingtype Name has not been Added. Please Try Again');
			redirect(base_url().'apanel/Packingtype');
		}
	}
	public function EditPackingtype($id)
	{
		$Packingtype_id = ci_dec($id);
		$where = array('packing_type_id' => $Packingtype_id);
		$orderby = '';
		$data['edit_Packingtype'] = $this->Packingtype_model->GetRecord('packing_type',$where,$orderby);

		//print_r($data['edit_Packingtype']); die;
		$this->get_header('Edit Packing Type');
		$this->load->view('backend/packingtype/Editpackingtype', $data);
		$this->load->view('inc/footer');  


	}
	public function EditData($id)
	{
		$Packingtype_id = ci_dec($id);
		$arr = array(
			'packingtype_name'=>$this->input->post('Packingtype_name'),
			'date_added'=>Date('Y-m-d h:i:s')
			);
		$where = array('packing_type_id' => $Packingtype_id);
		$update_Packingtype = $this->Packingtype_model->UpdateData('packing_type',$arr,$where);
		if($update_Packingtype!='')
		{ 
			$this->session->set_flashdata('succ','Packing type has been Updated Successfully');
			redirect(base_url().'apanel/Packingtype');
		}
		else
		{
			$this->session->set_flashdata('err','Packing type has not been Updated. Please Try Tgain');
			redirect(base_url().'apanel/Packingtype');
		}
	}
	public function DeletePackingtype($id)
	{
       // $Packingtype_id = ci_dec($id);
		$Packingtype_id = $id;
		$Delete_Packingtype = $this->Packingtype_model->DeleteRecord('packing_type',$Packingtype_id);
		if($Delete_Packingtype!='')
		{ 
			$this->session->set_flashdata('succ','Packing type has been Deleted Successfully');
			redirect(base_url().'apanel/Packingtype');
		}
		else
		{
			$this->session->set_flashdata('err','Packing type has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/Packingtype');
		}

	}
	public function checkName()
	{
		$value=trim($this->input->post('Packingtype_name'));
		
		$res =$this->common_model->getSuggetion('packing_type','packingtype_name',$value);
		if(!empty($res) && count($res) > 0){
			echo (json_encode(false));
		}else{
			echo (json_encode(true));
		}
	}
	public function Packingtype_changeStatus(){
    // echo 'ok';

    // $this->check_admin_login();
    // print_r($_POST);
		$action = $this->input->post('ac');
		$actionid = $this->input->post('acid');
		if(!empty($action) && !empty($actionid)){

			if($action == 'block'){
				$status = 0;
			} else {
				$status = 1;
			}
			$this->common_model->update_entry('packing_type',array('status'=>$status),array('packing_type_id'=>$actionid));
			
			echo 'ok';exit;

		} else {
			echo '';exit;
		}
	}

}