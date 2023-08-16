<?php

class Supplier_model extends CI_Model {
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

    function GetRecord($table,$where='',$orderby='', $sort='') {

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
    function DeleteRecord($table,$id)
    {   
        $this->db->where('supplier_id', $id);
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

}
?>