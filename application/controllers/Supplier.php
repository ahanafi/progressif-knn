<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2|3|5");
    }

    public function index()
    {
        provideAccessTo("1|2");
        $data = [
            'title' => 'Data Supplier',
            'suppliers' => $this->Supplier->all(),
            'no' => 1
        ];

        $this->main_lib->getTemplate('supplier/index', $data);
    }

    public function hutang()
    {

        $all_supplier = $this->Supplier->all();
        $supplier = [];

        $totalHutangLama = 0;
        $totalHutang = 0;
        $totalRetur = 0;
        $totalBayar = 0;
        $totalLainLain = 0;
        $totalSisa = 0;

        $i = 0;
        foreach ($all_supplier as $spl) {
            $id_supplier = $spl->id_supplier;
            $supplier[$i] = $spl;
            //total hutang dari nota pembelian/nota supplier
            $hutang = $this->Notasupplier->getSumTotalNota(['id_supplier' => $id_supplier])->total;

            //total retur dari retur supplier
            $retur = $this->Retursupplier->getSumTotalRetur(['id_supplier' => $id_supplier])->total;

            //total bayar dari detail pembayaran hutang
            $bayar = 0;

            $index = 0;
            //Get all pembayaran hutang supplier
            $pembayaran_supplier = $this->Pembayaranhutang->getPembayaranSupplier($id_supplier);
            foreach ($pembayaran_supplier as $ps) {
                //$bayar += $this->Detailpembayaranhutang->getNominalBayarBy(['id_pembayaran_hutang' => $ps->id_pembayaran_hutang])->nominal_bayar;
                $bayar += $pembayaran_supplier[$index]->jumlah;
                $index++;
            }
            //
            $lain_lain = $this->Pembayaranhutang->getTotalLainLain(['id_supplier' => $id_supplier])->potongan_lain_lain;
            //
            $hutang_lama = $this->Notasupplier->getSumTotalNotaLama(['id_supplier' => $id_supplier], ['YEAR(tanggal)' => date('Y') - 1])->total;

            $sisa = $hutang_lama + $hutang - $retur - $bayar - $lain_lain;

            $supplier[$i]->hutang_lama = $hutang_lama;
            $supplier[$i]->hutang = $hutang;
            $supplier[$i]->retur = $retur;
            $supplier[$i]->bayar = $bayar;
            $supplier[$i]->lain_lain = $lain_lain;
            $supplier[$i]->sisa = $sisa;

            //Add total
            $totalHutangLama += $hutang_lama;
            $totalHutang += $hutang;
            $totalRetur += $retur;
            $totalBayar += $bayar;
            $totalLainLain += $lain_lain;
            $totalSisa += $sisa;

            $i++;
        }

        $data = [
            'title' => 'Data Hutang Supplier',
            'suppliers' => $supplier,
            'total_hutang_lama' => $totalHutangLama,
            'total_hutang' => $totalHutang,
            'total_retur' => $totalRetur,
            'total_bayar' => $totalBayar,
            'total_lain_lain' => $totalLainLain,
            'total_sisa' => $totalSisa,
            'no' => 1
        ];

        $this->main_lib->getTemplate('supplier/hutang_supplier', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Supplier',
            'action' => site_url('supplier/create_action'),
            'button' => 'Simpan Data',
            'id_supplier' => set_value('id_supplier'),
            'nama_supplier' => set_value('nama_supplier'),
            'kota' => set_value('kota'),
            'alamat' => set_value('alamat'),
            'kontak' => set_value('kontak')
        ];
        $this->main_lib->getTemplate('supplier/form_createupdate', $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $supplier_data = $this->getPostData();

            $insert = $this->Supplier->insert($supplier_data);
            if ($insert) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Data Supplier berhasil ditambahkan!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menambahkan data Supplier baru!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('supplier'), 'refresh');
        }
    }

    public function edit($id_supplier = null)
    {
        if (empty(trim($id_supplier)) || $this->uri->segment('2') == 'edit' && $this->uri->segment('3') == '') {
            redirect('supplier');
        }

        $supplier = $this->Supplier->findById(['id_supplier' => $id_supplier]);
        $data = [
            'title' => 'Edit Supplier',
            'action' => site_url('supplier/update_action'),
            'button' => 'Update Data',
            'id_supplier' => set_value('id_supplier', $supplier->id_supplier),
            'nama_supplier' => set_value('nama_supplier', $supplier->nama_supplier),
            'kota' => set_value('kota', $supplier->kota),
            'alamat' => set_value('alamat', $supplier->alamat),
            'kontak' => set_value('kontak', $supplier->kontak)
        ];
        $this->main_lib->getTemplate('supplier/form_createupdate', $data);
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->edit($this->main_lib->getPost('id_supplier'));
        } else {
            $supplier_data = $this->getPostData();
            $update = $this->Supplier->update($supplier_data, ['id_supplier' => $this->main_lib->getPost('id_supplier')]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Data Supplier berhasil disimpan!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menyimpan data Supplier!'
                ];
            }
            $this->session->set_flashdata('message', $messages);
            redirect(base_url('supplier'), 'refresh');
        }
    }

    public function delete($id_supplier)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_supplier && $data_type === 'supplier') {
                $delete = $this->Supplier->delete(['id_supplier' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Supplier berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Supplier!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('supplier'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('supplier'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {

        $this->form_validation->set_rules('nama_supplier', 'nama_supplier', 'required');
        $this->form_validation->set_rules('kota', 'kota', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');
        $this->form_validation->set_rules('kontak', 'kontak', 'required');
        $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");
    }


    public function get_nota_supplier($idSupplier)
    {
        if (!empty(trim($idSupplier))) {
            if ($this->input->is_ajax_request()) {
                $allNotaSupplier = $this->Notasupplier->getByIdSupplier($idSupplier);
                $notaSupplier = [];

                $i = 0;

                foreach ($allNotaSupplier as $nota) {
                    //store temp variable
                    $noNota = $nota->no_nota;
                    $totalNota = $nota->total;

                    //Get total bayar from detail pembayaran piutang
                    $nominalBayar = $this->Detailpembayaranhutang->getPembayaranNotaSupplier($noNota);
                    if ($totalNota !== $nominalBayar) {
                        $notaSupplier[$i] = $nota;
                        $i++;
                    }
                }
                echo json_encode($notaSupplier);
            }
        }
    }

    public function get_retur_supplier($idSupplier)
    {
        if (!empty(trim($idSupplier))) {
            if ($this->input->is_ajax_request()) {
                $returSupplier = [];
                $allReturSupplier = $this->Retursupplier->getByIdSupplier($idSupplier);
                $i = 0;

                foreach ($allReturSupplier as $retur) {
                    $noRetur = $retur->no_retur;
                    $totalRetur = $retur->total;

                    $potongRetur = $this->Detailpembayaranhutang->getSumPotongReturByNoRetur($noRetur);
                    if($totalRetur !== $potongRetur) {
                        $returSupplier[$i] = $retur;
                        $i++;
                    }
                }

                echo json_encode($returSupplier);
            }
        }
    }

    public function get_detail($jenis_data, $id_supplier)
    {
        $arr_jenis_data = ['hutang-lama', 'hutang', 'retur', 'transfer', 'lain-lain'];
        if (in_array($jenis_data, $arr_jenis_data) && $id_supplier !== '') {
            $response = [];
            if ($this->input->is_ajax_request()) {
                if ($jenis_data === 'hutang' || $jenis_data == "hutang-lama") {
                    $nota_supplier = [];
                    $all_nota_supplier = $this->Notasupplier->getByIdSupplier($id_supplier);
                    $nama_supplier = $this->Supplier->findById(['id_supplier' => $id_supplier])->nama_supplier;
                    $i = 0;

                    $currentYear = (int)date('Y');
                    if ($jenis_data === 'hutang-lama') {
                        $currentYear = $currentYear - 1;
                    }

                    foreach ($all_nota_supplier as $nota) {
                        //store temp variable
                        $no_nota = $nota->no_nota;
                        $total_nota = $nota->total;

                        //Get total bayar from detail pembayaran piutang
                        $nominal_bayar = $this->Detailpembayaranhutang->getPembayaranNotaSupplier($no_nota);

                        $tanggalNota = $nota->tanggal;
                        $tahunNota = getYearFromDate($tanggalNota);

                        if ($currentYear === $tahunNota) {
                            //Assign object to array
                            $nota_supplier[$i] = $nota;
                            $nota_supplier[$i]->nama_supplier = $nama_supplier;
                            $nota_supplier[$i]->bayar = $nominal_bayar;
                            $nota_supplier[$i]->is_lunas = getStatus($total_nota === $nominal_bayar, "pelunasan");
                            $i++;
                        }
                    }

                    $response = [
                        'status' => 'success',
                        'data' => $nota_supplier
                    ];
                } elseif ($jenis_data === 'transfer' || $jenis_data === 'lain-lain') {
                    $pembayaran = $this->Pembayaranhutang->getPembayaranSupplier($id_supplier);
                    $response = [
                        'status' => 'success',
                        'data' => $pembayaran
                    ];
                } elseif ($jenis_data === 'retur') {
                    $allReturPenjualan = $this->Retursupplier->findById(['id_supplier' => $id_supplier], true);
                    $retur = [];

                    $index = 0;
                    foreach ($allReturPenjualan as $returItem) {
                        $retur[$index] = $returItem;

                        $potong = $this->Detailpembayaranhutang->getSumPotongReturByNoRetur($returItem->no_retur);
                        $retur[$index]->total_potong = $potong;

                        $isLunas = ($potong === $returItem->total);
                        $retur[$index]->is_lunas = getStatus($isLunas, 'pelunasan');
                        $index++;
                    }
                    $response = [
                        'status' => 'success',
                        'data' => $retur
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Unable to proccess the request.'
                ];
            }

            echo json_encode($response);
        }
    }

    public function get_supplier()
    {
        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo $this->Supplier->getJsonResult();
        } else {
            redirect(base_url('error'));
        }
    }

    private function getPostData()
    {
        return [
            'nama_supplier' => strtoupper($this->main_lib->getPost('nama_supplier')),
            'kota' => strtoupper($this->main_lib->getPost('kota')),
            'alamat' => strtoupper($this->main_lib->getPost('alamat')),
            'kontak' => $this->main_lib->getPost('kontak'),
        ];
    }
}

/* End of file Supplier.php */
