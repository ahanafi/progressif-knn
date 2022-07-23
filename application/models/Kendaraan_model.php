<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan_model extends Main_model
{
    protected $table = 'kendaraan';

    public function getJsonResult()
    {
        $this->datatables->select('*')->from($this->table);
        return $this->datatables->generate();
    }
}

/* End of file Kendaraan_model.php */