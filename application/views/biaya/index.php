<?php
$saldo = 0;
$index = 1;
$second_uri = $this->uri->segment(2);
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Biaya</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Tambah Biaya
            </h2>
            <p class="section-lead">Tambah Biaya</p>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('export-excel/biaya'); ?>" target="_blank" class="btn btn-success btn-icon icon-left float-right ml-2">
                                    <i class="fa fa-file-excel"></i>
                                    Export Excel
                                </a>
                                <a href="<?php echo base_url('biaya/create'); ?>" class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-plus"></i>
                                    Tambah Biaya
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table" width='100%'>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Kode Transaksi</th>
                                        <th>Keterangan</th>
                                        <th>Jenis Biaya</th>
                                        <th>Jumlah</th>
                                        <th>Saldo</th>
                                        <th>Oleh</th>
                                        <th>Status</th>
                                        <th>Bukti</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($biayas) > 0): ?>
                                        <?php foreach ($biayas as $biaya):
                                            $jenis = $biaya->jenis_biaya;
                                            if ($jenis === 'MASUK') {
                                                $saldo += $biaya->nominal;
                                            } else {
                                                $saldo -= $biaya->nominal;
                                            }

                                            $encodeKode = base64_encode($biaya->kode_transaksi);
                                            $replaceEqualSign = str_replace("=", "", $encodeKode);
                                            $link_cetak = base_url("cetak/biaya-" . strtolower($jenis) . "/" . $replaceEqualSign);
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td data-sort="<?php echo strtotime($biaya->tanggal); ?>"><?php echo IdFormatDate($biaya->tanggal); ?></td>
                                                <td>
                                                    <a target="_blank" href="<?php echo $link_cetak; ?>" class="link">
                                                        <?php echo strtoupper($biaya->kode_transaksi); ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $biaya->keterangan; ?></td>
                                                <td><?php echo "Biaya " . ucwords(strtolower($jenis)); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($biaya->nominal); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($saldo); ?></td>
                                                <td><?php echo $biaya->oleh; ?></td>
                                                <td class="text-center"><?php echo getStatus($biaya->status); ?></td>
                                                <td>
                                                    <button class='btn btn-primary pop' data-toggle='modal' id='show_picture' data-url='<?= base_url('uploads/bukti/' . $biaya->foto) ?>'>
                                                        <span class='fa fa-eye'></span></button>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($biaya->status == 0): ?>
                                                        <a href="<?php echo base_url('biaya/edit/' . $biaya->id_biaya); ?>" class="btn btn-light">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-light" onclick="showConfirmDelete('biaya', <?php echo $biaya->id_biaya; ?>)">
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
                                            <td class="text-center text-info font-weight-bold" colspan="9">
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
