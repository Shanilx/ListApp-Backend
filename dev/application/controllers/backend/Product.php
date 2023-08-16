<?php
error_reporting(0);

defined('BASEPATH') OR exit('No direct script access allowed');



class Product extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    @set_time_limit(0);
    $this->load->library("pagination");
    $this->load->library('session');
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

  public function send_email($to_email, $from_email, $subject, $message) { 
    $from_email = "notify.listapp@gmail.com"; 

    $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
    $this->email->set_header('Content-type', 'text/html');

    $this->email->from($from_email, 'LIST APP'); 
    $this->email->to($to_email);
    $this->email->subject($subject); 
    $this->email->message($message); 

         //Send mail 
    $this->email->send();
         /*if($this->email->send()) 
         { echo "sent"; }
         else 
         { echo $this->email->print_debugger(); }*/
       } 


  //Patient Listing
       public function index()
       {
         
        $this->check_admin_login();
        $where_like=array();
        $search_per_page='';
        $company_name==array();
        $form_name==array();
        if($this->input->get('search'))
        {
             //print_r($_GET); die;
          if($this->input->get('product_name'))
          {          
            $product_name=strip_tags(trim($this->input->get('product_name')));   
            $where_like['product_name']=$product_name;
          } 

          if($this->input->get('advanced_search_val'))
          {
            $advanced_search_val=$this->input->get('advanced_search_val');
            if($this->input->get('company_name'))
            {          
             $company_name=$this->input->get('company_name');              
           } 
           if($this->input->get('drug_name'))
           {          
            $drug_name=strip_tags(trim($this->input->get('drug_name')));
            if($drug_name!="NA" && $drug_name!="na")
            {
             $where_like['drug_name']=$drug_name;
           }  

         }
         if($this->input->get('form_name') )
         {          
          $form_name_=strip_tags($this->input->get('form_name')); 
          if($form_name_!="NA" && $form_name_!="na")
          {
            $form_name=$this->GetName('form','Form',$form_name_,'form_id');
            if($form_name=='')
            {
            $form_name='5445654ssd4fdsfds4f';
             }
          }
          else
          {
            $form_name='5445654ssd4fdsfds4f';
          }
        }
      }
    }

    /*pagination ends here*/
     //$this->product_model->GetPaginationData('product',$where_like,$company_name,$form_name,'product_id','desc');
  
    $where = '';
    $data['all_record']=$this->product_model->GetPaginationData('product',$where_like,$company_name,$form_name,'product_id','desc');



    //---- Strat Pgignation code----//
    $config = array();
    $config["base_url"] = base_url() . "apanel/product/";
    $total_row = count($data['all_record']);
    
    $this->session->set_userdata(array('total_record'=>$total_row));

    $config["total_rows"] = $total_row;
    if($this->uri->segment(4)){
      $this->session->unset_userdata('per_page');
       $this->session->set_userdata(array('per_page'=>$this->uri->segment(4)));     
    }

    if($this->session->userdata('per_page')){
      $config["per_page"] = $this->session->userdata('per_page');
      $data['rpp'] = $this->session->userdata('per_page');
    }else{
      $config["per_page"] = 100;
      $data['rpp'] = 100;
    }

    $config['num_links'] = 2;
    $config['cur_tag_open'] = '&nbsp;<a class="current">';
    $config['cur_tag_close'] = '</a>';
    $config['next_link'] = '&gt;';
    $config['prev_link'] = '&lt;';


    $config['use_page_numbers'] = true;
    $config["uri_segment"] = 3;
    $config['enable_query_strings'] = true;  
    $config['query_string_segment'] = 'per_page_re='.$_GET['per_page_re'].'&product_name='.$_GET['product_name'].'&advanced_search_val='.$_GET['advanced_search_val'].'&company_name[]='.$_GET['company_name'].'&drug_name='.$_GET['drug_name'].'&form_name='.$_GET['form_name'].'&search='.$_GET['search'];
    $config['reuse_query_string']=true;
    //$config['first_url'] = '1?'.$config['query_string_segment'];
    // $config['first_url'] = '1?'.$config['query_string_segment'];
    //$config['query_string']= true;
    if($config["total_rows"] > 100){
      $this->pagination->initialize($config);
    }

    if($this->uri->segment(3) <= 1){
      $page = 0; 
    }
    else{
      $page = $this->uri->segment(3)-1; 
      $page = $page*$config["per_page"];
    }        


   if($page > $total_row){
     $page=($page/$config["per_page"])*100;
   }


    /* $data['record']=$this->home_model->get_all_entries('product', array(

              'fields' => array(
                  'product' => array('*'),

              ),

              'sort'    => 'product.product_id',
              'start' => $page,
              'limit' => $config["per_page"],
              'sort_type' => 'desc'
              ));*/
              if(!empty($where_like )|| !empty($company_name) || !empty($form_name)){

               $data['record']=$this->product_model->GetPaginationData('product',$where_like,$company_name,$form_name,'product_id','desc',$page,$_GET["per_page_re"]);
               $data['search_by']=$where_like;
               $data['form_name']=$form_name_;
               $data['company_name']=$company_name;
               $data['advanced_search_val']=$advanced_search_val;

             }else{
              // $data['record']=$this->product_model->GetPaginationData('product',$where_like,$company_name,$form_name,'product_id','desc',$page,$config["per_page"]);
                $data['record']=$this->home_model->get_all_entries('product', array(

              'fields' => array(
                  'product' => array('*'),

              ),

              'sort'    => 'product.product_id',
              'start' => $page,
              'limit' => $config["per_page"],
              'sort_type' => 'desc'
              ));
             }



             $str_links = $this->pagination->create_links();
             $data["links"] = explode('&nbsp;',$str_links );
//echo $this->db->last_query(); die;
    // $where = '';
    // $data['record'] = $this->product_model->GetRecord('product', $where,'product_id','desc');
             $this->get_header('Manage Product');
             $this->load->view('backend/product/productList', $data);
             $this->load->view('inc/footer');
           }

