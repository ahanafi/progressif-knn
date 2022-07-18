<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_hutang_model extends Main_model
{
    protected $table = 'pembayaran_hutang';

    //Define related tables
    private $_SUPPLIER = 'supplier',
        $_BANK = 'bank',
        $_JENIS_BAYAR = 'jenis_bayar',
        $_KETERANGAN = 'keterangan';

    //Define foreign key
    private $_ID_SUPPLIER = 'id_supplier',
        $_ID_BANK = 'id_bank',
        $_ID_JENIS_BAYAR = 'id_jenis_bayar',
        $_ID_KETERANGAN = 'id_keterangan';

    private function getColumns()
    {
        $columns = $this->table . ".*, $this->_SUPPLIER.nama_supplier, $this->_BANK.nama_bank, ";
        $columns .= $this->_JENIS_BAYAR . ".nama_jenis_bayar, $this->_KETERANGAN.nama_keterangan";
        return $columns;
    }

    private function getJoinQueries($where = [])
    {
        $joinTo = " JOIN $this->_SUPPLIER USING ($this->_ID_SUPPLIER) ";
        $joinTo .= " JOIN $this->_BANK USING ($this->_ID_BANK) ";
        $joinTo .= " JOIN $this->_JENIS_BAYAR USING ($this->_ID_JENIS_BAYAR) ";
        $joinTo .= " JOIN $this->_KETERANGAN USING ($this->_ID_KETERANGAN) ";

        $columns = self::getColumns();
        $query = "SELECT " . $columns . " FROM " . $this->table . " " . $joinTo;
        if (!empty($where)) {
            $column = array_keys($where)[0];
            $value = array_values($where)[0];

            $query .= " WHERE $column = '$value' ";
        }

        return $query;
    }

    public function all()
    {
        $query = $this->getJoinQueries();
        return $this->db->query($query)->result();

    }

    public function findById($where = [])
    {
        $query = $this->getJoinQueries($where);
        return $this->db->query($query)->row();
    }

    public function getPembayaranSupplier($id_supplier)
    {
        $query = $this->getJoinQueries(['id_supplier' => $id_supplier]);
        return $this->db->query($query)->result();
    }

    public function getTotalLainLain($where = [])
    {
        $query = $this->db->select_sum('potongan_lain_lain')
            ->from($this->table)
            ->where($where);
        return $query->get()->row();
    }

    public function getTotalPembayaranByBulan($where = [])
    {
        return parent::getSumOfColumn('jumlah', $where);
    }
}

/* End of file Pembayaran_hutang_model.php */
