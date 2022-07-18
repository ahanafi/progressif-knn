<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Retur Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Tambah Retur Supplier
            </h2>
            <p class="section-lead">Tambah Retur Supplier</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('retur-supplier/create'); ?>" class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered w-100" id='data-table'>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No Retur</th>
                                        <th>Tanggal</th>
                                        <th>Nama Supplier</th>
                                        <th>Total</th>
                                        <th class="text-center">Status</th>
                                        <th>Potong</th>
										<th>Lunas</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($retursupplier) > 0): ?>
                                        <?php foreach ($retursupplier as $ret_sup): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php if ($ret_sup->file_retur != '' && file_exists(FCPATH . 'uploads/retur-supplier/' . $ret_sup->file_retur)): ?>
                                                        <a href="#" onclick="showFileNota('<?php echo $ret_sup->pdflink; ?>')" class="btn-link"><?php echo $ret_sup->no_retur; ?></a>
                                                    <?php else: ?>
                                                        <?php echo $ret_sup->no_retur; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-sort="<?php echo strtotime($ret_sup->tanggal); ?>"><?php echo IdFormatDate($ret_sup->tanggal); ?></td>
                                                <td><?php echo $ret_sup->nama_supplier; ?></td>
                                                <td class="format-uang"><?php echo toRupiah($ret_sup->total); ?></td>
                                                <td class="text-center"><?php echo getStatus($ret_sup->status); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($ret_sup->potong); ?></td>
												<td><?php echo getStatus($ret_sup->lunas, 'pelunasan'); ?></td>
                                                <td class="text-center">
                                                    <?php if ($ret_sup->status != 1): ?>
                                                        <a href="<?php echo base_url('retur-supplier/update/' . $ret_sup->id_retur_supplier); ?>" class="btn btn-light">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-light" onclick="showConfirmDelete('retur-supplier', <?php echo $ret_sup->id_retur_supplier; ?>)">
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
                                            <td class="text-center text-info font-weight-bold" colspan="7">
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-center font-weight-bold">GRAND TOTAL</th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($grand_total_retur); ?></th>
                                        <th></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($grand_total_potong); ?></th>
                                        <th></th>
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
