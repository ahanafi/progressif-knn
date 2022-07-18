<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Biaya extends CI_Controller
{

    private $uploadConfig = [];

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2|3|5");

        $this->uploadConfig = [
            'upload_path' => './uploads/bukti/',
            'allowed_types' => 'gif|jpg|png',
            'file_name' => date("y m d h-i-sa"),
            'overwrite' => true,
            'max_size' => 1024, // 1MB
        ];
    }

    public function index()
    {
        provideAccessTo("1|2|3|5");
        $biaya = $this->Biaya->all();
        $bulan = getMonth();

        if (isset($_GET['bulan']) && $_GET['bulan'] !== '') {
            $index_bulan = $this->input->get('bulan', true);
            $index_bulan += 1;
            $biaya = $this->Biaya->getByBulan($index_bulan);
        }

        $data = [
            'title' => 'Data Biaya',
            'biayas' => $biaya,
            'bulan' => $bulan,
            'no' => 1
        ];
        $this->main_lib->getTemplate('biaya/index', $data);
    }

    public function daftar()
    {
        provideAccessTo("1|2|3|5");
        $biaya = $this->Biaya->all();
        $bulan = getMonth();

        if (isset($_GET['bulan']) && $_GET['bulan'] !== '') {
            $index_bulan = $this->input->get('bulan', true);
            $biaya = $this->Biaya->getByBulan($index_bulan);
        }

        $data = [
            'title' => 'Data Biaya',
            'biayas' => $biaya,
            'bulan' => $bulan,
            'no' => 1
        ];
        $this->main_lib->getTemplate('biaya/daftar', $data);
    }

    public function status()
    {
        provideAccessTo("1|3");
        $data = [
            'title' => 'Data Status Biaya',
            'biayas' => $this->Biaya->all(),
            'no' => 1
        ];

        $this->main_lib->getTemplate('biaya/form-status', $data);
    }

    public function ubah_status($id_biaya)
    {
        provideAccessTo("1|3");
        if (empty(trim($id_biaya))) {
            redirect(base_url('biaya'));
        } else {
            $update = $this->Biaya->update(['status' => 1], ['id_biaya' => $id_biaya]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Status data biaya berhasil diperbarui!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal memperbarui status data biaya!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('biaya/status'), 'refresh');
        }
    }

    public function create()
    {
        provideAccessTo("1|2");
        $data = [
            'title' => 'Tambah Biaya',
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('biaya/form-create', $data);
            } else {
                $foto = $this->_doUpload('foto');
                if (is_array($foto)) {
                    $data['err_upload'] = $foto;
                    $this->main_lib->getTemplate('biaya/form-create', $data);
                } else {
                    $jenis_biaya = $this->main_lib->getPost('jenis_biaya');
                    $nominal = removeDots($this->main_lib->getPost('nominal'));
                    $saldo = 0;

                    //BIAYA MASUK
                    if ($jenis_biaya == "MASUK") {
                        //Cek data
                        $last_biaya = $this->Biaya->getLastRow();

                        if ($last_biaya) {
                            $saldoSekarang = $last_biaya->saldo;
                            $saldo = $saldoSekarang + $nominal;
                        } else {
                            $saldo = $nominal;
                        }
                    }

                    //BIAYA KELUAR
                    if ($jenis_biaya == "KELUAR") {
                        //Cek data
                        $last_biaya = $this->Biaya->getLastRow();

                        if ($last_biaya) {
                            $saldoSekarang = $last_biaya->saldo;
                            $saldo = $saldoSekarang - $nominal;
                        }
                    }

                    $biaya_data = [
                        'tanggal' => $this->main_lib->getPost('tanggal'),
                        'keterangan' => $this->main_lib->getPost('keterangan'),
                        'kode_transaksi' => strtoupper($this->main_lib->getPost('kode_transaksi')),
                        'oleh' => strtoupper($this->main_lib->getPost('oleh')),
                        'jenis_biaya' => $jenis_biaya,
                        'nominal' => $nominal,
                        'saldo' => $saldo,
                        'foto' => $foto
                    ];

                    $insert = $this->Biaya->insert($biaya_data);
                    if ($insert) {
                        $messages = [
                            'type' => 'success',
                            'text' => 'Data Biaya berhasil ditambahkan!',
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal menambahkan data Biaya baru!'
                        ];
                    }

                    $this->session->set_flashdata('message', $messages);
                    redirect(base_url('biaya'), 'refresh');
                }
            }
        } else {
            $this->main_lib->getTemplate('biaya/form-create', $data);
        }
    }

    public function edit($id_biaya)
    {
        provideAccessTo("1|2");
        if (empty(trim($id_biaya))) {
            redirect(base_url('biaya'));
        }

        $biaya = $this->Biaya->findById(['id_biaya' => $id_biaya]);
        $data = [
            'title' => 'Edit Biaya',
            'biaya' => $biaya,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('biaya/form-update', $data);
            } else {
                $jenis_biaya = $this->main_lib->getPost('jenis_biaya');
                $nominal = removeDots($this->main_lib->getPost('nominal'));
                $saldo = 0;

                //BIAYA MASUK
                if ($jenis_biaya == "MASUK") {
                    //Cek data
                    $last_biaya = $this->Biaya->getLastRow();

                    if ($last_biaya) {
                        $saldoSekarang = $last_biaya->saldo;
                        $saldo = $saldoSekarang + $nominal;
                    } else {
                        $saldo = $nominal;
                    }
                }

                //BIAYA KELUAR
                if ($jenis_biaya == "KELUAR") {
                    //Cek data
                    $last_biaya = $this->Biaya->getLastRow();

                    if ($last_biaya) {
                        $saldoSekarang = $last_biaya->saldo;
                        $saldo = $saldoSekarang - $nominal;
                    }
                }

                $biaya_data = [
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'keterangan' => $this->main_lib->getPost('keterangan'),
                    'kode_transaksi' => strtoupper($this->main_lib->getPost('kode_transaksi')),
                    'oleh' => strtoupper($this->main_lib->getPost('oleh')),
                    'jenis_biaya' => $jenis_biaya,
                    'nominal' => $nominal,
                    'saldo' => $saldo
                ];

                if (isset($_FILES['foto']) && $_FILES['foto']['name'] !== '') {
                    $foto = $this->_doUpload('foto');

                    if (is_array($foto)) {
                        $data['err_upload'] = $foto;
                        $this->main_lib->getTemplate('biaya/form-update', $data);
                        return false;
                    } else {
                        $biaya_data['foto'] = $foto;

                        //if exist foto
                        if ($biaya->foto !== '') {
                            //delete the old foto
                            unlink(FCPATH . 'uploads/bukti/' . $biaya->foto);
                        }
                    }
                }

                $update = $this->Biaya->update($biaya_data, ['id_biaya' => $id_biaya]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Biaya berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Biaya!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('biaya'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('biaya/form-update', $data);
        }
    }

    public function delete($id_biaya)
    {
        provideAccessTo("1|2");
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_biaya && $data_type === 'biaya') {
                $cek = $this->Biaya->findById(['id_biaya' => $id_biaya]);

                if ($cek->foto !== '') {
                    unlink(FCPATH . 'uploads/bukti/' . $cek->foto);
                }

                $delete = $this->Biaya->delete(['id_biaya' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Biaya berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Biaya!'
                    ];
                }
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('biaya'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('biaya'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'tanggal',
                'label' => 'Tanggal',
                'rules' => 'required'
            ],
            [
                'field' => 'kode_transaksi',
                'label' => 'Kode transaksi',
                'rules' => 'required'
            ],
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
            [
                'field' => 'jenis_biaya',
                'label' => 'Jenis biaya',
                'rules' => 'required'
            ],
            [
                'field' => 'nominal',
                'label' => 'Nominal',
                'rules' => 'required'
            ],
            [
                'field' => 'oleh',
                'label' => 'Oleh',
                'rules' => 'required'
            ],
        ];
    }

    /*
     *  If return is as array value, it means there are error while upload the image
     *  But, if return is string value, it means successfully upload image
     * */
    private function _doUpload($inputName)
    {
        $fileName = "";
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['name'] !== '') {
            $config = $this->uploadConfig;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload($inputName)) {
                $fileName = $this->upload->data("file_name");
            } else {
                $error = $this->upload->display_errors();
                return [
                    'error' => $error
                ];
            }
        } else {
            $fileName = "noimage.png";
        }

        return $fileName;
    }
}

/* End of file Biaya.php */
