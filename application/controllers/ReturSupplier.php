<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReturSupplier extends CI_Controller
{
    private $uploadConfig = [];

    public function __construct()
    {
        parent::__construct();

        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }

        $this->uploadConfig = [
            'upload_path' => './uploads/retur-supplier/',
            'allowed_types' => 'pdf',
            'file_name' => date("Ymd-His"),
            'overwrite' => true,
            'encrypt_name' => true,
            'max_size' => 1024,
        ];
    }

    public function index()
    {
        $allReturSupplier = $this->Retursupplier->getAll('supplier', 'supplier.id_supplier = retur_supplier.id_supplier');
        $returSupplier = [];

        $grandTotalRetur = 0;
        $grandTotalPotong = 0;
        $i = 0;

        foreach ($allReturSupplier as $retur) {
            $no_retur = $retur->no_retur;
            $total = $retur->total;

            $potong = $this->Detailpembayaranhutang->getSumPotongReturByNoRetur($no_retur);
            $is_lunas = $potong === $total;

            $returSupplier[$i] = $retur;
            $returSupplier[$i]->potong = $potong;
            $returSupplier[$i]->lunas = $is_lunas;

            $pdfLink = getPdfLink($retur->file_retur, "retur-supplier");
            $returSupplier[$i]->pdflink = $pdfLink;

            $grandTotalRetur += $total;
            $grandTotalPotong += $potong;
            $i++;
        }

        $data = [
            'title' => 'Retur Supplier',
            'retursupplier' => $returSupplier,
            'grand_total_retur' => $grandTotalRetur,
            'grand_total_potong' => $grandTotalPotong,
            'no' => 1
        ];

        $this->main_lib->getTemplate("retur-supplier/index", $data);
    }

    public function daftar()
    {
        $bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        $index = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $retur = $this->Retursupplier->getAll('supplier', 'supplier.id_supplier = retur_supplier.id_supplier');
        $id_supplier = $this->input->get('supplier');
        $index_bulan = $this->input->get('bulan');
        $get_parameter = "";

        //Filtering
        if (isset($_GET['supplier']) || isset($_GET['bulan'])) {
            $id_supplier = $this->input->get('supplier', true);
            $index_bulan = $this->input->get('bulan', true);

            if (!empty(trim($id_supplier))) {
                $retur = $this->Retursupplier->filterBy([
                    'retur_supplier.id_supplier' => $id_supplier,
                ]);
                $get_parameter = "?supplier=" . $id_supplier;
            }
            if (!empty(trim($index_bulan))) {
                $retur = $this->Retursupplier->filterBy([
                    'MONTH(retur_supplier.tanggal)' => $index_bulan,
                ]);
                $get_parameter = "?bulan=" . $index_bulan;
            }
            if (!empty(trim($id_supplier)) && !empty(trim($index_bulan))) {
                $retur = $this->Retursupplier->filterBy([
                    'retur_supplier.id_supplier' => $id_supplier,
                    'MONTH(retur_supplier.tanggal)' => $index_bulan,
                ]);
                $get_parameter = "?supplier=" . $id_supplier . "&bulan=" . $index_bulan;
            }

        }

        $retursuplier = [];
        $i = 0;
        $grandTotal = 0;
        $totalPotong = 0;
        foreach ($retur as $retur) {
            $no_retur = $retur->no_retur;
            $total = $retur->total;

            $potong = $this->Detailpembayaranhutang->getSumPotongReturByNoRetur($no_retur);
            $is_lunas = $potong === $total;

            $retursuplier[$i] = $retur;
            $retursuplier[$i]->potong = $potong;
            $retursuplier[$i]->lunas = $is_lunas;

            $pdfLink = getPdfLink($retur->file_retur, "retur-supplier");
            $retursuplier[$i]->pdflink = $pdfLink;

            $grandTotal += $total;
            $totalPotong += $potong;
            $i++;
        }

        $data = [
            'title' => 'Daftar Retur Supplier',
            'suppliers' => $this->Supplier->all(),
            'get_parameter' => $get_parameter,
            'id_supplier' => $id_supplier,
            'retursupplier' => $retursuplier,
            'bulan' => $bulan,
            'index' => $index,
            'grand_total' => $grandTotal,
            'total_potong' => $totalPotong,
            'no' => 1
        ];
        $this->main_lib->getTemplate("retur-supplier/daftar", $data);
    }

    public function create($err_upload = '')
    {
        provideAccessTo("1|4");
        $data = [
            'title' => 'Tambah Retur Supplier',
            'action' => site_url('ReturSupplier/create_action'),
            'button' => 'Tambah Data',
            'id_retur_supplier' => set_value('id_retur_supplier'),
            'no_retur' => set_value('no_retur'),
            'tanggal' => set_value('tanggal'),
            'id_supplier' => set_value('id_supplier'),
            'supplier' => $this->Supplier->all(),
            'total' => (set_value('total') !== '' ? set_value('total') : 0),
            'status' => 0,
            'err_upload' => $err_upload
        ];
        $this->main_lib->getTemplate("retur-supplier/create_form", $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $fileRetur = $this->main_lib->_doUpload('file_retur', $this->uploadConfig);
            if (is_array($fileRetur)) {
                $this->create($fileRetur);
            } else {
                $retur_supplier_data = [
                    'no_retur' => strtoupper($this->main_lib->getPost('no_retur')),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_supplier' => $this->main_lib->getPost('id_supplier'),
                    'total' => removeDots($this->main_lib->getPost('total')),
                    'status' => 0,
                    'file_retur' => $fileRetur
                ];

                $insert = $this->Retursupplier->insert($retur_supplier_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Retur Supplier berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Supplier baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('retur-supplier'), 'refresh');
            }
        }
    }

    public function update($id_retur_supplier = null)
    {
        if (empty(trim($id_retur_supplier)) || $this->uri->segment('2') == 'update' && $this->uri->segment('3') == '') {
            redirect('retur-supplier');
        }
        $retur_supplier = $this->Retursupplier->findById(['id_retur_supplier' => $id_retur_supplier]);
        $data = [
            'title' => 'Edit Retur Supplier',
            'action' => site_url('ReturSupplier/update_action'),
            'button' => 'Update Data',
            'id_retur_supplier' => $retur_supplier->id_retur_supplier,
            'no_retur' => $retur_supplier->no_retur,
            'tanggal' => $retur_supplier->tanggal,
            'id_supplier' => $retur_supplier->id_supplier,
            'supplier' => $this->Supplier->all(),
            'total' => $retur_supplier->total,
            'status' => $retur_supplier->status,
            'file_retur' => set_value('file_retur', $retur_supplier->file_retur),
        ];
        $this->main_lib->getTemplate('retur-supplier/create_form', $data);
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->update($this->main_lib->getPost('id_retur_supplier'));
        } else {
            $id_retur_supplier = $this->main_lib->getPost('id_retur_supplier');

            $retur_supplier_data = [
                'no_retur' => strtoupper($this->main_lib->getPost('no_retur')),
                'tanggal' => $this->main_lib->getPost('tanggal'),
                'id_supplier' => $this->main_lib->getPost('id_supplier'),
                'total' => removeDots($this->main_lib->getPost('total'))
            ];

            $retur_supplier = $this->Retursupplier->findById([
                'id_retur_supplier' => $id_retur_supplier
            ]);
            if (isset($_FILES['file_retur']) && $_FILES['file_retur']['name'] !== '') {
                $fileRetur = $this->main_lib->_doUpload('file_retur', $this->uploadConfig);

                if (is_array($fileRetur)) {
                    $this->create($fileRetur);
                } else {

                    $retur_supplier_data['file_retur'] = $fileRetur;
                    $oldFileRetur = $retur_supplier->file_retur;
                    $pathFile = FCPATH . 'uploads/retur-supplier/' . $oldFileRetur;

                    //if exist file
                    if ($oldFileRetur != '' && file_exists($pathFile)) {
                        //delete the old file
                        unlink($pathFile);
                    }
                }
            }

            $insert = $this->Retursupplier->update($retur_supplier_data, ['id_retur_supplier' => $id_retur_supplier]);
            if ($insert) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Data Retur Supplier berhasil diupdate!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menambahkan data Retur Supplier baru!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('retur-supplier'), 'refresh');
        }
    }

    public function delete($id_retur_supplier)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_retur_supplier && $data_type === 'retur-supplier') {
                $delete = $this->Retursupplier->delete(['id_retur_supplier' => $data_id]);
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
                redirect(base_url('retur-supplier'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('retur-supplier'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        // $this->form_validation->set_rules('id_retur_supplier', 'id_retur_supplier', 'required');
        $this->form_validation->set_rules('no_retur', 'no_retur', 'required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        $this->form_validation->set_rules('id_supplier', 'id_supplier', 'required');
        $this->form_validation->set_rules('total', 'total', 'required');
        $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");
    }

    public function status()
    {
        provideAccessTo("1|2");
        $allReturSupplier = $this->Retursupplier->getAll('supplier', 'supplier.id_supplier = retur_supplier.id_supplier');
        $returSupplier = [];

        $grandTotalRetur = 0;
        $grandTotalPotong = 0;
        $i = 0;

        foreach ($allReturSupplier as $retur) {
            $no_retur = $retur->no_retur;
            $total = $retur->total;

            $potong = $this->Detailpembayaranhutang->getSumPotongReturByNoRetur($no_retur);
            $is_lunas = $potong === $total;

            $returSupplier[$i] = $retur;
            $returSupplier[$i]->potong = $potong;
            $returSupplier[$i]->lunas = $is_lunas;

            $grandTotalRetur += $total;
            $grandTotalPotong += $potong;
            $i++;
        }

        $data = [
            'title' => 'Status Retur Supplier',
            'retur_supplier' => $returSupplier,
            'grand_total_retur' => $grandTotalRetur,
            'grand_total_potong' => $grandTotalPotong,
            'no' => 1
        ];
        $this->main_lib->getTemplate('retur-supplier/status', $data);
    }

    public function getTotal($no_nota)
    {
        $response = [];
        if ($this->input->is_ajax_request()) {
            $total_retur = $this->Retursupplier->getTotalByNumber($no_nota);
            if ($total_retur) {
                $response = [
                    'status' => 'success',
                    'data' => $total_retur
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Unable to process the request.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Unable to process the request.'
            ];
        }

        echo json_encode($response);
    }

    public function ubah_status($id_retur_supplier)
    {
        if (empty(trim($id_retur_supplier))) {
            redirect(base_url('retur-supplier'));
        } else {
            $update = $this->Retursupplier->update(['status' => 1], ['id_retur_supplier' => $id_retur_supplier]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Status Retur Supplier berhasil diperbarui!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal memperbarui status Retur Supplier!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('retur-supplier/status'), 'refresh');
        }
    }
}

/* End of file Dashboard.php */
