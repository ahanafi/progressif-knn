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

    public function getByNik($nik)
    {
        return $this->getWhereLike('*', ['nik_pemilik' => $nik]);
    }

    public function getByNomorPolisi($nopol)
    {
        return $this->getBy('nomor_polisi', $nopol, true);
    }

    public function getDataBaru()
    {
        $query = $this->customQuery("
            SELECT * FROM $this->table WHERE `status` IS NULL
        ");
        return $query->result();
    }
}

/* End of file Kendaraan_model.php */