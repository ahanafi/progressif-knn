<?php
$saldo = 0;
$second_uri = $this->uri->segment(2);
$bankId = $this->main_lib->getParam('bank');
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Rekening Koran</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Tambah Rekening Koran
            </h2>
            <p class="section-lead">Tambah Rekening Koran</p>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('rekening-koran/create') . "?bank=$bankId"; ?>" class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </a>
                                <form action="" method="GET">
                                    <div class='form-group row mb-0 text-left'>
                                        <label for="" class="col-form-label col-sm-2">Filter Bulan :</label>

                                        <div class='col-sm-4'>
                                            <select class='form-control select2' name="bank">
                                                <option disabled selected>-- Pilih Bank --</option>
                                                <?php foreach ($bank as $b): ?>
                                                    <option <?php echo (isset($_GET['bank']) && $_GET['bank'] == $bankId) ? 'selected' : ''; ?> value="<?php echo $b->id_bank; ?>">
                                                        <?php echo $b->nama_bank . " - " . $b->no_rekening; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 text-left">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-eye"></i>
                                                <span>Tampilkan</span>
                                            </button>
                                            <?php if (isset($_GET['bank']) && $_GET['bank'] !== ''): ?>
                                                <a href="<?php echo base_url('rekening-koran'); ?>" class="btn btn-danger">
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
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($rekening_koran) > 0): ?>
                                        <?php foreach ($rekening_koran as $rekening):
                                            $nomorBukti = str_replace("=", "", base64_encode($rekening->no_bukti));
                                            $linkCetak = base_url('cetak/rekening-koran/' . $nomorBukti);

                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td data-sort="<?php echo strtotime($rekening->tanggal); ?>"><?php echo IdFormatDate($rekening->tanggal); ?></td>
                                                <td>
                                                    <a href="<?php echo $linkCetak; ?>" class="btn-link" target="_blank">
                                                        <?php echo strtoupper($rekening->no_bukti); ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $rekening->keterangan; ?></td>
                                                <td><?php echo "Biaya " . ucwords(strtolower($rekening->jenis_biaya)); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($rekening->nominal); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($rekening->saldo); ?></td>
                                                <td><?php echo $rekening->oleh; ?></td>
                                                <td><?php echo $rekening->link_pembayaran; ?></td>
                                                <td class="text-center"><?php echo getStatus($rekening->status); ?></td>
                                                <td class="text-center">
                                                    <?php if ($rekening->status == 0): ?>
                                                        <a href="<?php echo base_url('rekening-koran/edit/' . $rekening->id_rekening_koran); ?>" class="btn btn-light">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-light" onclick="showConfirmDelete('rekening-koran', <?php echo $rekening->id_rekening_koran; ?>)">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <small><i>NO ACTION</i></small>
                                                    <?php endif; ?>
                                                </td>
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