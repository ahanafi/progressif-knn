<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotaSupplier extends CI_Controller
{
    private $uploadConfig = [];

    public function __construct()
    {
        parent::__construct();

        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }

        $this->uploadConfig = [
            'upload_path' => './uploads/nota-supplier/',
            'allowed_types' => 'pdf',
            'file_name' => date("Ymd-His"),
            'overwrite' => true,
            'encrypt_name' => true,
            'max_size' => 1024,
        ];
    }

    public function index()
    {
        provideAccessTo('1|4');
        $allNotaSupplier = $this->Notasupplier->getAll();
        $notaSupplier = [];
        $grandTotalBayar = 0;
        $grandTotalNota = 0;
        $grandTotalHpp = 0;
        $i = 0;

        foreach ($allNotaSupplier as $nota) {
            //store temp variable
            $no_nota = $nota->no_nota;
            $total_nota = $nota->total;

            //Get total bayar from detail pembayaran piutang
            $nominal_bayar = $this->Detailpembayaranhutang->getPembayaranNotaSupplier($no_nota);

            //Assign object to array
            $notaSupplier[$i] = $nota;
            $notaSupplier[$i]->bayar = $nominal_bayar;
            $notaSupplier[$i]->is_lunas = $total_nota === $nominal_bayar;

            $pdfLink = getPdfLink($nota->file_nota, "nota-supplier");
            $notaSupplier[$i]->pdflink = $pdfLink;

            $grandTotalBayar += $nominal_bayar;
            $grandTotalNota += $total_nota;
            $grandTotalHpp += $nota->total_hpp;
            $i++;
        }

        $data = [
            'title' => 'Nota Supplier',
            'notasupplier' => $notaSupplier,
            'grand_total_bayar' => $grandTotalBayar,
            'grand_total_nota' => $grandTotalNota,
            'grand_total_hpp' => $grandTotalHpp,
            'no' => 1
        ];

        $this->main_lib->getTemplate("nota-supplier/index", $data);
    }

    public function create($err_upload = '')
    {
        provideAccessTo("1|4");
        $pelanggan = $this->Pelanggan->all();
        $supplier = $this->Supplier->all();

        $data = [
            'title' => 'Tambah Nota Supplier',
            'action' => site_url('NotaSupplier/create_action'),
            'button' => 'Simpan Data',
            'pelanggan' => $pelanggan,
            'supplier' => $supplier,
            'id_nota_supplier' => set_value('id_nota_pembelian'),
            'no_nota' => set_value('no_nota'),
            'tanggal' => set_value('tanggal'),
            'id_pelanggan' => set_value('id_pelanggan'),
            'total' => set_value('total'),
            'total_hpp' => set_value('total_hpp'),
            'id_supplier' => set_value('id_supplier'),
            'err_upload' => $err_upload,
            'no' => 1
        ];

        $this->main_lib->getTemplate("nota-supplier/form_createupdate", $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $fileNota = $this->main_lib->_doUpload('file_nota', $this->uploadConfig);
            if (is_array($fileNota)) {
                $this->create($fileNota);
            } else {
                $nota_supplier_data = [
                    'no_nota' => strtoupper($this->main_lib->getPost('no_nota')),
                    'tanggal' => $this->main_lib->getPost('tanggal'),
                    'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                    'id_supplier' => $this->main_lib->getPost('id_supplier'),
                    'total' => removeDots($this->main_lib->getPost('total')),
                    'total_hpp' => removeDots($this->main_lib->getPost('total_hpp')),
                    'file_nota' => $fileNota
                ];

                $insert = $this->Notasupplier->insert($nota_supplier_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Nota Supplier berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan Nota Supplier baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('nota-supplier'), 'refresh');
            }
        }
    }

    public function edit($id_nota_supplier)
    {
        if (empty(trim($id_nota_supplier)) || $this->uri->segment('2') == 'edit' && $this->uri->segment('3') == '') {
            redirect('nota-supplier');
        }
        $pelanggan = $this->Pelanggan->all();
        $supplier = $this->Supplier->all();
        $nota_supplier = $this->Notasupplier->findById(['id_nota_pembelian' => $id_nota_supplier]);
        $data = [
            'title' => 'Tambah Nota Supplier',
            'action' => site_url('NotaSupplier/update_action'),
            'button' => 'Update Data',
            'pelanggan' => $pelanggan,
            'supplier' => $supplier,
            'id_nota_supplier' => set_value('id_nota_pembelian', $nota_supplier->id_nota_pembelian),
            'no_nota' => set_value('no_nota', strtoupper($nota_supplier->no_nota)),
            'tanggal' => set_value('tanggal', $nota_supplier->tanggal),
            'id_pelanggan' => set_value('id_pelanggan', $nota_supplier->id_pelanggan),
            'total' => set_value('total', toRupiah($nota_supplier->total)),
            'total_hpp' => set_value('total_hpp', toRupiah($nota_supplier->total_hpp)),
            'id_supplier' => set_value('id_supplier', $nota_supplier->id_supplier),
            'file_nota' => set_value('file_nota', $nota_supplier->file_nota),
            'no' => 1
        ];

        $this->main_lib->getTemplate("nota-supplier/form_createupdate.php", $data);
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->edit($this->main_lib->getPost('id_nota_supplier'));
        } else {
            $id_nota_supplier = $this->main_lib->getPost('id_nota_supplier');

            $nota_supplier_data = [
                'tanggal' => $this->main_lib->getPost('tanggal'),
                'id_pelanggan' => $this->main_lib->getPost('id_pelanggan'),
                'id_supplier' => $this->main_lib->getPost('id_supplier'),
                'total' => removeDots($this->main_lib->getPost('total')),
                'total_hpp' => removeDots($this->main_lib->getPost('total_hpp')),
            ];

            $nota_supplier = $this->Notasupplier->findById([
                'id_nota_pembelian' => $id_nota_supplier
            ]);
            if (isset($_FILES['file_nota']) && $_FILES['file_nota']['name'] !== '') {
                $fileNota = $this->main_lib->_doUpload('file_nota', $this->uploadConfig);

                if (is_array($fileNota)) {
                    $this->create($fileNota);
                } else {

                    $nota_supplier_data['file_nota'] = $fileNota;
                    $oldFileNota = $nota_supplier->file_nota;
                    $pathFile = FCPATH . 'uploads/nota-supplier/' . $oldFileNota;

                    //if exist file
                    if ($oldFileNota != '' && file_exists($pathFile)) {
                        //delete the old file
                        unlink($pathFile);
                    }
                }
            }

            $update = $this->Notasupplier->update($nota_supplier_data, ['id_nota_pembelian' => $id_nota_supplier]);
            if ($update) {
                $messages = [
                    'type' => 'success',
                    'text' => 'Data Nota Supplier berhasil diupdate!',
                ];
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal mengubah data nota Supplier!'
                ];
            }
            $this->session->set_flashdata('message', $messages);
            redirect(base_url('nota-supplier'), 'refresh');
        }
    }

    public function daftar()
    {
        provideAccessTo('1|2|3|4');
        $nota_supplier = [];
        $all_nota_supplier = $this->Notasupplier->all();
        $pelanggans = $this->Pelanggan->all();
        $suppliers = $this->Supplier->all();
        $bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        $index = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $get_parameter = "";

        //FILTERING
        if (isset($_GET['pelanggan']) || isset($_GET['supplier']) || isset($_GET['bulan'])) {
            $id_pelanggan = $this->input->get('pelanggan', true);
            $id_supplier = $this->input->get('supplier', true);
            $index_bulan = $this->input->get('bulan', true);

            $filter = [];

            //Filter only by pelanggan
            if (!empty(trim($id_pelanggan))) {
                $filter = ['nota_pembelian.id_pelanggan' => $id_pelanggan];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan;
            }

            //Filter only by supplier
            if (!empty(trim($id_supplier))) {
                $filter = ['nota_pembelian.id_supplier' => $id_supplier];
                $get_parameter = "?id_supplier=" . $id_supplier;
            }

            //Filter only by month
            if (!empty(trim($index_bulan))) {
                $filter = ['MONTH(nota_pembelian.tanggal)' => $index_bulan];
                $get_parameter = "?bulan=" . $index_bulan;
            }

            //Filter only by pelanggan and supplier
            if (!empty(trim($id_pelanggan)) && !empty(trim($id_supplier))) {
                $filter = [
                    'nota_pembelian.id_pelanggan' => $id_pelanggan,
                    'nota_pembelian.id_supplier' => $id_supplier,
                ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan . "&id_supplier=" . $id_supplier;
            }

            //Filter only by pelanggan and month
            if (!empty(trim($id_pelanggan)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_pembelian.id_pelanggan' => $id_pelanggan,
                    'MONTH(nota_pembelian.tanggal)' => $index_bulan
                ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan . "&bulan=" . $index_bulan;
            }

            //Filter only by supplier and month
            if (!empty(trim($id_supplier)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_pembelian.id_supplier' => $id_supplier,
                    'MONTH(nota_pembelian.tanggal)' => $index_bulan
                ];
                $get_parameter = "?id_supplier=" . $id_supplier . "&bulan=" . $index_bulan;
            }

            if (!empty(trim($id_pelanggan)) && !empty(trim($id_supplier)) && !empty(trim($index_bulan))) {
                $filter = [
                    'nota_pembelian.id_pelanggan' => $id_pelanggan,
                    'nota_pembelian.id_supplier' => $id_supplier,
                    'MONTH(nota_pembelian.tanggal)' => $index_bulan
                ];
                $get_parameter = "?id_pelanggan=" . $id_pelanggan . "&id_supplier=" . $id_supplier . "&bulan=" . $index_bulan;
            }

            if ($filter !== '') {
                $all_nota_supplier = $this->Notasupplier->filterBy($filter);
            }
        }

        $i = 0;
        $totalBayar = 0;
        $grandTotal = 0;
        $grandTotalHpp = 0;
        foreach ($all_nota_supplier as $nota) {
            //store temp variable
            $no_nota = $nota->no_nota;
            $total_nota = $nota->total;

            //Get total bayar from detail pembayaran piutang
            $nominal_bayar = $this->Detailpembayaranhutang->getPembayaranNotaSupplier($no_nota);

            //Assign object to array
            $nota_supplier[$i] = $nota;
            $nota_supplier[$i]->bayar = $nominal_bayar;
            $nota_supplier[$i]->is_lunas = $total_nota === $nominal_bayar;

            $pdfLink = getPdfLink($nota->file_nota, "nota-supplier");
            $nota_supplier[$i]->pdflink = $pdfLink;

            $totalBayar += $nominal_bayar;
            $grandTotal += $total_nota;
            $grandTotalHpp += $nota->total_hpp;
            $i++;
        }

        $data = [
            'title' => 'Daftar Nota Supplier',
            'pelanggan' => $pelanggans,
            'get_parameter' => $get_parameter,
            'supplier' => $suppliers,
            'notasupplier' => $nota_supplier,
            'bulan' => $bulan,
            'index' => $index,
            'total_bayar' => $totalBayar,
            'grand_total' => $grandTotal,
            'grand_total_hpp' => $grandTotalHpp,
            'no' => 1
        ];

        $this->main_lib->getTemplate("nota-supplier/daftar", $data);
    }

    public function status()
    {
        provideAccessTo('1|2');
        $allNotaSupplier = $this->Notasupplier->getAll();
        $notaSupplier = [];
        $grandTotalBayar = 0;
        $grandTotalNota = 0;
        $grandTotalHpp = 0;
        $i = 0;

        foreach ($allNotaSupplier as $nota) {
            //store temp variable
            $no_nota = $nota->no_nota;
            $total_nota = $nota->total;

            //Get total bayar from detail pembayaran piutang
            $nominal_bayar = $this->Detailpembayaranhutang->getPembayaranNotaSupplier($no_nota);

            //Assign object to array
            $notaSupplier[$i] = $nota;
            $notaSupplier[$i]->bayar = $nominal_bayar;
            $notaSupplier[$i]->is_lunas = $total_nota === $nominal_bayar;

            $grandTotalBayar += $nominal_bayar;
            $grandTotalNota += $total_nota;
            $grandTotalHpp += $nota->total_hpp;
            $i++;
        }

        $data = [
            'title' => 'Status Nota Supplier',
            'notasupplier' => $notaSupplier,
            'grand_total_bayar' => $grandTotalBayar,
            'grand_total_nota' => $grandTotalNota,
            'grand_total_hpp' => $grandTotalHpp,
            'no' => 1
        ];

        $this->main_lib->getTemplate("nota-supplier/status", $data);
    }

    public function updateToYes()
    {
        $id_nota_supplier = $this->main_lib->getPost('id');
        $update = $this->Notasupplier->updateToYes(['id_nota_pembelian' => $id_nota_supplier]);
        if ($update) {
            $messages = [
                'type' => 'success',
                'text' => 'Data Supplier berhasil disimpan!',
            ];
        } else {
            $messages = [
                'type' => 'error',
                'text' => 'Gagal menyimpan data Supplier!'
            ];
        }
        $this->session->set_flashdata('message', $messages);
    }

    public function _rules()
    {
        $this->form_validation->set_rules('no_nota', 'No. Nota', 'required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
        $this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
        $this->form_validation->set_rules('total', 'Total', 'required');
        $this->form_validation->set_rules('total_hpp', 'Total Hpp', 'required');
        $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");
    }

    public function getTotal($no_nota)
    {
        $response = [];
        if ($this->input->is_ajax_request()) {
            $total_nota = $this->Notasupplier->getTotalByNumber($no_nota);
            if ($total_nota) {
                $response = [
                    'status' => 'success',
                    'data' => $total_nota
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Unable to process the request.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Unable to process the request.'
            ];
        }

        echo json_encode($response);
    }

}

/* End of file Dashboard.php */
