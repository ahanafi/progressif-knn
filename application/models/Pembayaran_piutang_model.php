<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_piutang_model extends Main_model
{
    protected $table = 'pembayaran_piutang';

    //Define related tables
    private $_PELANGGAN = 'pelanggan',
        $_BANK = 'bank',
        $_JENIS_BAYAR = 'jenis_bayar',
        $_KETERANGAN = 'keterangan',
        $_DETAIL_PIUTANG = 'detail_pembayaran_piutang';

    //Define foreign key
    private $_ID_PELANGGAN = 'id_pelanggan',
        $_ID_BANK = 'id_bank',
        $_ID_JENIS_BAYAR = 'id_jenis_bayar',
        $_ID_KETERANGAN = 'id_keterangan',
        $_ID_PIUTANG = 'id_pembayaran_piutang';

    private $isFilteredByTanggalMasuk = false;

    private function getColumns()
    {
        $columns = $this->table . ".*, $this->_PELANGGAN.nama_pelanggan, $this->_BANK.nama_bank, ";
        $columns .= $this->_JENIS_BAYAR . ".nama_jenis_bayar, $this->_KETERANGAN.nama_keterangan ";

        return $columns;
    }

    private function getJoinQueries($where = [])
    {
        $joinTo = " JOIN $this->_PELANGGAN USING ($this->_ID_PELANGGAN) ";
        $joinTo .= " JOIN $this->_BANK USING ($this->_ID_BANK) ";
        $joinTo .= " JOIN $this->_JENIS_BAYAR USING ($this->_ID_JENIS_BAYAR) ";
        $joinTo .= " JOIN $this->_KETERANGAN USING ($this->_ID_KETERANGAN) ";

        $columns = self::getColumns();
        $query = "SELECT " . $columns . " FROM " . $this->table . " " . $joinTo;


        if (!empty($where)) {
            $column = array_keys($where)[0];
            $value = array_values($where)[0];

            $query = "SELECT " . $columns . " FROM " . $this->table . " " . $joinTo;
            $query .= " WHERE $column = '$value' ";
        }

        //die($query);
        return $query;
    }

    public function setFilterByTanggalMasuk($isFiltered = false)
    {
        $this->isFilteredByTanggalMasuk = $isFiltered;
    }

    public function all()
    {
        $query = $this->getJoinQueries();
        return $this->db->query($query)->result();
    }

    public function findById($where = [], $all = false)
    {
        $query = $this->getJoinQueries($where);
        if ($all == true) {
            return $this->db->query($query)->result();
        }
        return $this->db->query($query)->row();
    }

    public function getPembayaranPelanggan($id_pelanggan)
    {
        $query = $this->getJoinQueries(['id_pelanggan' => $id_pelanggan]);
        return $this->db->query($query)->result();
    }

    public function getTotalLainLain($where = [])
    {
        $query = $this->db->select_sum('potongan_lain_lain')
            ->from($this->table)
            ->where($where);
        return $query->get()->row();
    }

    public function getSumPembayaranByBulan($where = [])
    {
        if (count($where) > 1) {
            $id_sales = $where['id_sales'];
            $bulan = $where['MONTH(pembayaran_piutang.tanggal)'];

            $sql = "SELECT SUM(jumlah) AS jumlah
                        FROM pembayaran_piutang
                    JOIN (
                        SELECT DISTINCT id_sales, id_pelanggan FROM nota_penjualan
                        ) AS nota
                    ON nota.id_pelanggan = pembayaran_piutang.id_pelanggan
                    WHERE nota.id_sales = '$id_sales' AND MONTH(pembayaran_piutang.tanggal) = '$bulan'";
            $query = $this->db->query($sql);
        } else {
            $query = $this->db->select_sum('jumlah')
                ->from($this->table)
                ->where($where)
                ->get();
        }
        return $query->row();
    }

    public function getKomisiOrCashback($where = [])
    {
        //Get Selected Columns
        $columnsInPembayaran = $this->table.".kode_pembayaran, $this->table.tanggal AS tanggal_masuk, jumlah AS jumlah_transfer";
        $columnInPelanggan = $this->_PELANGGAN.".nama_pelanggan, $this->_PELANGGAN.id_pelanggan";
        $columnDetailPembayaran = $this->_DETAIL_PIUTANG.".no_nota, $this->_DETAIL_PIUTANG.tanggal AS tanggal_nota, $this->_DETAIL_PIUTANG.nominal_bayar AS jumlah_bayar";
        $otherColumns = "DATEDIFF($this->table.tanggal, $this->_DETAIL_PIUTANG.tanggal) AS jumlah_hari";

        $selectedColumns = "$columnsInPembayaran, $columnInPelanggan, $columnDetailPembayaran, $otherColumns";

        //Join table
        $joinToPelanggan = " JOIN $this->_PELANGGAN USING ($this->_ID_PELANGGAN) ";
        $joinToDetailPembayaran = " JOIN $this->_DETAIL_PIUTANG USING ($this->_ID_PIUTANG) ";

        $joinTable = "$joinToPelanggan $joinToDetailPembayaran";

        $query = "SELECT $selectedColumns FROM $this->table $joinTable";

        if($where != '' && key_exists('first_date', $where) && key_exists('last_date', $where)) {
            $firstDate = $where['first_date'];
            $lastDate = $where['last_date'];
            $query .= " WHERE $this->table.tanggal BETWEEN '$firstDate' AND '$lastDate' ";
        }

        return $this->db->query($query)->result();
    }


}

/* End of file Pembayaran_piutang_model.php */