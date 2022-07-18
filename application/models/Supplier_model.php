<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends Main_model
{
    protected $table = 'supplier';

    public function getJsonResult()
    {
        $actionEdit = anchor(base_url('supplier/edit/$1'), '<i class="fa fa-edit"></i>', array('class' => 'btn btn-light'));
        $actionDelete = "<a href='#' class='btn btn-light' onclick='showConfirmDelete(`supplier`, $1)'>";
        $actionDelete .= "<i class='fa fa-trash-alt'></i></a>";

        $action = $actionEdit . " ". $actionDelete;
        $this->datatables->select('id_supplier, nama_supplier, alamat, kontak, kota')
            ->from($this->table)
            ->add_column('action', $action, 'id_supplier');
        return $this->datatables->generate();
    }
}

/* End of file Supplier_model.php */
