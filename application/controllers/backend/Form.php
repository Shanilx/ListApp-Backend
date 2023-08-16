<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller

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
		// $where = array('supplier' => $user_id);
		$where = '';
		$orderby = 'form_id';
		$data['form_data'] = $this->Form_model->GetRecord('form',$where,$orderby,'desc');
		// print_r($data);die;

		$this->get_header('Manage Form');
		$this->load->view('backend/form/form_list', $data);
		$this->load->view('inc/footer'); 
	}
	public function add()
	{
		$this->get_header('Add Form');
		$this->load->view('backend/form/Addform');
		$this->load->view('inc/footer'); 
	}
	public function Add_Form()
	{
		$this->check_admin_login();
		$arr = array(
					'Form'=>$this->input->post('Form_name'),
					'status'=>1,
					'date_added'=>Date('Y-m-d h:i:s')
					);
		//print_r($arr);die;
		$save_result=$this->Form_model->save_entry('form',$arr);
		if($save_result!='')
		{ 
					// $supplier_id = $this->session->set_userdata('supplier_id ');
			$this->session->set_flashdata('succ','Form Name has been Added Successfully');
			redirect(base_url().'apanel/Form');
		}
		else
		{
			$this->session->set_flashdata('err','Form Name has not been Added. Please Try Again');
			redirect(base_url().'apanel/Form');
		}
	}
	public function Edit_Form($id)
	{
		$Form_id = ci_dec($id);
		$where = array('form_id' => $Form_id);
		$orderby = '';
		$data['edit_form'] = $this->Form_model->GetRecord('form',$where,$orderby);

		//print_r($data['edit_Packingtype']); die;
		$this->get_header('Edit Form ');
		$this->load->view('backend/form/Editform', $data);
		$this->load->view('inc/footer');  


	}
	public function Edit_Form_Data($id)
	{
       $Form_id = ci_dec($id);
       $arr = array(
					'Form'=>$this->input->post('Form_name'),
					'date_added'=>Date('Y-m-d h:i:s')
		           );
        $where = array('form_id' => $Form_id);
        $update_Form = $this->Form_model->UpdateData('form',$arr,$where);
		if($update_Form!='')
		{ 
			$this->session->set_flashdata('succ','Form Name has been Updated Successfully');
			redirect(base_url().'apanel/Form');
		}
		else
		{
			$this->session->set_flashdata('err','Form Name has not been Updated. Please Try Again');
			redirect(base_url().'apanel/Form');
		}
	}
	public function DeleteForm($id)
	{
        $Form_id = $id;
		$Delete_Form = $this->Form_model->DeleteRecord('form',$Form_id);
		if($Delete_Form!='')
		{ 
			$this->session->set_flashdata('succ','Form Name has been Deleted Successfully');
			redirect(base_url().'apanel/Form');
		}
		else
		{
			$this->session->set_flashdata('err','Form Name has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/Form');
		}

	}
	 public function checkName()
	 {
	    $value=trim($this->input->post('Form_name'));
	    
        $res =$this->common_model->getSuggetion('form','form',$value);
        if(!empty($res) && count($res) > 0){
        	echo (json_encode(false));
        }else{
        	echo (json_encode(true));
        }
	 }
	 public function Form_changeStatus(){
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
      $this->common_model->update_entry('form',array('status'=>$status),array('form_id'=>$actionid));
    
      echo 'ok';exit;

    } else {
      echo '';exit;
    }
  }
  public function ajaxDataTableForm()
  {
     //$where = array('status' =>'1');
     $result=$this->Form_model->GetRecord('form');

        $data = array();
        $i=1;
        foreach ($result  as $r) {
         
          
          if($r['status']==1){
            $status='<span id="span_active_'.$r['form_id'].'" class="label label-success">Active</span>';
            $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Form_changeStatus btn btn-default btn-sm" id="block_'.$r['form_id'].'" title="Block this Form ?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['form_id'].'"></i></a>';

             }
            else{
              $status='<span id="span_block_'.$r['form_id'].'" class="label label-danger" >Deactive</span>';

              $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Form_changeStatus btn btn-default btn-sm" id="activate_'.$r['form_id'].'" title="Activate this Form ?"><i class="fa fa-check fa-lg" id="icon_'.$r['form_id'].'"></i></a>';
            }
          //$view_link="<a class='btn btn-default btn-sm' data-target='#productModal' data-toggle='modal' href='". base_url()."apanel/product/product_detail/".ci_enc($r['form_id'])."' title='View Supplier'><i class='fa fa-eye'></i></a>";                    
          $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Form/Edit_Form/" . ci_enc($r['form_id'])."'> <i class='fa fa-pencil-square-o'></i></a>";
          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['form_id'].")'> <i class='fa fa-trash-o'></i></a>";
            
          $r['date_added']= date('d-m-Y h:i:s',strtotime($r['date_added']));
            array_push($data, array(
                $i,
                trim($r['Form']),
                $r['date_added'],                
                $status,
                $edit_link.$delete_link.$changeStatus
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['form_id'])."'> <i class='fa fa-eye'></i></a>
    }
    //Function for Load data in data table using ajax starts

}