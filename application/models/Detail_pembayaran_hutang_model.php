<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_pembayaran_hutang_model extends Main_model
{
	protected $table = 'detail_pembayaran_hutang';

	public function getPembayaranNotaSupplier($no_nota)
    {
        $query = $this->db->select("SUM(nominal_bayar + potongan_retur) AS nominal_bayar")
            ->where('no_nota', $no_nota)->get($this->table);
        $result = 0;
        if($query->num_rows() > 0) {
            $result = $query->row()->nominal_bayar;
        }

        return $result;
    }

    public function getNominalBayarBy($where = [])
    {
        $column = array_keys($where)[0];
        $value = array_values($where)[0];

        return $this->db->select_sum('nominal_bayar')
            ->where($column, $value)->get($this->table)
            ->row();
    }

    public function getSumPembayaranByBulan($where)
    {
       /* $query = "SELECT SUM(nominal_bayar) AS nominal_bayar
                    FROM $this->table
                JOIN nota_pembelian USING (no_nota)
                WHERE MONTH($this->table.`tanggal`) = '$bulan' ";

        if(!empty(trim($id_supplier))) {
            $query .= " AND id_supplier = '$id_supplier'";
        }

        $query = $this->db->query($query);*/
        $query = $this->db->select_sum('nominal_bayar')
            ->from($this->table)
            ->join('pembayaran_hutang', 'id_pembayaran_hutang')
            ->join('nota_pembelian', 'id_supplier')
            ->where($where)->get();

        $nominal_bayar = 0;
        if($query !== null) {
            $nominal_bayar = $query->row()->nominal_bayar;
        }

        return $nominal_bayar;
    }

    public function getSumReturSupplierByBulan($bulan)
    {
        $query = $this->db->select_sum('potongan_retur')
            ->from($this->table)
            ->where("MONTH(tanggal)", $bulan)->get();
        $potongan_retur = 0;
        if($query !== null) {
            $potongan_retur = $query->row()->potongan_retur;
        }

        return $potongan_retur;
    }

    public function getSumPotongReturByNoRetur($no_retur)
    {
        $query = $this->db->select_sum('potongan_retur')
            ->from($this->table)
            ->where("no_retur", $no_retur)->get();
        $potongan_retur = 0;
        if($query !== null) {
            $potongan_retur = $query->row()->potongan_retur;
        }

        return $potongan_retur;
    }

    public function getNominalBayarAddToPotongReturByNoNota($no_nota)
    {
        $query = $this->db->select_sum('potongan_retur')
            ->from($this->table)
            ->where("no_retur", $no_retur)->get();
    }

}

/* End of file Detail_pembayaran_hutang_model.php */
