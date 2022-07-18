<style>
    th {
        text-align: center;
        font-weight: bold;
    }

    .format-uang {
        text-align: right;
        font-style: italic;
    }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Hutang Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Hutang Supplier
            </h2>
            <p class="section-lead">Daftar Hutang Supplier</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="data-table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Supplier</th>
                                    <th>Hutang Lama</th>
                                    <th>Hutang</th>
                                    <th>Retur</th>
                                    <th>Pembayaran</th>
                                    <th>Lain-lain</th>
                                    <th>Sisa</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($suppliers) > 0): ?>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $supplier->nama_supplier; ?></td>
                                            <td class="format-uang">
                                                <a href='#' onclick="showDetails('hutang-lama', <?php echo $supplier->id_supplier; ?>)"><?= toRupiah($supplier->hutang_lama) ?></a></td>
                                            <td class="format-uang"><a href='#' onclick="showDetails('hutang', <?php echo $supplier->id_supplier; ?>)"><?= toRupiah($supplier->hutang) ?></a></td>
                                            <td class="format-uang"><a href='#' onclick="showDetails('retur', <?php echo $supplier->id_supplier; ?>)"><?= toRupiah($supplier->retur) ?></a></td>
                                            <td class="format-uang"><a href='#' onclick="showDetails('transfer', <?php echo $supplier->id_supplier; ?>)"><?= toRupiah($supplier->bayar) ?></a></td>
                                            <td class="format-uang">
                                                <a href='#' onclick="showDetails('lain-lain', <?php echo $supplier->id_supplier; ?>)"><?php echo toRupiah($supplier->lain_lain); ?></a></td>
                                            <td class="format-uang"><?php echo toRupiah($supplier->sisa); ?></td>
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
                                    <th class="text-center font-weight-bold" colspan="2">GRAND TOTAL</th>
                                    <th class="format-uang font-weight-bold"><?php echo toRupiah($total_hutang_lama); ?></th>
                                    <th class="format-uang font-weight-bold"><?php echo toRupiah($total_hutang); ?></th>
                                    <th class="format-uang font-weight-bold"><?php echo toRupiah($total_retur); ?></th>
                                    <th class="format-uang font-weight-bold"><?php echo toRupiah($total_bayar); ?></th>
                                    <th class="format-uang font-weight-bold"><?php echo toRupiah($total_lain_lain); ?></th>
                                    <th class="format-uang font-weight-bold"><?php echo toRupiah($total_sisa); ?></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="detail-modal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead id="table-header"></thead>
                        <tbody id="table-body"></tbody>
                        <tfoot id="table-footer"></tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
