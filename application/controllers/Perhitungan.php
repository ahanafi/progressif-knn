<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perhitungan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
    }

    public function index($type = 'komisi')
    {
        $allPembayaran = $this->Pembayaranpiutang->getKomisiOrCashback();

        //Filter
        $firstDate = $this->main_lib->getParam('from');
        $lastDate = $this->main_lib->getParam('to');
        $getParameter = "";

        if (!empty(trim($firstDate)) && !empty(trim($lastDate))) {
            $allPembayaran = $this->Pembayaranpiutang->getKomisiOrCashback([
                'first_date' => $firstDate,
                'last_date' => $lastDate
            ]);
            $getParameter = "?from=$firstDate&to=$lastDate";
        }

        $data = [
            'title' => 'Data Komisi',
            'pembayaran' => $allPembayaran,
            'first_date' => $firstDate,
            'last_date' => $lastDate,
            'get_parameter' => $getParameter,
            'no' => 1
        ];

        $this->main_lib->getTemplate("perhitungan/$type", $data);
    }
}

/* End of file Perhitungan.php */