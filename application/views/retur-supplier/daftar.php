<?php
$getParameter = $get_parameter;
$no = 1;
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Retur Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Daftar Retur Supplier
            </h2>
            <p class="section-lead">Daftar Retur Supplier</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class='card-body'>
                        <form action='' method='get'>
                            <div class='form-group row col-sm-6'>
                                <label class='col-sm-3 col-form-label'>
                                    Supplier
                                </label>
                                <div class='col-sm-9'>
                                    <select class='form-control select2' name="supplier">
                                        <option disabled selected>-- Pilih Supplier --</option>
                                        <?php foreach ($suppliers as $s): ?>
                                            <option value='<?= $s->id_supplier ?>' <?php echo (isset($_GET['supplier']) && $_GET['supplier'] === $s->id_supplier) ? 'selected' : ''; ?>><?= $s->nama_supplier ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group col-sm-6 row'>
                                <label class='col-sm-3 col-form-label'>
                                    Bulan
                                </label>
                                <div class='col-sm-9'>
                                    <select class='form-control select2' name="bulan">
                                        <option disabled selected>-- Pilih Bulan --</option>
                                        <?php
                                        for ($i = 0; $i <= 11; $i++): ?>
                                            <option <?php echo (isset($_GET['bulan']) && $_GET['bulan'] === $index[$i]) ? 'selected' : ''; ?> value="<?php echo $index[$i]; ?>"><?php echo $bulan[$i]; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class='row col-sm-6'>
                                <div class='col-sm-3'>
                                </div>
                                <div class='col-sm-9'>
                                    <button type="submit" class="btn btn-primary btn-icon icon-left">
                                        <i class="fa fa-eye"></i>
                                        Tampilkan
                                    </button> &nbsp;
                                    <?php if (isset($_GET['supplier']) || isset($_GET['bulan'])): ?>
                                        <a href="<?php echo base_url('retur-supplier/daftar'); ?>" class="btn btn-danger">
                                            <i class="fa fa-retweet"></i>
                                            <span>Reset Filter</span>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url('cetak/retur-supplier') . $getParameter;; ?>" class="btn btn-primary btn-icon icon-left" target="_blank">
                                        <i class="fa fa-print"></i>
                                        Cetak
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered" id='data-table' width='100%'>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No Retur</th>
                                        <th>Tanggal</th>
                                        <th>Nama Supplier</th>
                                        <th>Total</th>
                                        <th class="text-center">Status</th>
                                        <th>Potong</th>
                                        <th class="text-center">Lunas</th>
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
                                              <td data-sort="<?php echo strtotime($ret_sup->tanggal);  ?>"><?php echo IdFormatDate($ret_sup->tanggal); ?></td>
                                            <td><?php echo $ret_sup->nama_supplier; ?></td>
                                            <td class="format-uang"><?php echo toRupiah($ret_sup->total); ?></td>
                                            <td class="text-center"><?php echo getStatus($ret_sup->status); ?></td>
                                            <td class="format-uang"><?php echo toRupiah($ret_sup->potong); ?></td>
                                            <td class="text-center"><?php echo getStatus($ret_sup->lunas, "pelunasan"); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-center ui-priority-primary">GRAND TOTAL</th>
                                        <th class="format-uang">Rp. <?php echo toRupiah($grand_total); ?></th>
                                        <th></th>
                                        <th class="format-uang">Rp. <?php echo toRupiah($total_potong); ?></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
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

