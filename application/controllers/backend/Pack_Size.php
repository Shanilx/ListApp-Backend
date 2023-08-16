<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Pack_Size extends CI_Controller

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
		$orderby = 'pack_size_id';
		$data['pack_size_data'] = $this->Pack_Size_model->GetRecord('packsize',$where,$orderby,'desc');
		// print_r($data);die;

		$this->get_header('Manage Packsize');
		$this->load->view('backend/pack_size/pack_size_list', $data);
		$this->load->view('inc/footer'); 
	}
	public function add()
	{
		$this->get_header('Add Pack Size');
		$this->load->view('backend/pack_size/Addpacksize');
		$this->load->view('inc/footer'); 
	}
	public function Add_pack_size()
	{
		$this->check_admin_login();
		$arr = array(
					'Pack_size'=>$this->input->post('Pack_size'),
					'status'=>1,
					'date_added'=>Date('Y-m-d h:i:s')
					);
		//print_r($arr);die;
		$save_result=$this->Pack_Size_model->save_entry('packsize',$arr);
		if($save_result!='')
		{ 
					// $supplier_id = $this->session->set_userdata('supplier_id ');
			$this->session->set_flashdata('succ','Pack Size has been Added Successfully');
			redirect(base_url().'apanel/Packsize');
		}
		else
		{
			$this->session->set_flashdata('err','Pack Size has not been Added. Please Try Again');
			redirect(base_url().'apanel/Packsize');
		}
	}
	public function Edit_pack_size($id)
	{
		$packsize_id = ci_dec($id);
		$where = array('pack_size_id' => $packsize_id);
		$orderby = '';
		$data['edit_packsize'] = $this->Pack_Size_model->GetRecord('packsize',$where,$orderby);

		//print_r($data['edit_Packingtype']); die;
		$this->get_header('Edit Pack Size');
		$this->load->view('backend/pack_size/Editpacksize', $data);
		$this->load->view('inc/footer');  


	}
	public function Edit_packsize_Data($id)
	{
       $packsize_id  = ci_dec($id);
       $arr = array(
					'Pack_size'=>$this->input->post('Pack_size'),
					'date_added'=>Date('Y-m-d h:i:s')
		           );
        $where = array('pack_size_id' => $packsize_id );
        $update_Form = $this->Pack_Size_model->UpdateData('packsize',$arr,$where);
		if($update_Form!='')
		{ 
			$this->session->set_flashdata('succ','Pack Size has been Updated Successfully');
			redirect(base_url().'apanel/Packsize');
		}
		else
		{
			$this->session->set_flashdata('err','Pack Size has not been Updated. Please Try Again');
			redirect(base_url().'apanel/Packsize');
		}
	}
	public function DeletePacksize($id)
	{
		// echo "hello";die;
        $packsize_id = $id; 
		$Delete_Form = $this->Pack_Size_model->DeleteRecord('packsize',$packsize_id);
		// echo $this->db->last_query();die;
		if($Delete_Form!='')
		{ 
			$this->session->set_flashdata('succ','Pack Size has been Deleted Successfully');
			redirect(base_url().'apanel/Packsize');
		}
		else
		{
			$this->session->set_flashdata('err','Pack Size has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/Packsize');
		}

	}
	public function checkName()
	 {
	    $value=trim($this->input->post('Pack_size'));
	    
        $res =$this->common_model->getSuggetion('packsize','Pack_size',$value);
        if(!empty($res) && count($res) > 0){
        	echo (json_encode(false));
        }else{
        	echo (json_encode(true));
        }
	 }
	 
	 public function Packsize_changeStatus(){
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
      $this->common_model->update_entry('packsize',array('status'=>$status),array('pack_size_id'=>$actionid));
    
      echo 'ok';exit;

    } else {
      echo '';exit;
    }
  }
    

    	 public function ajaxDataTablePacksize()
  {
     //$where = array('status' =>'1');
     $result=$this->Pack_Size_model->GetRecord('packsize');

        $data = array();
        $i=1;
        foreach ($result  as $r) {
         
          
          if($r['status']==1){
            $status='<span id="span_active_'.$r['pack_size_id'].'" class="label label-success">Active</span>';
            $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Packsize_changeStatus btn btn-default btn-sm" id="block_'.$r['pack_size_id'].'" title="Block this Pack Size ?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['pack_size_id'].'"></i></a>';

             }
            else{
              $status='<span id="span_block_'.$r['pack_size_id'].'" class="label label-danger" >Deactive</span>';

              $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Packsize_changeStatus btn btn-default btn-sm" id="activate_'.$r['pack_size_id'].'" title="Activate this Pack Size?"><i class="fa fa-check fa-lg" id="icon_'.$r['pack_size_id'].'"></i></a>';
            }
          //$view_link="<a class='btn btn-default btn-sm' data-target='#productModal' data-toggle='modal' href='". base_url()."apanel/product/product_detail/".ci_enc($r['pack_size_id'])."' title='View Supplier'><i class='fa fa-eye'></i></a>";                    
          $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Packsize/Edit_pack_size/" . ci_enc($r['pack_size_id'])."'> <i class='fa fa-pencil-square-o'></i></a>";
          $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['pack_size_id'].")'> <i class='fa fa-trash-o'></i></a>";
             
          $r['date_added']= date('d-m-Y h:i:s',strtotime($r['date_added']));
            array_push($data, array(
                $i,
                $r['Pack_size'],
                $r['date_added'],                
                $status,
                $edit_link.$delete_link.$changeStatus
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['pack_size_id'])."'> <i class='fa fa-eye'></i></a>
    }
    //Function for Load data in data table using ajax starts
}