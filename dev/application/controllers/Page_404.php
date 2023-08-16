<?php 
error_reporting(0);
class Page_404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
        $config['title'] = 'Page Not Found';
        $this->load->view('inc/front_header', $config);
        $this->load->view('frontend/page_404.php');
        $this->load->view('inc/front_footer');
    } 
} 
?> 