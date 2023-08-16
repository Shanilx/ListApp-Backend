<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$admin_login = $this->session->userdata('admin_id');
		if($admin_login){
			return true;
		} else {
			redirect(base_url('apanel'));
		}
	}

	public function get_header($title='')
	{
		$config['title'] = $title;
		$this->load->view('inc/header', $config);
	}

	
	public function faq()
	{
		//$this->check_admin_login();
		$data['record']= $this->home_model->GetRecord('faq',array(),'created_date', 'DESC'); 

		$this->get_header('Manage FAQ');
		$this->load->view('backend/home/faqList', $data);
		$this->load->view('inc/footer');
	}

	//Schedule Dashboard
	public function addFaq()
	{ 
		//$this->check_admin_login();
		$this->form_validation->set_rules('question','Question','trim|required');
		$this->form_validation->set_rules('answer','Answer','trim|required');
		
		if($this->form_validation->run() == TRUE)
		{ 
			$created_date = date('Y-m-d H:i:s');
			$dataArray=array(
				'question' =>$this->input->post('question'),
				'answer' =>htmlspecialchars($this->input->post('answer')),
				'created_date' =>$created_date,
				);
			$save_faq = $this->home_model->save_entry('faq',$dataArray);

			if($save_faq!='')
			{ 
				$this->session->set_flashdata('succ','FAQ has been added successfully.');
				redirect(base_url().'apanel/home/faq');
			}
			else
			{
				$this->session->set_flashdata('err','FAQ has not been added. Please try again.');
				redirect(base_url().'apanel/home/addfaq');
			}		

		}else{
			
			$config['title'] = 'Add FAQ';
			$this->get_header('Add FAQ');
			$this->load->view('backend/home/addFaq');
			$this->load->view('inc/footer');
		}		

	}

	//function to edit faq
	public function editFaq($faq_id)
	{
		$faq_id = ci_dec($faq_id);

		$where = array('faq_id' => $faq_id);
		$data['records'] = $this->home_model->GetRecord('faq',$where,'');
		
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) 
		{
			$dataArray=array(
				'question' =>$this->input->post('question'),
				'answer' =>htmlspecialchars($this->input->post('answer')),
				);
			$save_entry = $this->home_model->UpdateData('faq',$dataArray,$where);
			
			if($save_entry!='')
			{ 
				$this->session->set_flashdata('succ','FAQ has been updated successfully.');
				redirect(base_url().'apanel/home/faq');
			}
			else
			{
				$this->session->set_flashdata('err','FAQ has not been updated. Please try again.');
				redirect(base_url().'apanel/home/faq');
			}
		}
		else
		{
			$config['title'] = 'Edit FAQ';
			$this->get_header('Edit FAQ');
			$this->load->view('backend/home/addFaq', $data);
			$this->load->view('inc/footer');
		}
		
	}

	//function to get full answer of faq
	public function faqDetail($faq_id)
	{
		$faq_id = $faq_id;

		$data['rec'] = $this->common_model->get_entry_by_data('faq',true,array('faq_id'=>$faq_id));
		$this->load->view('backend/home/viewFaq', $data);

	}

	public function update_faq_status()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		if($status=='1'){
			$st = '2' ;
		}else{
			$st = '1';
		}
		$where_new = array('faq_id' => $id);
		$update_data_new = array('status' => $st);
		$this->home_model->UpdateData('faq', $update_data_new, $where_new);
	}

}

?>
