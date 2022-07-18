<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biaya_model extends Main_model
{
    protected $table = 'biaya';

    public function all()
    {
        $query = $this->db->order_by('tanggal', 'ASC')->get($this->table);
        return $query->result();
    }

    public function _uploadImage($id_biaya)
    {
        $config['upload_path']          = './uploads/bukti/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $id_biaya;
        $config['overwrite']			= true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('picture_')) {
            return $this->upload->data("file_name");
        }

        return "default.jpg";
    }

    public function getLastRow()
    {
        $query = $this->db->select('*')
        ->from($this->table)
        ->order_by('id_biaya', 'DESC')
        ->limit(1);
        return $query->get()->row();
    }

    public function getByBulan($bulan)
    {
        return parent::getBy("MONTH(tanggal)", $bulan, true);
    }
}

/* End of file Biaya_model.php */
