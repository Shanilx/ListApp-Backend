<?php

class Supplier_product_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function save_bulk_entry($table_name, $data)
    {
        $product_ids = array(); // Initialize an array to store product IDs
        $supplier_id = null; // Initialize the supplier ID
        $encountered_entries = array(); // Initialize an array to track encountered entries
    
        foreach ($data as $entry) {
            if (isset($entry['existing_products']['product_name'])) {
                $product_name = $entry['existing_products']['product_name'];
                $product_id = $this->common_model->get_entry_by_data("product", true, array('product_name' => $product_name), "product_id");
                if ($product_id !== null) {
                    $product_ids[] = $product_id;
                }
            }
    
            if (isset($entry['id'])) {
                $supplier_id = $entry['id']; // Set the supplier ID
            }
    
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
        }
    
        $supplier_data = array(); // Initialize an array to store supplier data
    
        foreach ($product_ids as $product_id) {
            $entry = array(
                'supplier_id' => $supplier_id,
                'product_id' => $product_id['product_id'],
            );
    
            if (!in_array($entry, $supplier_data)) {
                $supplier_data[] = $entry;
            }
        }
    
        // Insert the data into the database
        if (!empty($supplier_data)) {
            // Make sure to replace 'product_id' and 'supplier_id' with the actual column names
            $this->db->insert_batch($table_name, $supplier_data);
        }
    
        return;
    }
    
       
    
    function UpdateData($table,$data,$where)
    {
        $this->db->where('supplier_id', $id);
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