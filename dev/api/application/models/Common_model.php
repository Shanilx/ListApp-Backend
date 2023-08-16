<?php

class Common_model extends CI_Model {

	
	
	function get_entry_by_data($table_name, $single = false, $data = array(),$select="",$order_by='',$orderby_field='', $group_by='') {
		
		if(!empty($select)){
			$this->db->select($select);
		}
		
		if (empty($data)){
			
			$id = $this->input->post('id');
			
			if ( ! $id ) return false;

			$data = array('id' => $id);		
			
		}     

		if(!empty($order_by) && !empty($orderby_field)){

			$this->db->order_by($orderby_field,$order_by);
		}

		if(!empty($group_by))
		{
			$this->db->group_by($group_by);
		}


		$query = $this->db->get_where($table_name, $data);

		$res = $query->result_array();

		if (!empty($res)) {

			if ($single)
				return $res[0]; 
			else
				return $res;
		}

		else
			return false;
	}
	


	function save_entry($table_name, $data, $key_field = 'id', $id = false) { 
		
		if (!empty($id)) 
		{   				
			if (!empty($data) and $this->db->update($table_name, $data, array($key_field => $id)))
			{ 
				$query = $this->db->get_where($table_name, array($key_field => $id));
				$result = $query->result_array();
				
				return (!empty($result)) ? $result[0] : false; 
			}
			else return false;					
		}
		else 
		{
			
			if ($this->db->insert($table_name, $data)) 
			{
				return $this->get_entry_by_data($table_name, true, array($key_field => $this->db->insert_id()));
			}
			else
				return false;
			
		}
	}	
	public function get_num_rows($table,$where)
	{ 
		$query = $this->db->query("SELECT * FROM $table $where");
		
		return $query->num_rows();

	}
	
	public function getNumRows($table,$orderby_field='',$orderby_val='',$where_field='',$where_val='')
	{ 
		
		if (empty($data)){
			
			$id = $this->input->post('id');
			
			if ( ! $id ) return false;

			$data = array('id' => $id);		
			
		}
		
		$query = $this->db->get_where($table_name, $data);
		$res = $query->num_rows;

		return $res;
	}

	public function getAllRecords($table,$orderby_field='',$orderby_val='',$where_field='',$where_val='', $group_by='')
	{
		if($orderby_field)
			$this->db->order_by($orderby_field, $orderby_val); 
		
		if($where_field)
			$this->db->where($where_field, $where_val);

		if($group_by)
			$this->db->group_by($group_by);			
		
		$query = $this->db->get($table);

		if($query->num_rows() >0)
		{
			return $query->result_array(); 	
		}
	}


	
	
	public function count_results($table_name,$where='')
	{
		// echo $table_name;
		// print_r($where);die;

		$this->db->from($table_name);

		if($where)
			$this->db->where($where);	
		// echo $this->db->last_query();

		return	$this->db->count_all_results();

	}

