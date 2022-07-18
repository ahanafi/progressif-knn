<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Retur Penjualan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Status Retur Penjualan
            </h2>
            <p class="section-lead">Daftar Status Retur Penjualan</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. retur</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Sales</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Potong</th>
                                        <th class="text-center">Lunas</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($retur_penjualan) > 0): ?>
                                        <?php foreach ($retur_penjualan as $retur): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $retur->no_retur; ?></td>
                                                  <td data-sort="<?php echo strtotime($retur->tanggal);  ?>"><?php echo IdFormatDate($retur->tanggal); ?></td>
                                                <td><?php echo $retur->nama_pelanggan; ?></td>
                                                <td><?php echo $retur->sales; ?></td>
                                                <td class="format-uang"><?php echo toRupiah($retur->total); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($retur->potong); ?></td>
												<td class="text-center"><?php echo getStatus($retur->lunas, 'pelunasan'); ?></td>
                                                <td class="text-center">
                                                    <?php if($retur->status == 0): ?>
                                                        <a href="<?php echo base_url('retur-penjualan/ubah-status/' . $retur->id_retur_penjualan); ?>" class="badge badge-primary">
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
                                            <td class="text-center text-info font-weight-bold" colspan="7">
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-center font-weight-bold">GRAND TOTAL</th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($grand_total_retur); ?></th>
                                        <th></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($grand_total_potong); ?></th>
                                        <th></th>
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