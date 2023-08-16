<?php

class Category_model extends CI_Model {

  
	
	function get_entry_by_data($table_name, $single = false, $data = array(),$select="",$order_by='',$orderby_field='',$limit='',$offset=0) {
	
	 	if(!empty($select)){ 
	 		$this->db->select($select);
	 	}
	 	
        if (empty($data)){
          	
          	$id = $this->input->post('id');
          	
          	if ( ! $id ) return false;

            $data = array('id' => $id);		
            
        }  

        if(!empty($limit)){
        	$this->db->limit($limit,$offset);
        }   

        if(!empty($order_by) && !empty($orderby_field)){

        	$this->db->order_by($orderby_field,$order_by);
        }


        $query = $this->db->get_where($table_name, $data);

        $res = $query->result_array();

        //echo $this->db->last_query();exit;

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

	public function getAllRecords($table,$orderby_field='',$orderby_val='',$where_field='',$where_val='')
	{
		if($orderby_field)
		$this->db->order_by($orderby_field, $orderby_val); 
		
		if($where_field)
		$this->db->where($where_field, $where_val);
		
		$query = $this->db->get($table);
		return $query->result_array(); 	
		/*if($query->num_rows >0)
		{
			
		}*/
	}

	public function count_results($table_name,$where='')
	{

		    $this->db->from($table_name);

		    if($where)
		    $this->db->where($where);	

	return	$this->db->count_all_results();

	}
	
	function insert_entry($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
		
	/* --------------------------------------------------------------------------------- */
	
	function update_entry($table_name, $data, $where)
	{
		return $this->db->update($table_name, $data, $where);
	}
		
     
	
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
		return $this->db->affected_rows();
	}

	function DeleteRecordWhere($table,$where)
	{	
		$this->db->where($where);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}
	
	
	function getSingleRow($table,$where_field,$where_val)
	{
		$this->db->where($where_field,$where_val);
		$query = $this->db->get($table);
		return $query->row();
	}
	
	
	function CheckExisting($table,$where)
	{
	    $this->db->where($where); 
		$rec = $this->db->get($table);
		return $rec->num_rows();
	}
	
	function CheckExisting_1($table,$where)
	{
	$this->db->where($where); 
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

	function run_query($query){

		$this->db->query($query);
		
	}
	function get_parent_category()
	{
		$query=$this->db->get_where('doctor_category',array('cat_parent_id'=>'0'));	
		return $query->result();
	}
	
public function get_per_category($id)
	{
		$query=$this->db->get_where('category',array('id'=>$id));
		return $query->result();
	}
	function get_parent_data(){
		$this->db->select("fs_category.*");
        $this->db->from('fs_category');
        $this->db->join('fs_category as c','c.id=fs_category.cat_parent_id', 'left');
       	$this->db->order_by("fs_category.id", "desc");
        $query = $this->db->get();		
		 $res = $query->result_array();
		return $res;
        //echo $this->db->last_query();exit;
      
	}
}//class end here.
?>