<?php

class Company_model extends CI_Model {
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

    public function count_results($table_name,$where='')
    {
        $this->db->from($table_name);
        if($where)
            $this->db->where($where);   
        return  $this->db->count_all_results();
    }
    function GetRecord($table,$where,$orderby='', $sort='',$offset='',$limit='') {

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
        if(!empty($limit))
        {
            $this->db->limit($limit, $offset);
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
        $this->db->where('company_id', $id);
        $this->db->delete($table);
        return $this->db->affected_rows();
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
        else{ return false; }    //if no result is present
    }

    public function count_results_find($table,$column_name,$id)
    {
        if(empty($table) ||empty($column_name) || empty($id)){
            return 0;
        }else{
            $this->db->from($table);
            $this->db->where("FIND_IN_SET('".$id."',".$column_name.")!=0");
            return  $this->db->count_all_results();
        }
    }

 }//close model class
 ?>