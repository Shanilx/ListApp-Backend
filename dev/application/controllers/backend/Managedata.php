<?php
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Managedata extends CI_Controller

{   
	public function __construct()
  {
    parent::__construct();
    set_time_limit(0);
  }

	public function get_header($title='')
	{
		$config['title'] = $title;
		$this->load->view('backend/ajaxDataTable/header', $config);
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
		

		$this->get_header('Manage Data');
		$this->load->view('backend/ajaxDataTable/ajaxDataTable');
		$this->load->view('backend/ajaxDataTable/footer'); 
	}

	public function ajaxDataTable_get()
	{

		// $col_arr=array(
		// 			'0'=>'product_id',
		// 			'1'=>'product_name',
		// 			'2'=>'company_name',
		// 			'3'=>'drug_name',
		// 			'4'=>'form',
		// 			'5'=>'pack_size',
		// 			'6'=>'packing_type',
		// 			'7'=>'mrp',
		// 			'8'=>'schedule',
		// 			'9'=>'rate',
		// 			'10'=>'add_date',
		// 			'11'=>'status'					
		// 			  );

  //      $json_arr=array(
  //      	              "data"=>array(),
  //      	              );
		 $result=$this->AjaxDataTable_model->GetRecord('product');
		// foreach ($data as $aRow) {
		// 	$row=array();
		// 	foreach ($col_arr as $col_name) {
		// 		$row[]=$aRow[$col_name];
		// 	}
  //          $json_arr['data'][]=$row;
		// }
  //      echo json_encode($json_arr);

        $data = array();
        $i=1;
        foreach ($result  as $r) {

          $href= $r['product_id'];
            array_push($data, array(
                $i,
                $r['product_name'],
                $r['Company_name'],
                $r['drug_name'],
                $r['form'],
                $r['pack_size'],
                $r['packing_type'],
                $r['mrp'],
                $r['schedule'],
                $r['rate'],
                $r['add_date'],                
                $r['status'],
                "<a href='".base_url()."apanel/product/edit/" . ci_enc($r['product_id'])."'> <i class='fa fa-pencil-square-o'></i></a><a href='javascript:confirmDelete(".$href.")'> <i class='fa fa-trash-o'></i></a>"
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));
    }

	


}//controller class ends

?>