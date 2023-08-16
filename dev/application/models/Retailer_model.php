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
        if(empty($where)){
            return false;
        }
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
         else { return false; }    //if no result is present
    }

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
            'having' => false,
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
        if (!empty($args['multi_joins'])) {
            $this->db->select($args['multi_joins']['select']);
            $this->db->join($args['multi_joins']['table'], "find_in_set(".$args['multi_joins']['table'].".".$args['multi_joins']['col_name'].",".$this->db->dbprefix($table_name).".".$args['multi_joins']['col_name1'].")!=0",'left',true);
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

        if ($args['having'])
            $this->db->having($args['having'],null,false);

        if ($args['count'])
        {
            $this->db->from($table_name);
            
            return $this->db->count_all_results();
        }   
        else
        {
            $query = $this->db->get($table_name);

            //echo $this->db->last_query(); die;

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







    }
    ?>