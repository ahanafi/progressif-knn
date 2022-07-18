<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening_koran_model extends Main_model
{
    protected $table = 'rekening_koran';

    public function filterByDate($where = [], $useBetween = false)
    {
        if($useBetween) {
            $idBank = $where['id_bank'];
            $firstDate = $where['first_date'];
            $lastDate =  $where['last_date'];
            $sql = "SELECT * FROM $this->table WHERE id_bank = '$idBank' AND (tanggal BETWEEN '$firstDate' AND '$lastDate')";

            $query = $this->db->query($sql);
        } else {
            $query = $this->db->where($where)->get($this->table);
        }

        return $query->result();
    }
}

/* End of file Rekening_koran_model.php */