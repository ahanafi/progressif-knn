<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_penjualan_model extends Main_model
{
    protected $table = 'retur_penjualan';

    private function getQueries($where = [])
    {
        $query = "SELECT * FROM $this->table JOIN pelanggan USING (id_pelanggan)";

        if (!empty($where)) {
            $column = array_keys($where)[0];
            $value = array_values($where)[0];

            $query .= " WHERE $column = '$value' ";
        }

        return $query;
    }

    public function all()
    {
        $query = $this->getQueries();
        return $this->db->query($query)->result();
    }

    public function findById($where = [], $all = false)
    {
        $query = $this->getQueries($where);
        $queryResult = $this->db->query($query);
        if ($all === true) {
            return $queryResult->result();
        } else {
            return $queryResult->row();
        }
    }

    public function getTotalByNumber($no_retur)
    {
        return $this->db->select("total")->from($this->table)
            ->where('no_retur', $no_retur)->get()->row();
    }

    public function getSumTotalRetur($where = [])
    {
        if(array_key_exists('id_sales', $where)) {
            $id_sales = $where['id_sales'];
            $month = $where['MONTH(tanggal)'];

            $query = $this->db->query("
                SELECT SUM($this->table.total) AS total
                FROM $this->table
                JOIN detail_pembayaran_piutang USING (no_retur)
                JOIN nota_penjualan USING (no_nota)
                WHERE MONTH($this->table.tanggal) = '$month'
                AND nota_penjualan.id_sales = '$id_sales'
            ");

            return $query->row();
        }

        return parent::getSumOfColumn('total', $where);
    }

    public function getByIdPelanggan($id_pelanggan)
    {
        return parent::getBy('id_pelanggan', $id_pelanggan, true);
    }

    public function filterBy($where = [])
    {
        return $this->db->select("*")
            ->from($this->table)
            ->join('pelanggan', "pelanggan.id_pelanggan =  $this->table.id_pelanggan")
            ->where($where)
            ->get()
            ->result();
    }
}

/* End of file Retur_penjualan_model.php */