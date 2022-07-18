<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Nota Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Tambah Nota Supplier
            </h2>
            <p class="section-lead">Tambah Nota Supplier</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('nota-supplier/create'); ?>" class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-plus"></i>
                                    Tambah Nota
                                </a>
                            </div>
                        </div>
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
                                    <th class="text-center">Status</th>
                                    <th>Transfer</th>
                                    <th>Lunas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($notasupplier) > 0): ?>
                                    <?php foreach ($notasupplier as $nota): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <?php if ($nota->file_nota != '' && file_exists(FCPATH . 'uploads/nota-supplier/' . $nota->file_nota)): ?>
                                                    <a href="#" onclick="showFileNota('<?php echo $nota->pdflink; ?>')" class="btn-link"><?php echo $nota->no_nota; ?></a>
                                                <?php else: ?>
                                                    <?php echo $nota->no_nota; ?>
                                                <?php endif; ?>
                                            </td>
                                             <td data-sort="<?php echo strtotime($nota->tanggal);  ?>"><?php echo IdFormatDate($nota->tanggal); ?></td>
                                            <td><?php echo $nota->nama_pelanggan; ?></td>
                                            <td class="format-uang"><?php echo toRupiah($nota->total); ?></td>
                                            <td class="format-uang"><?php echo toRupiah($nota->total_hpp); ?></td>
                                            <td><?php echo $nota->nama_supplier; ?></td>
                                            <td class="text-center"><?php echo getStatus($nota->status); ?></td>
                                            <td class="format-uang"><?php echo toRupiah($nota->bayar); ?></td>
                                            <td class="format-uang">
                                                <?php echo getStatus($nota->is_lunas, "pelunasan"); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($nota->status != 1): ?>
                                                    <a href="<?php echo base_url('nota-supplier/edit/' . $nota->id_nota_pembelian); ?>" class="btn btn-light">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-light" onclick="showConfirmDelete('Nota Pembelian', <?php echo $nota->id_nota_pembelian; ?>)">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <b><i><small>No action</small></i></b>
                                                <?php endif; ?>
                                            </td>
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