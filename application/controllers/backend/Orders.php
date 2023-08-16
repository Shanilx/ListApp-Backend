<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

header('Access-Control-Allow-Origin: *'); // old code 12-01-2021
/*header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Credentials: true");*/

/*header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
header("Access-Control-Allow-Headers:Content-Type, Authorization");*/


header("Access-Control-Allow-Methods: GET,POST, OPTIONS"); // old code 12-01-2021

// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

//     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
//         header("Access-Control-Allow-Methods: GET, POST,PUT,OPTIONS");        

//     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
//         header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

//     exit(0);
// }
class Orders extends CI_Controller {

  public function __construct()

  {

    parent::__construct();

     @set_time_limit(0);

  }

  function index()

  {

      echo "Index";

  }

  function unitlist()

  {

     $q="SELECT packing_type_id as id, packingtype_name as name FROM `m16j_packing_type` GROUP BY packingtype_name ORDER BY packing_type_id";

      $query = $this->db->query($q);   

    if($query->num_rows()>0){

      $result=$query->result_array();

      $rdata=array();
      foreach($result as $row)
      {
        $rdata[]=$row;
      }

      $data["status"]=200;

      $data["message"]="success";

      $data["result"]=$result;

      echo json_encode($rdata);

    }

    else{

   $data["status"]=201;

      $data["message"]="not found";

      $data["result"]=array();

      echo json_encode($data);

    }
  }

  function productlist()
  {

    //$params = json_decode(file_get_contents('php://input'), true);
    $product_name = $this->uri->segment(4);
      if(empty($product_name))
      {
      $data["status"]=201;
      $data["message"]="not found";
      $data["result"]=array();
      echo json_encode(array());
       return;   
      }
      //$product_name=$params["product_name"];
      //$q="SELECT product_name FROM `m16j_product` WHERE product_name like '%$product_name%'";
      $q="SELECT product_name FROM `m16j_product` WHERE product_name like '$product_name%'";

      $query = $this->db->query($q);   

    if($query->num_rows()>0){

      $result=$query->result_array();
      $rdata=array();
      foreach($result as $row)
      {
        $rdata[]=$row['product_name'];
      }
      

      $data["status"]=200;

      $data["message"]="success";

      $data["result"]=$result;

      echo json_encode($rdata);

    }

    else{

   $data["status"]=201;

      $data["message"]="not found";

      $data["result"]=array();

      echo json_encode(array());

    } 

  }

    function supplierlist()
  {

  //$params = json_decode(file_get_contents('php://input'), true);
  // $supplier_name = $this->uri->segment(4);
  //     if(empty($supplier_name))

  //     {

  //    $data["status"]=201;

  //     $data["message"]="not found";

  //     $data["result"]=array();

  //     echo json_encode(array());

  //      return;   

  //     }

      //$supplier_name=$params["supplier_name"];

     //$q="SELECT supplier_id ,name,mobile_number FROM `m16j_supplier` WHERE name like '%$supplier_name%'";
     $q="SELECT supplier_id ,name,mobile_number FROM `m16j_supplier`";

      $query = $this->db->query($q);   

    if($query->num_rows()>0){

      $result=$query->result_array();

 $rdata=array();
 $i=0;
      foreach($result as $row)
      {
        $rdata[$i]["abbr"]=$row['supplier_id'];
        $rdata[$i]["name"]=$row['name'];
        $rdata[$i]["value"]=$row['mobile_number'];
        $i++;
      }
      
      // $data["status"]=200;

      // $data["message"]="success";

      // $data["result"]=$result;

      echo json_encode($rdata);

    }

    else{

   $data["status"]=201;

      $data["message"]="not found";

      $data["result"]=array();

      echo json_encode(array());

    } 

  }



function getotp(){

    $method = $_SERVER['REQUEST_METHOD'];
      if($method != 'POST'){
      echo json_encode(array('status' => 400,'message' => 'Bad request'));
      return ;
       }

  //$data=$_POST;
          
      $data = json_decode(file_get_contents('php://input'), true);
  //, 'role'=>1
  $query_email=$this->db->get_where('user_test',array("phone"=>$data['phone']));
  $result = $query_email->result_array();
  if(!empty($result))  
  {
    $otp=123456;
    $arr["otp"]=$otp;
    $user_data = $this->common_model->UpdateData('user_test',$arr,array("phone"=>$data['phone']));
    echo json_encode(array('status' => 200,'message' => 'success',"otp"=>$otp));
    
  }else{
     echo json_encode(array('status' => 201,'message' => 'not Found'));
  }
}
function verifyotp()
{
 $method = $_SERVER['REQUEST_METHOD'];
  if($method != 'POST'){
    echo json_encode(array('status' => 400,'message' => 'Bad request'));
   return ;
   }

  //$data=$_POST;
  //, 'role'=>1
    $data = json_decode(file_get_contents('php://input'), true);
  $query_email=$this->db->get_where('user_test',array("phone"=>$data['phone'],'otp'=>$data['otp']));
  $result = $query_email->result_array();
  if(!empty($result))  
  {
   echo json_encode(array('status' => 200,'message' => 'success','data'=>$result[0]));
    
  }else{
     echo json_encode(array('status' => 201,'message' => 'Invalid OTP'));
  }
}
}//controller class ends here
?>