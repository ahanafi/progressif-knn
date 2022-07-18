<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PembayaranPiutang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
    }

    public function index()
    {
        provideAccessTo("1|2|3|5");
        $data = [
            'title' => 'Data Pembayaran Piutang',
            'pembayaran_piutang' => $this->Pembayaranpiutang->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('pembayaran-piutang/index', $data);
    }

    public function daftar()
    {
        provideAccessTo("1|2|3|5");
        $data = [
            'title' => 'Data Pembayaran Piutang',
            'pembayaran_piutang' => $this->Pembayaranpiutang->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('pembayaran-piutang/daftar', $data);
    }

    public function status()
    {
        provideAccessTo("1|3");
        $data = [
            'title' => 'Data Pembayaran Piutang',
            'pembayaran_piutang' => $this->Pembayaranpiutang->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('pembayaran-piutang/status-pembayaran', $data);
    }

    public function ubah_status($id_pembayaran_piutang)
    {
        if (empty(trim($id_pembayaran_piutang))) {
            redirect(base_url('pembayaran-piutang'));
        } else {
            $update = $this->Pembayaranpiutang->update(['status' => 1], ['id_pembayaran_piutang' => $id_pembayaran_piutang]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Status Pembayaran piutang berhasil diperbarui!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal memperbarui status Pembayaran piutang!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('pembayaran-piutang/status'), 'refresh');
        }
    }

    public function create()
    {
        $kode_pembayaran = getAutoNumber('pembayaran_piutang', 'kode_pembayaran', 'PU');
        $data = [
            'title' => 'Tambah Pembayaran Piutang',
            'kode_pembayaran' => $kode_pembayaran,
            'bank' => $this->Bank->all(),
            'pelanggan' => $this->Pelanggan->all(),
            'jenis_bayar' => $this->Jenisbayar->all(),
            'keterangan' => $this->Keterangan->all(),
            'nota_penjualan' => $this->Notapenjualan->all(),
            'retur_penjualan' => $this->Returpenjualan->all(),
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pembayaran-piutang/form-create', $data);
            } else {
                $no_nota = $this->main_lib->getPost('no_nota');
                $no_retur = $this->main_lib->getPost('no_retur');
                $potong_retur = $this->main_lib->getPost('potong_retur');
                $tanggal_nota = $this->main_lib->getPost('tanggal_nota');
                $bayar = $this->main_lib->getPost('bayar');

                //Potongan
                $potongan_lain_lain = $this->main_lib->getPost('potongan_lain_lain');
                $no_giro_cek = $this->main_lib->getPost('no_giro_cek');

                $pembayaran_piutang_data = [
                    'kode_pembayaran' => $this->main_lib->getPost('kode_pembayaran'),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                    'id_bank' => $this->main_lib->getPost('id_bank'),
                    'id_jenis_bayar' => $this->main_lib->getPost('id_jenis_bayar'),
                    'id_keterangan' => $this->main_lib->getPost('id_keterangan'),
                    'jumlah' => removeDots($this->main_lib->getPost('jumlah')),
                    'potongan_lain_lain' => removeDots($potongan_lain_lain),
                    'no_giro_cek' => $no_giro_cek,
                ];

                //Insert Parent Table
                $insertPembayaranPiutang = $this->Pembayaranpiutang->insert($pembayaran_piutang_data);
                $id_pembayaran_piutang = $this->Main_model->getLastInsertID();

                //Helper variable
                $statusInsertDetail = false;
                if (count((array)$no_nota) == count((array)$tanggal_nota) && count((array)$tanggal_nota) == count((array)$bayar)) {
                    for ($i = 0; $i < count((array)$no_nota); $i++) {
                        $no_retur = $no_retur[$i];
                        $potong_retur = $potong_retur[$i];
                        if ($no_retur == '') {
                            $no_retur = NULL;
                            $potong_retur = NULL;
                        }

                        $detail_pembayaran_piutang_data = [
                            'id_pembayaran_piutang' => $id_pembayaran_piutang,
                            'tanggal' => $tanggal_nota[$i],
                            'no_nota' => $no_nota[$i],
                            'nominal_bayar' => removeDots($bayar[$i]),
                            'no_retur' => $no_retur,
                            'potongan_retur' => removeDots($potong_retur)
                        ];

                        $insertDetail = $this->Detailpembayaranpiutang->insert($detail_pembayaran_piutang_data);
                        if ($insertDetail) {
                            $statusInsertDetail = true;
                        }
                    }
                }

                if ($statusInsertDetail && $insertPembayaranPiutang) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Piutang berhasil ditambahkan!',
                    ];
                } else {
                    $this->Pembayaranpiutang->delete(['id_pembayaran_piutang' => $id_pembayaran_piutang]);

                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Pembayaran Piutang baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-piutang'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pembayaran-piutang/form-create', $data);
        }
    }

    public function edit($id_pembayaran_piutang)
    {
        if (empty(trim($id_pembayaran_piutang))) {
            redirect(base_url('pembayaran-piutang'));
        }

        $pembayaran_piutang = $this->Pembayaranpiutang->findById([
            'id_pembayaran_piutang' => $id_pembayaran_piutang
        ]);
        $idPelanggan = $pembayaran_piutang->id_pelanggan;
        $detail_pembayaran_piutang = $this->Detailpembayaranpiutang->getBy('id_pembayaran_piutang', $id_pembayaran_piutang, true);
        $total_detail = count($detail_pembayaran_piutang);
        $detail = [];
        for ($i = 0; $i < $total_detail; $i++) {
            $detail[$i] = $detail_pembayaran_piutang[$i];
            $no_nota = $detail[$i]->no_nota;
            $no_retur = $detail[$i]->no_retur;

            //Get Total Nota
            $totalNota = 0;
            $getTotalNota = $this->Notapenjualan->findById(['no_nota' => $no_nota]);
            if($getTotalNota) {
                $totalNota = $getTotalNota->total;
            }
            $detail[$i]->total_nota = $totalNota;

            //Get total retur
            $getTotalRetur = 0;
            if ($no_retur != NULL) {
                $getTotalRetur = $this->Returpenjualan->findById(['no_retur' => $no_retur])->total;
            }
            $detail[$i]->total_retur = $getTotalRetur;
        }

        $data = [
            'title' => 'Edit Pembayaran Piutang',
            'pembayaran' => $pembayaran_piutang,
            'detail' => $detail,
            'bank' => $this->Bank->all(),
            'pelanggan' => $this->Pelanggan->all(),
            'jenis_bayar' => $this->Jenisbayar->all(),
            'keterangan' => $this->Keterangan->all(),
            'nota_penjualan' => $this->Notapenjualan->findById(['id_pelanggan' => $idPelanggan], true),
            'retur_penjualan' => $this->Returpenjualan->findById(['id_pelanggan' => $idPelanggan], true),
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules('update');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pembayaran-piutang/form-update', $data);
            } else {
                $no_nota = $this->main_lib->getPost('no_nota');
                $no_retur = $this->main_lib->getPost('no_retur');
                $potong_retur = $this->main_lib->getPost('potong_retur');
                $tanggal_nota = $this->main_lib->getPost('tanggal_nota');
                $bayar = $this->main_lib->getPost('bayar');

                //Potongan
                $potongan_lain_lain = $this->main_lib->getPost('potongan_lain_lain');
                $no_giro_cek = $this->main_lib->getPost('no_giro_cek');

                $pembayaran_piutang_data = [
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                    'id_bank' => $this->main_lib->getPost('id_bank'),
                    'id_jenis_bayar' => $this->main_lib->getPost('id_jenis_bayar'),
                    'id_keterangan' => $this->main_lib->getPost('id_keterangan'),
                    'jumlah' => removeDots($this->main_lib->getPost('jumlah')),
                    'potongan_lain_lain' => removeDots($potongan_lain_lain),
                    'no_giro_cek' => $no_giro_cek,
                ];

                $arrIdPembayaranPiutang = [
                    'id_pembayaran_piutang' => $id_pembayaran_piutang
                ];
                //Update Parent Table
                $insertPembayaranPiutang = $this->Pembayaranpiutang->update($pembayaran_piutang_data, $arrIdPembayaranPiutang);

                //Delete old data
                $this->Detailpembayaranpiutang->delete($arrIdPembayaranPiutang);

                //Helper variable
                $statusInsertDetail = false;
                if (count((array)$no_nota) == count((array)$tanggal_nota) && count((array)$tanggal_nota) == count((array)$bayar)) {
                    for ($i = 0; $i < count((array)$no_nota); $i++) {
                        $detail_pembayaran_piutang_data = [
                            'id_pembayaran_piutang' => $id_pembayaran_piutang,
                            'tanggal' => $tanggal_nota[$i],
                            'no_nota' => $no_nota[$i],
                            'nominal_bayar' => removeDots($bayar[$i]),
                            'no_retur' => $no_retur[$i],
                            'potongan_retur' => removeDots($potong_retur[$i])
                        ];

                        $insertDetail = $this->Detailpembayaranpiutang->insert($detail_pembayaran_piutang_data);
                        if ($insertDetail) {
                            $statusInsertDetail = true;
                        }
                    }
                }

                if ($statusInsertDetail && $insertPembayaranPiutang) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Piutang berhasil diperbarui!',
                    ];
                } else {
                    $this->Pembayaranpiutang->delete(['id_pembayaran_piutang' => $id_pembayaran_piutang]);

                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal memperbarui data Pembayaran Piutang!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-piutang'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pembayaran-piutang/form-update', $data);
        }
    }

    public function edit_status($id_pembayaran_piutang)
    {
        if (empty(trim($id_pembayaran_piutang))) {
            redirect(base_url('pembayaran-piutang'));
        }

        $pembayaran_piutang = $this->Pembayaranpiutang->findById([
            'id_pembayaran_piutang' => $id_pembayaran_piutang
        ]);
        $detail_pembayaran_piutang = $this->Detailpembayaranpiutang->getBy('id_pembayaran_piutang', $id_pembayaran_piutang, true);
        $total_detail = count($detail_pembayaran_piutang);
        $detail = [];
        for ($i = 0; $i < $total_detail; $i++) {
            $detail[$i] = $detail_pembayaran_piutang[$i];
            $no_nota = $detail[$i]->no_nota;
            $no_retur = $detail[$i]->no_retur;

            //Get Total Nota
            $getTotalNota = $this->Notapenjualan->findById(['no_nota' => $no_nota])->total;
            $detail[$i]->total_nota = $getTotalNota;

            //Get total retur
            $getTotalRetur = 0;
            if ($no_retur != NULL) {
                $getTotalRetur = $this->Returpenjualan->findById(['no_retur' => $no_retur])->total;
            }
            $detail[$i]->total_retur = $getTotalRetur;
        }

        $data = [
            'title' => 'Edit Pembayaran Piutang',
            'pembayaran' => $pembayaran_piutang,
            'detail' => $detail,
            'bank' => $this->Bank->all(),
            'pelanggan' => $this->Pelanggan->all(),
            'jenis_bayar' => $this->Jenisbayar->all(),
            'keterangan' => $this->Keterangan->all(),
            'nota_penjualan' => $this->Notapenjualan->all(),
            'retur_penjualan' => $this->Returpenjualan->all(),
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules('update-status');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pembayaran-piutang/form-update-status', $data);
            } else {
                $no_giro_cek = $this->main_lib->getPost('no_giro_cek');

                $pembayaran_piutang_data = [
                    'status' => $this->main_lib->getPost('status'),
                    'saldo' => removeDots($this->main_lib->getPost('saldo')),
                    'no_giro_cek' => $no_giro_cek,
                ];

                $arrIdPembayaranPiutang = [
                    'id_pembayaran_piutang' => $id_pembayaran_piutang
                ];
                //Update Parent Table
                $updatePembayaranPiutang = $this->Pembayaranpiutang->update($pembayaran_piutang_data, $arrIdPembayaranPiutang);

                if ($updatePembayaranPiutang) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Piutang berhasil diperbarui!',
                    ];
                } else {
                    $this->Pembayaranpiutang->delete(['id_pembayaran_piutang' => $id_pembayaran_piutang]);

                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal memperbarui data Pembayaran Piutang!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-piutang'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pembayaran-piutang/form-update-status', $data);
        }
    }

    public function detail($id_pembayaran_piutang)
    {
        if (empty(trim($id_pembayaran_piutang))) {
            redirect(base_url('pembayaran-piutang'));
        }

        $pembayaran_piutang = $this->Pembayaranpiutang->findById([
            'id_pembayaran_piutang' => $id_pembayaran_piutang
        ]);
        $detail_pembayaran_piutang = $this->Detailpembayaranpiutang->getBy('id_pembayaran_piutang', $id_pembayaran_piutang, true);
        $total_detail = count($detail_pembayaran_piutang);
        $detail = [];
        for ($i = 0; $i < $total_detail; $i++) {
            $detail[$i] = $detail_pembayaran_piutang[$i];
            $no_nota = $detail[$i]->no_nota;
            $no_retur = $detail[$i]->no_retur;

            //Get Total Nota
            $totalNota = 0;
            $getTotalNota = $this->Notapenjualan->findById(['no_nota' => $no_nota]);
            if($getTotalNota) {
                $totalNota = $getTotalNota->total;
            }

            $detail[$i]->total_nota = $totalNota;

            //Get total retur
            $getTotalRetur = 0;
            if ($no_retur != NULL) {
                $getTotalRetur = $this->Returpenjualan->findById(['no_retur' => $no_retur])->total;
            }
            $detail[$i]->total_retur = $getTotalRetur;
        }

        $data = [
            'title' => 'Detail Pembayaran Piutang',
            'pembayaran' => $pembayaran_piutang,
            'detail' => $detail,
            'no' => 1,
        ];

        $this->main_lib->getTemplate('pembayaran-piutang/detail', $data);

    }

    public function delete($id_pembayaran_piutang)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_pembayaran_piutang && $data_type === 'pembayaran-piutang') {
                $delete = $this->Pembayaranpiutang->delete(['id_pembayaran_piutang' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Piutang berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Pembayaran Piutang!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-piutang'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-piutang'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules($type = 'insert')
    {
        $rules = [
            [
                'field' => 'tanggal',
                'label' => 'tanggal',
                'rules' => 'required'
            ],
            [
                'field' => 'id_pelanggan',
                'label' => 'Pelanggan',
                'rules' => 'required'
            ],
            [
                'field' => 'id_bank',
                'label' => 'Bank',
                'rules' => 'required'
            ],
            [
                'field' => 'id_jenis_bayar',
                'label' => 'Jenis bayar',
                'rules' => 'required'
            ],
            [
                'field' => 'id_keterangan',
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
            [
                'field' => 'jumlah',
                'label' => 'Jumlah transfer',
                'rules' => 'required'
            ],
            [
                'field' => 'no_nota[]',
                'label' => 'No. Nota',
                'rules' => 'required'
            ],
            [
                'field' => 'tanggal_nota[]',
                'label' => 'Tanggal nota',
                'rules' => 'required'
            ],
            [
                'field' => 'bayar[]',
                'label' => 'No. Nota',
                'rules' => 'required'
            ],
        ];
        if ($type == 'insert') {
            array_push($rules, [
                'field' => 'kode_pembayaran',
                'label' => 'Kode Pembayaran',
                'rules' => 'required|is_unique[pembayaran_piutang.kode_pembayaran]'
            ]);
        } else if ($type == "update-status") {
            $rules = [
                [
                    'field' => 'saldo',
                    'label' => 'Saldo',
                    'rules' => 'required'
                ],
                [
                    'field' => 'status',
                    'label' => 'Status',
                    'rules' => 'required'
                ],
                [
                    'field' => 'no_giro_cek',
                    'label' => 'No. Giro/Cek',
                    'rules' => 'required'
                ],
            ];
        }

        return $rules;
    }
}

/* End of file Pembayaran Piutang.php */
