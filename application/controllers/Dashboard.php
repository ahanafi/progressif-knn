<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
    }

    public function index()
    {
        provideAccessTo("all");
        error_reporting(0);
        $total_pelanggan = $this->Pelanggan->count();
        $total_supplier = $this->Supplier->count();
        $total_nota_penjualan = $this->Notapenjualan->count();
        $total_nota_supplier = $this->Notasupplier->count();
        $total_retur_penjualan = $this->Returpenjualan->count();
        $total_retur_supplier = $this->Retursupplier->count();

        $list_bulan = getMonth(null, 'long');
        $penjualan = [];
        $nota_supplier = [];

        //GET Parameter
        $getSupplierParams = "";
        $getSalesParams = "";

        $id_supplier = $this->input->get('id_supplier', true);
        $id_sales = $this->input->get('id_sales', true);

        if(!empty(trim($id_supplier)) && $id_supplier !== 'ALL' && $id_supplier !== '-') {
            $getSupplierParams = $id_supplier;
        }

        if(!empty(trim($id_sales)) && $id_sales !== 'ALL' && $id_sales !== '-') {
            $getSalesParams = $id_sales;
        }

        //Loop data table
        $i = 0;
        foreach ($list_bulan as $bulan) {
            $bln = $i + 1;

            /*
             * TABEL PENJUALAN
             * */
            $penjualan[$i]->bulan = $bulan;

            //Total penjualan
            $totalPenjualan = 0;
            $getPenjualan = $this->Notapenjualan->getSumTotalNotaByBulan($bln, $id_sales)->total;
            if ($getPenjualan) {
                $totalPenjualan = $getPenjualan;
            }
            $penjualan[$i]->total_penjualan = $totalPenjualan;

            $where = ['MONTH(tanggal)' => $bln];
            if(!empty(trim($id_sales))) {
                $where['id_sales'] = $id_sales;
            }

            //Total Retur Penjualan
            $totalRetur = 0;
            $getTotalRetur = $this->Returpenjualan->getSumTotalRetur($where);
            if ($getTotalRetur) {
                $totalRetur = $getTotalRetur->total;
            }
            $penjualan[$i]->total_retur = $totalRetur;

            unset($where['MONTH(tanggal)']);

            //Total Pembayaran Piutang (Penjualan)
            $where['MONTH(pembayaran_piutang.tanggal)'] = $bln;
            $pembayaran = 0;
            $getPembayaran = $this->Pembayaranpiutang->getSumPembayaranByBulan($where);
            if ($getPembayaran) {
                $pembayaran = $getPembayaran->jumlah;
            }
            $penjualan[$i]->total_pembayaran = $pembayaran;

            /*
             * END NOTA PENJUALAN
             * */

            /* ===================================================================== */

            /*
             * TABEL NOTA SUPPLIER
             * */
            $nota_supplier[$i]->bulan = $bulan;

            //Total Hpp
            $totalHpp = 0;
            $getTotalHpp = $this->Notasupplier->getSumTotalHppByBulan($bln, $id_supplier)->total_hpp;
            if ($getTotalHpp) {
                $totalHpp = $getTotalHpp;
            }
            $nota_supplier[$i]->total_hpp = $totalHpp;

            //Total Retur Supplier
            $where = ['MONTH(tanggal)' => $bln];
            if(!empty(trim($id_supplier))) {
                $where['id_supplier'] = $id_supplier;
            }

            $totalReturSupplier = 0;
            $getTotalReturSupplier = $this->Retursupplier->getSumTotalRetur($where);
            if ($getTotalReturSupplier) {
                $totalReturSupplier = $getTotalReturSupplier->total;
            }
            $nota_supplier[$i]->total_retur = $totalReturSupplier;

            //Total Pembayaran Hutang (Supplier)
            $totalPembayaran = 0;
            $where = ['MONTH(pembayaran_hutang.tanggal)' => $bln];
            if(!empty(trim($id_supplier))) {
                $where['id_supplier'] = $id_supplier;
            }
            $getTotalPembayaran = $this->Pembayaranhutang->getTotalPembayaranByBulan($where);
            if ($getTotalPembayaran) {
                $totalPembayaran = $getTotalPembayaran->jumlah;
            }
            $nota_supplier[$i]->total_pembayaran = $totalPembayaran;

            /*
             * END NOTA SUPPLIER
             * */

            $i++;
        }

        //Hutang - Piutang lama
        $hutang_lama = $this->Notasupplier->getSumTotalHppLama($id_supplier)->total_hpp;
        $piutang_lama = $this->Notapenjualan->getSumTotalPiutangLama($id_sales)->total;

        //Sales dan Supplier
        $sales = $this->Sales->all();
        $supplier = $this->Supplier->all();

        $data = [
            'title' => 'Dashboard',
            'total_pelanggan' => $total_pelanggan,
            'total_supplier' => $total_supplier,
            'total_nota_penjualan' => $total_nota_penjualan,
            'total_nota_supplier' => $total_nota_supplier,
            'total_retur_penjualan' => $total_retur_penjualan,
            'total_retur_supplier' => $total_retur_supplier,

            //TABLE
            'penjualan' => $penjualan,
            'nota_supplier' => $nota_supplier,

            //Hutang & Piutang Lama
            'hutang_lama' => $hutang_lama,
            'piutang_lama' => $piutang_lama,

            //Sales & Supplier
            'sales' => $sales,
            'supplier' => $supplier,

            'supplier_params' => $getSupplierParams,
            'sales_params' => $getSalesParams
        ];

        $this->main_lib->getTemplate("dashboard/index", $data);
    }

}

/* End of file Dashboard.php */
