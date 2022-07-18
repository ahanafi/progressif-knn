<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotaPembelian extends CI_Controller {

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
            'title' => 'Nota Pembelian',
            'notapembelian' => $this->Notapembelian->getAll(),
            'no' => 1
        ];

        $this->main_lib->getTemplate("nota_pembelian/index", $data);
	}
  public function daftar()
  {
      $data = [
        'title' => 'Daftar Nota Pembelian',
        'notapembelian' => $this->Notapembelian->getAll(),
        'no' => 1
      ];
      $this->main_lib->getTemplate("nota_pembelian/daftar", $data);
  }

}

/* End of file NotaPembelian.php */
