<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_testing_model extends Main_model
{
	protected $table = 'data_testing';

	public function resetData()
    {
        $this->db->truncate($this->table);
    }

    public function getDataTesting()
    {
        $query = $this->customQuery("
            SELECT *, kendaraan.status AS status_kendaraan FROM $this->table
            RIGHT JOIN kendaraan USING (id_kendaraan)
        ");
        return $query->result();
    }
}

/* End of file Data_testing_model.php */