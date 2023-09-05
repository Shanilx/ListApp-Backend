<?php

class Supplier_company_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function save_bulk_entry($table_name, $data)
    {
        $companyIDs = explode(',', $data[0]);
        $supplierID = $data[1]; // Extract the single value from the data

        $supplier_data = [];
        foreach ($companyIDs as $companyID) {
            $supplier_data[] = array(
                'supplier_id' => $supplierID,
                'company_id' => $companyID,
            );
        }

        if (!empty($supplier_data)) {
            $this->db->insert_batch($table_name, $supplier_data);
        }
        return;
    }


    public function store_bulk_entry($table_name, $data)
    {
        $supplier_data = array(); // Initialize an array to store supplier data
        $encountered_entries = array(); // Initialize an array to track encountered entries
    
        foreach ($data as $entry) {
            $existing_company = isset($entry['company_id']) ? $entry['company_id'] : null;
            $supplier_id = isset($entry['id']) ? $entry['id'] : null;
    
            if ($existing_company !== null && $supplier_id !== null) {
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
                    "supplier_company",
                    true,
                    array('supplier_id' => $supplier_id, 'company_id' => $existing_company),
                    ""
                );
    
                if (!$existing_entry) {
                    // Entry does not exist, so add it to the supplier_data array
                    $supplier_data[] = array(
                        'supplier_id' => $supplier_id,
                        'company_id' => $existing_company,
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
        $this->db->where('supplier_id', $id);
        $this->db->delete($table);
        return $this->db->affected_rows();
        $supplier_data = [];
        foreach ($companyIDs as $companyID) {
            $supplier_data[] = array(
                'supplier_id' => $supplierID,
                'company_id' => $companyID,
            );
        }

        $companyIDs = explode(',', $data);
        $insert_id = $this->db->update($table_name, $data,$where);
        return;
        //echo $this->db->last_query();
    }
}

?>