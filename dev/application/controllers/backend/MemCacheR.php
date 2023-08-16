<?php 
//ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');

class MemCacheR extends CI_Controller

{

	function __construct(){
		parent::__construct();
		//$this->load->library("pagination");

	}
	// public function index()
	// {  
	// 	$this->load->driver('cache_memcached');
	// 	// $product = $this->product_model->GetRecord('product');
	// 	$cache = $this->cache->memcached->get('cache_data2');
	// 		if($cache)
	// 		{
	// 		  $data = $this->cache->get('cache_data');
	// 		  //print_r($data);
	// 		}
	// 		else
	// 		{
	// 	         $data = $this->product_model->GetRecord('user');
	// 		     $this->cache->memcached->save('cache_data2', '', NULL, 3600);

	// 		}
		
 //                  $all=$this->cache->memcached->get('cache_data2');
 //                  print_r($all);
					
	// }
	public function index()
    {
        // manual connection to Mamcache
        $memcache = new Memcache;
        $memcache->connect("localhost",11211);
    
        echo "Server's version: " . $memcache->getVersion() . "<br />\n";
    
      //  $data = 'This is working';
    
        //$memcache->set("key",$data,false,10);
       // echo "cache expires in 10 seconds<br />\n";
    
        //echo "Data from the cache:<br />\n";
        //var_dump($memcache->get("key"));
        //echo 'If this is all working, <a href="/welcome/go">click here</a> view comparisions';
         $cache=$memcache->delete("key");
         $cache=$memcache->get("key");
        if($cache)
         {
           $data = $memcache->get("key");
          
         }
         else
         {    echo "no cache data";
              $data = $this->product_model->GetRecord('product');
              $memcache->set("key",$data,false,10);

         }
          function search_exif($exif, $field)
				{
				    foreach ($exif as $data)
				    {
				        if ($data['product_name'] == $field){
				            return $data;
				        }
				    }
				}

				$camera = search_exif($data, 'S-NORM CAPSULE');
                 
            echo"<pre>";      print_r($camera);
        
    }
    
  
}

/* End of file welcome.php */


?>