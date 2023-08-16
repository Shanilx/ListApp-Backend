 <?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
  class Check_mail extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Kolkata');
  } 
    public function send_eamil($to_email='')
    {
     $this->load->library('email');
     $this->load->helper('path');
     $config['protocol']='sendmail';
     $config['wordwrap'] = TRUE;
     $config['mailtype'] = 'html';
     $config['priority'] = '1';
     $config['charset'] = 'utf-8';
     $config['crlf']      = "\r\n";
     $config['newline']      = "\r\n";
     $this->email->initialize($config);
     $to_email=($to_email)?$to_email:'rahulnakum.syscraft@gmail.com';
     $from_email='notify@listapp.in';
     $this->email->from($from_email, 'ListApp'); 
     $this->email->to($to_email);
     $this->email->cc('avinash.syscraft@gmail.com,shanilkothari@gmail.com,rahulnakum.syscraft@gmail.com');

     $this->email->subject($subject); 
     $this->email->message($message); 
     $send= $this->email->send(); 
     if($send){
      echo "Mail sent successfully";
     }else{
      print_r($this->email->print_debugger());
     }
  }  
} 
  


  