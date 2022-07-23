<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progressif extends CI_Controller
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
            'title' => 'Data Progressif',
            'no' => 1
        ];
        $this->main_lib->getTemplate('progressif/form-pencarian', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pelanggan',
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('progressif/form-create', $data);
            } else {
                $pelanggan_data = $this->getPostData();

                $insert = $this->Pelanggan->insert($pelanggan_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pelanggan berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Pelanggan baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('progressif/form-create', $data);
        }
    }

    public function edit($id_pelanggan)
    {
        if (empty(trim($id_pelanggan))) {
            redirect(base_url('pelanggan'));
        }

        $pelanggan = $this->Pelanggan->findById(['id_pelanggan' => $id_pelanggan]);
        $data = [
            'title' => 'Edit Pelanggan',
            'pelanggan' => $pelanggan,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('progressif/form-update', $data);
            } else {
                $pelanggan_data = $this->getPostData();

                $update = $this->Pelanggan->update($pelanggan_data, ['id_pelanggan' => $id_pelanggan]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pelanggan berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Pelanggan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('progressif/form-update', $data);
        }
    }

    private function getPostData()
    {
        return [
            'nama_pelanggan' => strtoupper($this->main_lib->getPost('nama_pelanggan')),
            'kota' => strtoupper($this->main_lib->getPost('kota')),
            'alamat' => strtoupper($this->main_lib->getPost('alamat')),
            'kontak' => $this->main_lib->getPost('kontak'),
        ];
    }

    public function delete($id_pelanggan)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_pelanggan && $data_type === 'pelanggan') {
                $delete = $this->Pelanggan->delete(['id_pelanggan' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pelanggan berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Pelanggan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pelanggan'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'nama_pelanggan',
                'name' => 'nama_pelanggan',
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
}

/* End of file Pelanggan.php */
