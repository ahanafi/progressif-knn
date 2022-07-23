<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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

        $data = [
            'title' => 'Laporan Data Wajib Pajak',
            'kendaraan' => $this->Kendaraan->all()
        ];

        $this->main_lib->getTemplate("laporan/index", $data);
    }

}

/* End of file WajibPajak.php */
