<?php 
error_reporting(1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_sell_post extends CI_Controller

{

	public function __construct()
	{
		parent::__construct();
		$this->check_admin_login();
		date_default_timezone_set('Asia/Kolkata');

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
		$where = array('post_status'=>'Active');
		$orderby = 'created_date';
		$data['retailer_data'] = $this->Retailer_model->GetRecord('product_sell_post',$where,$orderby,'desc');
		//print_r($data['records']);die;
		$this->get_header('Manage Post');
		$this->load->view('backend/post/post_list', $data);
		$this->load->view('inc/footer'); 

		// $this->load->view('Retailer_list', $config);
	}
	
	public function delete_post($id)
	{ 
		$where=array('post_id'=>$id);
		$Delete_retailer = $this->common_model->update_entry('product_sell_post',array('post_status'=>'Deleted'),$where);	
		//$Delete_retailer = $this->Retailer_model->DeleteRecord('product_sell_post',$where);
		if($Delete_retailer!='')
		{ 
			$this->session->set_flashdata('succ','Post has been Deleted Successfully');
			redirect(base_url().'apanel/post');
		}
		else
		{
			$this->session->set_flashdata('err','Post has not been Deleted. Please Try Again');
			redirect(base_url().'apanel/post');
		}

	}
	public function post_changeStatus(){
		$action = $this->input->post('ac');
		$actionid = $this->input->post('acid');
		if(!empty($action) && !empty($actionid)){

			if($action == 'deactivate'){
				$status = 'Deactive';
				$this->common_model->update_entry('product_sell_post',array('post_status'=>$status),array('post_id'=>$actionid,));
			} else {
				$status = 'Active';
				$this->common_model->update_entry('product_sell_post',array('post_status'=>$status),array('post_id'=>$actionid));
			}
			echo 'ok';exit;
		} else {
			echo '';exit;
		}
	}
	public function sold_changeStatus(){
		$action = $this->input->post('ac');
		$actionid = $this->input->post('acid');
		if(!empty($action) && !empty($actionid)){

			if($action == 'Sold'){
				$status = 'Sold';
				$this->common_model->update_entry('product_sell_post',array('sold_status'=>$status),array('post_id'=>$actionid,));
			} else {
				$status = 'Available';
				$this->common_model->update_entry('product_sell_post',array('sold_status'=>$status),array('post_id'=>$actionid));
			}
			echo 'ok';exit;
		} else {
			echo '';exit;
		}
	}
	public  function post_detail($id='')
	{
		$post_id=ci_dec($id);
		$where=array('post_id'=>$post_id);
		$data=  $this->Retailer_model->get_all_entries('product_sell_post', array(
			'fields' => array(
				'product_sell_post' => array('*'),
				'user' => array('first_name as user_name,phone'),				
			),
			'sort'    => 'product_sell_post.created_date',
			'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
			'joins' => array(
				'user' => array('user_id','user_id'),  
				
			),    
			'custom_where' => "product_sell_post.post_id='".$post_id."'",

		));
		$rec['record']=$data[0];
		$this->load->view('backend/post/post_detail_view',$rec);
	}


	public function ajaxDataTablePost()
	{

		$result=$this->Retailer_model->get_all_entries('product_sell_post', array(
			'fields' => array(
				'product_sell_post' => array('*'),
				'user' => array('first_name as user_name,phone'),				
			),
			'sort'    => 'product_sell_post.created_date',
			'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
			'joins' => array(
				'user' => array('user_id','user_id'),  
				
			),    
			'custom_where' => "product_sell_post.post_status!='Deleted' AND user.status='Active'",

		));  

		$data = array();
		$sn=1;
		foreach ($result  as $r) {    

			if($r['post_status']=='Active'){
				$status='<span id="span_active_'.$r['post_id'].'" class="label label-success">Active</span>';
				$changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="post_changeStatus btn btn-default btn-sm" id="deactivate_'.$r['post_id'].'" title="Deactivate" ><i class="fa fa-ban fa-lg" id="icon_'.$r['post_id'].'"></i></a>';

			}
			else{
				$status='<span id="span_deactivate_'.$r['post_id'].'" class="label label-danger" >Deactive</span>';

				$changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="post_changeStatus btn btn-default btn-sm" id="activate_'.$r['post_id'].'" title="Activate"><i class="fa fa-check fa-lg" id="icon_'.$r['post_id'].'"></i></a>';
			}
			if($r['sold_status']=='Available'){
				$sold_status='<span id="span_available_'.$r['post_id'].'" class="label label-success">Available</span>';
				$soldChangeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="sold_changeStatus btn btn-default btn-sm" id="Sold_'.$r['post_id'].'" title="Sold" ><i class="fa fa-sign-in fa-lg" id="icon_'.$r['post_id'].'"></i></a>';

			}
			else{
				$sold_status='<span id="span_sold_'.$r['post_id'].'" class="label label-danger" >Sold</span>';

				$soldChangeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="sold_changeStatus btn btn-default btn-sm" id="Available_'.$r['post_id'].'" title="Available"><i class="fa fa-sign-out fa-lg" id="icon_'.$r['post_id'].'"></i></a>';
			}

			if(strlen($r['post_description']) > 40){
				$r['post_description']=substr($r['post_description'], 0,40).'...';
			}

			$view_link="<a class='btn btn-default btn-sm' data-target='#postModal' data-toggle='modal' href='". base_url()."apanel/post/post_detail/".ci_enc($r['post_id'])."' title='View Post'><i class='fa fa-eye'></i></a>";                      
			//$edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Retailer/Editretailer/" . ci_enc($r['user_id'])."' title='Edit' > <i class='fa fa-pencil-square-o'></i></a>";


			$delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['post_id'].")' title='Delete'> <i class='fa fa-trash-o'></i></a>";

			$r['created_date']= date('d-m-Y h:i:s',strtotime($r['created_date']));	
			//$r['product_expire_date']= date('d-m-Y',strtotime($r['product_expire_date']));	
			//`post_id`, `user_id`, `product_name`, `post_description`, `mrp`, `selling_price`, `margin`, `quantity`, `contact_detail`, `sold_status`, `product_expire_date`, `post_status`, `like_count`, `view_count`, `interested_user`, `created_date`, `updated_date` FROM `m16j_product_sell_post	
			$margin_ruppee=$r['mrp']-$r['selling_price'];	
			$price_in_pre=($margin_ruppee*100)/$r['mrp'];
			array_push($data, array(
				$sn,
				htmlentities( (string) $r['user_name'], ENT_QUOTES, 'utf-8', FALSE),
				$r['phone'],
				$r['product_name'],
				$r['post_description'],
				$r['mrp'],
				$r['selling_price'],
				$price_in_pre.' / '.$margin_ruppee,				
				$r['quantity'],
				$r['contact_detail'],			
				$r['product_expire_date'],
				$sold_status,
				$status,
				$view_link.$changeStatus.$delete_link.$soldChangeStatus
			));
			$sn++;


		}

		echo json_encode(array('data' => $data));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['retailer_id'])."'> <i class='fa fa-eye'></i></a>
	}
    //Function for Load data in data table using ajax starts



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


	public function export_sell_post()
	{
		$this->check_admin_login();
		$this->phpexcel->setActiveSheetIndex(0);
		$this->phpexcel->getActiveSheet()->setCellValue('A1', 'User Name');		
		$this->phpexcel->getActiveSheet()->setCellValue('B1', 'Mobile Number');
		$this->phpexcel->getActiveSheet()->setCellValue('C1', 'Product Name');
		$this->phpexcel->getActiveSheet()->setCellValue('D1', 'Description');
		$this->phpexcel->getActiveSheet()->setCellValue('E1', 'MRP');
		$this->phpexcel->getActiveSheet()->setCellValue('F1', 'Offer Price');
		$this->phpexcel->getActiveSheet()->setCellValue('G1', 'Margin ');
		$this->phpexcel->getActiveSheet()->setCellValue('H1', 'Quantity');
		$this->phpexcel->getActiveSheet()->setCellValue('I1', 'Expire Date');
		$this->phpexcel->getActiveSheet()->setCellValue('J1', 'Contact Detail'); 
		$this->phpexcel->getActiveSheet()->setCellValue('K1', 'Sold Status'); 
		$this->phpexcel->getActiveSheet()->setCellValue('L1', 'Post Date'); 
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
		$where = array('role!='=>1);
		$data_d = $this->Retailer_model->get_all_entries('product_sell_post', array(
			'fields' => array(
				'product_sell_post' => array('*'),
				'user' => array('first_name as user_name,phone'),				
			),
			'sort'    => 'product_sell_post.created_date',
			'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
			'joins' => array(
				'user' => array('user_id','user_id'),  
				
			),    
			'custom_where' => "product_sell_post.post_status!='Deleted' AND user.status='Active'",

		));  
		$exceldata="";
		foreach ($data_d as $row)
		{
			$exceldata[] = array(
				'user_name'=>ucfirst($row['user_name']),
				'mobile_number'=>$row['phone'],
				'product_name'=>$row['product_name'],
				'description'=>trim($row['post_description']),
				'mrp'=>$row['mrp'],
				'offer_price' =>$row['selling_price'],
				'margin'=> $row['margin'],
				'quantity'=>$row['quantity'],
				'expire_date'=>date('d/m/Y',strtotime($row['product_expire_date'])),
				'contact_detail'=>$row['contact_detail'],
				'sold_status'=>$row['sold_status'],
				'post_date'=>date('m/d/Y h:i:s',strtotime($row['created_date']))
			);
			$this->phpexcel->getActiveSheet()->fromArray($exceldata, null, 'A2');
		}	
              $filename="Sell Post File.xlsx"; //save our workbook as this file name
              header("Content-Type: application/vnd.ms-excel");
              header('Content-Disposition: attachment;filename="'.$filename.'"');
              header('Cache-Control: max-age=0'); 
              $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007'); 
              $objWriter->save('php://output');

          }



}//end of controller class