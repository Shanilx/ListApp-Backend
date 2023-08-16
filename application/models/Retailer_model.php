<?php

class Retailer_model extends CI_Model {
public function __construct()
   	{
        parent::__construct();
    }
    public function save_entry($table_name,$data)
    {
    	//echo $table_name; echo $data;die;
        $this->db->insert($table_name,$data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function GetRecord($table,$where,$orderby='', $sort='') {

        $this->db->select('*');
        $this->db->from($table);
        if(!empty($where))
        {
            $this->db->where($where);
        }
        if(!empty($orderby))
        {
            $this->db->order_by($orderby, $sort);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }
    function UpdateData($table,$data,$where)
    {
        $prefTable = $this->db->dbprefix($table);
        $insert_id = $this->db->update($prefTable, $data,$where);
        return $insert_id;
        //echo $this->db->last_query();
    }
    function DeleteRecord($table,$where)
    {   
        $this->db->where($where);        
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

     public function ajaxGetCompany($table_name,$where='',$ids=array(),$col_name)
    {    
        $this->db->select($col_name);
        $this->db->from($table_name);
        $this->db->where_in($where,$ids);   
        $query= $this->db->get();   
        return  $query->result_array();
    }
       function get_entry_by_data($single = false, $data = array(), $select="", $table) 
    {
         //if $select has value then select particular fields, else select all fields
        if(!empty($select))
        {
            $this->db->select($select);
        }
       
            $query = $this->db->get_where($table, $data);
            //echo $this->db->last_query();die;
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

}
?>