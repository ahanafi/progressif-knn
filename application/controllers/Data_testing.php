<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_testing extends CI_Controller
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
            'title' => 'Data testing',
            'data_testing' => $this->Data_testing->all(),
            'kendaraan' => $this->Data_testing->getDataTesting(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('knn/data-testing', $data);
    }

    public function update()
    {
        if (isset($_POST['update'])) {
            $this->form_validation->set_rules('kendaraan[]', 'Kendaraan', 'required');
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->index();
            } else {
                $arrIdKendaraan = $this->_getPostData();
                $this->Data_testing->resetData();

                $arrDataTesting = [];
                foreach ($arrIdKendaraan['kendaraan'] as $idKendaraan) {
                    $kd = $this->Kendaraan->findById(['id_kendaraan' => $idKendaraan]);

                    $arrDataTesting[] = [
                        'id_kendaraan' => $idKendaraan,
                        'nik' => getNik($kd->nik_pemilik),
                        'nopol' => getNopol($kd->nomor_polisi),
                        'status_progresif' => $kd->status == 1 ? 1 : 0
                    ];
                }

                $update = $this->Data_testing->insert($arrDataTesting, true);

                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data testing berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Data testing!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-testing'), 'refresh');
            }
        } else {
            $this->index();
        }
    }

    private function _getPostData(): array
    {
        return [
            'kendaraan' => $this->main_lib->getPost('kendaraan[]'),
        ];
    }

    public function delete($idData_testing)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $idData_testing && $data_type === 'data_testing') {
                $delete = $this->Data_testing->delete(['id_data_testing' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data testing berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Data testing!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-testing'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-testing'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function data_baru()
    {
        $data = [
            'title' => 'Data baru',
            'data_baru' => $this->Data_baru->all(),
            'kendaraan' => $this->Kendaraan->getDataBaru(),
            'no' => 1
        ];

        if (isset($_POST['submit'])) {
            $idKendaraan = $this->main_lib->getPost('id_kendaraan');
            $kd = $this->Kendaraan->findById(['id_kendaraan' => $idKendaraan]);

            $arrDataBaru = [
                'id_kendaraan' => $idKendaraan,
                'nik' => getNik($kd->nik_pemilik),
                'nopol' => getNopol($kd->nomor_polisi)
            ];

            $insert = $this->Data_baru->insert($arrDataBaru);

            if ($insert) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Data baru berhasil disimpan!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menyimpan data Data baru!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('data-testing/data-baru'), 'refresh');
        }

        $this->main_lib->getTemplate('knn/data-baru', $data);
    }

    public function delete_data_baru($idDataBaru)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $idDataBaru && $data_type === 'data_baru') {
                $delete = $this->Data_testing->delete(['id_data_baru' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data baru berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Data baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-baru'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-baru'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }
}

/* End of file Data testing.php */
