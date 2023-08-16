<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller

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
		$orderby = 'company_id';
		$data['company_data'] = $this->Company_model->GetRecord('company',$where,$orderby,'desc');

		$this->get_header('Manage Company');
		$this->load->view('backend/company/Company_list', $data);
		$this->load->view('inc/footer'); 
	}
	public function add()
	{
		$this->get_header('Add Company');
		$this->load->view('backend/company/Addcompany');
		$this->load->view('inc/footer'); 
	}
	public function Addcompany()
	{
		$this->check_admin_login();
		$arr = array(
					'company_name'=>$this->input->post('company_name'),
					'date_added'=>Date('Y-m-d h:i:s')
					);
		//print_r($arr);die;
		$save_result=$this->Company_model->save_entry('company',$arr);
		if($save_result!='')
		{ 
					// $supplier_id = $this->session->set_userdata('supplier_id ');
			$this->session->set_flashdata('succ','Company Name has been Added Successfully');
			redirect(base_url().'apanel/Company');
		}
		else
		{
			$this->session->set_flashdata('err','Company Name has not been Added. Please Try Again');
			redirect(base_url().'apanel/Company');
		}
	}
	public function Editcompany($id)
	{
		$company_id = ci_dec($id);
		$where = array('company_id' => $company_id);
		$orderby = '';
		$data['edit_company'] = $this->Company_model->GetRecord('company',$where,$orderby);

		//print_r($data['edit_company']); die;
		$this->get_header('Edit Company');
		$this->load->view('backend/company/Editcompany', $data);
		$this->load->view('inc/footer');  


	}
	public function EditData($id)
	{
       $company_id = ci_dec($id);
       $arr = array(
					'company_name'=>$this->input->post('company_name'),
					'date_added'=>Date('Y-m-d h:i:s')
		           );
        $where = array('company_id' => $company_id);
        $update_company = $this->Company_model->UpdateData('company',$arr,$where);
		if($update_company!='')
		{ 
			$this->session->set_flashdata('succ','Company Name has been Updated Successfully');
			redirect(base_url().'apanel/Company');
		}
		else
		{
			$this->session->set_flashdata('err','Company Name has not been Updated. Please Try Again');
			redirect(base_url().'apanel/Company');
		}
	}
	public function Deletecompany($id)
	{
        $company_id = $id;
         // $where = array('Company_id' => $company_id);
		$Delete_company = $this->Company_model->DeleteRecord('company',$company_id );
		if($Delete_company!='')
		{ 
			$this->session->set_flashdata('succ','Company Name has been Deleted Successfully');
			redirect(base_url().'apanel/Company');
		}
		else
		{
			$this->session->set_flashdata('err','Company Name has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/Company');
		}

	}
	public function check_company_name()
	{
		$company_name = trim($this->input->post('company_name'));
		$data = $this->Company_model->get_entry_by_data(true, array('company_name' => $company_name), "company_name","company");
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
	  public function Company_changeStatus(){
    
     $action = $this->input->post('ac');
     $actionid = $this->input->post('acid');
    if(!empty($action) && !empty($actionid)){

      if($action == 'block'){
        $status = 0;
      } else {
        $status = 1;
      }
      $this->common_model->update_entry('company',array('status'=>$status),array('company_id'=>$actionid));
      $this->common_model->update_entry('product',array('status'=>$status),array('company_name'=>$actionid));
    
      echo 'ok';exit;

    } else {
      echo '';exit;
    }
  }
	

	 public function ajaxDataTableCompany()
  {
     //$where = array('status' =>'1');
  	/*$sql="SELECT `m16j_company`.*,  COUNT(`m16j_product`.`product_id`) AS `p_count` FROM `m16j_company`LEFT JOIN `m16j_product` ON `m16j_company`.`company_id` =`m16j_product`.`company_name`GROUP BY `m16j_company`.`company_id` limit 1";
  	$result=$this->db->query($sql)->result_array();*/
    $result=$this->Company_model->GetRecord('m16j_company','');

        $data = array();
        $i=1;
        foreach ($result  as $r) {
         $where_comp=array('company_name'=>$r['company_id']);
         $no_of_product = 0;
         $no_of_product = $this->Company_model->count_results('product',$where_comp);

          if($r['status']==1){
            $status='<span id="span_active_'.$r['company_id'].'" class="label label-success">Active</span>';
            $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Company_changeStatus btn btn-default btn-sm" id="block_'.$r['company_id'].'" title="Block this Company ?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['company_id'].'"></i></a>';

             }
            else{
              $status='<span id="span_block_'.$r['company_id'].'" class="label label-danger" >Deactive</span>';

              $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Company_changeStatus btn btn-default btn-sm" id="activate_'.$r['company_id'].'" title="Activate this Company ?"><i class="fa fa-check fa-lg" id="icon_'.$r['company_id'].'"></i></a>';
            }
                            
          $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Company/Editcompany/" . ci_enc($r['company_id'])."'> <i class='fa fa-pencil-square-o'></i></a>";
          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['company_id'].")'> <i class='fa fa-trash-o'></i></a>";
             
          $curr_date = date('d-m-Y h:i:s',strtotime($r['date_added']));
            array_push($data, array(
                $i,
                $r['company_name'],
                 '<span style="text-align: center;margin-left:40%;">'.$no_of_product.'</span>',
                $curr_date,                
                $status,
                $edit_link.$delete_link.$changeStatus
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/Company/Company_detail/" . ci_enc($r['company_id'])."'> <i class='fa fa-eye'></i></a>
    }
    //Function for Load data in data table using ajax starts

}