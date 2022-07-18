<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retursupplier_model extends Main_model
{
    protected $table = 'retur_supplier';

    public function getAll($table, $where)
    {
      $this->db->select('*');
      $this->db->from($this->table);
      $this->db->join($table, $where);
      return $this->db->get()->result();
    }

    public function getByIdSupplier($id_supplier){
      return parent::getBy('id_supplier', $id_supplier, true);
    }

    public function getWhere($table, $where, $where1)
    {
      $this->db->select('*');
      $this->db->from($this->table);
      $this->db->join($table, $where);
      $this->db->where($where1);
      return $this->db->get()->result();
    }
    public function getSumTotalRetur($where = [])
    {
        return parent::getSumOfColumn('total', $where);
    }
    private function getQueries($where = [])
    {
        $query = "SELECT * FROM $this->table JOIN supplier USING (id_supplier)";

        if (!empty($where)) {
            $column = array_keys($where)[0];
            $value = array_values($where)[0];

            $query .= " WHERE $column = '$value' ";
        }

        return $query;
    }
    public function findById($where = [], $all = false)
    {
        $query = $this->getQueries($where);
        $queryResult = $this->db->query($query);
        if ($all === true) {
            return $queryResult->result();
        } else {
            return $queryResult->row();
        }
    }
    public function getTotalByNumber($no_retur)
    {
        return $this->db->select("total")->from($this->table)
            ->where('no_retur', $no_retur)->get()->row();
    }
    public function filterBy($where = [])
    {
        return $this->db->select("*")
            ->from($this->table)
            ->join('supplier', "supplier.id_supplier =  $this->table.id_supplier")
            ->where($where)
            ->get()
            ->result();
    }
}

/* End of file .php */
