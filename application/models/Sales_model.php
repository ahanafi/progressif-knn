<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends Main_model
{
    protected $table = 'sales';

    public function getJsonResult()
    {
        $actionEdit = anchor(base_url('sales/edit/$1'), '<i class="fa fa-edit"></i>', array('class' => 'btn btn-light'));
        $actionDelete = "<a href='#' class='btn btn-light' onclick='showConfirmDelete(`sales`, $1)'>";
        $actionDelete .= "<i class='fa fa-trash-alt'></i></a>";
        
        $action = $actionEdit . " ". $actionDelete;
        $this->datatables->select('id_sales, nama_sales, alamat, kontak, kota')
            ->from($this->table)
            ->add_column('action', $action, 'id_sales');
        return $this->datatables->generate();
    }
}

/* End of file Sales_model.php */