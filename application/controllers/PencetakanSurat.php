<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PencetakanSurat extends CI_Controller
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
            'title' => 'Pencetakan Surat',
        ];

        $this->main_lib->getTemplate("cetak-surat/form-pencarian", $data);
    }

}

/* End of file PencetakanSurat.php */
