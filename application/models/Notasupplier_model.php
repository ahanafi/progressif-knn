<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notasupplier_model extends Main_model
{
    protected $table = 'nota_pembelian';
    public function getAll(){
      $this->db->select('*');
      $this->db->from($this->table);
      $this->db->join('pelanggan','pelanggan.id_pelanggan = '.$this->table.'.id_pelanggan');
      $this->db->join('supplier','supplier.id_supplier = '.$this->table.'.id_supplier');
      return $this->db->get()->result();
    }

    public function all()
    {
        $query = "SELECT * FROM $this->table JOIN pelanggan USING (id_pelanggan) JOIN supplier USING (id_supplier)";
        $query .= " ORDER BY no_nota ASC";
        return $this->db->query($query)->result();
    }

    public function getByIdSupplier($id_supplier){
      return parent::getBy('id_supplier', $id_supplier, true);
    }
    public function getTotalByNumber($no_nota)
    {
        return $this->db->select("total, tanggal")->from($this->table)
            ->where('no_nota', $no_nota)->get()->row();
    }
    public function getWhere($field1, $field2){
      $this->db->select('*');
      $this->db->from($this->table);
      $this->db->join('pelanggan','pelanggan.id_pelanggan = '.$this->table.'.id_pelanggan');
      $this->db->join('supplier','supplier.id_supplier = '.$this->table.'.id_supplier');
      $this->db->where('nota_pembelian.id_pelanggan', $field1);
      $this->db->where('nota_pembelian.id_supplier', $field2);
      return $this->db->get()->result();
    }
    public function updateToYes($id){
      $this->db->where($id);
      return $this->db->update($this->table,['status'=>1]);
    }

    public function getSumTotalNota($where = [])
    {
        return $this->getSumOfColumn('total', $where);
    }

    public function getSumTotalNotaLama($field1, $field2)
    {
      $this->db->select_sum('total');
      $this->db->where($field1);
      $this->db->where($field2);
      $query = $this->db->get($this->table);
      return $query->row();
    }

    public function filterBy($where = [])
    {
        return $this->db->select("*")
            ->from($this->table)
            ->join('pelanggan', "pelanggan.id_pelanggan =  $this->table.id_pelanggan")
            ->join('supplier', "supplier.id_supplier =  $this->table.id_supplier")
            ->where($where)
            ->get()
            ->result();
    }
    public function getSumTotalHppByBulan($bulan, $id_supplier = '')
    {
        $currentYear = date('Y');
        $where = [
            "MONTH(tanggal)" => $bulan,
            "YEAR(tanggal)" => $currentYear
        ];

        if(!empty(trim($id_supplier))) {
            $where['id_supplier'] = $id_supplier;
        }

        return $this->getSumOfColumn('total_hpp', $where);
    }

    public function getSumTotalHppLama($id_supplier = NULL)
    {
        $currentYear = date('Y');
        $where = [
            "YEAR(tanggal) <" => $currentYear
        ];

        if($id_supplier != NULL) {
            $where['id_supplier'] = $id_supplier;
        }
        return $this->getSumOfColumn('total_hpp', $where);
    }
}

/* End of file Notasupplier_model.php */
