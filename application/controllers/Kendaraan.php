<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kendaraan extends CI_Controller
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
            'title' => 'Data Kendaraan',
            'kendaraan' => $this->Kendaraan->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('kendaraan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kendaraan',
            'url' => base_url('data-kendaraan/create'),
            'action' => 'insert',

            // Data kendaraan
            'nomor_polisi' => set_value('nomor_polisi'),
            'nik_pemilik' => set_value('nik_pemilik'),
            'nama_pemilik' => set_value('nama_pemilik'),
            'alamat_pemilik' => set_value('alamat_pemilik'),
            'merk' => set_value('merk'),
            'tipe' => set_value('tipe'),
            'tahun' => set_value('tahun'),
            'warna' => set_value('warna'),
            'nomor_rangka' => set_value('nomor_rangka'),
            'nomor_mesin' => set_value('nomor_mesin'),
            'jenis' => set_value('jenis'),
            'tanggal_daftar' => set_value('tanggal_daftar'),
            'tanggal_bayar' => set_value('tanggal_bayar'),
            'status' => set_value('status'),
        ];

        if (isset($_POST['insert'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('kendaraan/form-kendaraan', $data);
            } else {
                $pelanggan_data = $this->_getPostData();

                $insert = $this->Kendaraan->insert($pelanggan_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Kendaraan berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Kendaraan baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-kendaraan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('kendaraan/form-kendaraan', $data);
        }
    }

    public function edit($idKendaraan)
    {
        if (empty(trim($idKendaraan))) {
            redirect(base_url('data-kendaraan'));
        }

        $kendaraan = $this->Kendaraan->findById(['id_kendaraan' => $idKendaraan]);
        $data = [
            'title' => 'Edit Kendaraan',
            'url' => base_url('data-kendaraan/edit/' . $idKendaraan),
            'action' => 'update',

            'nomor_polisi' => $kendaraan->nomor_polisi,
            'nik_pemilik' => $kendaraan->nik_pemilik,
            'nama_pemilik' => $kendaraan->nama_pemilik,
            'alamat_pemilik' => $kendaraan->alamat_pemilik,
            'merk' => $kendaraan->merk,
            'tipe' => $kendaraan->tipe,
            'tahun' => $kendaraan->tahun,
            'warna' => $kendaraan->warna,
            'nomor_rangka' => $kendaraan->nomor_rangka,
            'nomor_mesin' => $kendaraan->nomor_mesin,
            'jenis' => $kendaraan->jenis,
            'tanggal_daftar' => $kendaraan->tanggal_daftar,
            'tanggal_bayar' => $kendaraan->tanggal_bayar,
            'status' => $kendaraan->status,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('kendaraan/form-kendaraan', $data);
            } else {
                $pelanggan_data = $this->_getPostData();

                $update = $this->Kendaraan->update($pelanggan_data, ['id_kendaraan' => $idKendaraan]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Kendaraan berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Kendaraan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-kendaraan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('kendaraan/form-kendaraan', $data);
        }
    }

    private function _getPostData(): array
    {
        return [
            'nomor_polisi' => strtoupper($this->main_lib->getPost('nomor_polisi')),
            'nik_pemilik' => strtoupper($this->main_lib->getPost('nik_pemilik')),
            'nama_pemilik' => strtoupper($this->main_lib->getPost('nama_pemilik')),
            'alamat_pemilik' => strtoupper($this->main_lib->getPost('alamat_pemilik')),
            'merk' => strtoupper($this->main_lib->getPost('merk')),
            'tipe' => strtoupper($this->main_lib->getPost('tipe')),
            'tahun' => $this->main_lib->getPost('tahun'),
            'warna' => $this->main_lib->getPost('warna'),
            'nomor_rangka' => $this->main_lib->getPost('nomor_rangka'),
            'nomor_mesin' => $this->main_lib->getPost('nomor_mesin'),
            'jenis' => $this->main_lib->getPost('jenis'),
            'tanggal_daftar' => $this->main_lib->getPost('tanggal_daftar'),
            'tanggal_bayar' => $this->main_lib->getPost('tanggal_bayar'),
            'status' => $this->main_lib->getPost('status'),
        ];
    }

    public function delete($idKendaraan)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $idKendaraan && $data_type === 'kendaraan') {
                $delete = $this->Kendaraan->delete(['id_kendaraan' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Kendaraan berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Kendaraan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-kendaraan'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-kendaraan'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    private function _rules() : array
    {
        return [
            [
                'field' => 'nomor_polisi',
                'label' => 'Nomor Polisi',
                'rules' => 'required'
            ],
            [
                'field' => 'nik_pemilik',
                'label' => 'NIK pemilik',
                'rules' => 'required'
            ],
            [
                'field' => 'nama_pemilik',
                'label' => 'Nama pemilik',
                'rules' => 'required'
            ],
            [
                'field' => 'alamat_pemilik',
                'label' => 'Alamat Pemilik',
                'rules' => 'required'
            ],
            [
                'field' => 'merk',
                'label' => 'Merk',
                'rules' => 'required'
            ],
            [
                'field' => 'tipe',
                'label' => 'Tipe',
                'rules' => 'required'
            ],
            [
                'field' => 'tahun',
                'label' => 'Tahun',
                'rules' => 'required'
            ],
            [
                'field' => 'warna',
                'label' => 'Warna',
                'rules' => 'required'
            ],
            [
                'field' => 'nomor_rangka',
                'label' => 'No. Rangka',
                'rules' => 'required'
            ],
            [
                'field' => 'nomor_mesin',
                'label' => 'No. Mesin',
                'rules' => 'required'
            ],
            [
                'field' => 'jenis',
                'label' => 'Jenis',
                'rules' => 'required'
            ],
            [
                'field' => 'tanggal_daftar',
                'label' => 'Tanggal Daftar',
                'rules' => 'required'
            ],
            [
                'field' => 'tanggal_bayar',
                'label' => 'Tanggal Bayar',
                'rules' => 'required'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ],
        ];
    }
}

/* End of file Kendaraan.php */
