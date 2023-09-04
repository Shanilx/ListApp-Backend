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