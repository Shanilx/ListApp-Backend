<?php
class Myclass
{
    function upload_pic($img='',$path='')
	{		

		$this->CI =& get_instance();	
		//$config['upload_path'] = 'uploads/offer/'; 
		$config['upload_path'] = $path; 
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$config['max_width'] = '10241';
		$config['max_height'] = '7681';
		$config['encrypt_name'] = TRUE;
		$this->CI->load->library('upload');
		$this->CI->upload->initialize($config);
		if ($this->CI->upload->do_upload($img))
		{
			$newdata = $this->CI->upload->data();
			$img_new = $newdata['file_name'];

		$return = array('status'=>1,'name'=>$img_new);
		//$this->CI->upload->clear();
		
		return $return;
		} else {
			$return = array('status'=>0,'name'=>$this->CI->upload->display_errors());
			return $return;
		}
			
	}



		function upload_pic_thumb($img='',$path='')
		{
			
			$this->CI =& get_instance();
			$config1['upload_path'] = $path;  //getcwd().'/uploads/icons';
			$config1['allowed_types'] = 'gif|jpg|png|jpeg';
			$config1['max_width'] = '10241';
			$config1['max_height'] = '7681';
			$config1['encrypt_name'] = TRUE;
			$this->CI->load->library('upload');
			$this->CI->upload->initialize($config1);
			if ($this->CI->upload->do_upload($img))
			{
				$newdata = $this->CI->upload->data();
//print_r($newdata);exit;

				$img_new = $newdata['file_name'];
				$config2['image_library'] = 'gd';
			    //$config['source_image'] = getcwd().'/uploads/icons/'.$img_new;
				$config2['source_image'] = 'uploads/offer/icons/temp/'.$img_new;
				$config2['new_image'] =   'uploads/offer/icons/'.$img_new;
				$config2['create_thumb'] = false;
			    $config2['maintain_ratio'] = TRUE;
			    $config2['width'] = 100;
			    $config2['height'] = 100;
				
			$this->CI->load->library('image_lib', $config2);
			
			$this->CI->image_lib->initialize($config2);

		    if(!$this->CI->image_lib->resize())
		    {
		    	//echo $this->CI->image_lib->display_errors();exit;
		    	$return = array('status'=>0,'name'=>$this->CI->image_lib->display_errors());
				return $return;
		    }
		    unlink($config2['source_image']);
		    $return = array('status'=>1,'name'=>$img_new);
			$this->CI->image_lib->clear();
			
			return $return;
			} else {
				$return = array('status'=>0,'name'=>$this->CI->upload->display_errors());
				return $return;
			}
		
		}

	function check_user_login(){ 
		$this->CI = & get_instance();
		$user_login = $this->CI->session->userdata('user_login');
		if($user_login){
			return true;
		} else {
			redirect(base_url());
		}
	}

}
?>