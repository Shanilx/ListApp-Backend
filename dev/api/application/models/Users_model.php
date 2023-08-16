<?php
/*
Model for functions for user registration, login
*/

//class starts here, extending class of CodeIgniter
class Users_model extends CI_Model 
{

    //function to get entry from sys_users table
    function get_entry_by_data($single = false, $data = array(), $select="") 
    {
	    //if $select has value then select particular fields, else select all fields
     if(!empty($select))
     {
        $this->db->select($select);
    }

    $query = $this->db->get_where('signup', $data);
        // print_r($data);
        // echo $this->db->last_query();die;
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

    // kamini...loin auth...
    function CheckLogin($table_name,$fieldname,$where='')
    {
      $this->db->select($fieldname);
      $this->db->from($table_name);
      if($where !=''):
         $this->db->where($where);
     endif;
     $query = $this->db->get();
  // print_r($where);
  // echo $this->db->last_query();
     if ( $query->num_rows() > 0 )
     {
      $row = $query->row();
      // print_r($row);
      return $row;
  }
  else
  {
      // echo "no data";
      return FALSE;
  }
}
    // end kamini...loin auth...

function CheckAuthentication($select,$data)
{
        //echo 'tetete';die;
    $this->db->select($select);
    $this->db->from('signup');
    $this->db->where($data);
    $query = $this->db->get();
        //echo $this->db->last_query();die;
    $res = $query->result_array();
    return $res[0];
}


function getAllRecords($orderby_field='',$orderby_val='',$where_field='',$where_val='',$limit='')
{
        //echo $limit;
    if($orderby_field)
        $this->db->order_by($orderby_field, $orderby_val); 

    if($where_field)
        $this->db->where($where_field, $where_val);

    if($limit)
        $this->db->limit($limit);

    $query = $this->db->get('users');
        //echo $this->db->last_query();
        //echo $query->num_rows;die;
    if($query->num_rows() >0)
    {
        return $query->result_array();  
    }else
            {   //echo 'wrong';
            return false; }
        }

    //function to save entry in the sys_users table
        function save_entry($data, $key_field, $val) 
        {

        if (!empty($val))    //if select value is given, then update the entry
        {         								
            if (!empty($data) and $this->db->update('users', $data, array($key_field => $val)))
            {
                $query = $this->db->get_where('users', array($key_field => $val));

                $result = $query->result_array();

                return (!empty($result)) ? $result[0] : false; 
            }
            else { return false; }
        }
        else                //if select value is not present, then insert entry
        {

            if ($this->db->insert('users', $data)) 
            {
                return $this->get_entry_by_data(true, array($key_field => $this->db->insert_id()), '*');
            }
            else
                { return false; }

        }
    }	

	//to count all resuls from users table
    function countAllResults($where)
    {
        if($where != '')
        {
            return $this->db->where($where)->count_all_results('users');
        }
        else
        {
            return $this->db->count_all('users');
        }
    }

    //to get records from two tables, i.e. user_role and users using join
    function GetJoinRecords($where_array='',$order_by_field='',$order_by_option='',$limit_start='',$limit_end='',$group_by='')
    {
        if($where_array!='') 
        {
            $this->db->where($where_array); 
        }
        if($order_by_field!='')
        {
            $this->db->order_by($order_by_field,$order_by_option); 
        }
        if($group_by!='')
        {
            $this->db->group_by($group_by); 
        }
        $this->db->select('users.*, user_role.role_title');
        $this->db->from('users');
        $this->db->join('user_role','users.role_id = user_role.role_id');
        //$this->db->join('districts','users.project_zone = districts.dist_id');
        $this->db->where($where_array);
        
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return FALSE;   
        }
        
    }

