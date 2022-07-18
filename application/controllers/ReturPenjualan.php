<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturPenjualan extends CI_Controller
{
    private $uploadConfig = [];

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }

        $this->uploadConfig = [
            'upload_path' => './uploads/retur-penjualan/',
            'allowed_types' => 'pdf',
            'file_name' => date("Ymd-His"),
            'overwrite' => true,
            'encrypt_name' => true,
            'max_size' => 1024,
        ];
    }

    public function index()
    {
        provideAccessTo("1|2|3|5");
        $all_retur_penjualan = $this->Returpenjualan->all();
        $retur_penjualan = [];
        $grandTotalRetur = 0;
        $grandTotalPotong = 0;

        for ($i = 0; $i < count($all_retur_penjualan); $i++) {
            $no_retur = $all_retur_penjualan[$i]->no_retur;
            $total = $all_retur_penjualan[$i]->total;

            $retur_penjualan[$i] = $all_retur_penjualan[$i];

            $potong = $this->Detailpembayaranpiutang->getSumPotonganReturByNoRetur($no_retur);
            $is_lunas = $potong === $total;

            $retur_penjualan[$i]->potong = $potong;
            $retur_penjualan[$i]->lunas = $is_lunas;
            $retur_penjualan[$i]->sales = $this->Detailpembayaranpiutang->getSalesByRetur($no_retur);

            $pdfLink = getPdfLink($all_retur_penjualan[$i]->file_retur, "retur-penjualan");
            $retur_penjualan[$i]->pdflink = $pdfLink;

            $grandTotalRetur += $total;
            $grandTotalPotong += $potong;
        }

        $data = [
            'title' => 'Data Retur Penjualan',
            'retur_penjualan' => $retur_penjualan,
            'pelanggan' => $this->Pelanggan->all(),
            'grand_total_retur' => $grandTotalRetur,
            'grand_total_potong' => $grandTotalPotong,
            'no' => 1
        ];

        $this->main_lib->getTemplate('retur-penjualan/index', $data);
    }

    public function daftar()
    {
        provideAccessTo("1|2|3|5");
        $bulan = getMonth();
        $all_retur_penjualan = $this->Returpenjualan->all();
        $retur_penjualan = [];
        $get_parameter = "";

        //Filtering
        if(isset($_GET['id_pelanggan']) || isset($_GET['bulan'])) {
            $id_pelanggan = $this->input->get('id_pelanggan', true);
            $index_bulan = $this->input->get('bulan', true);

            $filter = [];

            //Filter only by pelanggan
            if(!empty(trim($id_pelanggan))) {
                $filter = ['retur_penjualan.id_pelanggan' => $id_pelanggan ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan;
            }

            //Filter only by month
            if(!empty(trim($index_bulan))) {
                $filter = ['MONTH(retur_penjualan.tanggal)' => $index_bulan];
                $get_parameter = "?bulan=" . $index_bulan;
            }

            //Filter only by supplier and month
            if(!empty(trim($id_pelanggan)) && !empty(trim($index_bulan))) {
                $filter = [
                    'retur_penjualan.id_pelanggan' => $id_pelanggan,
                    'MONTH(retur_penjualan.tanggal)' => $index_bulan
                ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan . "&bulan=" . $index_bulan;
            }

            if($filter !== '') {
                $all_retur_penjualan = $this->Returpenjualan->filterBy($filter);
            }
        }

        $grandTotal = 0;
        $totalPotong = 0;
        for ($i = 0; $i < count($all_retur_penjualan); $i++) {
            $no_retur = $all_retur_penjualan[$i]->no_retur;
            $total = $all_retur_penjualan[$i]->total;

            $retur_penjualan[$i] = $all_retur_penjualan[$i];

            $potong = $this->Detailpembayaranpiutang->getSumPotonganReturByNoRetur($no_retur);
            $is_lunas = $potong === $total;

            $retur_penjualan[$i]->sales = $this->Detailpembayaranpiutang->getSalesByRetur($no_retur);

            $retur_penjualan[$i]->potong = $potong;
            $retur_penjualan[$i]->lunas = $is_lunas;

            $pdfLink = getPdfLink($all_retur_penjualan[$i]->file_retur, "retur-penjualan");
            $retur_penjualan[$i]->pdflink = $pdfLink;

            $grandTotal += $total;
            $totalPotong += $potong;
        }

        $data = [
            'title' => 'Data Retur Penjualan',
            'retur_penjualan' => $retur_penjualan,
            'get_parameter' => $get_parameter,
            'pelanggan' => $this->Pelanggan->all(),
            'bulan' => $bulan,
            'grand_total' => $grandTotal,
            'total_potong' => $totalPotong,
            'no' => 1
        ];
        $this->main_lib->getTemplate('retur-penjualan/daftar', $data);
    }

    public function status()
    {
        provideAccessTo("1|3");
        $all_retur_penjualan = $this->Returpenjualan->all();
        $retur_penjualan = [];
        $grandTotalRetur = 0;
        $grandTotalPotong = 0;

        for ($i = 0; $i < count($all_retur_penjualan); $i++) {
            $no_retur = $all_retur_penjualan[$i]->no_retur;
            $total = $all_retur_penjualan[$i]->total;

            $retur_penjualan[$i] = $all_retur_penjualan[$i];

            $potong = $this->Detailpembayaranpiutang->getSumPotonganReturByNoRetur($no_retur);
            $is_lunas = $potong === $total;

            $retur_penjualan[$i]->sales = $this->Detailpembayaranpiutang->getSalesByRetur($no_retur);

            $retur_penjualan[$i]->potong = $potong;
            $retur_penjualan[$i]->lunas = $is_lunas;

            $grandTotalRetur += $total;
            $grandTotalPotong += $potong;
        }

        $data = [
            'title' => 'Data Retur Penjualan',
            'retur_penjualan' => $retur_penjualan,
            'pelanggan' => $this->Pelanggan->all(),
            'grand_total_retur' => $grandTotalRetur,
            'grand_total_potong' => $grandTotalPotong,
            'no' => 1
        ];
        $this->main_lib->getTemplate('retur-penjualan/form-status', $data);
    }

    public function create()
    {
        provideAccessTo("1|2");
        $pelanggan = $this->Pelanggan->all();
        $supplier = $this->Supplier->all();

        $data = [
            'title' => 'Tambah Retur Penjualan',
            'pelanggan' => $pelanggan,
            'supplier' => $supplier,
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('retur-penjualan/form-create', $data);
            } else {

                $fileRetur = $this->main_lib->_doUpload('file_retur', $this->uploadConfig);
                if (is_array($fileRetur)) {
                    $data['err_upload'] = $fileRetur;
                    $this->main_lib->getTemplate('retur-penjualan/form-create', $data);
                } else {
                    $retur_penjualan_data = [
                        'no_retur' => strtoupper($this->main_lib->getPost('no_retur')),
                        'tanggal' => $this->main_lib->getPost('tanggal'),
                        'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                        'total' => removeDots($this->main_lib->getPost('total')),
                        'file_retur' => $fileRetur
                    ];

                    $insert = $this->Returpenjualan->insert($retur_penjualan_data);
                    if ($insert) {
                        $messages = [
                            'type' => 'success',
                            'text' => 'Data Retur Penjualan berhasil ditambahkan!',
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal menambahkan data Retur Penjualan baru!'
                        ];
                    }

                    $this->session->set_flashdata('message', $messages);
                    redirect(base_url('retur-penjualan'), 'refresh');
                }
            }
        } else {
            $this->main_lib->getTemplate('retur-penjualan/form-create', $data);
        }
    }

    public function edit($id_retur_penjualan)
    {
        if (empty(trim($id_retur_penjualan))) {
            redirect(base_url('retur-penjualan'));
        }

        $pelanggan = $this->Pelanggan->all();
        $supplier = $this->Supplier->all();
        $retur_penjualan = $this->Returpenjualan->findById(['id_retur_penjualan' => $id_retur_penjualan]);
        $data = [
            'title' => 'Edit Retur Penjualan',
            'pelanggan' => $pelanggan,
            'supplier' => $supplier,
            'retur' => $retur_penjualan,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('retur-penjualan/form-update', $data);
            } else {
                $retur_penjualan_data = [
                    'no_retur' => strtoupper($this->main_lib->getPost('no_retur')),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                    'total' => removeDots($this->main_lib->getPost('total')),
                ];

                if (isset($_FILES['file_retur']) && $_FILES['file_retur']['name'] !== '') {
                    $fileRetur = $this->main_lib->_doUpload('file_retur', $this->uploadConfig);

                    if (is_array($fileRetur)) {
                        $data['err_upload'] = $fileRetur;
                        $this->main_lib->getTemplate('retur-penjualan/form-update', $data);
                        return false;
                    } else {
                        $retur_penjualan_data['file_retur'] = $fileRetur;
                        $oldFileRetur = $retur_penjualan->file_retur;
                        $pathFile = FCPATH . 'uploads/retur-penjualan/' . $oldFileRetur;
                        //if exist file
                        if ($oldFileRetur != '' && file_exists($pathFile)) {
                            //delete the old file
                            unlink($pathFile);
                        }
                    }
                }

                $update = $this->Returpenjualan->update($retur_penjualan_data, ['id_retur_penjualan' => $id_retur_penjualan]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Retur Penjualan berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Retur Penjualan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('retur-penjualan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('retur-penjualan/form-update', $data);
        }
    }

    public function delete($id_retur_penjualan)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_retur_penjualan && $data_type === 'retur-penjualan') {
                $delete = $this->Returpenjualan->delete(['id_retur_penjualan' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Retur Penjualan berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Retur Penjualan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('retur-penjualan'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('retur-penjualan'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'no_retur',
                'name' => 'No. retur',
                'rules' => 'required'
            ],
            [
                'field' => 'tanggal',
                'name' => 'tanggal',
                'rules' => 'required'
            ],
            [
                'field' => 'id_pelanggan',
                'name' => 'Pelanggan',
                'rules' => 'required'
            ],
            [
                'field' => 'total',
                'name' => 'total',
                'rules' => 'required'
            ]
        ];
    }

    public function getTotal($no_nota)
    {
        $response = [];
        if ($this->input->is_ajax_request()) {
            $total_retur = $this->Returpenjualan->getTotalByNumber($no_nota);
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

    public function ubah_status($id_retur_penjualan)
    {
        if (empty(trim($id_retur_penjualan))) {
            redirect(base_url('retur-penjualan'));
        } else {
            $update = $this->Returpenjualan->update(['status' => 1], ['id_retur_penjualan' => $id_retur_penjualan]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Status Retur Penjualan berhasil diperbarui!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal memperbarui status Retur Penjualan!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('retur-penjualan/status'), 'refresh');
        }
    }
}

/* End of file Retur Penjualan.php */
