<?php

class Draft_product_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function save_bulk_entry($table_name, $data)
    {
    
        // Insert the data into the database
        if (!empty($data)) {
            // Make sure to replace 'product_id' and 'supplier_id' with the actual column names
            $this->db->insert_batch($table_name, $data);
        }
    
        return;
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
}

?>