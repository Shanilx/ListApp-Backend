<?php

class Supplier_product_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    function get_entry_by_data($table_name, $single = false, $data = array(),$select="",$order_by='',$orderby_field='', $group_by='') {
		
		if(!empty($select)){
			$this->db->select($select);
		}
		
		if (empty($data)){
			
			$id = $this->input->post('id');
			
			if ( ! $id ) return false;

			$data = array('id' => $id);		
			
		}     

		if(!empty($order_by) && !empty($orderby_field)){

			$this->db->order_by($orderby_field,$order_by);
		}

		if(!empty($group_by))
		{
			$this->db->group_by($group_by);
		}


		$query = $this->db->get_where($table_name, $data);

		$res = $query->result_array();

		if (!empty($res)) {

			if ($single)
				return $res[0]; 
			else
				return $res;
		}

		else
			return false;
	}
    
    public function save_bulk_entry($table_name, $data)
    {
        $supplier_data = array(); // Initialize an array to store supplier data
        $encountered_entries = array(); // Initialize an array to track encountered entries
    
        foreach ($data as $entry) {
            $existing_product = isset($entry['existing_products']) ? $entry['existing_products'] : null;
            $supplier_id = isset($entry['id']) ? $entry['id'] : null;
    
            if ($existing_product !== null && $supplier_id !== null) {
                // Create a unique identifier for the current entry
                $entry_identifier = json_encode($entry);
    
                // Check if the entry has already been encountered
                if (isset($encountered_entries[$entry_identifier])) {
                    // Skip duplicate entry
                    continue;
                } else {
                    // Add the entry to the encountered entries
                    $encountered_entries[$entry_identifier] = true;
                }
    
                // Check if the entry already exists in the database
                $existing_entry = $this->common_model->get_entry_by_data(
                    "supplier_product",
                    true,
                    array('supplier_id' => $supplier_id, 'product_id' => $existing_product),
                    ""
                );
    
                if (!$existing_entry) {
                    // Entry does not exist, so add it to the supplier_data array
                    $supplier_data[] = array(
                        'supplier_id' => $supplier_id,
                        'product_id' => $existing_product,
                    );
                }
            }
        }
    
        // Insert the unique data into the database
        if (!empty($supplier_data)) {
            $this->db->insert_batch($table_name, $supplier_data);
        }
    
        return;
    }
    
    
       
    
    function UpdateData($table,$data,$where)
    {
        $this->db->where($where);
        $this->db->delete($table);
        return $this->db->affected_rows();
        $supplier_data = [];
        foreach ($ProductIDs as $companyID) {
            $supplier_data[] = array(
                'supplier_id' => $supplierID,
                'company_id' => $companyID,
            );
        }

        $ProductIDs = explode(',', $data);
        $insert_id = $this->db->update($table_name, $data,$where);
        return;
        //echo $this->db->last_query();
    }
}

?>