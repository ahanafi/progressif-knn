<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DaftarBayar extends CI_Controller {

    public function __construct()
    {
    	parent::__construct();

    	if(!isAuthenticated()) {
    	    redirect(base_url('auth'));
        }
    }

    public function index()
	{
	    $data = [
            'title' => 'Dashboard',
            'daftar_bayars' => $this->Daftarbayar->getAll('daftar_bayar','pelanggan','bank','jenis_bayar','daftar_bayar.id_pelanggan=pelanggan.id_pelanggan','daftar_bayar.id_bank=bank.id_bank','daftar_bayar.id_jenisbayar = jenis_bayar.id_jenis_bayar'),
          ];

        $this->main_lib->getTemplate("daftar-bayar/index", $data);
	}

}

/* End of file Dashboard.php */
