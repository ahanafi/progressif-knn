<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RekeningKoran extends CI_Controller
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
        provideAccessTo("1|2|3|5");
        $rekening = $this->Rekeningkoran->all();
        $bank = $this->Bank->all();
        $totalUangMasuk = 0;
        $totalUangKeluar = 0;

        if (isset($_GET['bank']) && $_GET['bank'] !== '') {
            $bankId = $this->input->get('bank', true);
            $rekening = $this->Rekeningkoran->getBy('id_bank', $bankId, true);
        }

        $rekening_koran = [];
        $saldo = 0;
        for ($i = 0; $i < count($rekening); $i++) {
            $rekening_koran[$i] = $rekening[$i];

            $jenis = $rekening[$i]->jenis_biaya;
            if ($jenis === 'MASUK') {
                $saldo += $rekening[$i]->nominal;
                $totalUangMasuk += $rekening[$i]->nominal;
            } elseif($jenis === "KELUAR") {
                $saldo -= $rekening[$i]->nominal;
                $totalUangKeluar += $rekening[$i]->nominal;
            } elseif($jenis === 'SALDO') {
                $saldo = $rekening[$i]->saldo;
            }

            $kode_pembayaran = $rekening[$i]->kode_pembayaran;
            $linkPembayaran = $kode_pembayaran;
            $idPembayaran = 0;

            if (!empty(trim($kode_pembayaran))) {
                $kode_tipe = explode("-", $kode_pembayaran);
                if ($kode_tipe[0] === "TF") {
                    $tipe = "hutang";
                    $idPembayaran = $this->Pembayaranhutang->selectOnly('id_pembayaran_hutang', [
                        'kode_pembayaran' => $kode_pembayaran
                    ], false)->id_pembayaran_hutang;
                } else {
                    $tipe = "piutang";
                    $idPembayaran = $this->Pembayaranpiutang->selectOnly('id_pembayaran_piutang', [
                        'kode_pembayaran' => $kode_pembayaran
                    ], false)->id_pembayaran_piutang;
                }

                $url = base_url("pembayaran-$tipe/detail/" . $idPembayaran);
                $linkPembayaran = anchor($url, $kode_pembayaran, [
                    'title' => 'Detail',
                    'target' => '_blank'
                ]);
            }

            $rekening_koran[$i]->saldo = $saldo;
            $rekening_koran[$i]->link_pembayaran = $linkPembayaran;
        }

        $data = [
            'title' => 'Data Rekening Koran',
            'rekening_koran' => $rekening_koran,
            'bank' => $bank,
            'total_uang_masuk' => $totalUangMasuk,
            'total_uang_keluar' => $totalUangKeluar,
            'no' => 1
        ];
        $this->main_lib->getTemplate('rekening-koran/index', $data);
    }

    public function daftar()
    {
        provideAccessTo("1|2|3|5");
        $rekening_koran = $this->Rekeningkoran->all();
        $bulan = getMonth();

        if (isset($_GET['bulan']) && $_GET['bulan'] !== '') {
            $index_bulan = $this->input->get('bulan', true);
            $rekening_koran = $this->Rekeningkoran->getByBulan($index_bulan);
        }

        $data = [
            'title' => 'Data Rekening Koran',
            'rekening_koran' => $rekening_koran,
            'bulan' => $bulan,
            'no' => 1
        ];
        $this->main_lib->getTemplate('rekening-koran/daftar', $data);
    }

    public function status()
    {
        provideAccessTo("1|3");
        $data = [
            'title' => 'Data Status Rekening Koran',
            'rekening_koran' => $this->Rekeningkoran->all(),
            'no' => 1
        ];

        $this->main_lib->getTemplate('rekening-koran/form-status', $data);
    }

    public function ubah_status($id_rekening_koran)
    {
        provideAccessTo("1|3");
        if (empty(trim($id_rekening_koran))) {
            redirect(base_url('rekening-koran'));
        } else {
            $update = $this->Rekeningkoran->update(['status' => 1], ['id_rekening_koran' => $id_rekening_koran]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Status data rekening koran berhasil diperbarui!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal memperbarui status data rekening koran!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('bank/status'), 'refresh');
        }
    }

    public function create()
    {
        provideAccessTo("1|2");
        $bankId = $this->main_lib->getParam('bank');
        if (empty(trim($bankId))) {
            $messages = [
                'type' => 'warning',
                'text' => 'Silahkan pilih bank terlebih dahulu!'
            ];

            $this->session->set_flashdata('message', $messages);
            redirectBack();
        }

        $data = [
            'title' => 'Tambah Rekening Koran',
            'bank' => $this->Bank->all(),
            'id_bank' => $bankId
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('rekening-koran/form-create', $data);
            } else {

                $jenis_biaya = $this->main_lib->getPost('jenis_biaya');
                $nominal = removeDots($this->main_lib->getPost('nominal'));
                $kode_pembayaran = strtoupper($this->main_lib->getPost('kode_pembayaran'));

                $rekening_koran_data = [
                    'id_bank' => $this->main_lib->getPost('id_bank'),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'keterangan' => strtoupper($this->main_lib->getPost('keterangan')),
                    'no_bukti' => strtoupper($this->main_lib->getPost('no_bukti')),
                    'oleh' => strtoupper($this->main_lib->getPost('oleh')),
                    'kode_pembayaran' => $kode_pembayaran,
                    'jenis_biaya' => $jenis_biaya,
                    'nominal' => $nominal,
                    'saldo' => $nominal
                ];

                $insert = $this->Rekeningkoran->insert($rekening_koran_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Rekening Koran berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Rekening Koran baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('rekening-koran'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('rekening-koran/form-create', $data);
        }
    }

    public function edit($id_rekening_koran)
    {
        provideAccessTo("1|2");
        if (empty(trim($id_rekening_koran))) {
            redirect(base_url('rekening-koran'));
        }

        $rekening_koran = $this->Rekeningkoran->findById(['id_rekening_koran' => $id_rekening_koran]);
        $data = [
            'title' => 'Edit Rekening Koran',
            'rekening' => $rekening_koran,
            'bank' => $this->Bank->all()
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('rekening-koran/form-update', $data);
            } else {
                $jenis_biaya = $this->main_lib->getPost('jenis_biaya');
                $nominal = removeDots($this->main_lib->getPost('nominal'));

                $rekening_koran_data = [
                    'id_bank' => $this->main_lib->getPost('id_bank'),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'keterangan' => strtoupper($this->main_lib->getPost('keterangan')),
                    'no_bukti' => strtoupper($this->main_lib->getPost('no_bukti')),
                    'oleh' => strtoupper($this->main_lib->getPost('oleh')),
                    'kode_pembayaran' => strtoupper($this->main_lib->getPost('kode_pembayaran')),
                    'jenis_biaya' => $jenis_biaya,
                    'nominal' => $nominal,
                ];

                $update = $this->Rekeningkoran->update($rekening_koran_data, ['id_rekening_koran' => $id_rekening_koran]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Rekening Koran berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan Data Rekening Koran!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('rekening-koran'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('rekening-koran/form-update', $data);
        }
    }

    public function delete($id_rekening_koran)
    {
        provideAccessTo("1|2");
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_rekening_koran && $data_type === 'rekening-koran') {

                $delete = $this->Rekeningkoran->delete(['id_rekening_koran' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Rekening Koran berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus Data Rekening Koran!'
                    ];
                }
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('rekening-koran'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('rekening-koran'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'id_bank',
                'label' => 'No. Rekening',
                'rules' => 'required'
            ],
            [
                'field' => 'tanggal',
                'label' => 'Tanggal',
                'rules' => 'required'
            ],
            [
                'field' => 'no_bukti',
                'label' => 'No. Bukti',
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
                'rules' => 'required|callback_validate_amount'
            ],
            [
                'field' => 'oleh',
                'label' => 'Oleh',
                'rules' => 'required'
            ],
//            [
//                'field' => 'kode_pembayaran',
//                'label' => 'Kode pembayaran',
//                'rules' => 'required'
//            ],
        ];
    }

    public function validate_amount()
    {
        $kode_pembayaran = strtoupper($this->main_lib->getPost('kode_pembayaran'));
        $nominal = removeDots($this->main_lib->getPost('nominal'));

        if (!empty(trim($kode_pembayaran))) {
            $kode_tipe = explode("-", $kode_pembayaran);
            $totalBayar = 0;
            $text_tipe = "";

            if ($kode_tipe[0] === "TF") {
                $totalBayar = $this->Pembayaranhutang->selectOnly('jumlah', [
                    'kode_pembayaran' => $kode_pembayaran
                ], false);
                $text_tipe = "supplier";

            } else if ($kode_tipe[0] == "PU") {
                $totalBayar = $this->Pembayaranpiutang->selectOnly('jumlah', [
                    'kode_pembayaran' => $kode_pembayaran
                ], false);
                $text_tipe = "penjualan";
            }

            if ($nominal != $totalBayar->jumlah) {
                $this->form_validation->set_message('validate_amount', 'Nominal pembayaran tidak sama dengan jumlah pembayaran ' . $text_tipe);
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function get_kode_pembayaran()
    {
        $response = [];
        if ($this->input->is_ajax_request()) {
            $kode_pembayaran = [];

            $keyword = $this->main_lib->getParam('term');
            $where = ['kode_pembayaran' => $keyword];

            //Pembayaran piutang
            $pembayaran_piutang = $this->Pembayaranpiutang->getWhereLike('kode_pembayaran', $where);
            foreach ($pembayaran_piutang as $pp) {
                $kode_pembayaran[] = $pp->kode_pembayaran;
            }

            //Pembayaran hutang
            $pembayaran_hutang = $this->Pembayaranhutang->getWhereLike('kode_pembayaran', $where);
            foreach ($pembayaran_hutang as $pp) {
                $kode_pembayaran[] = $pp->kode_pembayaran;
            }

            $response = $kode_pembayaran;
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Unable to proccess the request.'
            ];
        }

        echo json_encode($response);
    }
}

/* End of file RekeningKoran.php */
