<?php

class Csv_model extends CI_Model {

	function get_addressbook() {     
        $query = $this->db->get('product');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
 
    function insert_csv($data) {
        $this->db->insert('product', $data);
         // echo $this->db->last_query();die;
        return $this->db->insert_id();
    }

    function insert_bulk_of_data($data) {
        $this->db->insert('product', $data);
        // echo $this->db->last_query();die;
        return $this->db->insert_id();
    }

    //  function insert_sms_campaign($data) {
    //     $this->db->insert('sms_campaign', $data);
    //     return $this->db->insert_id();
    // }
}
/*END OF FILE*/
// class close here
?>