    function check_register($email)
    {

        $query=$this->db->get_where('users',array("user_email"=>$email));

        if($query->num_rows()>0)
        {

            foreach($query->result() as $a)
            {
              $data = array(
                'user_id'=>$a->user_id,
                'user_name'=>$a->first_name,
                );  
          }
          return $data;
      }
      else
      {
        return 0;
    }
    
}

function set_password($id)
{   
        //$userPassword = $this->input->post('new_password');
    $userPassword ='123456';
    $salt = randomString(4);
    $denspassword=$userPassword.$salt;
    $hashedPassword = sha1( $userPassword . $salt );

    $up_array = array(
      'user_password' => $hashedPassword,
      'salt' => $salt

      ); 
    $this->db->where('user_id',$id);
    
    $this->db->update('users',$up_array);


        //return $this->db->affected_rows();
    return $denspassword;
}

function get_all_records($table='',$col_name='')
{
    $this->db->order_by($col_name, 'asc');
    $query = $this->db->get($table);
      //echo $this->db->last_query();
    return $query->result();
}

function get_all_records_where($table,$where_array='')
{
    $this->db->where($where_array);
    $query = $this->db->get($table);

    return $query->result();
}

function get_permission_data($id,$table)
{
    $this->db->where('role_id',$id);
    $query = $this->db->get($table);

    return $query->result_array();
}
function get_site_all_data($where)
{
    $this->db->select('*,site_info.cust_site_id,site_info.project_zone,site_info.state,site_info.town_name,site_info.site_name,site_info.inc_part_id as partner');
    $this->db->from('site_info');
    $this->db->join('prop_equip_solution as prop', 'prop.site_id = site_info.cust_site_id');
        //$this->db->join('users as user', 'user.user_id = info.inc_part_id', 'left');
    $this->db->join('districts as dist', 'dist.dist_id = site_info.dist_id', 'left');
    $this->db->where($where);
    $query = $this->db->order_by('site_info.createdat', 'desc');
    $query = $this->db->get();        
    return $query->result_array();
}

function get_site_all_data_according_zonal_incharge($project_zone,$whr)
{
    $this->db->select('*,site_info.cust_site_id,site_info.project_zone,site_info.state,site_info.town_name,site_info.site_name,site_info.inc_part_id as partner');
    $this->db->from('site_info');
    $this->db->join('prop_equip_solution as prop', 'prop.site_id = site_info.cust_site_id');
    $this->db->join('districts as dist', 'dist.dist_id = site_info.dist_id', 'left');
    $this->db->where_in('project_zone',$project_zone);
    $this->db->where($whr);
    $query = $this->db->order_by('site_info.createdat', 'desc');
    $query = $this->db->get();  
        //echo $this->db->last_query();die;      
    return $query->result_array();
}

function get_site_data($site_id)
{
    $this->db->select('*,info.project_zone as pz');
    $this->db->from('site_info as info');
    $this->db->join('prop_equip_solution as prop', 'prop.site_id = info.cust_site_id');
    $this->db->join('telecom_technology as tech', 'tech.tech_id = info.tech_id', 'left');
    $this->db->join('users as user', 'user.user_id = info.inc_part_id', 'left');
    $this->db->join('districts as dist', 'dist.dist_id = info.dist_id', 'left');
    $this->db->where('info.cust_site_id',$site_id);
    $query = $this->db->get();        
    return $query->result_array();
}
function InsertData($table,$data)
{
    $prefTable = $this->db->dbprefix($table);
    $this->db->insert($table, $data); 
    $ins_id = $this->db->insert_id();
    return $ins_id;
}
function GetRecord($where=array(),$table,$col_NotIn='' ,$whereNotIn=array(),$select='', $limit='', $no_of_records='')
{  
     if($select){
       $this->db->select($select); 
     }
    else{
        $this->db->select('*'); 
    }
    $this->db->from($table);
    if($where){
        $this->db->where($where);
    }
    if($whereNotIn){
        $this->db->where_not_in($col_NotIn,$whereNotIn);
    }
    if($limit || $no_of_records)
    {
    $this->db->limit($no_of_records,$limit);
    }

    $query = $this->db->get();
    return $query->result_array();
}
function update_entry($data, $table, $site_id, $column)
{
    $this->db->where($column, $site_id);
    $this->db->update($table, $data);
    $this->db->where($column, $site_id);
    $query = $this->db->get($table);
    return $query->result();
}
function get_site_partner()
{
    $this->db->select('*');
    $this->db->from('users');
    $this->db->join('inc_partners as inc','inc.user_id = users.user_id');
    $this->db->where('role_id','5');
    $this->db->where('user_status','1');
    $query = $this->db->get();
    return $query->result();
}
function get_site_zones()
{
    $this->db->select('*');
    $this->db->from('project_zone');
    $this->db->join('districts as dist', 'dist.dist_id = project_zone.dist_id');
    $query = $this->db->order_by('dist_name', 'asc');
    $query = $this->db->get();
    return $query->result();
}
function get_site_project_zone_by_siteid($id)
{
    $this->db->select('*');
    $this->db->from('site_info as info');
    $this->db->join('project_zone as pz', 'pz.dist_id = info.project_zone');
    $this->db->join('districts as dist', 'dist.dist_id = pz.dist_id');
    $this->db->where('site_id', $id);
    $query = $this->db->get();
    return $query->row_array();
}
function UpdateData($table,$data,$where)
{
    $prefTable = $this->db->dbprefix($table);
    return  $this->db->update($prefTable, $data,$where);

}

public function count_record($table_name,$device_token='',$email='')
{

   $this->db->select('*');    
   $this->db->from($table_name);
   $this->db->where('device_token',$device_token);
   $this->db->where('email != ',$email);
   $query = $this->db->get();
        // echo $this->db->last_query();
   return $query->result();
        // return   $this->db->count_all_results();


}

/*Get State City Starts here */
public function GetCityState($table,$rtn_Col,$col_name,$single_val='',$mul_val=array() ,$whereIn=array())
{
    $this->db->select($rtn_Col);    
    $this->db->from($table);
    if($mul_val)
    {
        $this->db->where($mul_val);
    }
    else if($whereIn)
    {
        $this->db->where_in($col_name,$whereIn);
    }
    else
    {
        $this->db->where($col_name,$single_val);
    }
    if($table!='states' && $table!='cities'){
        $this->db->where('status',1);
    }

    $query = $this->db->get();
        // echo $this->db->last_query();
    return $query->result_array();
}

/*Get State City ends */

/*============= Update OTP starts ==============*/

public function updateOTP($table,$id,$data=array())
{
 $this->db->where('user_id',$id);
 $query= $this->db->update($table,$data); 
 return  $query;       
}
/*============= Update OTP ends ==============*/
/*============= Search with col name ==============*/

public function searchWithLike($table,$rtn_Col='',$like=array(),$limit='',$no_of_records='',$both ='')
{
       //$key=array_keys($like); 
 $this->db->distinct();
 if($rtn_Col){
     $this->db->select($rtn_Col);
 }    
 $this->db->from($table);
 $this->db->where('status','1');
 if(!empty($like)){
        foreach ($like as $key1 => $search) 
        {

            if ($search != '' && $both == '')
            {
                $this->db->like($key1, $search,'after');
            }
            elseif($both != '' && $search != '')
            {
                $this->db->like($key1, $search);
            }
        }
    }
if($limit || $no_of_records){
    $this->db->limit($no_of_records,$limit);
}
$query= $this->db->get(); 
return  $query->result_array();       
}
public function searchWithLikeProduct($like=array(),$limit='',$no_of_records='',$both ='' ,$sort='asc')
{
 $this->db->distinct();
 $this->db->select('p.product_id, p.product_name, p.drug_name, p.mrp, p.rate, p.status, p.add_date, cp.company_name as comp_name,f.Form as form, pt.packingtype_name as packing_type, ps.Pack_size as pack_size, sh.schedule_name as schedule');
 $this->db->from('product p');
 $this->db->join('company cp', 'cp.company_id = p.company_name', 'left');
 $this->db->join('form f', 'f.form_id = p.form', 'left');
 $this->db->join('packing_type pt', 'pt.packing_type_id = p.packing_type', 'left');
 $this->db->join('packsize ps', 'ps.pack_size_id = p.pack_size', 'left');
 $this->db->join('schedule sh', 'sh.schedule_id = p.schedule', 'left');
 $this->db->where('p.status','1');
     if(!empty($like)){
        foreach ($like as $key1 => $search) 
        {
            if ($search != '' && $both == ''){
             $this->db->like($key1, $search,'after');
            }
            elseif($both != '' && $search != '')
            {
             $this->db->like($key1, $search);
            }
        }

      }

if($limit || $no_of_records){
    $this->db->limit($no_of_records,$limit);
}
$this->db->order_by('p.product_name',$sort);

$query= $this->db->get();
//echo $this->db->last_query(); 
return  $query->result_array();       
}

/*============= Search with col name ends ==============*/
public function viewProduct($like=array(), $pId='',$offset='',$no_of_records='')
    {
          
        $this->db->select('p.product_id,p.product_name,p.drug_name,c.company_name,f.Form,ps.Pack_size,pkt.packingtype_name,sh.schedule_name,p.mrp,p.rate,p.status,p.add_date');
            $this->db->from('product p'); 
            $this->db->join('company c', 'c.company_id=p.company_name', 'left');
            $this->db->join('form f', 'f.form_id=p.form', 'left');
            $this->db->join('packsize ps', 'ps.pack_size_id=p.pack_size', 'left');
            $this->db->join('packing_type pkt', 'pkt.packing_type_id=p.packing_type', 'left');
            $this->db->join('schedule sh', 'sh.schedule_name = p.schedule', 'left');
            $this->db->where('p.status',1);
            if($pId > 0)
            {
                $this->db->where('p.product_id',$pId);
            }
            

            $this->db->order_by('p.product_id','desc'); 
             if($like){
                    $this->db->like($like);

                }

            if(!empty($offset) || !empty($no_of_records)) {
                $this->db->limit($no_of_records,$offset); 
            }else{
                $this->db->limit(100,0);
            }       
                    
            $query = $this->db->get(); 
            //echo $this->db->last_query();
            if($query->num_rows() != 0)
            {
                return $query->result_array();
                //echo "<pre>";
                //print_r($q); 
            }
            else
            {
                return '0';
            }
    }

    function GetRecord_order($table,$where='', $orderby='', $sort='',$where_like=array()) {

           
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
            $this->db->select('GROUP_CONCAT(m16j_doctor_category.category SEPARATOR ",") AS all_specs');
            $this->db->join('m16j_doctor_category', 'find_in_set(m16j_doctor_category.id,m16j_user.specialization)!=0','left',true);
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

}//class end here.
?>