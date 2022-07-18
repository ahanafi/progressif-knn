<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2|3|5");
    }

    public function index()
    {
        provideAccessTo("1|2");
        $data = [
            'title' => 'Data Sales',
            'sales' => $this->Sales->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('sales/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Sales',
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('sales/form-create', $data);
            } else {
                $sales_data = $this->getPostData();

                $insert = $this->Sales->insert($sales_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Sales berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Sales baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('sales'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('sales/form-create', $data);
        }
    }

    public function edit($id_sales)
    {
        if (empty(trim($id_sales))) {
            redirect(base_url('sales'));
        }

        $sales = $this->Sales->findById(['id_sales' => $id_sales]);
        $data = [
            'title' => 'Edit Sales',
            'sales' => $sales,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('sales/form-update', $data);
            } else {
                $sales_data = $this->getPostData();

                $update = $this->Sales->update($sales_data, ['id_sales' => $id_sales]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Sales berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Sales!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('sales'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('sales/form-update', $data);
        }
    }

    public function delete($id_sales)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_sales && $data_type === 'sales') {
                $delete = $this->Sales->delete(['id_sales' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Sales berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Sales!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('sales'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('sales'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'nama_sales',
                'name' => 'nama_sales',
                'rules' => 'required'
            ],
            [
                'field' => 'kota',
                'name' => 'kota',
                'rules' => 'required'
            ],
            [
                'field' => 'alamat',
                'name' => 'alamat',
                'rules' => 'required'
            ],
            [
                'field' => 'kontak',
                'name' => 'kontak',
                'rules' => 'required'
            ]
        ];
    }

    public function get_sales()
    {
        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            $jsonResult = $this->Sales->getJsonResult();
            echo $jsonResult;
        } else {
            redirect(base_url('error'));
        }
    }

    private function getPostData()
    {
        return [
                    'nama_sales' => strtoupper($this->main_lib->getPost('nama_sales')),
                    'kota' => strtoupper($this->main_lib->getPost('kota')),
                    'alamat' => strtoupper($this->main_lib->getPost('alamat')),
                    'kontak' => $this->main_lib->getPost('kontak'),
                ];
    }
}

/* End of file Sales.php */