	function UpdateData($table,$data,$where)
	{
		$prefTable = $this->db->dbprefix($table);
       //return $this->db->update($prefTable, $data,$where);
		return $this->db->update($prefTable, $data,$where);
		// echo $this->db->last_query(); die;
	}
	
	
	function insert_entry($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
	
	/* --------------------------------------------------------------------------------- */
	
	function update_entry($table_name,$data,$where)
	{
		return $this->db->update($table_name, $data, $where);
		
	}
	 
	
	/* --------------------------------------------------------------------------------- */
	
	
	/* --------------------------------------------------------------------------------- */

	public function get_all_entries($table_name, $input = array()) {
		
		$default = array(
			'start' => 0,
			'limit' => false,
			'sort'  => 'id',
			'sort_type' => 'asc',
			'single' => false,
			'distinct' => false,
			'custom_where' => false,
			'group_by' => false,
			'count' => false
			);
		
		$args = array_merge($default, $input);

		if (!empty($args['fields'])) {
			foreach ($args['fields'] as $key => $value) {
				foreach ($value as $val) {
					if (strpos($val, "(") !== false)
						$this->db->select($val);
					else
						$this->db->select($key . '.' . $val);
				}
			}
		}
		if ($args['limit'] && !$args['count'])
			$this->db->limit($args['limit'], $args['start']);

		if (!$args['count']) $this->db->order_by($args['sort'], $args['sort_type']);

		if (!empty($args['joins'])) {
			foreach ($args['joins'] as $key => $value) {                
				if (is_array($value))
				{									
					if ($value[0] == 'custom')
					{						
						$this->db->join($key, $value[1], ((!empty($value[2])) ? $value[2] : 'left'));                						
					}
					else
						$this->db->join($key, $key . '.'.$value[0].' = ' . $table_name . '.' . $value[1], ((!empty($value[2])) ? $value[2] : 'left'));                
				}
				else
				{
					$this->db->join($key, $key . '.id = ' . $table_name . '.' . $value, 'left');                
				}
			}
		}		
		
		if (!empty($args['where'])) {
			foreach ($args['where'] as $key => $value) {
				if (is_array($value))
				{
					if (!empty($value[0]) and $value[0] == 'custom') 
						$this->db->where($value[1], NULL, FALSE);
					elseif (!empty($value[0])) 
						$this->db->where($value[0] . '.' . $key, $value[1]);
					else
						$this->db->where($table_name.'.'.$value[1], NULL, FALSE);
				}
				else
				{
					
					if ($value !== '')
						$this->db->where($table_name . '.' . $key, $value);					
				}
			}
		};        

		if (!empty($args['where_in'])) {
			foreach ($args['where_in'] as $key => $value) {
				if (is_array($value))
				{
					$this->db->where_in($table_name . '.' . $key, $value);					
				}				
			}
		};

		if (!empty($args['where_not_in'])) {
			foreach ($args['where_not_in'] as $key => $value) {
				if (is_array($value))
				{
					$this->db->where_not_in($table_name . '.' . $key, $value);					
				}				
			}
		};


		if ($args['custom_where']):

			$this->db->where($args['custom_where']);

		endif;

		if (!empty($args['or_where'])) {
			foreach ($args['or_where'] as $key => $value) {
				if ($value !== '')
					$this->db->or_where($table_name . '.' . $key, $value);
			}
		};

		if (!empty($args['like'])) {
			foreach ($args['like'] as $key => $value) {
				if (is_array($value))
				{					
					if (empty($value[2]))
						$this->db->like($value[0] . '.' . $key, $value[1]);					
					else
						$this->db->like($value[0] . '.' . $key, $value[1], $value[2]);
				}
				else
				{
					if ($value !== '')
						$this->db->like($table_name . '.' . $key, $value);
				}                
			}
		};
		
		if (!empty($args['or_like'])) {
			foreach ($args['or_like'] as $key => $value) {
				if (is_array($value))
				{					
					$this->db->or_like($value[0] . '.' . $key, $value[1]);					
				}
				else
				{
					if ($value !== '')
						$this->db->or_like($table_name . '.' . $key, $value);
				}                
			}
		};
		
		if (!empty($args['not_like'])) {
			foreach ($args['not_like'] as $key => $value) {
				if (is_array($value))
				{					
					$this->db->not_like($value[0] . '.' . $key, $value[1]);					
				}
				else
				{
					if ($value !== '')
						$this->db->not_like($table_name . '.' . $key, $value);
				}                
			}
		};        

		if ($args['distinct'])
			$this->db->distinct();
		
		if ($args['group_by'] && !$args['count'])
			$this->db->group_by($args['group_by']);

		if ($args['count'])
		{
			$this->db->from($table_name);
			
			return $this->db->count_all_results();
		}	
		else
		{
			$query = $this->db->get($table_name);

			$results = $query->result_array();

			if (!empty($results)) {

				if ($args['single'])
					return $results[0]; else
				return $results;
			}
			else
				return array();
		}
	}

	/* --------------------------------------------------------------------------------- */
	
	function UpdateRecords($table,$data,$field,$id)
	{	
		$this->db->where($field, $id);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}
	
	function DeleteRecord($table,$field,$id)
	{	
		$this->db->where($field, $id);
		$this->db->delete($table);
		$this->db->last_query();die;
		return $this->db->affected_rows();
	}
	function DeleteRecords($where,$table)
	{
		$this->db->where($where);
		$this->db->delete($table);
		return true;
	}
	
	function CheckEmailName($table,$email)
	{
		$this->db->where('member_email',$email);
		$rec = $this->db->get($table);
		return $rec->num_rows();
	}
	
	function getSingleRow($table,$where_field,$where_val)
	{
		$this->db->where($where_field,$where_val);
		$query = $this->db->get($table);
		
		if($query->num_rows>0)
		{
			return $query->row();
		}else
		{
			return false;
		}
		
		
	}
	
	
	function CheckExisting($table,$field_name,$param)
	{
		$this->db->where($field_name,$param);
		$rec = $this->db->get($table);
		return $rec->num_rows();
	}
	
	function CheckExistingMail($table,$email,$member_id)
	{
		$this->db->where('business_email',$email);
		$this->db->where('member_id <> ',$member_id);
		$rec = $this->db->get($table);
		return $rec->num_rows();
	}
	
	
	function selectColumn($table,$sel_field,$where_field,$where_val)
	{
		$this->db->select($sel_field); 
		$this->db->from($table);   
		$this->db->where($where_field, $where_val);
		return  $this->db->get()->result();	
		
		
	}
	
	//----------------------------------------------------------------------------------------

	public function check_register($email)
	{		
		$query=$this->db->get_where('hvs_supplier',array("email"=>$email));
		
		if($query->num_rows()>0)
		{
			
			foreach($query->result() as $a)
			{
				$data = array(
					
					'user_id'=>$a->user_id,
					'email'=>$a->email
							//'password'=>$a->password,
							///'password_without_md5'=>$a->password_without_md5 
					
					);	
			}
			return $data;
		}
		else
		{
			return 0;
		}
	}
	
	public function change_forget_password($id)
	{
		$up_array = array(
			'password' => md5($this->input->post('new_password')),
			 // 'password_without_md5' => $this->input->post('new_password'),	
			);	
		$this->db->where('email',$id);
		
		$this->db->update('hvs_supplier',$up_array);
		
		return $this->db->affected_rows();
	}
	
	public function change_password()
	{
		$admin_id = $this->session->userdata('user_id');
		
		$up_array = array(
			'password' => md5($this->input->post('new_password')),
			'password_without_md5' => $this->input->post('new_password'),	
			);	
		$this->db->where('user_id',$admin_id);
		
		$this->db->update('hvs_supplier',$up_array);
		
		return true;
	}
	
	function GetRecord($table,$where) {

		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
        //echo $this->db->last_query();
		return $query->result_array();
	}


	function getAllotedLocation()
	{
		$session_admin_id = $this->session->userdata('admin_id');
		$session_role_id = $this->session->userdata('role_id');
		if ($session_role_id == '1'){
			$dbquery = $this->db->query('select location_id, location_name from wp_location where status = 1 order by location_name');
		} else {
			$dbquery = $this->db->query('select location_id, location_name from wp_location 
				where location_id in (select location_id from wp_users_location where status = 1 and user_id = ' . $session_admin_id . ') order by location_name');
		}
		
		return $dbquery->result_array();
	}
	function get_suspend_date()
	{
    	//$today = date("Y-m-d");
		$email = $this->input->post('email');
		$cur_date   = date("Y-m-d");
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where("from_suspend_date <=",$cur_date);
		$this->db->where("to_suspend_date >=",$cur_date);
		$this->db->where("email =",$email);
		$this->db->where("role =",'2');
		$query = $this->db->get();
        //echo $this->db->last_query();die;
		return $query->result_array();
	}
	function get_suspend_browse_date($data_email)
	{
    	//echo $data_email;die;
    	//$today = date("Y-m-d");
		$email = $this->input->post('email');
		$cur_date   = date("Y-m-d");
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where("from_suspend_date <=",$cur_date);
		$this->db->where("to_suspend_date >=",$cur_date);
		$this->db->where("email =",$data_email);
		$this->db->where("role =",'2');
		$query = $this->db->get();
        //echo $this->db->last_query();die;
		return $query->result_array();
	}

	function GetSingleRecord($table,$where) {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
    }


	public function getSuggetion($table,$column_name,$Search='')
	{    
		$this->db->distinct();
		$this->db->where('status',1);
		$this->db->like($column_name, $Search);
		
		
    	$res = $this->db->get($table)->result_array();

    	return $res;
	}


	

//----------------------------------------Prasad--------------------------------------------


	
//---------------------------------------------------------------------------------------------

	
	
	
} // class close here
?>