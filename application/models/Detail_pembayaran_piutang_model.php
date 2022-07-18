<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_pembayaran_piutang_model extends Main_model
{
	protected $table = 'detail_pembayaran_piutang';

	public function getPembayaranNotaPenjualan($no_nota)
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
        $sql = $this->db->select_sum('nominal_bayar')
            ->where($where)->get($this->table);
        $result = 0;
        if($sql->num_rows() > 0) {
            $result = $sql->row()->nominal_bayar;
        }
        return $result;
    }

    public function getSumPembayaranByBulan($where)
    {
        $query = $this->db->select_sum('nominal_bayar')
            ->from($this->table)
            ->join('pembayaran_piutang', 'id_pembayaran_piutang')
            ->join('nota_penjualan', 'id_pelanggan')
            ->where($where)->get();
        $nominal_bayar = 0;
        if($query !== null) {
            $nominal_bayar = $query->row()->nominal_bayar;
        }

        return $nominal_bayar;
    }

    public function getSumReturPenjualanByBulan($bulan)
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

    public function getSumPotonganReturByNoRetur($no_retur)
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

    public function getSalesByRetur($noRetur)
    {
        $detail = $this->db->where('no_retur', $noRetur)->get($this->table)->row();
        $namaSales = "-";
        if($detail) {
            $noNota = $detail->no_nota;
            $getSalesQuery = $this->db->select('nama_sales')
                ->from('nota_penjualan')
                ->join('sales', 'id_sales')
                ->where('no_nota', $noNota)
                ->get()
                ->row();
            $namaSales = $getSalesQuery->nama_sales;
        }
        return $namaSales;
    }
}

/* End of file Detail_pembayaran_piutang_model.php */