//Function for Load data in data table using ajax starts

           public function GetName($table,$col_id,$val,$rt_colName)
           {
            $where=array($col_id=>$val);
            $data= $this->product_model->GetRecord($table, $where);
            return $data[0][$rt_colName];
          }
          public function ajaxDataTable_get()
          {

            $offset=100;
            $limit=0;
            $result=$this->AjaxDataTable_model->get_datatables();

            $data = array();
            $i=1;
            foreach ($result  as $r) {

              if($r['company_name']>0){
                $company_name=$this->GetName('company','company_id',$r['company_name'],'company_name');
              } else{ $company_name='NA';}
              if($r['form']>0){
                $form_name=$this->GetName('form','form_id',$r['company_name'],'Form');
              } 
              if($r['schedule'] > 0){
                $schedule_name=$this->GetName('schedule','schedule_id',$r['schedule'],'schedule_name');
              } else{ $schedule_name='NA';}
              if($r['packing_type']>0){
                $packingtype=$this->GetName('packing_type','packing_type_id',$r['packing_type'],'packingtype_name');
              }else{ $packingtype='NA';}
              if($r['pack_size']>0){
                $pack_size=$this->GetName('packsize','pack_size_id',$r['pack_size'],'Pack_size');
              }else{ $pack_size='NA';}
              if($r['status']==1){
                $status='<span id="span_active_'.$r['product_id'].'" class="label label-success">Active</span>';
                $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="product_changeStatus btn btn-default btn-sm" id="block_'.$r['product_id'].'" title="Block this Product ?" ><i class="fa fa-ban fa-lg" id="icon_'.$r['product_id'].'"></i></a>';

              }
              else{
                $status='<span id="span_block_'.$r['product_id'].'" class="label label-danger" >Deactive</span>';

                $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="product_changeStatus btn btn-default btn-sm" id="activate_'.$r['product_id'].'" title="Activate this Product ?"><i class="fa fa-check fa-lg" id="icon_'.$r['product_id'].'"></i></a>';
              }
              $view_link="<a class='btn btn-default btn-sm' data-target='#productModal' data-toggle='modal' href='". base_url()."apanel/product/product_detail/".ci_enc($r['product_id'])."' title='View Supplier'><i class='fa fa-eye'></i></a>";                    
              $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/product/edit/" . ci_enc($r['product_id'])."'> <i class='fa fa-pencil-square-o'></i></a>";
              $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$r['product_id'].")'> <i class='fa fa-trash-o'></i></a>";
              $drugname=($r['drug_name'])?$r['drug_name']:"NA";
              $mrp=($r['mrp'])?$r['mrp']:"0";
              $rate=($r['rate'])?$r['rate']:"0";
          //$href= $r['product_id'];
              array_push($data, array(
                $i,
                $r['product_name'],
                $company_name,
                $drugname,
                $form_name,
                $pack_size,
                $packingtype,
                $mrp,
                $schedule_name,
                $rate,
                $r['add_date'],                
                $status,
                $edit_link.$view_link.$delete_link.$changeStatus
                ));
              $i++;
            }




            $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->AjaxDataTable_model->count_all(),
              "recordsFiltered" => $this->AjaxDataTable_model->count_filtered(),
              "data" => $data,
              );

            echo json_encode($output);
        // echo json_encode(array('data' => $output));
        // <a href='".base_url()."apanel/product/product_detail/" . ci_enc($r['product_id'])."'> <i class='fa fa-eye'></i></a>
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

  //Patient Add
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


            $save_product = $this->product_model->save_entry('product',$arr);
            if($save_product!='')
            { 
              $this->session->set_flashdata('succ','Product has been Added Successfully');
              redirect(base_url().'apanel/product/1');
            }
            else
            {
              $this->session->set_flashdata('err','Product has not been Added. Please Try Again');
              redirect(base_url().'apanel/product/add');
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

        public function editProduct($product_id)
        {
          $this->session->unset_userdata('per_page');
          $product_id = ci_dec($product_id);

          $where = array('product_id' => $product_id);
          $orderby = '';
          $data['records'] = $this->product_model->GetRecord('product',$where,$orderby);

          $where_c=array('company_id'=>$data['records'][0]['company_name']);

          $data['company_name']=$this->product_model->GetRecord('company',$where_c);

          $where_S=array('schedule_id'=>$data['records'][0]['schedule']);
          $data['schedule']=$this->product_model->GetRecord('schedule',$where_S);

          $where_ptype=array('packing_type_id'=>$data['records'][0]['packing_type']);
          $data['packingtype']=$this->product_model->GetRecord('packing_type',$where_ptype);

          $where_psize=array('pack_size_id'=>$data['records'][0]['pack_size']);
          $data['packsize']=$this->product_model->GetRecord('packsize',$where_psize);

          $where_form=array('form_id'=>$data['records'][0]['form']);
          $data['form_name']=$this->product_model->GetRecord('form',$where_form);

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

            $date_updated = date('Y-m-d H:i:s');
            $arr = array(
              'product_name' => $this->input->post('product_name'),
          'company_name' =>$company_id, //$this->input->post('company_name'),
          'packing_type' =>$packing_type_id, //$this->input->post('packing_type'),
          'pack_size' =>$pack_size_id,//$this->input->post('pack_size'),
          'drug_name' =>$this->input->post('drug_name'),
          'form' =>$form_id,//$this->input->post('form_p'),
          'mrp' =>$this->input->post('mrp'),
          'rate' =>$this->input->post('rate'),
          'schedule' =>$schedule_id, //$this->input->post('schedule'),
          'status' =>'1',
          // 'add_date'=>$date_updated
          );


            $where = array('product_id' =>$this->input->post('product_id'));
            $update_product = $this->product_model->UpdateData('product',$arr,$where);


            if($update_product!='')
            { 
              $this->session->set_flashdata('succ','Product Details have been Updated Successfully');
              redirect(base_url().'apanel/product/'.$page_no);
            }
            else
            {
              $this->session->set_flashdata('err','Product Details have not been Updated. Please Try Again');
              redirect(base_url().'apanel/product/edit/'.ci_enc($product_id));
            }


          }
          else
          {
            $this->get_header('Edit Product');
            $this->load->view('backend/product/editProduct', $data);
            $this->load->view('inc/footer');
          }

        }


  //Edit the patient details
        public function detailPatient($user_id)
        {
          $user_id = ci_dec($user_id);

    //$data['rec'] = $this->common_model->get_entry_by_data('user',true,array('user_id'=>$user_id));
          $data['record'] = $this->home_model->get_all_entries('user', array(
            'fields' => array(
              'user' => array('*'),
              'languages' => array('*'),
              ),
            'joins' => array(
              'languages' => array('id','language_id'),
              ),    
            'custom_where' => "user.user_id='".$user_id."'",
            ));
          $this->load->view('backend/patient/viewPatient', $data);

        }


  //Fetch state as per the selected country
        public function get_state()
        {
          $id = $_POST['country_id'];
          $hide_state = $_POST['hide_state'];
    //echo $hide_state; die;

          $where = array('country_id'=>$id);
          $state= $this->patient_model->GetRecord('states', $where, 'name', 'asc');
    //echo $this->db->last_query();die;

          if(!empty($state))
          {
            echo '<option value="">--Select--</option>';
            foreach($state as $st)
            {
              if(!empty($hide_state))
              {
                if($hide_state==$st['id'])
                {
                  echo "<option selected='selected' value=".$st['id'].">".$st['name']."</option>";
            //echo "<option value=".$st['id'].">".$st['name']."</option>";
                }
                else
                {
                  echo "<option value=".$st['id'].">".$st['name']."</option>";
                } 
              }
              else
              {
                echo "<option value=".$st['id'].">".$st['name']."</option>";
              }
            }
          }
          else
          {
            echo "<option value=".''.">NA</option>";
          }


        }



  //Fetch city as per the selected state
        public function get_city()
        {
          $id = $_POST['state_id'];
          $hide_city = $_POST['hide_city'];
    //echo "State id = ".$id." city = ".$hide_city; die;

          $where = array('state_id'=>$id);
          $city= $this->patient_model->GetRecord('cities', $where, 'name', 'asc');

          if(!empty($city))
          {
            echo '<option value="">--Select--</option>';
            foreach($city as $cty)
            {
              if(!empty($hide_city))
              {
                if($hide_city==$cty['id'])
                {
                  echo "<option selected='selected' value=".$cty['id'].">".$cty['name']."</option>";    
            //echo "<option value=".$cty['id'].">".$cty['name']."</option>";
                }
                else
                {
                  echo "<option value=".$cty['id'].">".$cty['name']."</option>";
                }
              }
              else
              {
                echo "<option value=".$cty['id'].">".$cty['name']."</option>";
              }

            }
          }
          else
          {
            echo "<option value=".''.">NA</option>";
          }
        }



  //To check email already registered
        function check_email()
        {
          $email = $this->input->post('email_id');

          $where = array(
            'email' => $email
            );

          $check = $this->common_model->get_entry_by_data('user', true, $where);

          if($check)
          {
            $check=1;
          }
          else
          {
            $check=0;
          }

          echo $check;
          die;
        }

        public function csv_upload()
        {
          $this->check_admin_login();
          $this->get_header('Upload Product');
          $this->load->view('backend/product/csv_upload');
          $this->load->view('inc/footer');
        }

        public function upload_file_in_db()
        {
         //error_reporting(1);

      // 12-06-17
          $configUpload['upload_path'] = './uploads/csv_files';
          $configUpload['allowed_types'] = 'xlsx';
          $configUpload['detect_mime'] = true;

      // 12-06-17

          $this->load->library('upload', $configUpload);

          if (!$this->upload->do_upload('csv_file'))

          {
            $this->session->set_flashdata('err', 'Please use file in the format of .xlsx');
            echo "upload error to file";die;

            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('err', $error['error']);

            redirect(base_url().'apanel/product/csv_upload_form');

          }
          else
          {
            $file_data = $this->upload->data();
            $file_path =  './uploads/csv_files/'.$file_data['file_name'];
            $extension=$file_data['file_ext'];  
            if( $file_data['file_size'] > 0)
            {         // PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
                       $objReader= PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                       $objReader->setReadDataOnly(true);    
                  //Load excel file
                       $objPHPExcel=$objReader->load($file_path);    
                      $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();  //Count Numbe of rows avalable in excel         
                      $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);  
                      $time= date('Y-m-d h:i:s');  
                       // echo $time;die;
                      $column1= $objWorksheet->getCellByColumnAndRow(0,1)->getValue();           
                      $column2= $objWorksheet->getCellByColumnAndRow(1,1)->getValue();           
                      $column3= $objWorksheet->getCellByColumnAndRow(2,1)->getValue();           
                      $column4= $objWorksheet->getCellByColumnAndRow(3,1)->getValue();           
                      $column5= $objWorksheet->getCellByColumnAndRow(4,1)->getValue();           
                      $column6= $objWorksheet->getCellByColumnAndRow(5,1)->getValue();           
                      $column7= $objWorksheet->getCellByColumnAndRow(6,1)->getValue();           
                      $column8= $objWorksheet->getCellByColumnAndRow(7,1)->getValue(); 
                      $column9= $objWorksheet->getCellByColumnAndRow(8,1)->getValue();
                      $exist_product_name=array();
                      $empty_product_name=array();  

                      if((!empty($column1))&&(!empty($column2))&&(!empty($column3))&&(!empty($column4))&&(!empty($column5))&&(!empty($column6))&&(!empty($column7))&&(!empty($column8))&&(!empty($column9))) 
                      {   
                        if(($column1=='Product Name')&&($column2=='Company Name')&&($column3=='Drug Name')&&($column4=='Form')&&($column5=='Pack Size')&&($column6=='Packing Type')&&($column7=='MRP')&&($column8=='Schedule')&&($column9=='Rate'))
                        {
                  //loop from first data untill last data
                          $total_insert_record=0;
                         for($i=2;$i<=$totalrows;$i++)
                         { 

                           $productname= ''; 
                           $Company= ''; 
                           $drugName =''; 
                           $form= ''; 
                           $packSize= ''; 
                           $packingType= ''; 
                           $MRP='';

                           $productname= $objWorksheet->getCellByColumnAndRow(0,$i)->getValue(); 
                           $Company= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue(); 
                           $drugName =$objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); 
                           $form= $objWorksheet->getCellByColumnAndRow(3,$i)->getValue(); 
                           $packSize= $objWorksheet->getCellByColumnAndRow(4,$i)->getValue(); 
                           $packingType= $objWorksheet->getCellByColumnAndRow(5,$i)->getValue(); 
                           $MRP=$objWorksheet->getCellByColumnAndRow(6,$i)->getValue(); 

                           $already_exist='';
                             $already_form_exist = $this->common_model->get_entry_by_data("form",true, array('Form' => $form), "form_id");
                             $already_company_exist = $this->common_model->get_entry_by_data("company",true, array('company_name' => $Company), "company_id");

                             $already_packSize_exist = $this->common_model->get_entry_by_data("packsize",true, array('Pack_size' => $packSize), "pack_size_id");

                             $already_packingType_exist = $this->common_model->get_entry_by_data("packing_type",true, array('packingtype_name' => $packingType), "packing_type_id");

                             $form_id='';
                             $Compny_id='';
                             $packSize_id='';
                             $packingType_id='';

                             $form_id=$already_form_exist['form_id'];
                             unset($already_form_exist);
                             $Compny_id=$already_company_exist['company_id'];
                             unset($already_company_exist);
                             $packSize_id=$already_packSize_exist['pack_size_id'];
                             unset($already_packSize_exist);
                             $packingType_id=$already_packingType_exist['packing_type_id'];
                             unset($already_company_exist);
                             if(!empty($productname) && !empty($Compny_id))
                             {
                              $chek_product=array();
                             $chek_product['product_name']=$productname;
                             $chek_product['company_name']=$Compny_id;
                             if($form)
                             {
                               $chek_product['form']=($form_id)?$form_id:''; 
                             }
                             if($drugName)
                              {     
                                $chek_product['drug_name']=($drugName)?$drugName:'';
                              }
                             if($MRP)
                              { 
                               $chek_product['mrp']=($MRP)?$MRP:'';
                              }
                             if($packSize)
                              {   
                               $chek_product['pack_size']=($packSize_id)?$packSize_id:'';  
                              }
                             if($packingType)
                              {      
                               $chek_product['packing_type']=($packingType_id)?$packingType_id:'';     
                              }
                              
                              $already_exist = $this->common_model->get_entry_by_data("product",true, $chek_product, "product_name,form");
                                          $ququ .= $this->db->last_query()."<hr>"; 
                                          // print_r($already_exist);
                                        // echo  $total_coutn=count($already_exist);die;
                            }

                          
                           
                           //print_r($already_exist); die;

                       

                                      // print_r($already_exist);die;
                          if(!empty($already_exist))
                          {

                            $exist_product_name[]=$already_exist['product_name'].''.$already_exist['form'];
                                        // $exist_product_name[]=$already_exist['form'];
                                        // print_r($exist_product_name);die;
                            $total=count(array_unique($exist_product_name));
                          }
                          else
                          {
                                          // echo "else part";
                                          // die;
                           $drugname=$form=$pack_size=$pack_type=$mrp=$shedule=$rate='';
                           $productname= $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();   

                                          $companyname= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue(); //Excel Column 1
                                          $drugname= $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); //Excel Column 2
                                          if(empty($drugname)){ $drugname='';}
                                          $form=$objWorksheet->getCellByColumnAndRow(3,$i)->getValue(); //Excel Column 3
                                          if(empty($form)){ $form='';}
                                          $pack_size=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue(); //Excel Column 4 
                                          if(empty($pack_size)){ $pack_size='';}
                                           $pack_type=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue(); //Excel Column 5
                                           if(empty($pack_type)){ $pack_type='';}
                                          $mrp=$objWorksheet->getCellByColumnAndRow(6,$i)->getValue(); //Excel Column 6
                                          if(empty($mrp)){ $mrp='';}
                                          $shedule=$objWorksheet->getCellByColumnAndRow(7,$i)->getValue(); //Excel Column 7
                                          if(empty($shedule)){ $shedule='';}
                                          $rate=$objWorksheet->getCellByColumnAndRow(8,$i)->getValue(); //Excel Column 8
                                          if(empty($rate)){ $rate='';}
                                          if(!empty($productname)&&(!empty($companyname)))
                                          {

                                            // check company name suggest or not in company table
                                              // echo $companyname;
                                           $company_record=array(); 
                                           $exist_schedule_record=array();
                                           $exist_packing_type_record=array();
                                           $exist_form_record=array();
                                           $exist_pack_size_record=array();


                                           $exist_company_record = $this->common_model->get_entry_by_data("company",true, array('company_name' => $companyname), "*");


                                           $exist_schedule_record = $this->common_model->get_entry_by_data("schedule",true, array('schedule_name' => $shedule), "*");

                                           $exist_packing_type_record = $this->common_model->get_entry_by_data("packing_type",true, array('packingtype_name' => $pack_type), "*");

                                           $exist_form_record = $this->common_model->get_entry_by_data("form",true, array('Form' =>$form), "*");

                                           $exist_pack_size_record = $this->common_model->get_entry_by_data("packsize",true, array('Pack_size' =>$pack_size), "*");
                                            // echo $this->db->last_query();
                                            // print_r($exist_schedule_record);die;


                                           $company_id_already_exist="";
                                           $schedules_id_already_exist="";
                                           $pack_type_id_already_exist="";
                                           $form_id_already_exist="";
                                           $pack_size_id_already_exist="";
                                            // $exist_schedule_record="";


                                           if(empty($exist_company_record))
                                           {


                                            $company_data=array(
                                              'company_name'=>$companyname,
                                              'status'=>1,
                                              'date_added'=>$time
                                              );

                                            $save_company_data=$this->common_model->insert_entry('company',$company_data);
                                            $company_id_already_exist=$save_company_data;


                                          }

                                          else
                                          {
                                           $company_id_already_exist=$exist_company_record['company_id']; 
                                         }
                                            // code for schedule....

                                         if(!empty($shedule))
                                         {
                                           if(empty($exist_schedule_record))
                                           {
                                              // echo "hello";

                                            $schedule_data=array(
                                              'schedule_name'=>$shedule,
                                              'status'=>1,
                                              'date_added'=>$time
                                              );

                                            $save_schedule_data=$this->common_model->insert_entry('schedule',$schedule_data);
                                            $schedules_id_already_exist=$save_schedule_data;
                                              // echo $this->db->last_query();die;


                                          }
                                          else
                                          {

                                            $schedules_id_already_exist=$exist_schedule_record['schedule_id']; 
                                          }

                                        }
                                            // end schedule..




                                            // for a packing type..
                                        if(!empty($pack_type))
                                        {

                                          if(empty($exist_packing_type_record))
                                          {


                                            $pack_type_data=array(
                                              'packingtype_name'=>$pack_type,
                                              'status'=>1,
                                              'date_added'=>$time
                                              );

                                            $save_pack_type_data=$this->common_model->insert_entry('packing_type',$pack_type_data);
                                            $pack_type_id_already_exist=$save_pack_type_data;
                                              // echo $this->db->last_query();die;


                                          }
                                          else
                                          {

                                           $pack_type_id_already_exist=$exist_packing_type_record['packing_type_id']; 

                                         }
                                       }

                                            // Code for Form..

                                       if(!empty($form))
                                       {

                                        if(empty($exist_form_record))
                                        {


                                          $form_data=array(
                                            'Form'=>$form,
                                            'status'=>1,
                                            'date_added'=>$time
                                            );

                                          $save_form_data=$this->common_model->insert_entry('form',$form_data);
                                          $form_id_already_exist=$save_form_data;
                                              // echo $this->db->last_query();die;


                                        }
                                        else
                                        {

                                         $form_id_already_exist=$exist_form_record['form_id']; 

                                       }
                                     }
                                            // End  Code for Form..

                                            // code for a Pack Size...
                                     if(!empty($pack_size))
                                     {

                                      if(empty($exist_pack_size_record))
                                      {


                                        $pack_size_data=array(
                                          'Pack_size'=>$pack_size,
                                          'status'=>1,
                                          'date_added'=>$time
                                          );

                                        $save_pack_size_data=$this->common_model->insert_entry('packsize',$pack_size_data);
                                        $pack_size_id_already_exist=$save_pack_size_data;
                                              // echo $this->db->last_query();die;


                                      }
                                      else
                                      {

                                       $pack_size_id_already_exist=$exist_pack_size_record['pack_size_id']; 

                                     }
                                   }
                                            // End code for a Pack Size...







                                   $data_user=array('product_name'=>$productname, 'company_name'=>$company_id_already_exist ,'drug_name'=>$drugname ,'form'=>$form_id_already_exist , 'pack_size'=>$pack_size_id_already_exist,'packing_type'=>$pack_type_id_already_exist,'mrp'=>$mrp,'schedule'=>$schedules_id_already_exist,'rate'=>$rate,'status' => '1','add_date'=>$time,);
                                             // print_r($data_user);die;
                                   $save_entry='';
                                   $save_entry= $this->csv_model->insert_bulk_of_data($data_user);                                   
                                   if($save_entry > 0){
                                    $total_insert_record=$total_insert_record+1;
                                   }
                                 }
                               }
                             }
                             //echo $ququ;die;
                             $with_some_not_upload='';
                             if(!empty($exist_product_name) )
                             {



                                        // $var = implode(',',$exist_product_name);
                                        // $msg = $var." Product Name Already Exist.";
                              $total_exist_record=count($exist_product_name);

                              $with_some_not_upload="<span class='error'> ".$total_exist_record." Products Already Exist </span>";
                              $err_msg=$total_exist_record." Products Already Exist";
                              if($total_exist_record == 1){
                                $with_some_not_upload="<span class='error'> ".$total_exist_record." Product Already Exists </span>";
                                $err_msg=$total_exist_record." Product Already Exists";
                              }

                                       // $this->session->set_flashdata('err', $msg);
                                        // redirect(base_url().'apanel/product');
                                        // echo "Product Name Already Exist";
                              $this->session->set_flashdata('err', $err_msg);
                                        // echo $msg;
                              echo "2";
                            }
                            if(!empty($save_entry))
                            {
                              $total_exist_record=count($exist_product_name);
                              $uploaded_products=$total_insert_record;
                               $succ_msg=$uploaded_products.' Products have been Uploaded Successfully.'.$with_some_not_upload;
                                if($uploaded_products == 1){
                                  $succ_msg=$uploaded_products.' Product has been Uploaded Successfully.'.$with_some_not_upload;
                                }

                              $this->session->set_flashdata('succ', $succ_msg);                                      
                              echo "1";
                             }//else{
                            //   echo "4";
                            //   $this->session->set_flashdata('err', 'No Products have been uploaded. Please fill  correct data in sheet');
                            // }
                          }
                          else
                          {
                           $this->session->set_flashdata('err', 'Column Name should be according to Sample XLSX File. Please Try Again');
                             
                           echo "3";

                         }
                       }
                       else
                       {
                         $this->session->set_flashdata('err', 'Column Name should be according to Sample XLSX File. Please Try Again');                       
                         echo "4";

                       }
                     }

                   }
                 }

                 public function deleteProduct($id='')
                 {
        // echo $id;die;
                  $delete_id=ci_dec($id);
                  $where= array('product_id'=>$delete_id);
                  $deleted_id=$this->common_model->DeleteRecords($where,'product');
                  if($deleted_id)
                  { 
                    $this->session->set_flashdata('succ','Product has been Deleted Successfully');
                    redirect(base_url().'apanel/product/'. $this->session->userdata('page_no'));
                  }
                  else
                  {
                    $this->session->set_flashdata('err','Product has not been Deleted. Please Try Again');
                    redirect(base_url().'apanel/product/'. $this->session->userdata('page_no'));
                  }


                }

                 public function deleteMultiple()
                 {
        // echo $id;die;
                  
                  $where_in= $this->input->post('product_ids');
                 // print_r($where_in);die;
                  if(!empty($where_in))
                  {

                      $deleted_id=$this->product_model->deleteMultipleReecord('product','product_id',$where_in);
                      if($deleted_id)
                      { 
                        if($deleted_id==1){
                        $this->session->set_flashdata('succ','Product has been Deleted Successfully');
                        }
                        else
                        {
                          $this->session->set_flashdata('succ','Products has been Deleted Successfully');
                        }
                        echo"1";
                      }
                      else
                      {
                        $this->session->set_flashdata('err','Product has not been Deleted. Please Try Again');
                        echo'0';
                      }

                  }
                  else
                  {
                    echo "0";
                  }

                }
      // Export Product Record..
                public function exports_data(){

                  $this->check_admin_login();
                  $this->phpexcel->setActiveSheetIndex(0);
    //name the worksheet
    // print_r($this->phpexcel->getActiveSheet()->setTitle('Product Record'));
    // $this->phpexcel->getActiveSheet()->setCellValue('A1', 'Product Excel Sheet');
    // $this->phpexcel->getActiveSheet()->setCellValue('A1', 'S.No.');
                  $this->phpexcel->getActiveSheet()->setCellValue('A1', 'Product Name');
                  $this->phpexcel->getActiveSheet()->setCellValue('B1', 'Company Name');
                  $this->phpexcel->getActiveSheet()->setCellValue('C1', 'Drug Name');
                  $this->phpexcel->getActiveSheet()->setCellValue('D1', 'Form');
                  $this->phpexcel->getActiveSheet()->setCellValue('E1', 'Pack Size');
                  $this->phpexcel->getActiveSheet()->setCellValue('F1', 'Packing Type');
                  $this->phpexcel->getActiveSheet()->setCellValue('G1', 'MRP');
                  $this->phpexcel->getActiveSheet()->setCellValue('H1', 'Schedule');
                  $this->phpexcel->getActiveSheet()->setCellValue('I1', 'Rate'); 
                  $this->phpexcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $this->phpexcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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


                  $where = '';
                  $data_d = $this->product_model->GetRecord('product', $where,'add_date','desc');
            // print_r($data_d);die;



                  $exceldata="";
                  foreach ($data_d as $row){

                // Getting Comapny Name...
                    $where=array('company_id'=>$row['company_name']);
                    $company_name= $this->product_model->GetRecord('company', $where);
                    $new_company_name=$company_name[0]['company_name'];
                  // Getting Comapny Name...

                  // Getting Form Name ...
                    $where_form_id=array('form_id'=>$row['form']);
                    $form_name= $this->product_model->GetRecord('form', $where_form_id);
                    if(!empty($form_name))
                    {

                      $new_form_name=$form_name[0]['Form']; 
                    }
                    else
                    {
                  // print_r($form_name);
                      $new_form_name='NA';

                    }
                 // die;
                  // End Getting Drug Name ... 
                    $drug_name= $row['drug_name'];
                    if(empty($row['drug_name']))
                    {
                      $drug_name='NA';
                    }
                // End Getting Drug Name ...

                  //  Getting MRP ... 
                    $mrp= $row['mrp'];
                    if(empty($row['mrp']))
                    {
                      $mrp='NA';
                    }
                // End Getting rate ...

                    $rate= $row['rate'];
                    if(empty($row['rate']))
                    {
                      $rate='NA';
                    }
                // End Getting mrp ...

                  // Getting Pack Size Name

                    $where_pack_size_id=array('pack_size_id'=>$row['pack_size']);
                    $pack_size_name= $this->product_model->GetRecord('packsize', $where_pack_size_id);
                    if(!empty($pack_size_name))
                    {

                      $new_pack_size_name=$pack_size_name[0]['Pack_size']; 
                    }
                    else
                    {
                  // print_r($form_name);
                      $new_pack_size_name='NA';

                    }
                 // die;
                  // End Getting Pack Size Name

                   // Getting Pack Type Name

                    $where_pack_type_id=array('packing_type_id'=>$row['packing_type']);
                    $pack_type_name= $this->product_model->GetRecord('packing_type', $where_pack_type_id);
                    if(!empty($pack_type_name))
                    {

                      $new_pack_type_name=$pack_type_name[0]['packingtype_name']; 
                    }
                    else
                    {
                  // print_r($form_name);
                      $new_pack_type_name='NA';

                    }
                 // die;
                  // End Getting Pack Type Name


                  // Getting  Schedule Name

                    $where_schedule_id=array('schedule_id'=>$row['schedule']);
                    $schedule_name= $this->product_model->GetRecord('schedule', $where_schedule_id);
                    if(!empty($schedule_name))
                    {

                      $new_schedule_name=$schedule_name[0]['schedule_name']; 
                    }
                    else
                    {
                  // print_r($form_name);
                      $new_schedule_name='NA';

                    }
                 // die;
                  // End Getting Schedule Name

                    if(!empty($row['product_name']))
                    {
                      $new_product_name=$row['product_name'];
                    }
                    else
                    {
                      $new_product_name="NA";
                    }



                    $exceldata[] = array('product_name'=> ucfirst($new_product_name),'company_name'=> ucfirst($new_company_name),'drug_name'=> ucfirst($drug_name),'form'=>ucfirst($new_form_name),'pack_size'=>$new_pack_size_name,'packing_type'=>$new_pack_type_name,'mrp'=> $mrp,'schedule'=>$new_schedule_name,'rate'=>$rate);


                    $this->phpexcel->getActiveSheet()->fromArray($exceldata, null, 'A2');
                  }
        // print_r($exceldata);die;
        //Fill data
              $filename="Product Record.xlsx"; //save our workbook as this file name
              header("Content-Type: application/vnd.ms-excel");
              header('Content-Disposition: attachment;filename="'.$filename.'"');
              header('Cache-Control: max-age=0'); 
              $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007'); 
              $objWriter->save('php://output');




            }





            public function sample_exports_data(){





              header("Content-type: application/xlsx");

              header("Content-Disposition: attachment; filename=\"Sample".".xlsx\"");

              header('Content-Type: application/force-download');

              header('Content-Type: application/octet-stream');

              header("Pragma: no-cache");

              header("Expires: 0");



              $handle = fopen('php://output', 'w');

              fputcsv($handle, array('Product Name','Company Name','Drug Name','Form','Pack Size','Packing Type','MRP','Schedule','Rate'));



              $data = array('Product Name'=>'DDD','Company Name'=>'List App','Drug Name'=>'XYZ','Form'=> 'TABLET','Pack Size'=>'2666','Packing Type'=>'Test','MRP'=>'1000','Schedule'=>'ABC','Rate'=>'23.8');



              fputcsv($handle, $data);



              fclose($handle);

              exit;

            }

            public  function product_detail($id='')
            {
              $product_id=ci_dec($id);
              $where=array('product_id'=>$product_id);
              $data['record'] = $this->common_model->GetSingleRecord('product',$where);
        // print_r($data);die;
              $this->load->view('backend/product/viewProduct',$data);
            }

    // change status...
            public function product_changeStatus(){
   
             $action = $this->input->post('ac');
             $actionid = $this->input->post('acid');
             if(!empty($action) && !empty($actionid)){

              if($action == 'deactivate'){
                $status = 0;
              } else {
                $status = 1;
               $where= array('product_id'=>$actionid);
                $Company = $this->common_model->GetSingleRecord('product',$where);
               
              $this->common_model->update_entry('company',array('status'=>$status),array('company_id'=>$Company['company_name']));

              }
              $this->common_model->update_entry('product',array('status'=>$status),array('product_id'=>$actionid));

              echo 'ok';exit;

            } else {
              echo '';exit;
            }
          }

                 public function getCompany()
          {
           $company_name=$this->input->post('c_name');


           $res =$this->common_model->getSuggetion('company','company_name',$company_name);
           $sugetion="";
    //echo $this->db->last_query();die;
           $sugetion.='<ul style="list-style: none;margin-left:0px;">';

           if(!empty($res)){
            $c=1;
            foreach ($res as $value) {
              if($c==1){
                $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_company change_bg"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['company_name'].'">'.$value['company_name'].'</a></li>';
              }
              else{

              $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_company"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['company_name'].'">'.$value['company_name'].'</a></li>';
              }
              $c++;
            }

          }
  /*else
  {
      $sugetion.='<li style="background: lavender;margin-left: -40px;"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none" class="sugg_company" > No Match Found</a></li>';
    }*/
    $sugetion.='</ul>';

    echo $sugetion;
  }


  public function getSchedule()
  {
   $schedule_name=$this->input->post('s_name');


   $res =$this->common_model->getSuggetion('schedule','schedule_name',$schedule_name);
   $sugetion="";
    //echo $this->db->last_query();die;
   $sugetion.='<ul style="list-style: none;margin-left:0px;">';

   if(!empty($res)){
    $s=1;
    foreach ($res as $value) {
      if($s==1){
      $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_schedule change_bg"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['schedule_name'].'">'.$value['schedule_name'].'</a></li>';
    }else{
      $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_schedule"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['schedule_name'].'">'.$value['schedule_name'].'</a></li>';
     }
    }

  }
  /*else
  {
      $sugetion.='<li style="background: lavender;margin-left: -40px;"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none" class="sugg_company" > No Match Found</a></li>';
    }*/
    $sugetion.='</ul>';

    echo $sugetion;
  }

  public function getPackingtype()
  {
   $ptype_name=$this->input->post('ptype_name');


   $res =$this->common_model->getSuggetion('packing_type','packingtype_name',$ptype_name);
   $sugetion="";
    //echo $this->db->last_query();die;
   $sugetion.='<ul style="list-style: none;margin-left:0px;">';

   if(!empty($res)){
    $pk=1;
    foreach ($res as $value) {
      if($pk==1){

      $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_packingtype change_bg"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['packingtype_name'].'">'.$value['packingtype_name'].'</a></li>';
      }else{

      $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_packingtype"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['packingtype_name'].'">'.$value['packingtype_name'].'</a></li>';
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
  public function getPackSize()
  {
   $packS_name=$this->input->post('packS_name');


   $res =$this->common_model->getSuggetion('packsize','Pack_size',$packS_name);
   $sugetion="";
    //echo $this->db->last_query();die;
   $sugetion.='<ul style="list-style: none;margin-left:0px;">';
   $p=1;
   if(!empty($res)){
    foreach ($res as $value) {
      if($p==1){
      $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_packsize change_bg"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['Pack_size'].'">'.$value['Pack_size'].'</a></li>';
      }else{

       $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_packsize"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['Pack_size'].'">'.$value['Pack_size'].'</a></li>';
      }
       $p++;
    }

  }
  /*else
  {
      $sugetion.='<li style="background: lavender;margin-left: -40px;"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none" class="sugg_company" > No Match Found</a></li>';
    }*/
    $sugetion.='</ul>';

    echo $sugetion;
  }

  public function getForm()
  {
   $form_name=$this->input->post('form_name');


   $res =$this->common_model->getSuggetion('form','Form',$form_name);
   $sugetion="";
    //echo $this->db->last_query();die;
   $sugetion.='<ul style="list-style: none;margin-left:0px;">';

   if(!empty($res)){
    $i=1;
    foreach ($res as $value) {
      if($i==1){

      $sugetion.='<li  style="background: lavender;margin-left: -40px;" class="sugg_form_p change_bg"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['Form'].'">'.$value['Form'].'</a></li>';
      }else{
        
      $sugetion.='<li style="background: lavender;margin-left: -40px;" class="sugg_form_p"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none;background:#fffff;"  title="'.$value['Form'].'">'.$value['Form'].'</a></li>';
      }

      $i++;
    }

  }
  /*else
  {
      $sugetion.='<li style="background: lavender;margin-left: -40px;"><a style="margin-left:10px;color:blue;cursor: pointer;text-decoration:none" class="sugg_company" > No Match Found</a></li>';
    }*/
    $sugetion.='</ul>';

    echo $sugetion;
  }

  // public function check_product_name()
  // {
  //   // print_r($_POST);
  //   $product_name = trim($this->input->post('product_name'));
  //   $data = $this->Company_model->get_entry_by_data(true, array('product_name' => $product_name), "product_name","product");
  //     if($data)
  //     {
  //       //return true;
  //       echo (json_encode(false));
  //     }
  //     else
  //     {
  //       //return false;
  //       echo (json_encode(true));
  //     }
  // }


  public function check_product_and_form_combination()
  {
    // print_r($_POST);die;
    $product_name = trim($this->input->post('Product_Name'));
    $form_name = trim($this->input->post('Form_Name'));
    $product_id = trim($this->input->post('Product_id'));
    
    if(!empty($form_name)&&(!empty($product_name)))
    {
      $form_data = $this->Company_model->get_entry_by_data(true, array('Form' => $form_name), "Form,form_id","form");
      $form_id= $form_data['form_id'];

      if($product_id > 0){
        $where=array('product_name' => $product_name,'form'=>$form_id);
        $data=$this->product_model->CheckProductWithForm('product',$where,$product_id);

      }else{
        $data = $this->Company_model->get_entry_by_data(true, array('product_name' => $product_name,'form'=>$form_id), "product_name","product");
      }
      // print_r($data);die;
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


  }


/*===================== Delete Multiple Product Start  ========================*/

 public function deletebyfilter()
 {
   if($this->input->get('search'))
        {
             //print_r($_GET); die;
          if($this->input->get('product_name'))
          {          
            $product_name=strip_tags(trim($this->input->get('product_name')));   
            $where_like['product_name']=$product_name;
          } 

          if($this->input->get('advanced_search_val'))
          {
            $advanced_search_val=$this->input->get('advanced_search_val');
            if($this->input->get('company_name'))
            {          
             $company_name=$this->input->get('company_name');              
           } 
           if($this->input->get('drug_name'))
           {          
            $drug_name=strip_tags(trim($this->input->get('drug_name')));
            if($drug_name!="NA" && $drug_name!="na")
            {
             $where_like['drug_name']=$drug_name;
           }  

         }
         if($this->input->get('form_name') )
         {          
          $form_name_=strip_tags($this->input->get('form_name')); 
          if($form_name_!="NA" && $form_name_!="na")
          {
            $form_name=$this->GetName('form','Form',$form_name_,'form_id');
            if($form_name=='')
            {
            $form_name='5445654ssd4fdsfds4f';
             }
          }
          else
          {
            $form_name='5445654ssd4fdsfds4f';
          }
        }
      }
    }

$data=$this->product_model->deleteMultipleReecordWithSearch('product',$where_like,$company_name,$form_name);
  if($data > 0)
            { 
              $this->session->set_flashdata('succ','Product has been Deleted Successfully');
              redirect(base_url().'apanel/product/1');
            }
            else
            {
              $this->session->set_flashdata('err','Product has not been Deleted. Please Try Again');
              redirect(base_url().'apanel/product/1');
            }

 }

/*===================== Delete Multiple Product Ends ========================*/

public function product_search_log()
{
  $this->get_header('Product Search');
  $this->load->view('backend/product/product_search_log');
  $this->load->view('inc/footer');
}
public function p_search_log()
{
  $result= $this->Retailer_model->get_all_entries('product_search_log', array(
            'fields' => array(
                'product_search_log' => array('*'),
                'user' => array('first_name as user_name,phone'),
                'product' => array('product_name'),
            ),
            'sort'    => 'product_search_log.created_date',
            'sort_type' => 'desc',
          //   'start'    => 0,
          // 'limit'    => 4,
        'joins' => array(
          'user' => array('user_id','user_id','inner'),  
          'product' => array('product_id','product_id'),  
            ),    
       ///'custom_where' => "user.user_id='".$user_id."' AND DATE_FORMAT(created_date,'%Y-%m-%d') >= '".$date."'",
        )); 

    $data = array();
        $i=1;
        foreach ($result  as $r) {
          $created_date=date('d-m-Y h:i:s', strtotime($r['created_date']));
            array_push($data, array(
                $i,
                $r['user_name'],                            
                $r['phone'],                            
                $r['search_text'],                            
                $r['product_name'],   
                $r['pl_count'],   
                $created_date
            ));
            $i++;
        }
 
        echo json_encode(array('data' => $data));


}


}//controller class ends here

?>
