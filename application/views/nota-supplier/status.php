<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Nota Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Status Nota Supplier
            </h2>
            <p class="section-lead">Status Nota Supplier</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <table id='data-table' class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Nota</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total</th>
                                    <th>Total HPP</th>
                                    <th>Supplier</th>
                                    <th>Transfer</th>
                                    <th>Lunas</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($notasupplier) > 0): ?>
                                    <?php foreach ($notasupplier as $supplier): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $supplier->no_nota; ?></td>
                                            <td data-sort="<?php echo strtotime($supplier->tanggal); ?>"><?php echo IdFormatDate($supplier->tanggal); ?></td>
                                            <td><?php echo $supplier->nama_pelanggan; ?></td>
                                            <td class="format-uang"><?php echo toRupiah($supplier->total); ?></td>
                                            <td class="format-uang"><?php echo toRupiah($supplier->total_hpp); ?></td>
                                            <td><?php echo $supplier->nama_supplier; ?></td>
                                            <td class="format-uang"><?php echo toRupiah($supplier->bayar); ?></td>
                                            <td class="format-uang">
                                                <?php echo getStatus($supplier->is_lunas, "pelunasan"); ?>
                                            </td>
                                            <td class="text-center"><?php echo($supplier->status == 0 ? '<a href="#" class="badge badge-primary" data-id="<?=$supplier->id_supplier?>" data-link ="<?=site_url(nota-supplier/updateToYes)?>" onclick="updateToYes(' . $supplier->id_nota_pembelian . ',\'' . site_url('nota-supplier/updateToYes/' . $supplier->id_nota_pembelian) . '\')">Diterima</a>' : '<b><i><small>YES</small></i></b>'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                                 <tfoot>
                                <tr>
                                    <th colspan="4" class="text-center font-weight-bold">GRAND TOTAL</th>
                                    <th class="format-uang"><?php echo toRupiah($grand_total_nota); ?></th>
                                    <th class="format-uang"><?php echo toRupiah($grand_total_hpp); ?></th>
                                    <th></th>
                                    <th class="format-uang"><?php echo toRupiah($grand_total_bayar); ?></th>
                                    <th colspan="2"></th>
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
