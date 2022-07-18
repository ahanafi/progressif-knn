<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JenisBayar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2");
    }

    public function index()
    {
        $data = [
            'title' => 'Data Jenis Bayar',
            'jenis_bayars' => $this->Jenisbayar->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('jenis-bayar/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jenis Bayar',
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('jenis-bayar/form-create', $data);
            } else {
                $jenis_bayar_data = [
                    'nama_jenis_bayar' => $this->main_lib->getPost('nama_jenis_bayar'),
                    'keterangan' => $this->main_lib->getPost('keterangan'),
                ];

                $insert = $this->Jenisbayar->insert($jenis_bayar_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Jenis Bayar berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Jenis Bayar baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('jenis-bayar'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('jenis-bayar/form-create', $data);
        }
    }

    public function edit($id_jenis_bayar)
    {
        if (empty(trim($id_jenis_bayar))) {
            redirect(base_url('jenis-bayar'));
        }

        $jenis_bayar = $this->Jenisbayar->findById(['id_jenis_bayar' => $id_jenis_bayar]);
        $data = [
            'title' => 'Edit Jenis Bayar',
            'jenis_bayar' => $jenis_bayar,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('jenis-bayar/form-update', $data);
            } else {
                $jenis_bayar_data = [
                    'nama_jenis_bayar' => $this->main_lib->getPost('nama_jenis_bayar'),
                    'keterangan' => $this->main_lib->getPost('keterangan')
                ];

                $update = $this->Jenisbayar->update($jenis_bayar_data, ['id_jenis_bayar' => $id_jenis_bayar]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Jenis Bayar berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Jenis Bayar!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('jenis-bayar'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('jenis-bayar/form-update', $data);
        }
    }

    public function delete($id_jenis_bayar)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_jenis_bayar && $data_type === 'jenis-bayar') {
                $delete = $this->Jenisbayar->delete(['id_jenis_bayar' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Jenis Bayar berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Jenis Bayar!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('jenis-bayar'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('jenis-bayar'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'nama_jenis_bayar',
                'name' => 'nama_jenis_bayar',
                'rules' => 'required'
            ],
            [
                'field' => 'keterangan',
                'name' => 'Keterangan',
                'rules' => 'required'
            ]
        ];
    }
}

/* End of file Jenis Bayar.php */
