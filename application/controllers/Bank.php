<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends CI_Controller
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
            'title' => 'Data Bank',
            'banks' => $this->Bank->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('bank/index', $data);
    }

    public function status($id_bank = null)
    {
        if (!empty(trim($id_bank)) && $id_bank !== null) {
            $bank = $this->Bank->findById(['id_bank' => $id_bank]);
            $rekening_koran = $this->Rekeningkoran->getBy('id_bank', $id_bank, true);
            $data = [
                'title' => 'Status Bank',
                'bank' => $bank,
                'rekening_koran' => $rekening_koran,
                'no' => 1
            ];

            $this->main_lib->getTemplate("bank/status-rekening-koran", $data);
        } else {
            $data = [
                'title' => 'Status Bank',
                'banks' => $this->Bank->all(),
                'no' => 1
            ];
            $this->main_lib->getTemplate('bank/status', $data);
        }

    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Bank',
        ];

        if (isset($_GET['bank']) && $_GET['bank'] !== '') {
            set_value('id_bank', $_GET['id_bank']);
        }

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('bank/form-create', $data);
            } else {
                $bank_data = [
                    'nama_bank' => $this->main_lib->getPost('nama_bank'),
                    'no_rekening' => $this->main_lib->getPost('no_rekening'),
                    'nama_rekening' => $this->main_lib->getPost('nama_rekening'),
                    'alamat' => $this->main_lib->getPost('alamat'),
                    'kontak' => $this->main_lib->getPost('kontak'),
                ];

                $insert = $this->Bank->insert($bank_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data bank berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data bank baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('bank'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('bank/form-create', $data);
        }
    }

    public function edit($id_bank)
    {
        if (empty(trim($id_bank))) {
            redirect(base_url('bank'));
        }

        $bank = $this->Bank->findById(['id_bank' => $id_bank]);
        $data = [
            'title' => 'Edit Bank',
            'bank' => $bank,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('bank/form-update', $data);
            } else {
                $bank_data = [
                    'nama_bank' => $this->main_lib->getPost('nama_bank'),
                    'no_rekening' => $this->main_lib->getPost('no_rekening'),
                    'nama_rekening' => $this->main_lib->getPost('nama_rekening'),
                    'alamat' => $this->main_lib->getPost('alamat'),
                    'kontak' => $this->main_lib->getPost('kontak'),
                ];

                $update = $this->Bank->update($bank_data, ['id_bank' => $id_bank]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Bank berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data Bank!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('bank'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('bank/form-update', $data);
        }
    }

    public function delete($id_bank)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_bank && $data_type === 'bank') {
                $delete = $this->Bank->delete(['id_bank' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Bank berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Bank!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('bank'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('bank'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'nama_bank',
                'name' => 'nama_bank',
                'rules' => 'required'
            ],
            [
                'field' => 'no_rekening',
                'name' => 'no_rekening',
                'rules' => 'required'
            ],
            [
                'field' => 'nama_rekening',
                'name' => 'nama_rekening',
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

    public function rekening_koran($id_bank)
    {
        $bank = $this->Bank->findById(['id_bank' => $id_bank]);
        $rekening_koran = [];
        $rekeningByBank = $this->Rekeningkoran->getBy('id_bank', $id_bank, true);
        $totalUangMasuk = 0;
        $totalUangKeluar = 0;


        $getParameter = '';

        if (isset($_GET['first_date']) || isset($_GET['last_date'])) {
            $firstDate = $this->main_lib->getParam('first_date');
            $lastDate = $this->main_lib->getParam('last_date');

            $where = ['id_bank' => $id_bank];
            if (!empty(trim($firstDate)) && $lastDate == '') {
                $where['tanggal'] = $firstDate;
                $getParameter = "?first_date=" . $firstDate;
            }

            if (!empty(trim($lastDate)) && $firstDate == '') {
                $where['tanggal'] = $lastDate;
                $getParameter = "?last_date=" . $firstDate;
            }

            $rekeningByBank = $this->Rekeningkoran->filterByDate($where);

            if (!empty(trim($firstDate)) && !empty(trim($lastDate))) {
                $where = [
                    'id_bank' => $id_bank,
                    'first_date' => $firstDate,
                    'last_date' => $lastDate
                ];
                $getParameter = "?first_date=$firstDate&last_date=" . $lastDate;

                $rekeningByBank = $this->Rekeningkoran->filterByDate($where, true);
            }
        }

        $saldo = 0;

        for ($i = 0; $i < count($rekeningByBank); $i++) {
            $rekening_koran[$i] = $rekeningByBank[$i];
            $rekening = $rekeningByBank[$i];

            $jenis = $rekening->jenis_biaya;
            if ($jenis === 'MASUK' || $jenis === 'SALDO') {
                $saldo += $rekening->nominal;
                $totalUangMasuk += $rekening->nominal;
            } else {
                $saldo -= $rekening->nominal;
                $totalUangKeluar += $rekening->nominal;
            }

            $kode_pembayaran = $rekening->kode_pembayaran;
            $linkPembayaran = $kode_pembayaran;
            $id_pembayaran = 0;

            if (!empty(trim($kode_pembayaran))) {
                $kode_tipe = explode("-", $kode_pembayaran);
                if ($kode_tipe[0] === "TF") {
                    $tipe = "hutang";
                    $id_pembayaran = $this->Pembayaranhutang->selectOnly('id_pembayaran_hutang', [
                        'kode_pembayaran' => $kode_pembayaran
                    ], false)->id_pembayaran_hutang;
                } else {
                    $tipe = "piutang";
                    $id_pembayaran = $this->Pembayaranpiutang->selectOnly('id_pembayaran_piutang', [
                        'kode_pembayaran' => $kode_pembayaran
                    ], false)->id_pembayaran_piutang;
                }

                $url = base_url("pembayaran-$tipe/detail/" . $id_pembayaran);
                $linkPembayaran = anchor($url, $kode_pembayaran, [
                    'title' => 'Detail',
                    'target' => '_blank'
                ]);
            }

            $rekening_koran[$i]->saldo = $saldo;
            $rekening_koran[$i]->link_pembayaran = $linkPembayaran;
        }

        $data = [
            'title' => 'Detail Bank',
            'bank' => $bank,
            'rekening_koran' => $rekening_koran,
            'get_parameter' => $getParameter,
            'total_uang_masuk' => $totalUangMasuk,
            'total_uang_keluar' => $totalUangKeluar,
            'no' => 1
        ];

        $this->main_lib->getTemplate("bank/rekening-koran", $data);
    }
}

/* End of file bank.php */
