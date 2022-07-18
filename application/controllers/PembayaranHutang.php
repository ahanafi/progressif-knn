<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PembayaranHutang extends CI_Controller
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
        $data = [
            'title' => 'Data Pembayaran Hutang',
            'pembayaran_hutang' => $this->Pembayaranhutang->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('pembayaran-hutang/index', $data);
    }

    public function daftar()
    {
        provideAccessTo("1|2|3|5");
        $data = [
            'title' => 'Daftar Pembayaran Hutang',
            'pembayaran_hutang' => $this->Pembayaranhutang->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('pembayaran-hutang/daftar', $data);
    }

    public function status()
    {
        provideAccessTo("1|3");
        $data = [
            'title' => 'Data Pembayaran Hutang',
            'pembayaran_hutang' => $this->Pembayaranhutang->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('pembayaran-hutang/status', $data);
    }

    public function ubah_status($id_pembayaran_hutang)
    {
        if (empty(trim($id_pembayaran_hutang))) {
            redirect(base_url('pembayaran-hutang'));
        } else {
            $update = $this->Pembayaranhutang->update(['status' => 1], ['id_pembayaran_hutang' => $id_pembayaran_hutang]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Status Pembayaran hutang berhasil diperbarui!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal memperbarui status Pembayaran hutang!'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('pembayaran-hutang/status'), 'refresh');
        }
    }

    public function create()
    {
        provideAccessTo("1|2");
        $kode_pembayaran = getAutoNumber('pembayaran_hutang', 'kode_pembayaran', 'TF');
        $data = [
            'title' => 'Tambah Pembayaran Hutang',
            'kode_pembayaran' => $kode_pembayaran,
            'bank' => $this->Bank->all(),
            'supplier' => $this->Supplier->all(),
            'jenis_bayar' => $this->Jenisbayar->all(),
            'keterangan' => $this->Keterangan->all(),
            'nota_supplier' => $this->Notasupplier->all(),
            'retur_supplier' => $this->Retursupplier->all(),
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pembayaran-hutang/create_update', $data);
            } else {
                $no_nota = $this->main_lib->getPost('no_nota');
                $no_retur = $this->main_lib->getPost('no_retur');
                $potong_retur = $this->main_lib->getPost('potong_retur');
                $tanggal_nota = $this->main_lib->getPost('tanggal_nota');
                $bayar = $this->main_lib->getPost('bayar');

                //Potongan
                $potongan_lain_lain = $this->main_lib->getPost('potongan_lain_lain');
                $no_giro_cek = $this->main_lib->getPost('no_giro_cek');

                $pembayaran_hutang_data = [
                    'kode_pembayaran' => $this->main_lib->getPost('kode_pembayaran'),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_supplier' => $this->main_lib->getPost('id_supplier'),
                    'id_bank' => $this->main_lib->getPost('id_bank'),
                    'id_jenis_bayar' => $this->main_lib->getPost('id_jenis_bayar'),
                    'id_keterangan' => $this->main_lib->getPost('id_keterangan'),
                    'jumlah' => removeDots($this->main_lib->getPost('jumlah')),
                    'potongan_lain_lain' => removeDots($potongan_lain_lain),
                    'no_giro_cek' => $no_giro_cek,
                ];

                //Insert Parent Table
                $insertPembayaranHutang = $this->Pembayaranhutang->insert($pembayaran_hutang_data);
                $id_pembayaran_hutang = $this->Main_model->getLastInsertID();

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

                        $detail_pembayaran_hutang_data = [
                            'id_pembayaran_hutang' => $id_pembayaran_hutang,
                            'tanggal' => $tanggal_nota[$i],
                            'no_nota' => $no_nota[$i],
                            'nominal_bayar' => removeDots($bayar[$i]),
                            'no_retur' => $no_retur,
                            'potongan_retur' => removeDots($potong_retur)
                        ];

                        $insertDetail = $this->Detailpembayaranhutang->insert($detail_pembayaran_hutang_data);
                        if ($insertDetail) {
                            $statusInsertDetail = true;
                        }
                    }
                }

                if ($statusInsertDetail && $insertPembayaranHutang) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Hutang berhasil ditambahkan!',
                    ];
                } else {
                    $this->Pembayaranhutang->delete(['id_pembayaran_hutang' => $id_pembayaran_hutang]);

                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data Pembayaran Hutang baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-hutang'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pembayaran-hutang/create_update', $data);
        }
    }

    public function edit($id_pembayaran_hutang)
    {
        if (empty(trim($id_pembayaran_hutang))) {
            redirect(base_url('pembayaran-hutang'));
        }

        $pembayaran_hutang = $this->Pembayaranhutang->findById([
            'id_pembayaran_hutang' => $id_pembayaran_hutang
        ]);
        $detail_pembayaran_hutang = $this->Detailpembayaranhutang->getBy('id_pembayaran_hutang', $id_pembayaran_hutang, true);
        $detail = [];
        $total_detail = count($detail_pembayaran_hutang);
        for ($i = 0; $i < $total_detail; $i++) {
            $detail[$i] = $detail_pembayaran_hutang[$i];
            $no_nota = $detail[$i]->no_nota;
            $no_retur = $detail[$i]->no_retur;

            //Get Total Nota
            $getTotalNota = $this->Notasupplier->findById(['no_nota' => $no_nota])->total;
            $detail[$i]->total_nota = $getTotalNota;

            //Get total retur
            $getTotalRetur = 0;
            if ($no_retur != NULL) {
                $getTotalRetur = $this->Retursupplier->findById(['no_retur' => $no_retur])->total;
            }
            $detail[$i]->total_retur = $getTotalRetur;
        }

        $data = [
            'title' => 'Edit Pembayaran Hutang',
            'pembayaran' => $pembayaran_hutang,
            'detail' => $detail,
            'bank' => $this->Bank->all(),
            'supplier' => $this->Supplier->all(),
            'jenis_bayar' => $this->Jenisbayar->all(),
            'keterangan' => $this->Keterangan->all(),
            'nota_supplier' => $this->Notasupplier->getBy('id_supplier', $pembayaran_hutang->id_supplier, true),
            'retur_supplier' => $this->Retursupplier->getBy('id_supplier', $pembayaran_hutang->id_supplier, true),
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules('update');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pembayaran-hutang/update', $data);
            } else {
                $no_nota = $this->main_lib->getPost('no_nota');
                $no_retur = $this->main_lib->getPost('no_retur');
                $potong_retur = $this->main_lib->getPost('potong_retur');
                $tanggal_nota = $this->main_lib->getPost('tanggal_nota');
                $bayar = $this->main_lib->getPost('bayar');

                //Potongan
                $potongan_lain_lain = $this->main_lib->getPost('potongan_lain_lain');
                $no_giro_cek = $this->main_lib->getPost('no_giro_cek');

                $pembayaran_hutang_data = [
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_supplier' => $this->main_lib->getPost('id_supplier'),
                    'id_bank' => $this->main_lib->getPost('id_bank'),
                    'id_jenis_bayar' => $this->main_lib->getPost('id_jenis_bayar'),
                    'id_keterangan' => $this->main_lib->getPost('id_keterangan'),
                    'jumlah' => removeDots($this->main_lib->getPost('jumlah')),
                    'potongan_lain_lain' => removeDots($potongan_lain_lain),
                    'no_giro_cek' => $no_giro_cek,
                ];

                $arrIdPembayaranHutang = [
                    'id_pembayaran_hutang' => $id_pembayaran_hutang
                ];

                //Insert Parent Table
                $updatePembayaranHutang = $this->Pembayaranhutang->update($pembayaran_hutang_data, $arrIdPembayaranHutang);

                //Delete old
                $this->Detailpembayaranhutang->delete($arrIdPembayaranHutang);
                //Helper variable
                $statusInsertDetail = false;
                if (count((array)$no_nota) == count((array)$tanggal_nota) && count((array)$tanggal_nota) == count((array)$bayar)) {
                    for ($i = 0; $i < count((array)$no_nota); $i++) {
                        $detail_pembayaran_hutang_data = [
                            'id_pembayaran_hutang' => $id_pembayaran_hutang,
                            'tanggal' => $tanggal_nota[$i],
                            'no_nota' => $no_nota[$i],
                            'nominal_bayar' => removeDots($bayar[$i]),
                            'no_retur' => $no_retur[$i],
                            'potongan_retur' => removeDots($potong_retur[$i])
                        ];

                        $insertDetail = $this->Detailpembayaranhutang->insert($detail_pembayaran_hutang_data);
                        if ($insertDetail) {
                            $statusInsertDetail = true;
                        }
                    }
                }

                if ($statusInsertDetail && $updatePembayaranHutang) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Hutang berhasil diperbarui!',
                    ];
                } else {
                    $this->Pembayaranhutang->delete(['id_pembayaran_hutang' => $id_pembayaran_hutang]);

                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal memperbarui data Pembayaran Hutang!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-hutang'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pembayaran-hutang/update', $data);
        }
    }

    public function edit_status($id_pembayaran_hutang)
    {
        if (empty(trim($id_pembayaran_hutang))) {
            redirect(base_url('pembayaran-hutang'));
        }

        $pembayaran_hutang = $this->Pembayaranhutang->findById([
            'id_pembayaran_hutang' => $id_pembayaran_hutang
        ]);
        $detail_pembayaran_hutang = $this->Detailpembayaranhutang->getBy('id_pembayaran_hutang', $id_pembayaran_hutang, true);
        $detail = [];
        $total_detail = count($detail_pembayaran_hutang);
        for ($i = 0; $i < $total_detail; $i++) {
            $detail[$i] = $detail_pembayaran_hutang[$i];
            $no_nota = $detail[$i]->no_nota;
            $no_retur = $detail[$i]->no_retur;

            //Get Total Nota
            $getTotalNota = $this->Notasupplier->findById(['no_nota' => $no_nota])->total;
            $detail[$i]->total_nota = $getTotalNota;

            //Get total retur
            $getTotalRetur = 0;
            if ($no_retur != NULL) {
                $getTotalRetur = $this->Retursupplier->findById(['no_retur' => $no_retur])->total;
            }
            $detail[$i]->total_retur = $getTotalRetur;
        }

        $data = [
            'title' => 'Edit Pembayaran Hutang',
            'pembayaran' => $pembayaran_hutang,
            'detail' => $detail,
            'bank' => $this->Bank->all(),
            'supplier' => $this->Supplier->all(),
            'jenis_bayar' => $this->Jenisbayar->all(),
            'keterangan' => $this->Keterangan->all(),
            'nota_supplier' => $this->Notasupplier->getBy('id_supplier', $pembayaran_hutang->id_supplier, true),
            'retur_supplier' => $this->Retursupplier->getBy('id_supplier', $pembayaran_hutang->id_supplier, true),
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules('update-status');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('pembayaran-hutang/edit-status', $data);
            } else {
                $no_giro_cek = $this->main_lib->getPost('no_giro_cek');
                $saldo = removeDots($this->main_lib->getPost('saldo'));
                $status = $this->main_lib->getPost('status');

                $pembayaran_hutang_data = [
                    'saldo' => removeDots($saldo),
                    'status' => $status,
                    'no_giro_cek' => $no_giro_cek,
                ];

                $arrIdPembayaranHutang = [
                    'id_pembayaran_hutang' => $id_pembayaran_hutang
                ];

                //Insert Parent Table
                $updatePembayaranHutang = $this->Pembayaranhutang->update($pembayaran_hutang_data, $arrIdPembayaranHutang);

                if ($updatePembayaranHutang) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Hutang berhasil diperbarui!',
                    ];
                } else {
                    $this->Pembayaranhutang->delete(['id_pembayaran_hutang' => $id_pembayaran_hutang]);

                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal memperbarui data Pembayaran Hutang!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-hutang'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('pembayaran-hutang/edit-status', $data);
        }
    }

    public function detail($id_pembayaran_hutang)
    {
        if (empty(trim($id_pembayaran_hutang))) {
            redirect(base_url('pembayaran-hutang'));
        }

        $pembayaran_hutang = $this->Pembayaranhutang->findById([
            'id_pembayaran_hutang' => $id_pembayaran_hutang
        ]);

        if (!$pembayaran_hutang) {
            redirect(base_url('pembayaran-hutang'));
        }

        $id_pembayaran_hutang = $pembayaran_hutang->id_pembayaran_hutang;
        $detail_pembayaran_hutang = $this->Detailpembayaranhutang->getBy('id_pembayaran_hutang', $id_pembayaran_hutang, true);
        $detail = [];
        $total_detail = count($detail_pembayaran_hutang);
        for ($i = 0; $i < $total_detail; $i++) {
            $detail[$i] = $detail_pembayaran_hutang[$i];
            $no_nota = $detail[$i]->no_nota;
            $no_retur = $detail[$i]->no_retur;

            //Get Total Nota
            $getTotalNota = $this->Notasupplier->findById(['no_nota' => $no_nota])->total;
            $detail[$i]->total_nota = $getTotalNota;

            //Get total retur
            $getTotalRetur = 0;
            if ($no_retur != NULL) {
                $getTotalRetur = $this->Retursupplier->findById(['no_retur' => $no_retur])->total;
            }
            $detail[$i]->total_retur = $getTotalRetur;
        }

        $data = [
            'title' => 'Detail Pembayaran Hutang',
            'pembayaran' => $pembayaran_hutang,
            'detail' => $detail,
        ];

        $this->main_lib->getTemplate('pembayaran-hutang/detail', $data);

    }

    public function delete($id_pembayaran_hutang)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_pembayaran_hutang && $data_type === 'pembayaran-hutang') {
                $delete = $this->Pembayaranhutang->delete(['id_pembayaran_hutang' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data Pembayaran Hutang berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data Pembayaran Hutang!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-hutang'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pembayaran-hutang'), 'refresh');
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
                'field' => 'id_supplier',
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
        if ($type === 'insert') {
            array_push($rules, [
                'field' => 'kode_pembayaran',
                'label' => 'Kode Pembayaran',
                'rules' => 'required|is_unique[pembayaran_hutang.kode_pembayaran]'
            ]);
        } elseif ($type == "update-status") {

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

/* End of file Pembayaran Hutang.php */
