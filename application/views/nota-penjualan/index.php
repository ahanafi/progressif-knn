<?php
$grandTotal = 0;
$totalBayar = 0;
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Nota Penjualan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Tambah Nota Penjualan
            </h2>
            <p class="section-lead">Tambah Nota Penjualan</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('nota-penjualan/create'); ?>" class="btn float-right btn-icon icon-left btn-primary">
                                    <i class="fa fa-plus"></i>
                                    <span>Tambah Data</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped w-100 table-md table-bordered dt-responsive nowrap" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. Nota</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Sales</th>
                                        <th class="text-center">Total</th>
                                        <th>Status</th>
                                        <th>Bayar</th>
                                        <th>Lunas</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($nota_penjualan) > 0): ?>
                                        <?php foreach ($nota_penjualan as $nota):
                                            $grandTotal += $nota->total;
                                            $totalBayar += $nota->bayar;
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php if ($nota->file_nota !== '' && file_exists(FCPATH . 'uploads/nota-penjualan/' . $nota->file_nota)): ?>
                                                        <a href="#" onclick="showFileNota('<?php echo $nota->pdflink; ?>')" class="btn-link"><?php echo $nota->no_nota; ?></a>
                                                    <?php else: ?>
                                                        <?php echo $nota->no_nota; ?>
                                                    <?php endif; ?>
                                                </td>
                                                 <td data-sort="<?php echo strtotime($nota->tanggal);  ?>"><?php echo IdFormatDate($nota->tanggal); ?></td>
                                                <td><?php echo $nota->nama_pelanggan; ?></td>
                                                <td><?php echo $nota->nama_sales; ?></td>
                                                <td class="format-uang"><?php echo toRupiah($nota->total); ?></td>
                                                <td><?php echo getStatus($nota->status); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($nota->bayar); ?></td>
                                                <td style="font-weight:bold;text-align: center;">
                                                    <?php echo getStatus($nota->is_lunas, "pelunasan"); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($nota->status == 0): ?>
                                                        <a href="<?php echo base_url('nota-penjualan/edit/' . $nota->id_nota_penjualan); ?>" class="btn btn-light">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-light" onclick="showConfirmDelete('nota-penjualan', <?php echo $nota->id_nota_penjualan; ?>)">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <b><i><small>No action</small></i></b>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center text-info font-weight-bold" colspan="10">
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-center font-weight-bold">TOTAL</td>
                                        <td class="format-uang"><?php echo toRupiah($grandTotal); ?></td>
                                        <td></td>
                                        <td class="format-uang"><?php echo toRupiah($totalBayar); ?></td>
                                        <td></td>
                                        <td class="text-center"></td>
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
<div class="modal fade" id="preview-nota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pratinjau Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="target-view" src="" width="100%" height="520px"></iframe>
            </div>
        </div>
    </div>
</div>