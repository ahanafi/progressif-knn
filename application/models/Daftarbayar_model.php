<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftarbayar_model extends Main_model
{
    protected $table = 'daftar_bayar';
    public function getAll($table1, $table2, $table3, $table4, $where1, $where2, $where3){
      $this->db->select('*');
      $this->db->from($table1);
      $this->db->join($table2,$where1);
      $this->db->join($table3,$where2);
      $this->db->join($table4,$where3);
      return $this->db->get()->result();
    }
}

/* End of file .php */
