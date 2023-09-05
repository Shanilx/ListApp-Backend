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
    function GetMultipleRecord($table,$where='',$orderby='', $sort='') {

        $this->db->select('*');
        $this->db->from($table);
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        if(!empty($orderby))
        {
            $this->db->order_by($orderby, $sort);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

  function GetSupplierProduct($table, $where = array(), $orderby = '', $sort = '') {
    $this->db->select('*');
    $this->db->from($table);

    // Check if the $where parameter is an array and not empty
    if (!empty($where) && is_array($where)) {
        // Loop through each condition in the $where array and add it to the query
        foreach ($where as $key => $value) {
            if (is_array($value)) {
                // Handle the case where $value is an array (e.g., 'product_id' => array('product_name' => 'OESTROGEL 0.06% GEL'))
                foreach ($value as $subkey => $subvalue) {
                    $this->db->where("$table.$subkey", $subvalue);
                }
            } else {
                $this->db->where("$table.$key", $value);
            }
        }
    }

    if (!empty($orderby)) {
        $this->db->order_by($orderby, $sort);
    }

    $query = $this->db->get();
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
    function DeleteSupplierDraft($table,$name)
    {   
        $this->db->where('product_name', $name);
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