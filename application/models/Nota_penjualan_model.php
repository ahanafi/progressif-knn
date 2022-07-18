<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nota_penjualan_model extends Main_model
{
    protected $table = 'nota_penjualan';

    public function all()
    {
        $query = "SELECT * FROM $this->table JOIN pelanggan USING (id_pelanggan) JOIN sales USING (id_sales)";
        $query .= " ORDER BY no_nota ASC";
        return $this->db->query($query)->result();
    }

    public function findById($where = [], $all = false)
    {
        $column = array_keys($where)[0];
        $value = array_values($where)[0];

        $query = "SELECT * FROM $this->table JOIN pelanggan USING (id_pelanggan) JOIN sales USING (id_sales) WHERE $column = '$value'";
        if($all !== false) {
            return $this->db->query($query)->result();
        }

        return $this->db->query($query)->row();
    }

    public function getByIdPelanggan($id_pelanggan)
    {
        return parent::getBy('id_pelanggan', $id_pelanggan, true);
    }

    public function getTotalByNumber($no_nota)
    {
        return $this->db->select("total, tanggal")->from($this->table)
            ->where('no_nota', $no_nota)->get()->row();
    }

    public function getSumTotalNota($where = [])
    {
        return parent::getSumOfColumn('total', $where);
    }

    public function getSumTotalNotaLama($id_pelanggan)
    {
        $currentYear = date('Y');
        $query = $this->db->select_sum('total')
            ->where('YEAR(tanggal) <', "$currentYear")
            ->where('id_pelanggan', $id_pelanggan)
            ->get($this->table);
        return $query->row();
    }

    public function getSumTotalNotaByBulan($bulan, $id_sales = '')
    {
        $currentYear = date('Y');
        $where = [
            "MONTH(tanggal)" => $bulan,
            "YEAR(tanggal)" => $currentYear
        ];

        if (!empty(trim($id_sales))) {
            $where['id_sales'] = $id_sales;
        }
        return $this->getSumOfColumn('total', $where);
    }

    public function filterBy($where = [])
    {
        return $this->db->select("*")
            ->from($this->table)
            ->join('pelanggan', "pelanggan.id_pelanggan =  $this->table.id_pelanggan")
            ->join('sales', "sales.id_sales =  $this->table.id_sales")
            ->where($where)
            ->get()
            ->result();
    }

    public function getSumTotalPiutangLama($id_sales)
    {
        $currentYear = date('Y');
        $where = ["YEAR(tanggal) <" => $currentYear];
        if($id_sales != NULL) {
            $where['id_sales'] = $id_sales;
        }
        return $this->getSumOfColumn('total', $where);
    }

    public function getAllByDataTable()
    {
        $this->datatables->select("nota_penjualan.*, sales.nama_sales, pelanggan.nama_pelanggan")
            ->from($this->table)
            ->join('pelanggan', 'id_pelanggan')
            ->join('sales', 'id_sales');
        return $this->datatables->generate();


    }
}

/* End of file Nota_penjualan_model.php */