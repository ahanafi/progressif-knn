<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_baru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2|3|5");
    }

    public function delete($idDataBaru)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $idDataBaru && $data_type === 'data_baru') {
                $delete = $this->Data_baru->delete(['id_data_baru' => $data_id]);
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
                redirect(base_url('data-testing/data-baru'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('data-testing/data-baru'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }
}

/* End of file Data testing.php */
