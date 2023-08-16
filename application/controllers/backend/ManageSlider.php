<?php 
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class ManageSlider extends CI_Controller
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
		$orderby = 'updated_at';
		$data['slider_list'] = $this->common_model->selectData('m16j_slider','','','id','desc');

		$this->get_header('Manage Logs');
		$this->load->view('backend/slider/list', $data);
		$this->load->view('inc/footer'); 
	}

	public function add()
	{
		$this->get_header('Manage Slider');
		$this->load->view('backend/slider/add', $data);
		$this->load->view('inc/footer'); 
	}
	public function addSlider(){
		 $this->form_validation->set_rules('link', 'Link','trim|required');
		 if ($this->form_validation->run() == FALSE) 
        {
            $this->session->set_flashdata('error_message', validation_errors());
            $this->session->set_flashdata('errorclass', 'danger');
            redirect(base_url('backend/slider/add'));
        }
        else
        {
        	extract($this->input->post());
            //$employeedoc = '';
            $imageurl = '';
            $asset_type = MEDIA_PICTURE;
            if (!empty($_FILES['image_url']['name'])) {
                $dirPathThumb =  './uploads/slider/'; 
                $image_url = $this->common_model->docFilePpload('image_url', './uploads/slider/','','');
                if(!empty($image_url)){
                    $imageurl = $image_url;
                }else{
                    $error_text = "Need file type should be $asset_type";
                    $this->session->set_flashdata('errorclass', 'danger');
                    $this->session->set_flashdata('err', $error_text);
                    redirect(base_url('apanel/slider-add'));
                }
            }

            $addedData = array(
                    'link'          => trim($link),
                    'image_url'     => trim($imageurl),
                    'created_at'    => date('Y-m-d h:i:s'),
                    'updated_at'    => date('Y-m-d h:i:s'),
                    );
            $img_id = $this->common_model->insert_entry('m16j_slider', $addedData);
            if($img_id){
                $errors = 'Record added successfully';
                $this->session->set_flashdata('succ', $errors);
                $this->session->set_flashdata('errorclass', 'success');
                redirect(base_url('apanel/slider-list'));
            }else{
                $errors = 'Record not added of server issue';
                $this->session->set_flashdata('err', $errors);
                $this->session->set_flashdata('errorclass', 'danger');
                redirect(base_url('apanel/slider-add'));
            }

        }
	}
	public function edit($id)
	{
		
		$this->get_header('Manage Slider');
		$data['slider_info'] = $this->common_model->rowData('m16j_slider',array('id'=>$id));
		$this->load->view('backend/slider/edit', $data);
		$this->load->view('inc/footer'); 
	}
	public function updateSlider($id){
		 $this->form_validation->set_rules('link', 'Link','trim|required');
		 if ($this->form_validation->run() == FALSE) 
        {
            $this->session->set_flashdata('error_message', validation_errors());
            $this->session->set_flashdata('errorclass', 'danger');
            redirect(base_url('backend/slider/edit'));
        }
        else
        {
        	 extract($this->input->post());
            //$employeedoc = '';
            $imageurl = '';
            $asset_type = MEDIA_PICTURE;
            if (!empty($_FILES['image_url']['name'])) {
                $dirPathThumb =  './uploads/slider/'; 
                $image_url = $this->common_model->docFilePpload('image_url', './uploads/slider/','','');
                if(!empty($image_url)){
                    $imageurl = $image_url;
                     $path = '/uploads/slider/'.$old_img;
                    	unlink($path);
                    $path2 = ''.$old_img;
                    unlink($path2);
                }else{
                    $error_text = "Need file type should be $asset_type";
                    $this->session->set_flashdata('errorclass', 'danger');
                    $this->session->set_flashdata('err', $error_text);
                    redirect(base_url('apanel/slider-add'));
                }
            }
            $updateData = array(
                    'link'          => trim($link),
                    'updated_at'    => date('Y-m-d h:i:s'),
                    );
            if(!empty($imageurl)){
            	$updateData['image_url'] = trim($imageurl);
            }
            $img_id = $this->common_model->updateRecord('m16j_slider',array('id'=>$id), $updateData);
                $errors = 'Record Updated successfully';
                $this->session->set_flashdata('succ', $errors);
                $this->session->set_flashdata('errorclass', 'success');
                redirect(base_url('apanel/slider-list'));
        }
	}
    public function DeleteSliderData($id)
    {
        $this->load->library('session');
        $company_id = $id;
         
        $Delete_Notification = $this->common_model->DeleteRecord('m16j_slider','id',$id );
        if($Delete_Notification > 0)
        { 
            $this->session->set_flashdata('succ','Record has been Deleted Successfully');
            
            redirect(base_url('apanel/slider-list'));
        }
        else
        {
            $this->session->set_flashdata('err','Record has not been Deleted. Please Try Again');
            
            redirect(base_url('apanel/slider-list'));
        }

    }
}