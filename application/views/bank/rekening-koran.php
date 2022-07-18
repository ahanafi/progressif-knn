<?php
$saldo = 0;
$index = 1;
$second_uri = $this->uri->segment(2);

?>
<style type="text/css">
    .card-header-action {
        width: auto !important;
    }

    #table-detail > tbody > tr > td:first-child {
        width: 12rem !important;
    }

    .form-control {
        height: 42px !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Bank</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary mb-3">
                        <div class="card-header">
                            <h4>Detail Bank</h4>
                            <div class="card-header-action">
                                <a href="#" data-collapse="#detail-collapse" class="btn btn-info btn-icon">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="collapse" id="detail-collapse">
                            <div class="card-body">
                                <table class="table table-striped" id="table-detail">
                                    <tr>
                                        <td>Nama Bank</td>
                                        <td>:</td>
                                        <td><?php echo $bank->nama_bank; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>:</td>
                                        <td><?php echo $bank->no_rekening; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Rekening</td>
                                        <td>:</td>
                                        <td><?php echo $bank->nama_rekening; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo $bank->alamat; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kontak</td>
                                        <td>:</td>
                                        <td><?php echo $bank->kontak; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action" style="width: 100% !important;">
                                <form action="" method="GET">
                                    <div class='form-group row mb-0 text-left'>
                                        <label for="" class="col-form-label col-sm-2">Filter Tanggal :</label>
                                        <div class='col-sm-2'>
                                            <input type="date" class="form-control" name="first_date" value="<?= isset($_GET['first_date']) && $_GET['first_date'] !== '' ? $_GET['first_date'] : ""; ?>">
                                        </div>
                                        <div class='col-sm-2'>
                                            <input type="date" class="form-control" name="last_date" value="<?= isset($_GET['last_date']) && $_GET['last_date'] !== '' ? $_GET['last_date'] : ""; ?>">
                                        </div>
                                        <div class="col-sm-4 text-left">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                                <span>Tampilkan</span>
                                            </button>
                                            <a href="<?php echo base_url('cetak/rekening-koran/' . $bank->id_bank .'/bank') . $get_parameter; ?>" class="btn btn-light" target="_blank">
                                                <i class="fa fa-print"></i>
                                                <span>Cetak</span>
                                            </a>
                                            <?php if (isset($_GET['first_date'], $_GET['last_date'])): ?>
                                                <a href="<?php echo base_url('bank/rekening-koran/' . $bank->id_bank); ?>" class="btn btn-danger">
                                                    <i class="fa fa-retweet"></i>
                                                    <span>Reset</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table" width='100%'>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>No. Bukti</th>
                                        <th>Keterangan</th>
                                        <th>Jenis Biaya</th>
                                        <th>Jumlah</th>
                                        <th>Saldo</th>
                                        <th>Oleh</th>
                                        <th>Kode Pembayaran</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($rekening_koran) > 0): ?>
                                        <?php foreach ($rekening_koran as $rekening):
                                            $jenis = $rekening->jenis_biaya;
                                            if ($jenis === 'MASUK' || $jenis === 'SALDO') {
                                                $saldo += $rekening->nominal;
                                            } else {
                                                $saldo -= $rekening->nominal;
                                            }

                                            $nomorBukti = str_replace("=", "", base64_encode($rekening->no_bukti));
                                            $linkCetak = base_url('cetak/rekening-koran/' . $nomorBukti);
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                 <?php
                                                    $myStrTime = strtotime($rekening->tanggal);
                                                    $newDateFormat = date('d-m-Y',$myStrTime);
                                                ?>
                                                <td data-sort="<?php echo $myStrTime;  ?>"><?php echo IdFormatDate($rekening->tanggal); ?></td>
                                                <td>
                                                    <a href="<?php echo $linkCetak; ?>" class="btn-link" target="_blank">
                                                        <?php echo strtoupper($rekening->no_bukti); ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $rekening->keterangan; ?></td>
                                                <td><?php echo "Biaya " . ucwords(strtolower($jenis)); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($rekening->nominal); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($saldo); ?></td>
                                                <td><?php echo $rekening->oleh; ?></td>
                                                <td><?php echo $rekening->link_pembayaran; ?></td>
                                                <td class="text-center"><?php echo getStatus($rekening->status); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center text-info font-weight-bold" colspan="11">
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-center font-weight-bold">TOTAL</th>
                                        <th colspan="3" class="font-weight-bold">Total Uang Masuk = <?php echo toRupiah($total_uang_masuk); ?></th>
                                        <th colspan="4" class="font-weight-bold">Total Uang Keluar = <?php echo toRupiah($total_uang_keluar); ?></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>