<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Biaya</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Status Biaya
            </h2>
            <p class="section-lead">Daftar Status Biaya</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Jenis Biaya</th>
                                        <th>Jumlah</th>
                                        <th>Saldo</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($biayas) > 0): ?>
                                        <?php foreach ($biayas as $biaya): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td data-sort="<?php echo strtotime($biaya->tanggal); ?>"><?php echo IdFormatDate($biaya->tanggal); ?></td>
                                                <td><?php echo $biaya->keterangan; ?></td>
                                                <td><?php echo "Biaya " . ucwords(strtolower($biaya->jenis_biaya)); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($biaya->nominal); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($biaya->saldo); ?></td>
                                                <td class="text-center">
                                                    <?php if ($biaya->status == 0): ?>
                                                        <a href="<?php echo base_url('biaya/ubah-status/' . $biaya->id_biaya); ?>" class="badge badge-primary">
                                                            DITERIMA
                                                        </a>
                                                    <?php else: ?>
                                                        <b><i><small>YES</small></i></b>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center text-info font-weight-bold" colspan="8">
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