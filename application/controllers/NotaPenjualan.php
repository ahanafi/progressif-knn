<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotaPenjualan extends CI_Controller
{
    private $uploadConfig = [];

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2|3");

        $this->uploadConfig = [
            'upload_path' => './uploads/nota-penjualan/',
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
        $nota_pejualan = [];
        $all_nota_penjualan = $this->Notapenjualan->all();
        $pelanggan = $this->Pelanggan->all();
        $sales = $this->Sales->all();

        $grandTotalNota = 0;
        $grandTotalPotong = 0;



        $i = 0;
        foreach ($all_nota_penjualan as $nota) {
            //store temp variable
            $no_nota = $nota->no_nota;
            $total_nota = $nota->total;

            //Get total bayar from detail pembayaran piutang
            $nominal_bayar = $this->Detailpembayaranpiutang->getPembayaranNotaPenjualan($no_nota);

            //Assign object to array
            $nota_pejualan[$i] = $nota;
            $nota_pejualan[$i]->bayar = $nominal_bayar;
            $nota_pejualan[$i]->is_lunas = $total_nota === $nominal_bayar;

            $grandTotalNota += $total_nota;
            $grandTotalPotong += $nominal_bayar;

            $pdfLink = getPdfLink($nota->file_nota, "nota-penjualan");
            $nota_pejualan[$i]->pdflink = $pdfLink;
            $i++;
        }

        $data = [
            'title' => 'Data Nota Penjualan',
            'nota_penjualan' => $nota_pejualan,
            'pelanggan' => $pelanggan,
            'sales' => $sales,
            'grand_total_nota' => $grandTotalNota,
            'grand_total_potong' => $grandTotalPotong,
            'no' => 1
        ];
        $this->main_lib->getTemplate('nota-penjualan/index', $data);
    }

    public function daftar()
    {
        provideAccessTo("1|2|3|5");
        $nota_pejualan = [];
        $all_nota_penjualan = $this->Notapenjualan->all();
        $pelanggan = $this->Pelanggan->all();
        $sales = $this->Sales->all();
        $bulan = getMonth();
        $get_parameter = "";

        if (isset($_GET['id_pelanggan']) || isset($_GET['id_sales']) || isset($_GET['bulan'])) {
            $id_pelanggan = $this->input->get('id_pelanggan', true);
            $id_sales = $this->input->get('id_sales', true);
            $index_bulan = $this->input->get('bulan', true);

            $filter = [];

            //Filter only by pelanggan
            if (!empty(trim($id_pelanggan))) {
                $filter = ['nota_penjualan.id_pelanggan' => $id_pelanggan];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan;
            }

            //Filter only by sales
            if (!empty(trim($id_sales))) {
                $filter = ['nota_penjualan.id_sales' => $id_sales];
                $get_parameter = "?id_sales=" . $id_sales;
            }

            //Filter only by month
            if (!empty(trim($index_bulan))) {
                $filter = ['MONTH(nota_penjualan.tanggal)' => $index_bulan];
                $get_parameter = "?bulan=" . $index_bulan;
            }

            //Filter only by pelanggan and sales
            if (!empty(trim($id_pelanggan)) && !empty(trim($id_sales))) {
                $filter = [
                    'nota_penjualan.id_pelanggan' => $id_pelanggan,
                    'nota_penjualan.id_sales' => $id_sales,
                ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan . "&id_sales=" . $id_sales;
            }

            //Filter only by pelanggan and month
            if (!empty(trim($id_pelanggan)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_penjualan.id_pelanggan' => $id_pelanggan,
                    'MONTH(nota_penjualan.tanggal)' => $index_bulan
                ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan . "&bulan=" . $index_bulan;
            }

            //Filter only by sales and month
            if (!empty(trim($id_sales)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_penjualan.id_sales' => $id_sales,
                    'MONTH(nota_penjualan.tanggal)' => $index_bulan
                ];
                $get_parameter = "?id_sales=" . $id_sales . "&bulan=" . $index_bulan;
            }

            //Filter only by pelanggan and sales
            if (!empty(trim($id_pelanggan)) && !empty(trim($id_sales)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_penjualan.id_pelanggan' => $id_pelanggan,
                    'nota_penjualan.id_sales' => $id_sales,
                    'MONTH(nota_penjualan.tanggal)' => $index_bulan
                ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan . "&id_sales=" . $id_sales . "&bulan=" . $index_bulan;
            }

            if ($filter !== '') {
                $all_nota_penjualan = $this->Notapenjualan->filterBy($filter);
            }
        }

        $i = 0;
        foreach ($all_nota_penjualan as $nota) {
            //store temp variable
            $no_nota = $nota->no_nota;
            $total_nota = $nota->total;

            //Get total bayar from detail pembayaran piutang
            $nominal_bayar = $this->Detailpembayaranpiutang->getPembayaranNotaPenjualan($no_nota);

            //Assign object to array
            $nota_pejualan[$i] = $nota;
            $nota_pejualan[$i]->bayar = $nominal_bayar;
            $nota_pejualan[$i]->is_lunas = $total_nota === $nominal_bayar;

            $pdfLink = getPdfLink($nota->file_nota, "nota-penjualan");
            $nota_pejualan[$i]->pdflink = $pdfLink;

            $i++;
        }

        $data = [
            'title' => 'Data Nota Penjualan',
            'nota_penjualan' => $nota_pejualan,
            'get_parameter' => $get_parameter,
            'pelanggan' => $pelanggan,
            'sales' => $sales,
            'bulan' => $bulan,
            'no' => 1
        ];
        $this->main_lib->getTemplate('nota-penjualan/daftar', $data);
    }

    public function status()
    {
        provideAccessTo("1|3");
        $nota_penjualan = $this->Notapenjualan->all();

        $data = [
            'title' => 'Data Nota Penjualan',
            'nota_penjualan' => $nota_penjualan,
            'no' => 1
        ];
        $this->main_lib->getTemplate('nota-penjualan/form-status', $data);
    }

    public function ubah_status($id_nota_penjualan)
    {
        if (empty(trim($id_nota_penjualan))) {
            redirect(base_url('nota-penjualan'));
        } else {
            $update = $this->Notapenjualan->update(['status' => 1], ['id_nota_penjualan' => $id_nota_penjualan]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Status Nota Penjualan berhasil diperbarui!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal memperbarui status Nota Penjualan!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('nota-penjualan/status'), 'refresh');
        }
    }

    public function create()
    {
        provideAccessTo("1|2");
        $pelanggan = $this->Pelanggan->all();
        $sales = $this->Sales->all();
        $data = [
            'title' => 'Tambah Nota Penjualan',
            'pelanggan' => $pelanggan,
            'sales' => $sales
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('nota-penjualan/form-create', $data);
            } else {

                $fileNota = $this->main_lib->_doUpload('file_nota', $this->uploadConfig);
                if (is_array($fileNota)) {
                    $data['err_upload'] = $fileNota;
                    $this->main_lib->getTemplate('nota-penjualan/form-create', $data);
                } else {
                    $nota_penjualan_data = [
                        'no_nota' => $this->main_lib->getPost('no_nota'),
                        'tanggal' => $this->main_lib->getPost('tanggal'),
                        'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                        'id_sales' => $this->main_lib->getPost('id_sales'),
                        'total' => removeDots($this->main_lib->getPost('total')),
                        'file_nota' => $fileNota
                    ];

                    $insert = $this->Notapenjualan->insert($nota_penjualan_data);
                    if ($insert) {
                        $messages = [
                            'type' => 'success',
                            'text' => 'Data Nota Penjualan berhasil ditambahkan!',
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal menambahkan data Nota Penjualan baru!'
                        ];
                    }

                    $this->session->set_flashdata('message', $messages);
                    redirect(base_url('nota-penjualan'), 'refresh');

                }

            }
        } else {
            $this->main_lib->getTemplate('nota-penjualan/form-create', $data);
        }
    }

    public function edit($id_nota_penjualan)
    {
        if (empty(trim($id_nota_penjualan))) {
            redirect(base_url('nota-penjualan'));
        }

        $pelanggan = $this->Pelanggan->all();
        $sales = $this->Sales->all();
        $nota_penjualan = $this->Notapenjualan->findById(['id_nota_penjualan' => $id_nota_penjualan]);
        $data = [
            'title' => 'Edit Nota Penjualan',
            'pelanggan' => $pelanggan,
            'sales' => $sales,
            'nota' => $nota_penjualan,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('nota-penjualan/form-update', $data);
            } else {
                $nota_penjualan_data = [
                    'no_nota' => $this->main_lib->getPost('no_nota'),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                    'id_sales' => $this->main_lib->getPost('id_sales'),
                    'total' => removeDots($this->main_lib->getPost('total')),
                ];

                if (isset($_FILES['file_nota']) && $_FILES['file_nota']['name'] !== '') {
                    $fileNota = $this->main_lib->_doUpload('file_nota', $this->uploadConfig);

                    if (is_array($fileNota)) {
                        $data['err_upload'] = $fileNota;
                        $this->main_lib->getTemplate('nota-penjualan/form-update', $data);
                        return false;
                    } else {
                        $nota_penjualan_data['file_nota'] = $fileNota;
                        $oldFileNota = $nota_penjualan->file_nota;
                        $pathFile = FCPATH . 'uploads/nota-penjualan/' . $oldFileNota;
                        //if exist file
                        if ($oldFileNota != '' && file_exists($pathFile)) {
                            //delete the old file
                            unlink($pathFile);
                        }
                    }
                }

                $update = $this->Notapenjualan->update($nota_penjualan_data, ['id_nota_penjualan' => $id_nota_penjualan]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Nota Penjualan berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Nota Penjualan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('nota-penjualan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('nota-penjualan/form-update', $data);
        }
    }

    public function delete($id_nota_penjualan)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_nota_penjualan && $data_type === 'nota-penjualan') {
                $delete = $this->Notapenjualan->delete(['id_nota_penjualan' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Nota Penjualan berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Nota Penjualan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('nota-penjualan'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('nota-penjualan'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function getTotal($no_nota)
    {
        $response = [];
        if ($this->input->is_ajax_request()) {
            $total_nota = $this->Notapenjualan->getTotalByNumber($no_nota);
            if ($total_nota) {
                $response = [
                    'status' => 'success',
                    'data' => $total_nota
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

    public function _rules()
    {
        return [
            [
                'field' => 'no_nota',
                'name' => 'No. Nota',
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
                'field' => 'id_sales',
                'name' => 'Sales',
                'rules' => 'required'
            ],
            [
                'field' => 'total',
                'name' => 'total',
                'rules' => 'required'
            ]
        ];
    }

    public function getNotaPenjualanAjax()
    {
        $data = $this->Notapenjualan->getAllByDataTable();
        echo $data;
    }
}

/* End of file Nota Penjualan.php */
