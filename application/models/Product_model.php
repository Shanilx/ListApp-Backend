<?php

class Product_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
    }

    //function to get entry 
    function get_entry_by_data($single = false, $data = array(), $select="",$table) 
    {
        //if $select has value then select particular fields, else select all fields
        if(!empty($select))
        {
            $this->db->select($select);
        }
        
        $query = $this->db->get_where($table, $data);

        $res = $query->result_array();

        if (!empty($res)) 
        {

            if ($single)   //if single entry, then return single data
            { return $res[0]; }
            else           //if multiple entries, then return array or data
            { return $res;    }
        }

        else
            { return false; }    //if no result is present
    }
    
    function GetRecord($table,$where='',$orderby='', $sort='',$where_like=array()) {

        $this->db->select('*');
        $this->db->from($table);
        if(!empty($where))
        {
            $this->db->where($where);
        }
        if(!empty($where_like))
        {
            $this->db->like($where_like);
        }
        if(!empty($orderby))
        {
            $this->db->order_by($orderby, $sort);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    function GetPaginationData($table,$where_like=array(),$company_name=array(),$form_name=array(),$orderby='', $sort='',$start='',$limit='') {

        $this->db->select('*');
        $this->db->from($table);
        
        if(!empty($where_like))
        {
         $this->db->like($where_like);
            //   foreach ($where_like as $key1 => $search) 
            // {
            //     if (preg_match('/\s/', $search) > 0) 
            //     {
            //      $search = array_map('trim', array_filter(explode(' ', $search)));
            //     foreach ($search as $key => $value) 
            //     {
            //         $this->db->or_like($key1, $value ,'after');
            //     }
            // } 
            //     else if ($search != '')
            //     {
            //         $this->db->like($key1, $search,'after');
            //     }
            // }

     }
     if(!empty($company_name)){
        $this->db->where_in('company_name',$company_name);
    }
    if(!empty($form_name)){
        $this->db->where_in('form',$form_name);
    }
    if(!empty($limit))
    {
        $this->db->limit($limit,$start);
    }
    if(!empty($orderby))
    {
        $this->db->order_by($orderby, $sort);
    }
    $query = $this->db->get();
        //echo $this->db->last_query();
    return $query->result_array();
}

function Getinstructor()
{
    $query = $this->db->get('instructor');
    return $query;   
}

function save_entry($table_name,$data=array())
{

  $this->db->insert($table_name,$data);
  $insert_id = $this->db->insert_id();
  
  return $insert_id;
}
function UpdateData($table,$data,$where)
{
    $prefTable = $this->db->dbprefix($table);
    $insert_id = $this->db->update($prefTable, $data,$where);
    return $insert_id;
        //echo $this->db->last_query();
}
function DelRecord($table,$where)
{
    $prefTable = $this->db->dbprefix($table);
    $this->db->where($where);
    $this->db->delete($prefTable);

}
function deleteMultipleReecord($table,$col_name,$where_in=array())
{
    $prefTable = $this->db->dbprefix($table);
    $this->db->where_in($col_name,$where_in);
    $this->db->delete($table);
    return $this->db->affected_rows();

}



public function count_results($table_name,$where='')
{
    $this->db->from($table_name);
    if($where)
        $this->db->where($where);   
    return  $this->db->count_all_results();
}
public function CheckProductWithForm($table_name,$where='',$id)
{
    $this->db->from($table_name);      
    $this->db->where($where);
    $this->db->where_not_in('product_id',$id);   
    return  $this->db->count_all_results();
}

/*======Delete multiple product Starts ==============*/
function deleteMultipleReecordWithSearch($table,$where_like=array(),$company_name=array(),$form_name=array()) 
{


    if(!empty($where_like))
    {
      $this->db->like($where_like);
            //   foreach ($where_like as $key1 => $search) 
            // {
            //     if (preg_match('/\s/', $search) > 0) 
            //     {
            //      $search = array_map('trim', array_filter(explode(' ', $search)));
            //     foreach ($search as $key => $value) 
            //     {
            //         $this->db->or_like($key1, $value ,'after');
            //     }
            // } 
            //     else if ($search != '')
            //     {
            //         $this->db->like($key1, $search,'after');
            //     }
            // }

    }
         if(!empty($company_name))
         {
            $this->db->where_in('company_name',$company_name);
         }
        if(!empty($form_name))
        {
            $this->db->where_in('form',$form_name);
        }
        if(!empty($where_like) || !empty($form_name) || !empty($company_name))
        {
          $this->db->delete($table);
        }
        else
        {
           $this->db->empty_table($table); 
        }
       return $this->db->affected_rows();

}  
/*======Delete multiple product Ends ==============*/

}
?>